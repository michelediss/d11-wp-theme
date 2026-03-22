function uniqueActions(actions) {
  return Array.from(new Set(actions.filter(Boolean)));
}

function expandFixSeed(seed, issue) {
  const normalizedSeed = seed.toLowerCase();

  if (normalizedSeed.includes('hero image') || normalizedSeed.includes('lcp asset')) {
    return 'Preload the hero image or main LCP asset and ensure it is not lazily loaded.';
  }

  if (normalizedSeed.includes('render-blocking css')) {
    return 'Reduce blocking CSS by inlining the critical slice and deferring non-critical styles.';
  }

  if (normalizedSeed.includes('server response time')) {
    return 'Profile TTFB for the document route and remove backend work from the initial request path.';
  }

  if (normalizedSeed.includes('dimensions for images')) {
    return 'Set explicit width and height or aspect-ratio on images, embeds, and placeholders that shift layout.';
  }

  if (normalizedSeed.includes('font loading')) {
    return 'Use stable font metrics, preload critical fonts, and prefer font-display strategies that avoid late shifts.';
  }

  if (normalizedSeed.includes('long-running javascript')) {
    return 'Split long tasks, defer non-critical hydration, and move expensive work off the main thread when possible.';
  }

  if (normalizedSeed.includes('third-party script')) {
    return 'Delay third-party tags until after critical rendering or gate them behind user interaction where feasible.';
  }

  if (normalizedSeed.includes('responsive image')) {
    return 'Generate responsive `srcset` variants so large desktop assets are not sent to smaller viewports.';
  }

  if (normalizedSeed.includes('compress and modernize')) {
    return 'Convert oversized images to efficient formats such as AVIF or WebP and lower byte weight before delivery.';
  }

  if (normalizedSeed.includes('lazy-load')) {
    return 'Lazy-load only below-the-fold media and keep above-the-fold assets eager to protect LCP.';
  }

  if (normalizedSeed.includes('remove unused css')) {
    return 'Split route-specific CSS and remove unused selectors from the initial bundle.';
  }

  if (normalizedSeed.includes('tree-shake')) {
    return 'Tree-shake or code-split non-critical JavaScript so only route-critical code ships on first load.';
  }

  if (normalizedSeed.includes('simplify deep wrapper structures')) {
    return 'Reduce wrapper nesting and repeated layout containers in the critical viewport.';
  }

  return `${issue.problem} Fix: ${seed}.`;
}

function fallbackAnalyzeIssue(issue) {
  const concreteActions = uniqueActions(
    issue.suggestedFixSeeds.map((seed) => expandFixSeed(seed, issue))
  );

  return {
    id: issue.id,
    problem: issue.problem,
    impact: issue.impact,
    priority: issue.priority,
    explanation: issue.problem,
    probableCause: issue.evidence.join('; '),
    concreteActions,
    confidence: issue.confidence ?? 'medium',
  };
}

export async function analyzeIssues({ aggregate, prioritizedIssues, adapter = 'deterministic' }) {
  if (adapter !== 'deterministic') {
    throw new Error(
      `Unsupported AI analyzer adapter "${adapter}". The v1 CLI only ships the deterministic fallback adapter.`
    );
  }

  return prioritizedIssues.map((issue) => fallbackAnalyzeIssue({
    ...issue,
    aggregate,
  }));
}
