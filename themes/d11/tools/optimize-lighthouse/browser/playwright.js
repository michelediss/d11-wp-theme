import net from 'node:net';

import { chromium } from 'playwright';

async function getAvailablePort() {
  return new Promise((resolve, reject) => {
    const server = net.createServer();
    server.unref();
    server.on('error', reject);
    server.listen(0, () => {
      const address = server.address();
      const port = typeof address === 'object' && address ? address.port : null;
      server.close((error) => {
        if (error) {
          reject(error);
          return;
        }

        resolve(port);
      });
    });
  });
}

function getViewport(device) {
  if (device === 'desktop') {
    return {
      width: 1440,
      height: 900,
      isMobile: false,
      hasTouch: false,
      deviceScaleFactor: 1,
    };
  }

  return {
    width: 390,
    height: 844,
    isMobile: true,
    hasTouch: true,
    deviceScaleFactor: 2,
  };
}

export async function startBrowserSession({
  url,
  device,
  waitUntil,
  timeout,
  headless,
  logger,
}) {
  const remoteDebuggingPort = await getAvailablePort();
  const viewport = getViewport(device);
  const browser = await chromium.launch({
    headless,
    args: [`--remote-debugging-port=${remoteDebuggingPort}`],
  });

  const context = await browser.newContext({
    viewport: {
      width: viewport.width,
      height: viewport.height,
    },
    deviceScaleFactor: viewport.deviceScaleFactor,
    isMobile: viewport.isMobile,
    hasTouch: viewport.hasTouch,
  });

  context.setDefaultNavigationTimeout(timeout);
  context.setDefaultTimeout(timeout);

  const page = await context.newPage();
  logger.info('Navigating with Playwright', { url, device, waitUntil });
  await page.goto(url, { waitUntil, timeout });
  await page.waitForLoadState('networkidle', { timeout });

  return {
    browser,
    context,
    page,
    remoteDebuggingPort,
  };
}

export async function stopBrowserSession(session) {
  await session.context.close();
  await session.browser.close();
}
