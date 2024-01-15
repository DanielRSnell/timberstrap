<?php 


add_action('admin_notices', function() {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>Modify payload settings modified. </p>';
    echo '</div>';
});


add_filter('f!winden/core/worker:worker_npm_package', 'example_filter_worker_npm_package', 10);

function example_filter_worker_npm_package(string $npm_package): string 
{
    // rename the `flowbite/plugin` plugin to `flowbite` on the plugin list
    $npm_package = str_replace('flowbite/plugin', 'flowbite', $npm_package);

    // remove `tailwindcss/colors` from the plugin list 
    $npm_package = str_replace('tailwindcss/colors', '', $npm_package);

    return $npm_package;
}


function livecanvas_views_append_content_payload($content) {
    // Define an array of post types to include in the query.
    $post_types = [
        'lc_partial', 'lc_section', 'lc_block', 'lc_snippets',
        'lc_dynamic_template', 'page' // Add additional post types here.
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

    // Define the templates to include from the child theme.
    $timberstrap_directories = [
        'template-livecanvas-blocks',
        'template-livecanvas-sections',
        'template-livecanvas-dynamic',
        'template-livecanvas-partials',
        'template-livecanvas-snippets'
    ];

    // Create a filter for modifying which directories to check
    $timberstrap_directories = apply_filters('livecanvas_timberstrap_directories', $timberstrap_directories);

    // Get the path to the child theme directory.
    $child_theme_path = get_stylesheet_directory();

    // Iterate over each directory and retrieve files
    foreach ($pico_directories as $directory) {
        $dir_path = $child_theme_path . '/' . $directory;

        // Check if the directory exists
        if (file_exists($dir_path) && is_dir($dir_path)) {
            // Scan the directory for files
            $template_files = scandir($dir_path);

            // Iterate over each file in the directory
            foreach ($template_files as $template_file) {
                // Construct the full file path
                $file_path = $dir_path . '/' . $template_file;

                // Check if it's a file and not a directory
                if (is_file($file_path)) {
                    // Append file contents to the content
                    $content .= file_get_contents($file_path);
                }
            }
        }
    }

    // Return the concatenated string with appended post contents and template file contents.
    return $content;
}

// Attach the function to the 'f!winden/core/worker:compile_content_payload' filter
add_filter('f!winden/core/worker:compile_content_payload', 'livecanvas_views_append_content_payload', 10);