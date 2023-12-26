<?php 


add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory();

    // Assigning each path to its respective key
    $paths['blocks'] = [$theme_directory . '/template-livecanvas-blocks'];
    $paths['sections'] = [$theme_directory . '/template-livecanvas-sections'];
    $paths['partials'] = [$theme_directory . '/template-livecanvas-partials'];
    $paths['dynamic'] = [$theme_directory . '/template-livecanvas-dynamic'];
    // Dynamic is a new directory for Twig Templates that use version control.

    /* Example Usage: 

    {% include '@dynamic/hero.extension' %}

    */


    return $paths;
});