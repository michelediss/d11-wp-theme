function clamp(value, min, max) {
  return Math.min(Math.max(value, min), max);
}

async function waitForImages(page) {
  await page.evaluate(async () => {
    const images = Array.from(document.images);

    for (const image of images) {
      image.loading = 'eager';
      image.decoding = 'sync';

      if (!image.currentSrc && image.dataset?.src) {
        image.src = image.dataset.src;
      }
    }

    await Promise.all(
      images.map(async (image) => {
        if (!image.complete) {
          await new Promise((resolve) => {
            const done = () => resolve();
            image.addEventListener('load', done, { once: true });
            image.addEventListener('error', done, { once: true });
          });
        }

        if (typeof image.decode === 'function') {
          try {
            await image.decode();
          } catch {
            // Ignore decode failures, capture should continue with the current bitmap.
          }
        }
      })
    );
  });
}

export async function forceLazyLoad(page, { logger, timeout }) {
  const pageMetrics = await page.evaluate(() => ({
    documentHeight: Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight
    ),
    viewportHeight: window.innerHeight,
  }));

  const step = clamp(
    Math.round(pageMetrics.documentHeight / 12),
    400,
    Math.max(pageMetrics.viewportHeight, 1200)
  );

  logger.log(`[lazy] Warm-up scroll with step ${step}px`);

  let previousHeight = 0;
  let unchangedPasses = 0;
  const deadline = Date.now() + timeout;

  while (Date.now() < deadline && unchangedPasses < 2) {
    const currentHeight = await page.evaluate(() =>
      Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight,
        document.body.offsetHeight,
        document.documentElement.offsetHeight
      )
    );

    const maxScrollTop = Math.max(0, currentHeight - pageMetrics.viewportHeight);

    for (let offset = 0; offset <= maxScrollTop; offset += step) {
      await page.evaluate((scrollTop) => {
        window.scrollTo({ top: scrollTop, behavior: 'auto' });
      }, offset);

      await page.waitForTimeout(120);
    }

    await page.evaluate(() => {
      window.scrollTo({ top: document.documentElement.scrollHeight, behavior: 'auto' });
    });
    await page.waitForTimeout(200);

    await waitForImages(page);

    const nextHeight = await page.evaluate(() =>
      Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight,
        document.body.offsetHeight,
        document.documentElement.offsetHeight
      )
    );

    unchangedPasses = nextHeight === previousHeight ? unchangedPasses + 1 : 0;
    previousHeight = nextHeight;
  }

  await page.evaluate(() => {
    window.scrollTo({ top: 0, behavior: 'auto' });
  });

  await page.waitForTimeout(150);
  logger.log('[lazy] Completed preload pass');
}
