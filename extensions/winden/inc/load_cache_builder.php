<?php 

// Check for /wp-content/uploads/winden/cache/front.css 
// If it exists enqueue it 

add_action('template_redirect', 'enqueue_tailwind_if_dynamic_template');

function enqueue_tailwind_if_dynamic_template()
{
    
    add_action('wp_head', function() {
        $context = Timber::context();

       // Get styles from css-output/bundle.css
       $context['styles'] = file_get_contents(get_stylesheet_directory() . '/css-output/bundle.css');
       $context['globalCSS'] = wp_get_custom_css();
       // Get config and replace module.exports with tailwind.config
       $fetch_config = file_get_contents(get_stylesheet_directory() . '/tailwind.config.js');
       $fetch_config = str_replace('module.exports', 'tailwind.config', $fetch_config);

       // Add Config to Context 
       $context['config'] = $fetch_config;

       $context['CDN'] = 'https://cdn.tailwindcss.com';
 
        // Render the twig template
        echo Timber::compile('@winden/head.twig', $context);
    });


}