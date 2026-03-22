const FREEZE_STYLE_ID = '__screenshot_freeze_styles__';
const EXCLUDE_STYLE_ID = '__screenshot_exclude_styles__';

function buildExcludeCss(selectors) {
  if (!selectors.length) {
    return '';
  }

  const rule = selectors.join(',\n');
  return `${rule} { visibility: hidden !important; opacity: 0 !important; }`;
}

export async function preparePage(page, { excludeSelectors = [], logger }) {
  await page.addStyleTag({
    content: `
      html {
        scroll-behavior: auto !important;
      }

      *, *::before, *::after {
        animation: none !important;
        transition: none !important;
        caret-color: transparent !important;
      }
    `,
  });

  if (excludeSelectors.length > 0) {
    await page.evaluate(
      ({ styleId, cssText }) => {
        let style = document.getElementById(styleId);
        if (!style) {
          style = document.createElement('style');
          style.id = styleId;
          document.head.append(style);
        }

        style.textContent = cssText;
      },
      {
        cssText: buildExcludeCss(excludeSelectors),
        styleId: EXCLUDE_STYLE_ID,
      }
    );
  }

  const neutralizedCount = await page.evaluate((styleId) => {
    let style = document.getElementById(styleId);

    if (!style) {
      style = document.createElement('style');
      style.id = styleId;
      style.textContent = `
        [data-screenshot-neutralized-position="fixed"] {
          position: absolute !important;
        }

        [data-screenshot-neutralized-position="sticky"] {
          position: relative !important;
        }

        [data-screenshot-neutralized="true"] {
          top: auto !important;
          right: auto !important;
          bottom: auto !important;
          left: auto !important;
          inset: auto !important;
          transform: none !important;
        }
      `;

      document.head.append(style);
    }

    const allElements = Array.from(document.body.querySelectorAll('*'));
    let neutralized = 0;

    for (const element of allElements) {
      const computed = window.getComputedStyle(element);
      if (computed.position !== 'fixed' && computed.position !== 'sticky') {
        continue;
      }

      if (computed.display === 'none' || computed.visibility === 'hidden') {
        continue;
      }

      element.setAttribute('data-screenshot-neutralized', 'true');
      element.setAttribute('data-screenshot-neutralized-position', computed.position);
      neutralized += 1;
    }

    return neutralized;
  }, FREEZE_STYLE_ID);

  await page.evaluate(async () => {
    await new Promise((resolve) => requestAnimationFrame(() => requestAnimationFrame(resolve)));
  });

  logger.log(`[prepare] Styles frozen; exclusions applied: ${excludeSelectors.length}`);
  return { neutralizedCount };
}
