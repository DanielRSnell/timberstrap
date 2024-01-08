<?php 

$base_dir = get_stylesheet_directory() . '/extensions/unocss/';


// Register Paths for File Loader.
require $base_dir . '/endpoints/save.php';

add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory() . '/extensions/unocss/';

    // Assigning each path to its respective key
    $paths['unocss'] = [$theme_directory . '/views'];

    // Dynamic is a new directory for Twig Templates that use version control.

    /* Example Usage: 

    {% include '@dynamic/hero.extension' %}

    */


    return $paths;
});