import sharp from 'sharp';

function getDocumentMetrics() {
  return {
    documentHeight: Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight
    ),
    viewportHeight: window.innerHeight,
    viewportWidth: window.innerWidth,
    dpr: window.devicePixelRatio || 1,
    scrollTop: window.scrollY || window.pageYOffset || 0,
  };
}

async function cropSegment(buffer, cropTopCss, cropHeightCss, viewportHeightCss) {
  const image = sharp(buffer);
  const metadata = await image.metadata();

  if (!metadata.height || !metadata.width) {
    throw new Error('Unable to read screenshot metadata for stitching');
  }

  const pixelScale = metadata.height / viewportHeightCss;
  const top = Math.max(0, Math.round(cropTopCss * pixelScale));
  const height = Math.min(
    metadata.height - top,
    Math.max(1, Math.round(cropHeightCss * pixelScale))
  );

  return image
    .extract({
      left: 0,
      top,
      width: metadata.width,
      height,
    })
    .png()
    .toBuffer();
}

export async function scrollAndCapture(page, { logger, viewportName }) {
  const metrics = await page.evaluate(getDocumentMetrics);
  const segments = [];
  const totalSegments = Math.max(1, Math.ceil(metrics.documentHeight / metrics.viewportHeight));
  const maxScrollTop = Math.max(0, metrics.documentHeight - metrics.viewportHeight);

  for (let index = 0; index < totalSegments; index += 1) {
    const desiredTop = index * metrics.viewportHeight;
    const targetTop = Math.min(desiredTop, maxScrollTop);

    await page.evaluate((scrollTop) => {
      window.scrollTo({ top: scrollTop, behavior: 'auto' });
    }, targetTop);

    await page.evaluate(async () => {
      await new Promise((resolve) => requestAnimationFrame(() => requestAnimationFrame(resolve)));
    });

    const actualMetrics = await page.evaluate(getDocumentMetrics);
    const actualTop = actualMetrics.scrollTop;
    const cropTopCss = Math.max(0, desiredTop - actualTop);
    const remainingHeight = Math.max(1, actualMetrics.documentHeight - desiredTop);
    const cropHeightCss = Math.min(actualMetrics.viewportHeight - cropTopCss, remainingHeight);

    logger.log(
      `[${viewportName}] Segment ${index + 1}/${totalSegments} scrollTop=${Math.round(actualTop)} crop=${Math.round(cropHeightCss)}`
    );

    const rawBuffer = await page.screenshot({
      type: 'png',
    });

    const buffer = await cropSegment(
      rawBuffer,
      cropTopCss,
      cropHeightCss,
      actualMetrics.viewportHeight
    );

    segments.push({
      buffer,
      top: desiredTop,
    });
  }

  await page.evaluate(() => {
    window.scrollTo({ top: 0, behavior: 'auto' });
  });

  return segments;
}
