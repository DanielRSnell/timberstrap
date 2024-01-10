<?php 

function json_encode_for_js($data) {
    return htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
}

add_filter('timber/twig/functions', function ($functions) {
    // Add the custom function
    $functions['ScriptSafe'] = [
        'callable' => 'json_encode_for_js',
    ];
    return $functions;
});