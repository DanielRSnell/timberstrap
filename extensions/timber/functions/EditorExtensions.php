<?php 

function LivecanvasEditorTweaks() {
    
    $twig_editor_styles = get_stylesheet_directory_uri() . '/css/twig-editor.css';
    $twig_client =  get_stylesheet_directory_uri() . '/js/twig-editor.js';
    $observers_extension =  get_stylesheet_directory_uri() . '/js/editor-observers.js';
    
    echo '<script id="twig-client" src="' . esc_url($twig_client) . '" defer></script>';
    echo '<link id="twig-editor-styles" rel="stylesheet" href="' . esc_url($twig_editor_styles) . '">';
    echo '<script id="twig-observers" src="' . esc_url($observers_extension) . '" defer></script>'; 
}


add_action('lc_editor_header', 'LivecanvasEditorTweaks', 120);