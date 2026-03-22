import sharp from 'sharp';

export async function stitchImages(buffers) {
  if (buffers.length === 0) {
    throw new Error('Cannot stitch an empty image set');
  }

  const images = await Promise.all(
    buffers.map(async (buffer) => ({
      buffer,
      metadata: await sharp(buffer).metadata(),
    }))
  );

  const baseWidth = images[0].metadata.width;
  if (!baseWidth) {
    throw new Error('Unable to determine stitched image width');
  }

  let totalHeight = 0;
  const composite = images.map(({ buffer, metadata }) => {
    if (!metadata.width || !metadata.height) {
      throw new Error('Unable to determine segment size during stitching');
    }

    if (metadata.width !== baseWidth) {
      throw new Error('Segment widths differ; stitching would be invalid');
    }

    const top = totalHeight;
    totalHeight += metadata.height;

    return {
      input: buffer,
      left: 0,
      top,
    };
  });

  return sharp({
    create: {
      width: baseWidth,
      height: totalHeight,
      channels: 4,
      background: '#ffffff',
    },
  })
    .composite(composite)
    .png()
    .toBuffer();
}
