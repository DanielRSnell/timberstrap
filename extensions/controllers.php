<?php 

$BASE_DIR = get_stylesheet_directory() . '/extensions';

// Load Timber Extension.
require $BASE_DIR . '/timber/controller.php';
require $BASE_DIR . '/winden/controller.php';

/**
 * Triggers a custom action for adding editor extensions.
 *
 * This function serves as a hook point for adding various editor extensions.
 * It triggers a custom action 'lc_add_editor_extensions', which allows other
 * parts of the theme or plugins to add their own extensions to the editor
 * without directly modifying this function.
 */
function lc_editor_extensions() {
    /**
     * Custom action to add extensions to the editor.
     *
     * This action allows other functions or plugins to add their own
     * extensions (like autocomplete, custom styles, etc.) to the editor.
     * Extensions are hooked into this action using `add_action()`.
     */
    do_action('lc_add_editor_extensions');
}

/**
 * Attach the lc_editor_extensions function to the 'lc_editor_header' action hook.
 *
 * This attachment is done with a priority of 200, ensuring that it is executed
 * later in the sequence of functions hooked to 'lc_editor_header'. This allows
 * the extensions to be added after the basic editor setup is complete.
 */
add_action('lc_editor_header', 'lc_editor_extensions', 200);