<?php

require get_stylesheet_directory() . '/extensions/winden/helpers/get_json.php';

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

    $context = Timber::context();

    // Add the JSON to the Timber context
    $context['suggestions'] = $ready_json;

    // Render the autocomplete script template
    Timber::render('@winden/completions.twig', $context);
}

// Attach the generate_autocomplete_script function to the lc_editor_header action hook.
// The priority is set to 120, which determines the order in which the function is executed relative to others.
add_action('lc_editor_before_body_closing', 'generate_autocomplete_script', 120);

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