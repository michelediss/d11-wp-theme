function formatDelta(value, unit = '') {
  const sign = value > 0 ? '+' : '';
  return `${sign}${value}${unit}`;
}

function pushDirectionalChange(collection, metric, delta, smallerIsBetter) {
  if (delta === 0) {
    return;
  }

  const improved = smallerIsBetter ? delta < 0 : delta > 0;
  const label = `${metric} ${improved ? 'improved' : 'regressed'} (${formatDelta(delta)})`;
  collection[improved ? 'improvements' : 'regressions'].push(label);
}

export function compareResults(current, baseline) {
  const currentScores = current.aggregate.scores;
  const baselineScores = baseline.aggregate?.scores ?? {};
  const currentMetrics = current.aggregate.metrics;
  const baselineMetrics = baseline.aggregate?.metrics ?? {};

  const deltas = {
    performanceScore: currentScores.performance - (baselineScores.performance ?? 0),
    accessibilityScore: currentScores.accessibility - (baselineScores.accessibility ?? 0),
    seoScore: currentScores.seo - (baselineScores.seo ?? 0),
    fcpMs: currentMetrics.fcpMs - (baselineMetrics.fcpMs ?? 0),
    lcpMs: currentMetrics.lcpMs - (baselineMetrics.lcpMs ?? 0),
    speedIndexMs: currentMetrics.speedIndexMs - (baselineMetrics.speedIndexMs ?? 0),
    cls: Number((currentMetrics.cls - (baselineMetrics.cls ?? 0)).toFixed(3)),
    tbtMs: currentMetrics.tbtMs - (baselineMetrics.tbtMs ?? 0),
  };

  const summary = {
    improvements: [],
    regressions: [],
  };

  pushDirectionalChange(summary, 'performance', deltas.performanceScore, false);
  pushDirectionalChange(summary, 'accessibility', deltas.accessibilityScore, false);
  pushDirectionalChange(summary, 'seo', deltas.seoScore, false);
  pushDirectionalChange(summary, 'FCP', deltas.fcpMs, true);
  pushDirectionalChange(summary, 'LCP', deltas.lcpMs, true);
  pushDirectionalChange(summary, 'Speed Index', deltas.speedIndexMs, true);
  pushDirectionalChange(summary, 'CLS', deltas.cls, true);
  pushDirectionalChange(summary, 'TBT', deltas.tbtMs, true);

  return {
    baselineFile: baseline.meta?.sourceFile ?? null,
    deltas,
    ...summary,
  };
}
