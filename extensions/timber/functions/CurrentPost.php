<?php 

function getCurrentPost() {
    global $post;
    if ($post) {
        return Timber::get_post($post);
    }
    return null;
}

add_filter('timber/context', function ($context) {
    $context['CurrentPost'] = getCurrentPost();
    return $context;
});