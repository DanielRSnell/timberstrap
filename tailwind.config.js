module.exports = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#edfcf4',
          100: '#d2f9e1',
          200: '#aaf0ca',
          300: '#72e3ac',
          400: '#40cf8e',
          500: '#16b371',
          600: '#0a915b',
          700: '#08744b',
          800: '#095c3e',
          900: '#094b34',
          950: '#032b1d',
        },
        accent: {
          50: '#fdf2f8',
          100: '#fbe8f3',
          200: '#f9d1e8',
          300: '#f5acd4',
          400: '#ed6eb0',
          500: '#e54f98',
          600: '#d32f77',
          700: '#b71f5d',
          800: '#971d4e',
          900: '#7e1d44',
          950: '#4d0a25',
        },
        support: {
          50: '#f1f7fa',
          100: '#dceaf1',
          200: '#bdd8e4',
          300: '#8fbbd1',
          400: '#5995b5',
          500: '#3f7a9b',
          600: '#376483',
          700: '#32546c',
          800: '#30475a',
          900: '#2b3c4e',
          950: '#192633',
        },
        neutral: {},
        success: {},
        warning: {},
        error: {},
        info: {},
      },
    },
  },
  corePlugins: {
    preflight: true,
  },
  plugins: [
    require('flowbite-typography'),
	  require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/container-queries'),
    require('flowbite'),
	  plugin(function({ addVariant }) {
      addVariant('htmx-settling', ['&.htmx-settling', '.htmx-settling &'])
      addVariant('htmx-request',  ['&.htmx-request',  '.htmx-request &'])
      addVariant('htmx-swapping', ['&.htmx-swapping', '.htmx-swapping &'])
      addVariant('htmx-added',    ['&.htmx-added',    '.htmx-added &'])
    })
  ],
}
