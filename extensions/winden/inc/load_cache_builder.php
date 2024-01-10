<?php 

// Check for /wp-content/uploads/winden/cache/front.css 
// If it exists enqueue it 

add_action('wp_head', 'enqueue_tailwind_if_dynamic_template');

function enqueue_tailwind_if_dynamic_template()
{
    // Check if the URL contains the 'lc_dynamic_template' parameter
    // if (isset($_GET['lc_dynamic_template'])) {
    //     echo '<script src="https://cdn.tailwindcss.com"></script>';
	// 	echo '<script>console.log("Editor CDN Fallback Loaded");</script>';
    // }

   if (isset($_GET['lc_dynamic_template'])) {

       $context = Timber::context();

       // Get styles from css-output/bundle.css
       $context['styles'] = file_get_contents(get_stylesheet_directory() . '/css-output/bundle.css');

       // Get config and replace module.exports with tailwind.config
       $fetch_config = file_get_contents(get_stylesheet_directory() . '/tailwind.config.js');
       $fetch_config = str_replace('module.exports', 'tailwind.config', $fetch_config);

       // Add Config to Context 
       $context['config'] = $fetch_config;

       $context['CDN'] = 'https://cdn.tailwindcss.com';

       // Render the twig template
       echo Timber::compile('head.twig', $context);


    }
}


add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory() . '/extensions/winden';

    // Assigning each path to its respective key
    $paths['winden'] = [$theme_directory . '/views'];
    
    // Dynamic is a new directory for Twig Templates that use version control.

    /* Example Usage: 

    {% include '@dynamic/hero.extension' %}

    */


    return $paths;
});