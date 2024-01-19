<?php 


add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory();

    // Assigning each path to its respective key
    $paths['block'] = [$theme_directory . '/template-livecanvas-blocks'];
    $paths['section'] = [$theme_directory . '/template-livecanvas-sections'];
    $paths['partial'] = [$theme_directory . '/template-livecanvas-partials'];
    $paths['dynamic'] = [$theme_directory . '/template-livecanvas-dynamic'];
    $paths['snippet'] = [$theme_directory . '/template-livecanvas-snippets'];
    // Dynamic is a new directory for Twig Templates that use version control.

    /* Example Usage: 

    {% include '@dynamic/hero.extension' %}

    */


    return $paths;
});