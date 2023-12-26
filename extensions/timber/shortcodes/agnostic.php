<?php

function agnostic_shortcode($atts, $content = null) {
    // Ensure Timber is loaded
    if (class_exists('Timber')) {

        // Context: Use global post by default
        $context = Timber::context();

        // Compile the content as a Twig template
        $compiled_content = Timber::compile_string($content, $context);

        return $compiled_content;
    }

    // If Timber is not available, just return the content
    return $content;
}
add_shortcode('agnostic', 'agnostic_shortcode');