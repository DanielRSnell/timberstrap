<?php 

function LivecanvasEditorTweaks() {
    
    $timberstrap_editor_styles = get_stylesheet_directory_uri() . '/css/timberstrap-editor.css';
    $timberstrap_client =  get_stylesheet_directory_uri() . '/js/timberstrap-editor.js';
    $observers_extension =  get_stylesheet_directory_uri() . '/js/editor-observers.js';
    
    echo '<script id="timberstrap-client" src="' . esc_url($timberstrap_client) . '" defer></script>';
    echo '<link id="timberstrap-editor-styles" rel="stylesheet" href="' . esc_url($timberstrap_editor_styles) . '">';
    echo '<script id="timberstrap-observers" src="' . esc_url($observers_extension) . '" defer></script>'; 
}


add_action('lc_editor_header', 'LivecanvasEditorTweaks', 120);