<?php 

function add_theme_options_page() {
    add_menu_page(
        'Timberstrap Options', // Page title
        'Timberstrap', // Menu title
        'manage_options', // Capability
        'timberstrap-options', // Menu slug
        'timberstrap_options_page', // Function to display the options page
        'dashicons-admin-generic', // Icon (optional)
        81 // Position (optional)
    );
}
add_action('admin_menu', 'add_theme_options_page');

function timberstrap_options_page() {
    ?>
<div class="wrap">
    <h1>Timberstrap Options</h1>
    <form method="post" action="options.php">
        <?php
            settings_fields('timberstrap_options_group');
            do_settings_sections('timberstrap-options');
            submit_button();
            ?>
    </form>
</div>
<?php
}


function register_timberstrap_settings() {
    // Register a new setting for "Timberstrap" page
    register_setting('timberstrap_options_group', 'unocss');
    register_setting('timberstrap_options_group', 'markup_parsing');
    // Register a new setting for Alpine Integration
    register_setting('timberstrap_options_group', 'alpine_integration');

    // Register a new section in the "Timberstrap" page
    add_settings_section(
        'timberstrap_settings_section',
        'General Settings',
        'timberstrap_settings_section_callback',
        'timberstrap-options'
    );


    add_settings_field(
        'markup_parsing_field',
        'Markup Parsing',
        'markup_parsing_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );

    // Register new field for Alpine Integration
    add_settings_field(
        'alpine_integration_field',
        'Alpine Integration',
        'alpine_integration_field_callback',
        'timberstrap-options',
        'timberstrap_settings_section'
    );
}
add_action('admin_init', 'register_timberstrap_settings');

function timberstrap_settings_section_callback() {
    echo '<p>General settings for Timberstrap.</p>';
}


function markup_parsing_field_callback() {
    $markup_parsing = get_option('markup_parsing');
    echo '<input type="checkbox" id="markup_parsing" name="markup_parsing" value="1"' . checked(1, $markup_parsing, false) . '/>';
}

function alpine_integration_field_callback() {
    $alpine_integration = get_option('alpine_integration');
    echo '<input type="checkbox" id="alpine_integration" name="alpine_integration" value="1"' . checked(1, $alpine_integration, false) . '/>';
}