<?php

function agnostic_shortcode($atts, $content = null) {

        // Context: Use global post by default
        $context = Timber::context();

        // Compile the content as a Twig template
        $compiled_content = Timber::compile_string($content, $context);

        return $compiled_content;
    
}
add_shortcode('agnostic', 'agnostic_shortcode');