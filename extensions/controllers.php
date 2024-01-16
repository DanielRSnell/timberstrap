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

if ($tailwind_integration_enabled) {
    require $BASE_DIR . '/tailwind/controller.php';
}

if ($markup_parsing_enabled) {
    require $BASE_DIR . '/parse/controller.php';
}

if ($alpine_integration_enabled) {
    require $BASE_DIR . '/alpine/controller.php';
}