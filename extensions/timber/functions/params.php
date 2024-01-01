<?php 

add_filter('timber/context', function ($context) {

    $context['params'] = get_params_object();

    return $context;
});



function get_params_object() {
    // Get all query parameters
    $queryParams = $_GET;

    $attributes = [];
    foreach ($queryParams as $key => $value) {
        // If the parameter is not 'email', prefix it with 'metadata__'
        if ($key !== 'email') {
            $key = $key;
        }
        $attributes[$key] = sanitize_text_field($value);
    }

    return $attributes;
}
