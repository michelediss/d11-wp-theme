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
      colors: {
        white: '#ffffff',
        black: '#111111',
        light: '#f5efe3',
        primary: '#e5232f',
        accent: '#f58a1f',
      },
      fontFamily: {
        heading: ['"Space Grotesk"', 'sans-serif'],
        paragraph: ['"Inter"', 'sans-serif'],
      },
      fontSize: {
        hero: ['clamp(4rem, 9vw, 8rem)', { lineHeight: '0.88', letterSpacing: '-0.03em' }],
        display: ['clamp(2.5rem, 5vw, 4.5rem)', { lineHeight: '0.92', letterSpacing: '-0.02em' }],
        'section-title': ['clamp(1.75rem, 3vw, 3rem)', { lineHeight: '1.1' }],
      },
      letterSpacing: {
        tightest: '-0.03em',
        brand: '0.1em',
        wide: '0.14em',
      },
      lineHeight: {
        flat: '0.95',
      },
      spacing: {
        xs: '0.5rem',
        sm: '1rem',
        md: '1.5rem',
        lg: '3rem',
        xl: '5rem',
        '2xl': '6rem',
        '3xl': '8rem',
      },
      maxWidth: {
        content: '48rem',
        wide: '80rem',
      },
      borderRadius: {
        sm: '0.375rem',
        md: '0.75rem',
        lg: '1.5rem',
        pill: '999px',
        card: '1.5rem',
      },
      boxShadow: {
        card: '0 18px 45px -24px rgb(17 17 17 / 0.22)',
        panel: '0 24px 60px rgb(17 17 17 / 0.18)',
      },
    },
  },
  plugins: [],
};
