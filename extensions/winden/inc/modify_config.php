<?php 

add_action('admin_notices', function() {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>Modify Config is active - tailwind.config.js found.</p>';
    echo '</div>';
});


add_filter('f!winden/core/runtime:tailwind_config_cdn', function($config_cdn) {
    // Get the path to the tailwind.config.js in the current theme
    $tailwind_config_path = get_stylesheet_directory() . '/tailwind.config.js';

    // Check if the tailwind.config.js file exists in the theme
    if (file_exists($tailwind_config_path)) {
        // Read the contents of the tailwind.config.js file
        $tailwind_config_content = file_get_contents($tailwind_config_path);

        // Replace 'module.exports' with 'tailwind.config' in the file content
        $tailwind_config_content = str_replace('module.exports', 'tailwind.config', $tailwind_config_content);

        // Return the modified content
        return $tailwind_config_content;
    }
    
    // If the file doesn't exist, return the original config
    return $config_cdn;
});

add_filter('f!winden/core/runtime:tailwind_config', function($config) {
    // Get the path to the tailwind.config.js in the current theme
    $tailwind_config_path = get_stylesheet_directory() . '/tailwind.config.js';

     // Check if the tailwind.config.js file exists in the theme
    if (file_exists($tailwind_config_path)) {
        // Read the contents of the tailwind.config.js file
        $tailwind_config_content = file_get_contents($tailwind_config_path);

        // Replace 'module.exports' with 'tailwind.config' in the file content
        // $tailwind_config_content = str_replace('module.exports', 'tailwind.config', $tailwind_config_content);

        // Return the modified content
        return $tailwind_config_content;
    }
    
    // If the file doesn't exist, return the original config
    return $config;
});