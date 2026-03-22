function pushIssue(issues, issue) {
  issues.push({
    confidence: 'high',
    ...issue,
  });
}

export function runRulesEngine(aggregate) {
  const issues = [];
  const { metrics, opportunities, diagnostics } = aggregate;

  if ((metrics.lcpMs ?? 0) > 2500) {
    pushIssue(issues, {
      id: 'lcp-high',
      problem: 'Largest Contentful Paint is above target.',
      impact: 'high',
      priority: 100,
      evidence: [`LCP ${Math.round(metrics.lcpMs)}ms`],
      suggestedFixSeeds: [
        'preload the hero image or LCP asset',
        'reduce render-blocking CSS and fonts',
        'improve server response time for the initial document',
      ],
    });
  }

  if ((metrics.cls ?? 0) > 0.1) {
    pushIssue(issues, {
      id: 'cls-high',
      problem: 'Cumulative Layout Shift is above target.',
      impact: 'high',
      priority: 95,
      evidence: [`CLS ${metrics.cls.toFixed(3)}`],
      suggestedFixSeeds: [
        'reserve dimensions for images, embeds, and dynamic content',
        'stabilize font loading and avoid late layout-affecting swaps',
        'investigate shifting elements flagged by Lighthouse',
      ],
    });
  }

  if ((metrics.tbtMs ?? 0) > 200) {
    pushIssue(issues, {
      id: 'tbt-high',
      problem: 'Total Blocking Time is above target.',
      impact: 'high',
      priority: 90,
      evidence: [`TBT ${Math.round(metrics.tbtMs)}ms`],
      suggestedFixSeeds: [
        'defer or split long-running JavaScript',
        'reduce third-party script cost',
        'remove unused JavaScript from the critical path',
      ],
    });
  }

  for (const opportunity of opportunities) {
    if (opportunity.id === 'render-blocking-resources') {
      pushIssue(issues, {
        id: 'render-blocking-resources',
        problem: 'Render-blocking resources are delaying first paint.',
        impact: 'high',
        priority: 85,
        evidence: [opportunity.displayValue ?? 'render-blocking resources detected'],
        suggestedFixSeeds: [
          'inline or defer non-critical CSS',
          'preload critical CSS or font assets',
          'defer non-essential scripts',
        ],
      });
    }

    if (['uses-optimized-images', 'uses-responsive-images', 'offscreen-images'].includes(opportunity.id)) {
      pushIssue(issues, {
        id: `images-${opportunity.id}`,
        problem: 'Image delivery is inefficient.',
        impact: opportunity.severityHint === 'high' ? 'high' : 'medium',
        priority: 80,
        evidence: [opportunity.displayValue ?? opportunity.title],
        suggestedFixSeeds: [
          'serve responsive image sizes',
          'compress and modernize large images',
          'lazy-load non-critical images below the fold',
        ],
      });
    }

    if (['unused-css-rules', 'unused-javascript'].includes(opportunity.id)) {
      pushIssue(issues, {
        id: `unused-${opportunity.id}`,
        problem: 'Unused frontend assets are inflating the critical path.',
        impact: 'medium',
        priority: 70,
        evidence: [opportunity.displayValue ?? opportunity.title],
        suggestedFixSeeds: [
          'remove unused CSS or split it by route',
          'tree-shake or code-split unused JavaScript',
          'load optional assets only when needed',
        ],
      });
    }
  }

  if (diagnostics.some((diagnostic) => diagnostic.id === 'dom-size')) {
    pushIssue(issues, {
      id: 'dom-size',
      problem: 'DOM size may be increasing layout and rendering cost.',
      impact: 'medium',
      priority: 60,
      evidence: ['Lighthouse flagged DOM size'],
      suggestedFixSeeds: [
        'simplify deep wrapper structures',
        'reduce duplicated DOM in repeated sections',
        'avoid loading hidden-heavy components above the fold',
      ],
    });
  }

  return issues
    .sort((a, b) => b.priority - a.priority)
    .map((issue, index) => ({
      ...issue,
      priority: issue.priority - index,
    }));
}
