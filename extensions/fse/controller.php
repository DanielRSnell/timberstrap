<?php


function lc_section_block_render_callback($block, $content = '', $is_preview = false) {

    // Prepare the context for Timber
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    $context['state'] = $context;

    // Rener template content as block template with Timber from post_content string
    Timber::render_string($block['timber'] -> post_content, $context);
}




function register_acf_blocks_from_lc_sections() {
    if (function_exists('acf_register_block_type')) {
        $lc_sections = get_posts([
            'post_type' => 'lc_section',
            'numberposts' => -1 // Retrieve all posts
        ]);

        foreach ($lc_sections as $section) {
            acf_register_block_type([
                'name' => sanitize_title($section->post_name),
                'title' => $section->post_name,
                'render_callback' =>  'lc_section_block_render_callback',
                'category' => 'formatting',
                'timber' => $section
            ]);
        }
    }
}

add_action('acf/init', 'register_acf_blocks_from_lc_sections');


function mychildtheme_add_gutenberg_styles() {
    // Add support for editor styles
    add_theme_support('editor-styles');

    // Remove all previously enqueued editor styles
    remove_editor_styles();

    // Define the path to the editor stylesheet
    $editor_style_path = get_stylesheet_directory_uri() . '/css-output/tailwind.css';

    // Enqueue the editor style
    add_editor_style($editor_style_path);
}

add_action('after_setup_theme', 'mychildtheme_add_gutenberg_styles');




function timber_block_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    $context['state'] = $context;

    // Assuming that $block['timber'] contains a relative path from the theme root
    Timber::render($block['timber'], $context);
}



add_action('acf/init', 'register_acf_blocks_from_directories');


function register_acf_blocks_from_directories() {
    if (function_exists('acf_register_block_type')) {
        $directories = [
            'template-livecanvas-sections' => 'section', // Relative path from theme root
            'template-livecanvas-blocks' => 'block'
        ];

        foreach ($directories as $dir => $prefix) {
            $files = glob(get_theme_file_path() . '/' . $dir . '/*.twig'); // Ensure full file path for glob

            foreach ($files as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $name = $prefix . '-' . strtolower($filename);
                $title = ucwords(str_replace('-', ' ', $filename));

                // Store relative path from theme root
                $relative_path = $dir . '/' . basename($file);

                acf_register_block_type([
                    'name' => $name,
                    'title' => $title,
                    'render_callback' => 'timber_block_callback',
                    'category' => 'formatting',
                    'timber' => $relative_path
                ]);
            }
        }
    }
}