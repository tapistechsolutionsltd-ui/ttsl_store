/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50:  '#eff6ff',
          100: '#dbfef2',
          200: '#bfd8fe',
          300: '#93cafd',
          400: '#60c1fa',
          500: '#3ba2f6',
          600: '#2376d4',
          700: '#224ea0',
          800: '#1e59b1',
          900: '#002c7e',
        },
        brand: {
          DEFAULT: '#054880',
          light:   '#212926',
          dark:    '#222523',
        },
        accent: {
          DEFAULT: '#005ca8ec',
          light:   'hsl(335, 52%, 42%)',
          dark:    '#b60b69',
        }
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
    },
  },
  plugins: [],
}
