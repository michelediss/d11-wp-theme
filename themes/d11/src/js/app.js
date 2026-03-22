/*
 * Entry point for the theme front-end. It initializes the small progressive-enhancement modules
 * used across block templates and patterns.
 */

import { initMenuReveal } from './modules/menu';
import { initPatternHooks } from './patterns/index';

function scheduleNonCriticalTask(task) {
  const runTask = () => {
    void task();
  };

  if (typeof window.requestIdleCallback === 'function') {
    window.requestIdleCallback(runTask, { timeout: 1500 });
    return;
  }

  window.setTimeout(runTask, 1);
}

function bootstrap() {
  initMenuReveal();
  initPatternHooks();

  if (document.querySelector('[data-fade-in]:not(.no-fadein)')) {
    scheduleNonCriticalTask(async () => {
      const { initFadeIn } = await import('./modules/fade-in');
      initFadeIn();
    });
  }

  if (document.querySelector('[data-swiper]')) {
    scheduleNonCriticalTask(async () => {
      const { initSwipers } = await import('./modules/swiper');
      initSwipers();
    });
  }

  if (document.getElementById('simple-cookie-consent-banner')) {
    scheduleNonCriticalTask(async () => {
      const { initSimpleCookieConsentBanner } = await import('./modules/simple-cookie-consent-banner');
      initSimpleCookieConsentBanner();
    });
  }

  scheduleNonCriticalTask(async () => {
    const { initPageTransitions } = await import('./modules/page-transitions');
    initPageTransitions();
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bootstrap, { once: true });
} else {
  bootstrap();
}
