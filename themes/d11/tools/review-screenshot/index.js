#!/usr/bin/env node

import fs from 'node:fs/promises';
import path from 'node:path';
import process from 'node:process';

import { setupBrowser } from './browser.js';
import {
  DEFAULT_OPTIONS,
  DEFAULT_OUTPUT_ROOT,
  VIEWPORTS,
  parseCliArgs,
} from './config.js';
import { scrollAndCapture } from './capture.js';
import { forceLazyLoad } from './lazy-load.js';
import { preparePage } from './page-prep.js';
import { stitchImages } from './stitch.js';

function createLogger(enabled) {
  return {
    log(message) {
      if (enabled) {
        console.log(message);
      }
    },
    warn(message) {
      console.warn(message);
    },
  };
}

async function runForViewport(viewportConfig, options, logger) {
  const targetPath = path.join(options.outDir, `${viewportConfig.name}.png`);
  const { browser, page } = await setupBrowser({
    timeout: options.timeout,
    viewport: viewportConfig,
  });

  try {
    logger.log(`[${viewportConfig.name}] Navigating to ${options.url}`);
    await page.goto(options.url, {
      timeout: options.timeout,
      waitUntil: options.waitUntil,
    });

    await page.waitForTimeout(250);

    const prepResult = await preparePage(page, {
      excludeSelectors: options.excludeSelectors,
      logger,
    });

    logger.log(
      `[${viewportConfig.name}] Neutralized ${prepResult.neutralizedCount} sticky/fixed elements`
    );

    await forceLazyLoad(page, {
      logger,
      timeout: options.timeout,
    });

    const capturedSegments = await scrollAndCapture(page, {
      logger,
      timeout: options.timeout,
      viewportName: viewportConfig.name,
    });

    logger.log(
      `[${viewportConfig.name}] Captured ${capturedSegments.length} segments, stitching`
    );

    const finalBuffer = await stitchImages(capturedSegments.map((segment) => segment.buffer));
    await fs.writeFile(targetPath, finalBuffer);

    logger.log(`[${viewportConfig.name}] Wrote ${targetPath}`);
    return targetPath;
  } finally {
    await browser.close();
  }
}

async function main() {
  const options = parseCliArgs(process.argv.slice(2));
  const logger = createLogger(!options.quiet);

  if (options.help) {
    console.log(`Usage: node tools/review-screenshot/index.js <url> [options]

Options:
  --out-dir=<path>      Output directory (default: ${DEFAULT_OUTPUT_ROOT}/<page-name>)
  --timeout=<ms>        Navigation and operation timeout (default: ${DEFAULT_OPTIONS.timeout})
  --exclude=<selector>  Hide selector before capture; repeatable or comma-separated
  --wait-until=<event>  Playwright waitUntil value (default: ${DEFAULT_OPTIONS.waitUntil})
  --quiet               Reduce logging
  --help                Show this help
`);
    return;
  }

  await fs.mkdir(options.outDir, { recursive: true });

  logger.log(`Writing screenshots to ${options.outDir}`);

  for (const viewportConfig of VIEWPORTS) {
    await runForViewport(viewportConfig, options, logger);
  }
}

main().catch((error) => {
  console.error(error instanceof Error ? error.stack ?? error.message : String(error));
  process.exitCode = 1;
});
