<?php

function twig_shortcode($atts, $content = null) {

        global $post;
        global $wp_query;
        // Prepare Timber context
        $context = Timber::context();
        $context['state'] = $context;
        $context['attributes'] = $atts;

        // Compile the content as a Twig template
        $compiled_content = Timber::compile_string($content, $context);

        return $compiled_content;
    
}

add_shortcode('twig', 'twig_shortcode');