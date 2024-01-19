/**
 * Tailwind Editor Configuration (tailwind.editor.js)
 *
 * Purpose:
 * This configuration file is tailored for the LiveCanvas editor environment and is a crucial part of the 
 * development workflow. It provides real-time styling capabilities within LiveCanvas, enhancing the developer 
 * experience by allowing immediate visual feedback without the need for constant page refreshes.
 *
 * Key Features:
 * - Dark mode support for flexible theming within the editor.
 * - An extensive color palette with custom `brand`, `accent`, and `support` colors, among others, for rich 
 *   styling options.
 * - Custom `fontFamily` settings for consistent typography across the editor.
 * - Core plugins like `preflight` are included to ensure essential Tailwind CSS functionalities.
 *
 * Integration with Main Tailwind Configuration:
 * The settings defined in this file (`tailwind.editor.js`) are not standalone; they are imported into the 
 * main Tailwind configuration file (`tailwind.config.js`). This integration ensures that the customizations 
 * made for the LiveCanvas editor are consistently applied across the entire project. Any styles or themes 
 * developed within the editor are seamlessly transferred to the main build process handled by Vite, 
 * making the transition from development to production smooth and efficient.
 *
 * Usage:
 * The configuration is used exclusively within the LiveCanvas editor for real-time visual updates. It's 
 * important to note that this file should be kept in sync with the main Tailwind configuration to maintain 
 * consistency across development and production environments.
 */


module.exports = {
darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
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
        secondary: {
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
	fontFamily: {
      body: [
        'Montserrat',
        'ui-sans-serif',
        'system-ui',
        '-apple-system',
        'system-ui',
        'Segoe UI',
        'Roboto',
        'Helvetica Neue',
        'Arial',
        'Noto Sans',
        'sans-serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol',
        'Noto Color Emoji',
      ],
      sans: [
        'Montserrat',
        'ui-sans-serif',
        'system-ui',
        '-apple-system',
        'system-ui',
        'Segoe UI',
        'Roboto',
        'Helvetica Neue',
        'Arial',
        'Noto Sans',
        'sans-serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol',
        'Noto Color Emoji',
      ],
    },
    },
  },

  corePlugins: {
    preflight: true,
  },
}


