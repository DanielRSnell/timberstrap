<?php 

function complete_post_object($post, $raw_meta = false) {
    if (!$post instanceof \Timber\Post) {
        return [];
    }

    // Initialize the array with post data
    $post_array = get_object_vars($post);

    // Add thumbnail
    $post_array['thumbnail'] = $post->thumbnail() ? $post->thumbnail() : null;

    // Add terms associated with the post
    $post_array['terms'] = Timber::get_terms(['post' => $post->ID]);

    // Handle custom fields based on $raw_meta and the presence of ACF or Metabox
    if ($raw_meta) {
        $post_array['fields'] = $post->meta();
    } else {
        if (function_exists('get_fields')) {
            // ACF is active
            $post_array['fields'] = get_fields($post->ID);
        } elseif (is_callable('rwmb_meta')) {
            // Metabox is active
            // Assuming you have a function or a way to retrieve all Metabox fields
            $post_array['fields'] = rwmb_get_all_fields_values($post->ID);
        } else {
            $post_array['fields'] = $post->meta();
        }
    }

    return $post_array;
}


add_filter('timber/twig/functions', function ($functions) {
    // Add the custom function
    $functions['CompletePost'] = [
        'callable' => 'complete_post_object',
    ];
    return $functions;
});