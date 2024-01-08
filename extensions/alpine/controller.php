<?php 


function enqueue_custom_scripts() {
    wp_enqueue_script('headless-ui', get_stylesheet_directory_uri() . '/js/headless-ui/ui.js', array(), null, false);
    wp_enqueue_script('alpine-focus', get_stylesheet_directory_uri() . '/js/alpine/focus.js', array(), null, false);
    wp_enqueue_script('collapse', get_stylesheet_directory_uri() . '/js/alpine/collapse.js', array(), null, false);
    wp_enqueue_script('alpine', get_stylesheet_directory_uri() . '/js/alpine.js', array(), null, false);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function add_defer_attribute($tag, $handle) {
    // The handles of the enqueued scripts we want to defer
    $defer_scripts = array('headless-ui', 'alpine-focus', 'collapse', 'alpine');

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer="defer" src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);