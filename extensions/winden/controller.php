<?php 

/**
 * Adds the autocomplete script tag to the page.
 *
 * This function outputs a script tag for the 'autocomplete.js' file, with the 'defer' attribute.
 */
function lc_add_autocomplete_extension() {
    $script_url = get_stylesheet_directory_uri() . '/extensions/winden/assets/autocomplete.js';
    echo '<script src="' . esc_url($script_url) . '" defer></script>';
}

add_action('lc_add_editor_extensions', 'lc_add_autocomplete_extension');

/**
 * Generates the JavaScript payload for autocomplete suggestions.
 *
 * This function creates a JavaScript snippet that initializes a constant
 * with autocomplete suggestions. These suggestions are obtained through
 * a filter hook, allowing other functions or plugins to modify or add to the list.
 */
function generate_autocomplete_script() {
    // Apply a filter to get the completions array. 
    // Other functions can modify this array via the 'lc_modify_completions' filter hook.
    $completions = apply_filters('lc_modify_completions', []);

    // Encode the completions array to JSON for use in JavaScript
    $ready_json = json_encode($completions);

    // Echo out the JavaScript code. The suggestions are stored in a const variable.
    echo '<script data-integration="autocomplete">
    const suggestions = ' . $ready_json . ';
    </script>';
}

// Attach the generate_autocomplete_script function to the lc_editor_header action hook.
// The priority is set to 120, which determines the order in which the function is executed relative to others.
add_action('lc_editor_header', 'generate_autocomplete_script', 120);


/**
 * Retrieves dynamic completion options from a JSON file and adds them to the provided completions array.
 *
 * @param array $completions The existing array of completions to which new ones will be added.
 * @param string $file_path The file path to the JSON file containing the completion options.
 * @param string $meta The meta information to be included with each completion option.
 * @return array The updated array of completions with the new options added.
 */
function add_winden_v1_completions($completions, $file_path = '/uploads/winden/cache/autocomplete.json', $meta = 'Tailwind') {
    $full_file_path = WP_CONTENT_DIR . $file_path;

    // Check if the JSON file exists
    if (!file_exists($full_file_path)) {
        // Add an admin notice if the file doesn't exist
        add_action('admin_notices', function() use ($full_file_path) {
            echo '<div class="notice notice-warning is-dismissible"><p>';
            echo 'Warning: Autocomplete JSON file not found at path: ' . esc_html($full_file_path);
            echo '</p></div>';
        });

        // Return the original completions array to prevent errors
        return $completions;
    }

    // Fetch the JSON file contents and decode them
    $json_data = pico_get_json_file($full_file_path);

    // Check if the data is valid
    if (is_array($json_data)) {
        // Map the JSON data to the desired format
        $formatted_completions = array_map(function ($item) use ($meta) {
            return [
                'caption' => $item,
                'value'   => $item,
                'meta'    => $meta,
            ];
        }, $json_data);

        // Merge the formatted completions with existing completions and return
        return array_merge($completions, $formatted_completions);
        
    } else {
        // Return the original completions if JSON data is invalid
        return $completions;
    }
}

// Attach the function to the 'lc_modify_completions' filter
add_filter('lc_modify_completions', 'add_winden_v1_completions');

/**
 * Appends content from selected post types to a given string.
 * 
 * This function enhances the 'Winden Worker' optimization by adding content
 * from various post types, including custom and default ones, to the existing
 * content string. It queries for posts, pages, and custom post types defined
 * within the context and appends their content if available.
 *
 * @param string $content The initial content string to which additional content will be appended.
 * @return string Updated content string with appended post contents.
 */
add_filter('f!winden/core/worker:compile_content_payload', 'livecanvas_views_append_content_payload', 10);

function livecanvas_views_append_content_payload($content) {
    // Define an array of post types to include in the query.
    $post_types = [
        'lc_partial', 'lc_section', 'lc_block',
        'lc_dynamic_template', 'page', 'post' // Add additional post types here.
    ];

    // Create a new WP_Query instance to retrieve posts of specified types.
    $query = new WP_Query([
        'posts_per_page' => -1, // Retrieve all available posts.
        'post_type'      => $post_types
    ]);

    // Iterate over the retrieved posts and append their content.
    foreach ($query->posts as $post) {
        if (!empty(trim($post->post_content))) {
            $content .= $post->post_content;
        }
    }

    // Return the concatenated string with appended post contents.
    return $content;
}

/**
 * Fetches and decodes data from a specified JSON file.
 *
 * @param string $file_path The file path to the JSON file.
 * @return array|WP_Error An array of data from the JSON file or an error if the file is not found or cannot be decoded.
 */
function pico_get_json_file($file_path) {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Read the file contents
        $file_contents = file_get_contents($file_path);

        // Decode the file contents into an array
        $data = json_decode($file_contents, true);

        // Check if decoding was successful
        if (is_null($data)) {
            // Error handling for JSON decode failure
            return new WP_Error('json_decode_error', 'Error decoding JSON data', array('status' => 500));
        }

        // Return the decoded data as a PHP array
        return $data;
    } else {
        // File not found, return an error response
        return new WP_Error('file_not_found', 'JSON file not found', array('status' => 404));
    }
}

/**
 * Append or prepend the contents of 'bundle.css' from the child theme's 'css-output' directory to the global CSS.
 * 
 * @param string $global_css The existing global CSS content.
 * @return string Modified global CSS content with 'bundle.css' content appended or prepended.
 */
function add_bundle_css_to_global_css($global_css) {
    // Get the absolute path to the child theme directory.
    $child_theme_path = get_stylesheet_directory();

    // Specify the path to the 'bundle.css' file in the 'css-output' directory of the child theme.
    $css_file = $child_theme_path . '/css-output/bundle.css';

    // Check if 'bundle.css' exists.
    if (file_exists($css_file)) {
        // Read the contents of 'bundle.css'.
        $bundle_css = file_get_contents($css_file);

        // Append 'bundle.css' content before the global CSS.
        // Alternatively, use "$global_css . $bundle_css" to append it after the global CSS.
        return $bundle_css . $global_css;
    }

    // Return the original global CSS if 'bundle.css' does not exist.
    return $global_css;
}

// Attach the 'add_bundle_css_to_global_css' function to the 'f!winden/core/runtime:global_css' filter.
add_filter('f!winden/core/runtime:global_css', 'add_bundle_css_to_global_css');