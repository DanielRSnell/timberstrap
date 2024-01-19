<?php 

$TAILWIND_DIR = get_stylesheet_directory() . '/extensions/tailwind';

require $TAILWIND_DIR . '/helpers/clean_sort.php';

function generate_autocomplete_script() {
    $AUTOCOMPLETE_CSS = get_stylesheet_directory() . '/css-output/autocomplete.css';

    if (file_exists($AUTOCOMPLETE_CSS)) {
        $css_content = file_get_contents($AUTOCOMPLETE_CSS);
        $css_items = clean_sort($css_content);

        $completions = [];


        // Apply a filter to allow modification of the completions array
        $completions = apply_filters('lc_modify_completions', $completions);

        // Encode the completions array to JSON for use in JavaScript
        $ready_json = json_encode($css_items);

        $context = Timber::context();

        // Add the JSON to the Timber context
        $context['suggestions'] = $ready_json;

        // Render the autocomplete script template
        Timber::render('@tailwind/completions.twig', $context);
    } else {
        error_log('Autocomplete CSS file not found: ' . $AUTOCOMPLETE_CSS);
    }
}


// Attach the generate_autocomplete_script function to the lc_editor_header action hook.
// The priority is set to 120, which determines the order in which the function is executed relative to others.
add_action('lc_editor_before_body_closing', 'generate_autocomplete_script', 120);

function enqueue_tailwind_stylesheet() {
    // Get the URI of the child theme's directory
    $child_theme_uri = get_stylesheet_directory_uri();

    // Get the absolute path to the Tailwind CSS file
    $tailwind_css_file_path = get_stylesheet_directory() . '/css-output/tailwind.css';

    // Get the last modified time of the Tailwind CSS file
    $version = file_exists($tailwind_css_file_path) ? filemtime($tailwind_css_file_path) : false;

    // Enqueue the Tailwind CSS file with the version number as a query parameter
    wp_enqueue_style('tailwind-css', $child_theme_uri . '/css-output/tailwind.css', array());
}

add_action('wp_enqueue_scripts', 'enqueue_tailwind_stylesheet');


// if ($development_mode_enabled) {

add_action('save_post', 'send_post_request_on_update', 10, 3);

function send_post_request_on_update($post_ID, $post, $update) {
    // Check if the post is being updated
    if (!$update) {
        return;
    }

    // Check if the current origin contains .local
    if (strpos($_SERVER['HTTP_HOST'], '.local') !== false) {
        // Prepare the request URL
        $request_url = 'http://localhost:3000/rebuild';

        // Send a POST request
        $response = wp_remote_post($request_url, [
            'blocking' => false, // Non-blocking request
            'timeout' => 5, // Timeout in seconds
        ]);

        if (is_wp_error($response)) {
            error_log('Error sending POST request: ' . $response->get_error_message());
            return;
        }
    }
}


add_action('template_redirect', function() {
    // Check if the user is an admin and tailwind integration is enabled
    if (!current_user_can('administrator') || get_option('tailwind_integration') != '1') {
        return;
    }

    add_action('wp_head', function() {
        global $post;

        $context = Timber::context();
        $context['post'] = Timber::get_post(); // Get the current post as a Timber Post object

        // Define the paths to Tailwind configuration and CSS in your child theme
        $tailwindConfigPath = get_stylesheet_directory() . '/tailwind.editor.js';
        $tailwindCSSPath = get_stylesheet_directory() . '/css-output/bundle.css';

        // Load Tailwind configuration
        if (file_exists($tailwindConfigPath)) {
            $config = file_get_contents($tailwindConfigPath);
            $tailwind_update = str_replace('module.exports', 'tailwind.config', $config);
            $context['config'] = $tailwind_update;
        }

        // Load tailwind.css content
        if (file_exists($tailwindCSSPath)) {
            $context['tailwindCSS'] = file_get_contents($tailwindCSSPath);
        }

        $context['isTailwind'] = true;
        $context['isAdmin'] = true;
        
        // Render the Twig template
        Timber::render('@tailwind/editor-head.twig', $context);
    });
});





add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory() . '/extensions/tailwind';

    // Assigning each path to its respective key
    $paths['tailwind'] = [$theme_directory . '/views'];

    return $paths;
});
// }