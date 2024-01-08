<?php 


add_action( 'rest_api_init', function () {
    register_rest_route( 'timberstrap/v1', '/save_styles/', array(
        'methods' => 'POST',
        'callback' => 'save_html_styles',
        'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }
    ));
});


function save_html_styles( WP_REST_Request $request ) {
    // Get parameters from request
    $timestamp = current_time('mysql');
    $postId = $request->get_param('post_id');
    $postType = $request->get_param('post_type');
    $styles = $request->get_param('styles');

    // Validate and sanitize inputs...
    // Ensure postId and styles are valid and not empty...

    // Formulate a unique transient key. Example: 'html_styles_' . $postId
    $transientKey = 'html_styles_' . $postId;

    // Data to be saved
    $dataToSave = array(
        'timestamp' => $timestamp,
        'post_id' => $postId,
        'post_type' => $postType,
        'styles' => $styles
    );

    // Set the transient. You can define an expiration time as needed.
    // For example, 12 hours = 12 * HOUR_IN_SECONDS;
    $expiration = 12 * HOUR_IN_SECONDS;
    set_transient($transientKey, $dataToSave, $expiration);

    return new WP_REST_Response( array('success' => true, 'message' => 'Styles saved successfully.'), 200 );
}


add_action('template_redirect', 'check_and_load_page_styles');

function check_and_load_page_styles() {
    global $post;

    // Check if we are in a single post/page view and the global $post object is available
    if (!is_single() && !is_page() || !isset($post)) {
        return;
    }

    // Set cookies
    set_timberstrap_cookies();

    // Get the current post ID and generate the transient key
    $post_id = get_the_ID();
    $transient_key = 'html_styles_' . $post_id;

    // Check if the transient exists
    $page_styles = get_transient($transient_key);

    if ($page_styles !== false) {
        // Transient exists, output the HTML in the header
        add_action('wp_head', function() use ($page_styles) {
            if (is_array($page_styles['styles'])) {
                // Enqueue Preflight Wind 
                if (is_user_logged_in()) {
                    // For logged-in users, execute CreateTimberstrapUno
                    CreateTimberstrapUno();
                } else {
                    // For visitors who are not logged in, enqueue 'preflight-wind' stylesheet
                    wp_enqueue_style('preflight-wind', get_stylesheet_directory_uri() . '/extensions/unocss/css/preflights/wind.css');
                }
                // If 'styles' is an array, iterate and echo each style
                echo '<style id="uno-styles">';
                foreach ($page_styles['styles'] as $style) {
                    echo $style; // Assuming each $style is a string of CSS
                }
                echo '</style>';
            } else {
                // If 'styles' is not an array, echo it directly
                echo $page_styles['styles'];
            }
        });
    } else {
        // Transient does not exist, enqueue the scripts and styles
        
        add_action('wp_head', function() {
            echo CreateTimberstrapUno();
            echo '<script id="transient">console.log("transient does not exist");</script>';
        });
    }
}



function set_timberstrap_cookies() {
    global $post;

    // Set nonce cookie
    setcookie('timberstrap-wpNonce', wp_create_nonce('wp_rest'), time() + (86400 * 30), '/');

    // Set post ID and post type cookies
    setcookie('timberstrap-postId', $post->ID, time() + (86400 * 30), '/');
    setcookie('timberstrap-postType', $post->post_type, time() + (86400 * 30), '/');
}


// Ensure to define enqueue_page_scripts_and_styles function if not already defined


function delete_post_transient_on_update( $post_id ) {
    // Check if it's not an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check if the user has permission to edit the post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Formulate the transient key
    $transient_key = 'html_styles_' . $post_id;

    // Delete the transient
    delete_transient( $transient_key );
}

add_action( 'save_post', 'delete_post_transient_on_update' );
add_action( 'publish_post', 'delete_post_transient_on_update' );



function CreateTimberstrapUno() {
    // Retrieve custom CSS added in the Customizer
    $customCss = wp_get_custom_css();

    $bundle = get_stylesheet_directory() . "/css-output/bundle.css";

    // Check if the file exists to avoid errors
    if(file_exists($bundle)) {
        $cssString = file_get_contents($bundle);
        // Now $cssString contains the contents of your CSS file
    } else {
        echo "File not found: " . $bundle;
        $cssString = '';
    }

   // Intialize Timber Context 
    $context = Timber::context();
    $context['unocss'] = true;
    $context['preflight'] = array(
        'tailwind' => true,
        'customCSS' => $customCss,
        'icons' => true,
        'typography' => true,
        'normalize' => false,
        'bundle' => $cssString,
        'webfonts' => true,
    );

    // Render Twig String  


    $output = Timber::compile('@unocss/head.twig', $context);

    wp_enqueue_script('timberstrap-observer');


    echo $output;
}

function timberstrap_register_scripts_and_styles() {
    // Register the JavaScript script
    wp_register_script('timberstrap-observer', get_stylesheet_directory_uri() . '/extensions/unocss/js/observer.js', array(), '1.0.0', true);

    // Path to the preflights directory
    $preflights_dir = get_stylesheet_directory() . '/extensions/unocss/css/preflights/';

    // Check if the directory exists
    if (file_exists($preflights_dir)) {
        // Create a directory handle
        $dir_handle = opendir($preflights_dir);

        // Loop through the files in the directory
        while (false !== ($file = readdir($dir_handle))) {
            // Check for .css files
            if (strpos($file, '.css') !== false) {
                // Register each CSS file
                $handle = 'preflight-' . sanitize_title($file);
                $src = get_stylesheet_directory_uri() . '/extensions/unocss/css/preflights/' . $file;
                wp_register_style($handle, $src, array(), '1.0.0');
            }
        }

        // Close the directory handle
        closedir($dir_handle);
    }
}

add_action('wp_enqueue_scripts', 'timberstrap_register_scripts_and_styles');