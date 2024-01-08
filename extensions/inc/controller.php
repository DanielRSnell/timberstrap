<?php 

$ADMIN_DIR = get_stylesheet_directory() . '/extensions/inc/';

// List of directories to include files from.
$directories = ['admin', 'snippets'];

foreach ($directories as $dir) {
    $full_dir_path = $ADMIN_DIR . $dir;

    // Check if directory exists.
    if (file_exists($full_dir_path) && is_dir($full_dir_path)) {
        // Include all PHP files from the directory.
        foreach (new DirectoryIterator($full_dir_path) as $file) {
            if ($file->isFile() && $file->getExtension() == 'php') {
                require_once $file->getPathname();
            }
        }
    }
}


add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory() . '/extensions/inc/admin';

    // Assigning each path to its respective key
    $paths['admin'] = [$theme_directory . '/views'];
    // Dynamic is a new directory for Twig Templates that use version control.

    /* Example Usage: 

    {% include '@dynamic/hero.extension' %}

    */


    return $paths;
});