function formatMilliseconds(value) {
  if (!Number.isFinite(value)) {
    return 'n/a';
  }

  if (value >= 1000) {
    return `${(value / 1000).toFixed(1)}s`;
  }

  return `${Math.round(value)}ms`;
}

function formatScore(value) {
  if (!Number.isFinite(value)) {
    return 'n/a';
  }

  return `${Math.round(value * 100)}`;
}

function metricBadge(value, target) {
  const exceedsTarget = target.smallerIsBetter ? value > target.value : value < target.value;
  return exceedsTarget ? target.badge : '🟢';
}

export function renderTerminalReport(result) {
  const lines = [];
  const { meta, aggregate, issues, compare } = result;
  const metrics = aggregate.metrics;
  const targets = {
    lcpMs: { value: 2500, smallerIsBetter: true, badge: '🔴' },
    cls: { value: 0.1, smallerIsBetter: true, badge: '🟡' },
    tbtMs: { value: 200, smallerIsBetter: true, badge: '🔴' },
    fcpMs: { value: 1800, smallerIsBetter: true, badge: '🟡' },
    speedIndexMs: { value: 3400, smallerIsBetter: true, badge: '🟡' },
  };

  lines.push(`URL: ${meta.url}`);
  lines.push(`Device: ${meta.device} | Runs: ${meta.runs} | WaitUntil: ${meta.waitUntil}`);
  lines.push('');
  lines.push(`Performance: ${formatScore(aggregate.scores.performance)}`);
  lines.push(`Accessibility: ${formatScore(aggregate.scores.accessibility)}`);
  lines.push(`SEO: ${formatScore(aggregate.scores.seo)}`);
  lines.push('');
  lines.push(
    `${metricBadge(metrics.lcpMs, targets.lcpMs)} LCP: ${formatMilliseconds(metrics.lcpMs)} (target < 2.5s)`
  );
  lines.push(
    `${metricBadge(metrics.cls, targets.cls)} CLS: ${metrics.cls.toFixed(3)} (target < 0.1)`
  );
  lines.push(
    `${metricBadge(metrics.tbtMs, targets.tbtMs)} TBT: ${formatMilliseconds(metrics.tbtMs)} (target < 200ms)`
  );
  lines.push(
    `${metricBadge(metrics.fcpMs, targets.fcpMs)} FCP: ${formatMilliseconds(metrics.fcpMs)}`
  );
  lines.push(
    `${metricBadge(metrics.speedIndexMs, targets.speedIndexMs)} Speed Index: ${formatMilliseconds(metrics.speedIndexMs)}`
  );

  if (issues.length > 0) {
    lines.push('');
    lines.push('Top fixes:');

    for (const issue of issues.slice(0, 5)) {
      lines.push(`- [${issue.impact.toUpperCase()}] ${issue.problem}`);
      for (const action of issue.concreteActions.slice(0, 3)) {
        lines.push(`  Fix: ${action}`);
      }
    }
  }

  if (compare) {
    lines.push('');
    lines.push('Compare:');
    if (compare.improvements.length > 0) {
      lines.push(`- Improvements: ${compare.improvements.join('; ')}`);
    }
    if (compare.regressions.length > 0) {
      lines.push(`- Regressions: ${compare.regressions.join('; ')}`);
    }
  }

  return `${lines.join('\n')}\n`;
}
