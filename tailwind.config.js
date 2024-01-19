/**
 * Main Tailwind Configuration (tailwind.config.js)
 *
 * Purpose:
 * This configuration file is the primary Tailwind CSS configuration for the project. It includes settings 
 * for JIT mode, content paths, safelisting, and plugins necessary for both development and production environments.
 *
 * Integration with Editor Configuration:
 * - The `editorConfig`, imported from './tailwind.editor.js', contains specific settings tailored for the 
 *   LiveCanvas editor. This configuration enhances the development experience by providing real-time visual 
 *   feedback within the editor.
 * - By integrating `editorConfig` into the main configuration file, we ensure a consistent styling experience 
 *   across the entire project. This integration allows for seamless transitions of styles and themes from the 
 *   LiveCanvas editor to the broader project context.
 * - It's crucial to maintain alignment between `editorConfig` and this main configuration to ensure 
 *   consistency across development and production environments.
 *
 * Plugins:
 * - This configuration includes several Tailwind CSS plugins such as 'flowbite-typography', '@tailwindcss/typography', 
 *   '@tailwindcss/forms', and 'flowbite/plugin'. These plugins extend the utility of Tailwind CSS within the project.
 * - Custom plugins, like those adding variants for 'htmx', are also defined here, enriching the project with 
 *   additional functionality.
 *
 * Usage:
 * - For general project development, this configuration file should be used.
 * - When working within the LiveCanvas editor, keep in mind that `editorConfig` will provide specific 
 *   enhancements and settings that are reflected here.
 * - Modify `editorConfig` for editor-specific changes and this file for global Tailwind CSS settings applicable 
 *   across the project.
 */

const plugin = require('tailwindcss/plugin')
const editorConfig = require('./tailwind.editor.js');

module.exports = {
  mode: 'jit',
  content: [
    // Existing paths
    // './**/*.{php,twig,html,css}',
    './extensions/inc/assets/index.html',
    './css-output/bundle.css',
    // Paths for template-livecanvas-*
    // './template-livecanvas-blocks/**/*.{php,twig,html,css}',
    // './template-livecanvas-sections/**/*.{php,twig,html,css}',
    // './template-livecanvas-partials/**/*.{php,twig,html,css}',
    // './template-livecanvas-dynamic-templates/**/*.{php,twig,html,css}',
    // './template-livecanvas-snippets/**/*.{php,twig,html,css}',
  ],
  safelist: process.env.GENERATE_AUTOCOMPLETE
      ? [{ pattern: /./ }]
      : [], 
  ...editorConfig,
   plugins: [
        require('flowbite-typography'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('flowbite/plugin'),
        plugin(function({ addVariant }) {
            addVariant('htmx-settling', ['&.htmx-settling', '.htmx-settling &']);
            addVariant('htmx-request',  ['&.htmx-request',  '.htmx-request &']);
            addVariant('htmx-swapping', ['&.htmx-swapping', '.htmx-swapping &']);
            addVariant('htmx-added',    ['&.htmx-added',    '.htmx-added &']);
        }),
        // ... additional plugins if any ...
    ]
}
