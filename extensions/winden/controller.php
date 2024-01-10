<?php 

namespace Timberstrap;

// Ensure WordPress functions are available, especially if this code runs early in your plugin file.
if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

// Hook into admin notices to check for the Winden plugin's active status.
add_action('admin_notices', function() {
    // Specify the correct path to the main Winden plugin file.
    $winden_plugin_path = 'winden/wakaloka-winden.php';

    // Check if Winden is not active.
    if (!is_plugin_active($winden_plugin_path)) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Winden plugin is not active.</strong> Timberstrap requires Winden to function properly.</p>';
        echo '</div>';
    }
});

$base_dir = get_stylesheet_directory() . '/extensions/winden/';

// Register Paths for File Loader.
require $base_dir . 'inc/load_cache_builder.php';
require $base_dir . 'inc/modify_config.php';
require $base_dir . 'inc/modify_global_css.php';
require $base_dir . 'inc/modify_payload.php';
require $base_dir . 'inc/load_completions.php';


add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory() . '/extensions/winden';

    // Assigning each path to its respective key
    $paths['winden'] = [$theme_directory . '/views'];

    return $paths;
});