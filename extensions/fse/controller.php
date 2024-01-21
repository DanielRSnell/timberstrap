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

    // Enqueue the editor style
    add_editor_style('css-output/tailwind.css');
}

add_action('after_setup_theme', 'mychildtheme_add_gutenberg_styles');