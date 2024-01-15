<?php 

add_action('rest_api_init', function () {
    register_rest_route('timberstrap/v1', '/fetch_content', array(
        'methods' => 'GET',
        'callback' => 'fetch_concatenated_content',
    ));
});

function fetch_concatenated_content($request) {
    // Default post types
    $post_types = array('lc_block', 'lc_partial', 'lc_section', 'lc_dynamic_template', 'page');

    // Apply filter to allow adding more post types
    $post_types = apply_filters('my_custom_endpoint_post_types', $post_types);

    // Initialize content string
    $concatenated_content = '';

    foreach ($post_types as $post_type) {
        $posts = get_posts(array('post_type' => $post_type, 'numberposts' => -1));
        foreach ($posts as $post) {
            $concatenated_content .= $post->post_content;
        }
    }

    return $concatenated_content;
}

// Filter function for adding more post types
function add_more_post_types($post_types) {
    // Example: adding 'post' post type
    $post_types[] = 'post';
    return $post_types;
}
add_filter('my_custom_endpoint_post_types', 'add_more_post_types');