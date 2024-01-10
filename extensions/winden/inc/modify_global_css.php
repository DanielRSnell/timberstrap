<?php 

add_action('admin_notices', function() {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>Modify Config is active - CSS Output found.</p>';
    echo '</div>';
});


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