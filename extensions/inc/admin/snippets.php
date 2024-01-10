<?php 

function enqueue_ace_and_alpine_scripts() {
    $screen = get_current_screen();
    if ($screen->post_type === 'lc_snippets') {
        wp_enqueue_script('ace-editor', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js', [], '1.4.12', true);
        wp_enqueue_script('alpinejs', 'https://unpkg.com/alpinejs', [], null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_ace_and_alpine_scripts');



function replace_editor_with_ace() {
    global $post_type;
    if ('lc_snippets' == $post_type) {
        remove_post_type_support('lc_snippets', 'editor');
        add_meta_box('custom_ace_editor', 'Snippet Editor', 'custom_ace_editor_callback', 'lc_snippets', 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'replace_editor_with_ace');

function custom_ace_editor_callback($post) {
    
    $context = Timber::context();
    $context['state'] = $context;

    Timber::render('@admin/editor.twig', $context);
}

function disable_wpautop_for_snippets($content) {
    global $post;

    if (isset($post) && $post->post_type === 'lc_snippets') {
        remove_filter('the_content', 'wpautop');
    }

    return $content;
}

add_filter('the_content', 'disable_wpautop_for_snippets', 0);