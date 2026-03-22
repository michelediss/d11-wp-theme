const CORE_METRIC_IDS = {
  fcpMs: 'first-contentful-paint',
  lcpMs: 'largest-contentful-paint',
  speedIndexMs: 'speed-index',
  cls: 'cumulative-layout-shift',
  tbtMs: 'total-blocking-time',
};

const OPPORTUNITY_IDS = new Set([
  'render-blocking-resources',
  'unused-css-rules',
  'unused-javascript',
  'modern-image-formats',
  'offscreen-images',
  'uses-optimized-images',
  'uses-responsive-images',
  'efficient-animated-content',
  'font-display',
  'uses-text-compression',
  'server-response-time',
  'third-party-summary',
]);

const DIAGNOSTIC_IDS = new Set([
  'largest-contentful-paint-element',
  'layout-shift-elements',
  'long-tasks',
  'network-requests',
  'mainthread-work-breakdown',
  'dom-size',
  'bootup-time',
]);

function getAuditValue(audits, id) {
  return audits[id]?.numericValue ?? null;
}

function getAuditDisplay(audits, id) {
  return audits[id]?.displayValue ?? null;
}

function getOpportunitySeverity(audit) {
  const ms = audit.details?.overallSavingsMs ?? 0;
  const bytes = audit.details?.overallSavingsBytes ?? 0;

  if (ms >= 250 || bytes >= 200_000) {
    return 'high';
  }

  if (ms >= 100 || bytes >= 50_000) {
    return 'medium';
  }

  return 'low';
}

export function extractMetrics(lhr) {
  const { audits, categories, finalDisplayedUrl } = lhr;
  const scores = {
    performance: categories.performance?.score ?? 0,
    accessibility: categories.accessibility?.score ?? 0,
    seo: categories.seo?.score ?? 0,
  };

  const metrics = Object.fromEntries(
    Object.entries(CORE_METRIC_IDS).map(([key, auditId]) => [key, getAuditValue(audits, auditId)])
  );

  const opportunities = Object.entries(audits)
    .filter(([id, audit]) => OPPORTUNITY_IDS.has(id) && audit.score !== 1)
    .map(([id, audit]) => ({
      id,
      title: audit.title,
      description: audit.description,
      displayValue: audit.displayValue ?? null,
      numericSavingsMs: audit.details?.overallSavingsMs ?? audit.numericValue ?? null,
      numericSavingsBytes: audit.details?.overallSavingsBytes ?? null,
      severityHint: getOpportunitySeverity(audit),
      sourceCategory: 'opportunity',
    }));

  const diagnostics = Object.entries(audits)
    .filter(([id, audit]) => DIAGNOSTIC_IDS.has(id) && audit.score !== 1)
    .map(([id, audit]) => ({
      id,
      title: audit.title,
      details: audit.displayValue ?? audit.description ?? '',
    }));

  return {
    url: finalDisplayedUrl,
    scores,
    metrics,
    opportunities,
    diagnostics,
    display: {
      fcp: getAuditDisplay(audits, CORE_METRIC_IDS.fcpMs),
      lcp: getAuditDisplay(audits, CORE_METRIC_IDS.lcpMs),
      speedIndex: getAuditDisplay(audits, CORE_METRIC_IDS.speedIndexMs),
      cls: getAuditDisplay(audits, CORE_METRIC_IDS.cls),
      tbt: getAuditDisplay(audits, CORE_METRIC_IDS.tbtMs),
    },
  };
}

function average(values) {
  const presentValues = values.filter((value) => Number.isFinite(value));
  if (presentValues.length === 0) {
    return null;
  }

  return presentValues.reduce((sum, value) => sum + value, 0) / presentValues.length;
}

function computeRange(values) {
  const presentValues = values.filter((value) => Number.isFinite(value));
  if (presentValues.length === 0) {
    return null;
  }

  return Math.max(...presentValues) - Math.min(...presentValues);
}

export function aggregateRuns(extractedRuns) {
  const metrics = {
    fcpMs: average(extractedRuns.map((run) => run.metrics.fcpMs)),
    lcpMs: average(extractedRuns.map((run) => run.metrics.lcpMs)),
    speedIndexMs: average(extractedRuns.map((run) => run.metrics.speedIndexMs)),
    cls: average(extractedRuns.map((run) => run.metrics.cls)),
    tbtMs: average(extractedRuns.map((run) => run.metrics.tbtMs)),
  };

  const scores = {
    performance: average(extractedRuns.map((run) => run.scores.performance)),
    accessibility: average(extractedRuns.map((run) => run.scores.accessibility)),
    seo: average(extractedRuns.map((run) => run.scores.seo)),
  };

  const variability = {
    lcpRangeMs: computeRange(extractedRuns.map((run) => run.metrics.lcpMs)),
    clsRange: computeRange(extractedRuns.map((run) => run.metrics.cls)),
    tbtRangeMs: computeRange(extractedRuns.map((run) => run.metrics.tbtMs)),
  };

  const opportunityMap = new Map();
  for (const run of extractedRuns) {
    for (const opportunity of run.opportunities) {
      const existing = opportunityMap.get(opportunity.id) ?? {
        ...opportunity,
        occurrences: 0,
      };
      existing.occurrences += 1;
      opportunityMap.set(opportunity.id, existing);
    }
  }

  const diagnosticMap = new Map();
  for (const run of extractedRuns) {
    for (const diagnostic of run.diagnostics) {
      if (!diagnosticMap.has(diagnostic.id)) {
        diagnosticMap.set(diagnostic.id, diagnostic);
      }
    }
  }

  return {
    scores,
    metrics,
    variability,
    opportunities: Array.from(opportunityMap.values()).sort((a, b) => b.occurrences - a.occurrences),
    diagnostics: Array.from(diagnosticMap.values()),
  };
}
