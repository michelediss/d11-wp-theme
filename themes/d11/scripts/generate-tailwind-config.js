import { createHash } from 'node:crypto';
import { watch } from 'node:fs';
import { mkdir, readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const themeJsonPath = path.resolve(__dirname, '../theme.json');
const generatedDir = path.resolve(__dirname, 'generated');
const generatedModulePath = path.join(generatedDir, 'tailwind-theme.generated.js');
const debugJsonPath = path.join(generatedDir, 'tailwind-theme.debug.json');

const requiredColorSlugs = ['white', 'black', 'light', 'primary', 'accent'];
const requiredFontSlugs = ['heading', 'paragraph'];

function assertSlugEntries(entries, label) {
  if (!Array.isArray(entries)) {
    throw new Error(`${label} must be an array in theme.json.`);
  }

  const bySlug = {};

  for (const entry of entries) {
    if (!entry || typeof entry.slug !== 'string' || entry.slug.trim() === '') {
      throw new Error(`${label} contains an item without a valid slug.`);
    }

    bySlug[entry.slug] = entry;
  }

  return bySlug;
}

function assertRequiredSlugs(bySlug, required, label) {
  const missing = required.filter((slug) => !Object.prototype.hasOwnProperty.call(bySlug, slug));

  if (missing.length > 0) {
    throw new Error(`Missing required ${label} slug(s): ${missing.join(', ')}.`);
  }
}

function buildThemeExtend(themeJson) {
  const settings = themeJson.settings ?? {};
  const colorEntries = settings.color?.palette ?? [];
  const fontEntries = settings.typography?.fontFamilies ?? [];
  const spacingEntries = settings.spacing?.spacingSizes ?? [];
  const radiusEntries = settings.custom?.radius ?? {};
  const layout = settings.layout ?? {};

  const colorsBySlug = assertSlugEntries(colorEntries, 'settings.color.palette');
  const fontsBySlug = assertSlugEntries(fontEntries, 'settings.typography.fontFamilies');

  assertRequiredSlugs(colorsBySlug, requiredColorSlugs, 'color');
  assertRequiredSlugs(fontsBySlug, requiredFontSlugs, 'font family');

  const themeExtend = {
    colors: Object.fromEntries(
      Object.keys(colorsBySlug).map((slug) => [slug, `var(--wp--preset--color--${slug})`])
    ),
    fontFamily: Object.fromEntries(
      Object.keys(fontsBySlug).map((slug) => [slug, [`var(--wp--preset--font-family--${slug})`]])
    ),
  };

  if (Array.isArray(spacingEntries) && spacingEntries.length > 0) {
    themeExtend.spacing = Object.fromEntries(
      spacingEntries
        .filter((entry) => entry && typeof entry.slug === 'string' && entry.slug.trim() !== '')
        .map((entry) => [entry.slug, `var(--wp--preset--spacing--${entry.slug})`])
    );
  }

  if (radiusEntries && typeof radiusEntries === 'object' && Object.keys(radiusEntries).length > 0) {
    themeExtend.borderRadius = Object.fromEntries(
      Object.keys(radiusEntries).map((slug) => [slug, `var(--wp--custom--radius--${slug})`])
    );
  }

  if (layout.contentSize || layout.wideSize) {
    themeExtend.maxWidth = {};

    if (layout.contentSize) {
      themeExtend.maxWidth.content = 'var(--wp--style--global--content-size)';
    }

    if (layout.wideSize) {
      themeExtend.maxWidth.wide = 'var(--wp--style--global--wide-size)';
    }
  }

  return {
    themeExtend,
    tokenMeta: {
      requiredColorSlugs,
      requiredFontSlugs,
      colors: Object.keys(colorsBySlug),
      fontFamilies: Object.keys(fontsBySlug),
      spacing: Array.isArray(spacingEntries)
        ? spacingEntries
            .filter((entry) => entry && typeof entry.slug === 'string' && entry.slug.trim() !== '')
            .map((entry) => entry.slug)
        : [],
      radius: radiusEntries && typeof radiusEntries === 'object' ? Object.keys(radiusEntries) : [],
      layout: {
        hasContentSize: Boolean(layout.contentSize),
        hasWideSize: Boolean(layout.wideSize),
      },
    },
  };
}

function stableHash(value) {
  return createHash('sha256').update(value).digest('hex');
}

function buildOutputs(themeJsonContents, themeExtend, tokenMeta) {
  const sourceHash = stableHash(themeJsonContents);
  const payload = {
    generatedFrom: 'theme.json',
    sourceHash,
    tokenMeta,
    themeExtend,
  };

  const generatedModule = `/**
 * AUTO-GENERATED FILE.
 * Source: theme.json
 * Do not edit manually. Run \`npm run tokens:generate\`.
 */

export const sourceHash = ${JSON.stringify(sourceHash)};
export const tokenMeta = ${JSON.stringify(tokenMeta, null, 2)};
export const themeExtend = ${JSON.stringify(themeExtend, null, 2)};

export default themeExtend;
`;

  const debugJson = `${JSON.stringify(payload, null, 2)}\n`;

  return { generatedModule, debugJson };
}

async function ensureGeneratedOutputs() {
  const themeJsonContents = await readFile(themeJsonPath, 'utf8');
  const themeJson = JSON.parse(themeJsonContents);
  const { themeExtend, tokenMeta } = buildThemeExtend(themeJson);

  return buildOutputs(themeJsonContents, themeExtend, tokenMeta);
}

async function writeOutputs() {
  const { generatedModule, debugJson } = await ensureGeneratedOutputs();

  await mkdir(generatedDir, { recursive: true });
  await writeFile(generatedModulePath, generatedModule);
  await writeFile(debugJsonPath, debugJson);

  console.log(`Generated ${path.relative(process.cwd(), generatedModulePath)}`);
  console.log(`Generated ${path.relative(process.cwd(), debugJsonPath)}`);
}

async function checkOutputs() {
  const { generatedModule, debugJson } = await ensureGeneratedOutputs();
  const [currentModule, currentDebugJson] = await Promise.all([
    readFile(generatedModulePath, 'utf8').catch(() => null),
    readFile(debugJsonPath, 'utf8').catch(() => null),
  ]);

  if (currentModule !== generatedModule || currentDebugJson !== debugJson) {
    throw new Error('Generated Tailwind token files are stale. Run `npm run tokens:generate`.');
  }

  console.log('Generated Tailwind token files are up to date.');
}

function watchThemeJson() {
  let timeout = null;

  const run = async () => {
    try {
      await writeOutputs();
    } catch (error) {
      console.error(error instanceof Error ? error.message : error);
    }
  };

  run();

  const watcher = watch(themeJsonPath, () => {
    clearTimeout(timeout);
    timeout = setTimeout(run, 80);
  });

  process.on('SIGINT', () => {
    watcher.close();
    process.exit(0);
  });

  console.log(`Watching ${path.relative(process.cwd(), themeJsonPath)} for changes...`);
}

async function main() {
  const args = new Set(process.argv.slice(2));

  if (args.has('--watch')) {
    watchThemeJson();
    return;
  }

  if (args.has('--check')) {
    await checkOutputs();
    return;
  }

  await writeOutputs();
}

main().catch((error) => {
  console.error(error instanceof Error ? error.message : error);
  process.exit(1);
});
