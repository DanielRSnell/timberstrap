<?php 

// Get the base directory for the Timber extensions.
$base_dir = get_stylesheet_directory() . '/extensions/parse/';

// List of directories to include files from.
$directories = ['inc'];

foreach ($directories as $dir) {
    $full_dir_path = $base_dir . $dir;

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