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
darkMode: 'media',
  theme: {
     fontSize: {
      xs: [
        "0.75rem",
        {
          lineHeight: "1rem",
        },
      ],
      sm: [
        "0.875rem",
        {
          lineHeight: "1.5rem",
        },
      ],
      base: [
        "1rem",
        {
          lineHeight: "1.75rem",
        },
      ],
      lg: [
        "1.125rem",
        {
          lineHeight: "2rem",
        },
      ],
      xl: [
        "1.25rem",
        {
          lineHeight: "2rem",
        },
      ],
      "2xl": [
        "1.5rem",
        {
          lineHeight: "2rem",
        },
      ],
      "3xl": [
        "2rem",
        {
          lineHeight: "2.5rem",
        },
      ],
      "4xl": [
        "2.5rem",
        {
          lineHeight: "3.5rem",
        },
      ],
      "5xl": [
        "3rem",
        {
          lineHeight: "3.5rem",
        },
      ],
      "6xl": [
        "3.75rem",
        {
          lineHeight: "1",
        },
      ],
      "7xl": [
        "4.5rem",
        {
          lineHeight: "1.1",
        },
      ],
      "8xl": [
        "6rem",
        {
          lineHeight: "1",
        },
      ],
      "9xl": [
        "8rem",
        {
          lineHeight: "1",
        },
      ],
    },
    extend: {
      boxShadow: {
        thick: "0px 7px 32px rgb(0 0 0 / 35%);",
      },
      colors: {
        // Gray
        "primary": "#101010",
  "secondary": "#1a1a1a",
  "tertiary": "#262626",
        // Purple
        //primary:"#080118",
        //secondary:"#140d23",
        //tertiary:"#1d1333",
        white:"#ececec",
      },
      borderRadius: {
        "4xl": "2rem",
        "5xl": "3rem",
        "6xl": "5rem",
      },
    },
  },
  corePlugins: {
    preflight: true,
  },
}


