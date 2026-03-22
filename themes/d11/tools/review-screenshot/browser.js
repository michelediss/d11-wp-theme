import { chromium } from 'playwright';

export async function setupBrowser({ viewport, timeout }) {
  const browser = await chromium.launch({
    headless: true,
  });

  const context = await browser.newContext({
    deviceScaleFactor: 1,
    viewport: {
      width: viewport.width,
      height: viewport.height,
    },
  });

  context.setDefaultNavigationTimeout(timeout);
  context.setDefaultTimeout(timeout);

  const page = await context.newPage();
  return { browser, context, page };
}
