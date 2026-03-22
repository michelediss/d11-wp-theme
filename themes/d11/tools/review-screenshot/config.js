import path from 'node:path';

export const VIEWPORTS = [
  { name: 'desktop', width: 1440, height: 900 },
  { name: 'tablet', width: 768, height: 1024 },
  { name: 'mobile', width: 375, height: 812 },
];

export const DEFAULT_OUTPUT_ROOT = path.resolve(
  process.cwd(),
  '..',
  '..',
  'uploads',
  'dev-screenshots'
);

export const DEFAULT_OPTIONS = {
  outDir: '',
  timeout: 30_000,
  waitUntil: 'networkidle',
  excludeSelectors: [],
  quiet: false,
};

function sanitizeSegment(value) {
  return value
    .toLowerCase()
    .replace(/\.[a-z0-9]+$/i, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '') || 'page';
}

export function derivePageNameFromUrl(urlString) {
  const url = new URL(urlString);

  if (url.protocol === 'file:') {
    const filePath = decodeURIComponent(url.pathname);
    const filename = path.basename(filePath);
    return sanitizeSegment(filename || 'page');
  }

  const pathname = url.pathname.replace(/\/+$/, '');
  if (!pathname || pathname === '') {
    return 'home';
  }

  const segments = pathname.split('/').filter(Boolean);
  return sanitizeSegment(segments.at(-1) || 'home');
}

export function deriveDefaultOutDir(urlString) {
  return path.join(DEFAULT_OUTPUT_ROOT, derivePageNameFromUrl(urlString));
}

function parseExcludeSelectors(value) {
  if (!value) {
    return [];
  }

  return value
    .split(',')
    .map((selector) => selector.trim())
    .filter(Boolean);
}

export function parseCliArgs(argv) {
  const options = {
    ...DEFAULT_OPTIONS,
    help: false,
    outDirSpecified: false,
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

    if (arg.startsWith('--out-dir=')) {
      options.outDir = path.resolve(process.cwd(), arg.slice('--out-dir='.length));
      options.outDirSpecified = true;
      continue;
    }

    if (arg.startsWith('--timeout=')) {
      const timeout = Number.parseInt(arg.slice('--timeout='.length), 10);
      if (!Number.isFinite(timeout) || timeout <= 0) {
        throw new Error(`Invalid --timeout value: ${arg}`);
      }
      options.timeout = timeout;
      continue;
    }

    if (arg.startsWith('--wait-until=')) {
      options.waitUntil = arg.slice('--wait-until='.length);
      continue;
    }

    if (arg.startsWith('--exclude=')) {
      options.excludeSelectors.push(...parseExcludeSelectors(arg.slice('--exclude='.length)));
      continue;
    }

    if (!arg.startsWith('--') && !options.url) {
      options.url = arg;
      continue;
    }

    throw new Error(`Unknown argument: ${arg}`);
  }

  if (!options.help && !options.url) {
    throw new Error('Missing target URL. Usage: node tools/review-screenshot/index.js <url>');
  }

  if (!options.help && !options.outDirSpecified) {
    options.outDir = deriveDefaultOutDir(options.url);
  }

  return options;
}
