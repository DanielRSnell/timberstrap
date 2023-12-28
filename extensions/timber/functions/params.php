<?php 

add_filter('timber/twig/functions', function ($functions) {
    // Adding your custom functions
    $functions['get_any_var'] = ['callable' => 'get_any_var'];
    $functions['get_params_object'] = ['callable' => 'get_params_object'];
    $functions['get_string_vars'] = ['callable' => 'get_string_vars'];
    $functions['has_query_params'] = ['callable' => 'has_query_params'];

    return $functions;
});


function get_any_var($var_name) {
    if (isset($_GET[$var_name])) {
        return sanitize_text_field($_GET[$var_name]);
    }
    return null;
}

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


function get_string_vars() {
    if (!empty($_GET)) {
        // Sanitize each query variable
        $clean_vars = array_map('sanitize_text_field', $_GET);

        // Create a stringified version of the query vars
        $output = 'domain.com/string?' . http_build_query($clean_vars);

        // Create an array of strings, each in "key=value" format, and an array of values
        $vars = array();
        $values = array();
        foreach ($clean_vars as $key => $value) {
            $vars[] = "{$key}={$value}";
            $values[] = $value;
        }

        // Create a string with the values separated by a comma and a space
        $values_string = implode(', ', $values);

        // Return the results
        return array(
            'output' => $output,
            'vars' => $vars,
            'values' => $values_string
        );
    } else {
        return array(
            'output' => '',
            'vars' => array(),
            'values' => ''
        );
    }
};

add_filter('rwmb_frontend_shortcode_params', function ($params) {
    $params['get_any_var'] = 'get_any_var';
    $params['get_string_vars'] = 'get_string_vars';
    return $params;
});

function has_query_params() {
    return !empty($_GET);
}