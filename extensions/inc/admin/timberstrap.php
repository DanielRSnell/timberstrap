<?php 

function create_custom_post_types() {
    // Register lc_snippets as a custom post type
    register_post_type('lc_snippets', [
        'labels' => [
            'name' => __('Snippets'),
            'singular_name' => __('Snippet')
        ],
        'public' => true,
        'has_archive' => false,
        'show_ui' => true,
        'show_in_menu' => 'timberstrap-options', // Show under livecanvas menu
        // Other arguments...
    ]);
}

add_action('init', 'create_custom_post_types');

function add_theme_options_page() {
    add_menu_page(
        'Timberstrap Options', // Page title
        'Timberstrap', // Menu title
        'manage_options', // Capability
        'timberstrap-options', // Menu slug
        'timberstrap_options_page', // Function to display the options page
        'dashicons-editor-code', // Icon (optional)
        81 // Position (optional)
    );

     // Submenu for Settings
    add_submenu_page(
        'timberstrap-options', // Parent slug
        'Settings', // Page title
        'Settings', // Menu title
        'manage_options', // Capability
        'timberstrap-settings', // Menu slug
        'timberstrap_options_page' // Function to display the settings page
    );
}
add_action('admin_menu', 'add_theme_options_page');

function register_timberstrap_settings() {
       // Register settings
    register_setting('timberstrap_options_group', 'markup_parsing');
    register_setting('timberstrap_options_group', 'alpine_integration');
    register_setting('timberstrap_options_group', 'tailwind_integration');
    register_setting('timberstrap_options_group', 'vite_development_mode'); // Register 'Vite Development Mode' setting

    // Add settings section
    add_settings_section(
        'timberstrap_settings_section',
        'General Settings',
        'timberstrap_settings_section_callback',
        'timberstrap-options'
    );

    // Add fields to the settings section
    add_settings_field(
        'markup_parsing_field',
        'Markup Parsing',
        'markup_parsing_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );

    add_settings_field(
        'alpine_integration_field',
        'Alpine Integration',
        'alpine_integration_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );

    add_settings_field(
        'tailwind_integration_field',
        'Tailwind Integration',
        'tailwind_integration_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );

    // Add 'Vite Development Mode' field
    add_settings_field(
        'vite_development_mode_field',
        'Vite Development Mode',
        'vite_development_mode_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );
}
add_action('admin_init', 'register_timberstrap_settings');

function timberstrap_settings_section_callback() {
    echo '<p>General settings for Timberstrap.</p>';
}

// Move all render into Timber Twig files
function markup_parsing_field_callback() {
    $markup_parsing = get_option('markup_parsing');
    echo '<input type="checkbox" id="markup_parsing" name="markup_parsing" value="1"' . checked(1, $markup_parsing, false) . '/>';
}

function alpine_integration_field_callback() {
    $alpine_integration = get_option('alpine_integration');
    echo '<input type="checkbox" id="alpine_integration" name="alpine_integration" value="1"' . checked(1, $alpine_integration, false) . '/>';
}

function tailwind_integration_field_callback() {
    $tailwind_integration = get_option('tailwind_integration');
    echo '<input type="checkbox" id="tailwind_integration" name="tailwind_integration" value="1"' . checked(1, $tailwind_integration, false) . '/>';
}

function vite_development_mode_field_callback() {
    $vite_development_mode = get_option('vite_development_mode');
    echo '<input type="checkbox" id="vite_development_mode" name="vite_development_mode" value="1"' . checked(1, $vite_development_mode, false) . '/>';
}

function timberstrap_options_page() {
    $context = Timber::context();
    $context['alpine'] =  get_stylesheet_directory_uri() . '/js/alpine.js';

    // Start output buffering
    ob_start();
    // Output settings sections and fields
    do_settings_sections('timberstrap-options');
    $context['settings_sections'] = ob_get_clean();

    ob_start();
    settings_fields('timberstrap_options_group');
    $context['settings_fields'] = ob_get_clean();

    $context['state'] = $context;

    Timber::render('@admin/admin-settings.twig', $context);
}

function timberstrap_enqueue_admin_scripts($hook) {
    // Check if we are on the timberstrap-settings page
    if (isset($_GET['page']) && $_GET['page'] === 'timberstrap-settings') {
        // Enqueue Alpine.js from your child theme's directory
        wp_enqueue_script('alpine-js', get_stylesheet_directory_uri() . '/js/alpine.js', array(), null, true);

        // Development Mode Enqueue UnoCSS runtime
        // wp_enqueue_script('unocss-runtime', 'https://cdn.jsdelivr.net/npm/@unocss/runtime', array(), null, true);

        // Development Mode Enqueue Tailwind reset CSS
        // wp_enqueue_style('tailwind-reset', 'https://cdn.jsdelivr.net/npm/@unocss/reset/tailwind.min.css', array(), null, 'all');

        wp_enqueue_style('timberstrap-styles', get_stylesheet_directory_uri() . '/extensions/inc/admin/styles/main.css', array(), null, 'all');
    }
}

add_action('admin_enqueue_scripts', 'timberstrap_enqueue_admin_scripts');