import { startBrowserSession, stopBrowserSession } from '../browser/playwright.js';
import { runLighthouseAudit } from '../lighthouse/runner.js';
import { aggregateRuns, extractMetrics } from '../processor/extractMetrics.js';
import { analyzeIssues } from '../analyzer/aiAnalyzer.js';
import { runRulesEngine } from '../analyzer/rulesEngine.js';
import { compareResults } from '../utils/compare.js';
import { readJsonFile, writeJsonFile } from '../utils/json.js';
import { renderTerminalReport } from '../utils/formatters.js';

export async function runOrchestrator(options, logger) {
  const session = await startBrowserSession({
    auditUrl: options.auditUrl || options.url,
    device: options.device,
    waitUntil: options.waitUntil,
    timeout: options.timeout,
    headless: options.headless,
    hostMap: options.executionMeta?.hostMap ?? null,
    logger,
  });

  try {
    const rawRuns = [];
    const extractedRuns = [];

    for (let index = 0; index < options.runs; index += 1) {
      logger.info(`Starting Lighthouse run ${index + 1}/${options.runs}`);
      const runnerResult = await runLighthouseAudit({
        auditUrl: options.auditUrl || options.url,
        remoteDebuggingPort: session.remoteDebuggingPort,
        device: options.device,
        timeout: options.timeout,
        throttling: options.throttling,
        cpuSlowdown: options.cpuSlowdown,
        networkProfile: options.networkProfile,
        logger,
      });

      rawRuns.push({
        index: index + 1,
        finalUrl: runnerResult.lhr.finalDisplayedUrl,
        fetchTime: runnerResult.lhr.fetchTime,
      });

      extractedRuns.push({
        index: index + 1,
        ...extractMetrics(runnerResult.lhr),
      });
    }

    if (extractedRuns.length === 0) {
      throw new Error('No successful Lighthouse runs completed.');
    }

    const aggregate = aggregateRuns(extractedRuns);
    const prioritizedIssues = runRulesEngine(aggregate);
    const issues = await analyzeIssues({
      aggregate,
      prioritizedIssues,
      adapter: options.aiAdapter,
    });

    let compare = null;
    if (options.compareFile) {
      const baseline = await readJsonFile(options.compareFile);
      baseline.data.meta = {
        ...baseline.data.meta,
        sourceFile: baseline.path,
      };
      compare = compareResults(
        {
          aggregate,
        },
        baseline.data
      );
    }

    const result = {
      meta: {
        url: options.auditUrl || options.url,
        auditUrl: options.auditUrl || options.url,
        canonicalUrl: options.canonicalUrl || options.url,
        device: options.device,
        runs: options.runs,
        waitUntil: options.waitUntil,
        throttling: options.throttling,
        cpuSlowdown: options.cpuSlowdown,
        timestamp: new Date().toISOString(),
        execution: options.executionMeta ?? null,
      },
      aggregate,
      runs: extractedRuns,
      issues,
      compare,
      rawRefs: rawRuns,
    };

    if (options.output === 'terminal' || options.output === 'both') {
      process.stdout.write(renderTerminalReport(result));
    }

    if (options.output === 'json' || options.output === 'both') {
      const outputPath = options.outFile
        ? await writeJsonFile(options.outFile, result)
        : null;

      if (outputPath) {
        logger.info('Wrote JSON report', { outFile: outputPath });
      } else if (options.output === 'json') {
        process.stdout.write(`${JSON.stringify(result, null, 2)}\n`);
      }
    }

    return result;
  } finally {
    await stopBrowserSession(session);
  }
}
