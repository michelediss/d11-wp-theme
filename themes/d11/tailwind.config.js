/*
 * Tailwind shell configuration.
 * Primitive tokens are generated from theme.json into scripts/generated/tailwind-theme.generated.js.
 * Do not manually define canonical colors, fonts, spacing, or widths here.
 */

import generatedThemeExtend from './scripts/generated/tailwind-theme.generated.js';

export default {
  content: [
    './*.php',
    './*.html',
    './templates/**/*.html',
    './parts/**/*.html',
    './patterns/**/*.{php,html}',
    './inc/**/*.php',
    './src/js/**/*.js',
  ],
  theme: {
    extend: {
      ...generatedThemeExtend,
      borderRadius: {
        ...(generatedThemeExtend.borderRadius ?? {}),
        card: 'var(--wp--custom--radius--lg)',
      },
      boxShadow: {
        card: '0 18px 45px -24px color-mix(in srgb, var(--wp--preset--color--black) 22%, transparent)',
      },
    },
  },
  plugins: [],
};
