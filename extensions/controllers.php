<?php 

$BASE_DIR = get_stylesheet_directory() . '/extensions';

// Load Timber Extension.
require $BASE_DIR . '/timber/controller.php';

require $BASE_DIR . '/inc/controller.php'; // Extension admin settings page.



// Get the values of the options
$unocss_enabled = get_option('unocss');
$markup_parsing_enabled = get_option('markup_parsing');
$alpine_integration_enabled = get_option('alpine_integration');


// Conditionally require the files
if ($unocss_enabled) {
    require $BASE_DIR . '/unocss/controller.php';
}

if ($markup_parsing_enabled) {
    require $BASE_DIR . '/parse/controller.php';
}

if ($alpine_integration_enabled) {
    require $BASE_DIR . '/alpine/controller.php';
}