<?php 

function getCurrentArchive() {
    global $wp_query;

    if (is_archive()) {
        return [
            'title' => get_the_archive_title(),
            'description' => get_the_archive_description(),
            'posts' => Timber::get_posts($wp_query) // Uses global $wp_query for the current archive
        ];
    }
    return null;
}

add_filter('timber/context', function ($context) {
    $context['CurrentArchive'] = getCurrentArchive();
    return $context;
});