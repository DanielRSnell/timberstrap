<?php 

$BASE_DIR = get_stylesheet_directory() . '/extensions';

require_once $BASE_DIR . '/class-tgm-plugin-activation.php';

// add_action( 'tgmpa_register', 'prefix_register_required_plugins' );

// function prefix_register_required_plugins() {
//     $plugins = [
//         [
//             'name'     => 'Meta Box',
//             'slug'     => 'meta-box',
//             'required' => true,
//         ],
//     ];
//     $config  = [
//         'id' => 'timberstrap',
//     ];
//     tgmpa( $plugins, $config );
// }

// Load Timber Extension.
require $BASE_DIR . '/timber/controller.php';

require $BASE_DIR . '/inc/controller.php'; // Extension admin settings page.



// Get the values of the options
$markup_parsing_enabled = get_option('markup_parsing');
$alpine_integration_enabled = get_option('alpine_integration');
$tailwind_integration_enabled = get_option('tailwind_integration');
$development_mode_enabled = get_option('vite_development_mode');


if ($tailwind_integration_enabled) {
    require $BASE_DIR . '/tailwind/controller.php';
}

if ($markup_parsing_enabled) {
    require $BASE_DIR . '/parse/controller.php';
}

if ($alpine_integration_enabled) {
    require $BASE_DIR . '/alpine/controller.php';
}


if ($development_mode_enabled) {

function check_env_for_wordpress() {
    // Get the absolute path to the child theme directory
    $child_theme_path = get_stylesheet_directory();

    // Set the path to the .env file within the child theme directory
    $env_path = $child_theme_path . '/.env';

    // Read the .env file content
    $env_content = file_exists($env_path) ? file_get_contents($env_path) : false;

    if (!$env_content) {
        // .env file does not exist
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>The .env file is missing from the child theme directory.</p></div>';
        });
        return;
    }

    $vite_wp_local_url = 'not set';
    foreach (explode("\n", $env_content) as $line) {
        if (strpos(trim($line), 'VITE_WP_LOCAL_URL') === 0) {
            list(, $vite_wp_local_url) = explode('=', $line, 2);
            $vite_wp_local_url = trim($vite_wp_local_url);
            break;
        }
    }

    if ($vite_wp_local_url === 'http://timberstrap-example.local') {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible"><p>Please update VITE_WP_LOCAL_URL in your .env file within the child theme directory.</p></div>';
        });
    } elseif ($vite_wp_local_url === 'not set') {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible"><p>VITE_WP_LOCAL_URL is not set in your .env file within the child theme directory.</p></div>';
        });
    } else {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>Timberstrap is now active with the current settings.</p></div>';
        });
    }
}

add_action('admin_init', 'check_env_for_wordpress');

// Enable Endpoints
require get_stylesheet_directory() . '/extensions/inc/assets/endpoints_filter.php';
}