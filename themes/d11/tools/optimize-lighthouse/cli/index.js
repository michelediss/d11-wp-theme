#!/usr/bin/env node

import path from 'node:path';
import process from 'node:process';

import { runOrchestrator } from '../core/orchestrator.js';
import { createLogger } from '../utils/logger.js';

const DEFAULTS = {
  device: 'mobile',
  runs: 3,
  output: 'both',
  waitUntil: 'networkidle',
  timeout: 60000,
  throttling: 'default',
  cpuSlowdown: 4,
  networkProfile: 'mobile',
  headless: true,
  quiet: false,
  aiAdapter: 'deterministic',
  outFile: '',
  compareFile: '',
};

function parseBoolean(value) {
  if (value === 'true') {
    return true;
  }

  if (value === 'false') {
    return false;
  }

  throw new Error(`Invalid boolean value: ${value}`);
}

function getNetworkProfile(name) {
  const profiles = {
    mobile: {
      requestLatencyMs: 150,
      downloadThroughputKbps: 1638.4,
      uploadThroughputKbps: 750,
    },
    desktop: {
      requestLatencyMs: 40,
      downloadThroughputKbps: 10240,
      uploadThroughputKbps: 10240,
    },
    off: {
      requestLatencyMs: 0,
      downloadThroughputKbps: 0,
      uploadThroughputKbps: 0,
    },
  };

  if (!profiles[name]) {
    throw new Error(`Invalid network profile: ${name}`);
  }

  return profiles[name];
}

function printHelp() {
  console.log(`Usage: optimize-lighthouse <url> [options]

Options:
  --device=mobile|desktop
  --runs=<n>
  --output=terminal|json|both
  --out-file=<path>
  --compare=<baseline.json>
  --timeout=<ms>
  --wait-until=load|domcontentloaded|networkidle
  --throttling=default|off|custom
  --cpu-slowdown=<n>
  --network-profile=mobile|desktop|off
  --headless=true|false
  --quiet
  --help
`);
}

function parseArgs(argv) {
  const options = {
    ...DEFAULTS,
    url: '',
  };

  for (const arg of argv) {
    if (arg === '--help' || arg === '-h') {
      options.help = true;
      continue;
    }

    if (arg === '--quiet') {
      options.quiet = true;
      continue;
    }

    if (!arg.startsWith('--') && !options.url) {
      options.url = arg;
      continue;
    }

    const [flag, rawValue] = arg.split('=');
    const value = rawValue ?? '';

    switch (flag) {
      case '--device':
        if (!['mobile', 'desktop'].includes(value)) {
          throw new Error(`Invalid device: ${value}`);
        }
        options.device = value;
        break;
      case '--runs':
        options.runs = Number.parseInt(value, 10);
        if (!Number.isInteger(options.runs) || options.runs < 1) {
          throw new Error(`Invalid runs value: ${value}`);
        }
        break;
      case '--output':
        if (!['terminal', 'json', 'both'].includes(value)) {
          throw new Error(`Invalid output mode: ${value}`);
        }
        options.output = value;
        break;
      case '--out-file':
        options.outFile = value;
        break;
      case '--compare':
        options.compareFile = value;
        break;
      case '--timeout':
        options.timeout = Number.parseInt(value, 10);
        if (!Number.isInteger(options.timeout) || options.timeout < 1000) {
          throw new Error(`Invalid timeout: ${value}`);
        }
        break;
      case '--wait-until':
        if (!['load', 'domcontentloaded', 'networkidle'].includes(value)) {
          throw new Error(`Invalid wait-until value: ${value}`);
        }
        options.waitUntil = value;
        break;
      case '--throttling':
        if (!['default', 'off', 'custom'].includes(value)) {
          throw new Error(`Invalid throttling mode: ${value}`);
        }
        options.throttling = value;
        break;
      case '--cpu-slowdown':
        options.cpuSlowdown = Number.parseInt(value, 10);
        if (!Number.isInteger(options.cpuSlowdown) || options.cpuSlowdown < 1) {
          throw new Error(`Invalid cpu-slowdown value: ${value}`);
        }
        break;
      case '--network-profile':
        options.networkProfile = value;
        break;
      case '--headless':
        options.headless = parseBoolean(value);
        break;
      default:
        throw new Error(`Unknown argument: ${arg}`);
    }
  }

  if (!options.help && !options.url) {
    throw new Error('Missing target URL.');
  }

  if (!options.help) {
    new URL(options.url);
  }

  if (options.output !== 'terminal' && !options.outFile && options.output !== 'json') {
    options.outFile = path.join(
      'wp-content',
      'uploads',
      'dev-lighthouse',
      `${options.device}-${Date.now()}.json`
    );
  }

  options.networkProfile = getNetworkProfile(options.networkProfile);
  return options;
}

async function main() {
  const options = parseArgs(process.argv.slice(2));
  if (options.help) {
    printHelp();
    return;
  }

  const logger = createLogger({
    level: options.quiet ? 'error' : 'info',
    quiet: options.quiet,
  });

  await runOrchestrator(options, logger);
}

main().catch((error) => {
  console.error(error instanceof Error ? error.stack ?? error.message : String(error));
  process.exitCode = 1;
});
