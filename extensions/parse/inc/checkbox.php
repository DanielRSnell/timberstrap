<?php 

function add_custom_meta_box() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_parse_box',
            'Custom Parse Settings',
            'custom_parse_meta_box_callback',
            $post_type,
            'side',
            'high'
        );
    }
}

function custom_parse_meta_box_callback($post) {
    $parse = get_post_meta($post->ID, 'parse', true);
    echo '<label for="parse_field">Make Editable:</label> ';
    echo '<input type="checkbox" id="parse_field" name="parse_field" value="1" ' . checked(1, $parse, false) . '/>';
}

function save_custom_meta_box_data($post_id) {
    if (isset($_POST['parse_field'])) {
        update_post_meta($post_id, 'parse', $_POST['parse_field']);
    }
}

add_action('add_meta_boxes', 'add_custom_meta_box');
add_action('save_post', 'save_custom_meta_box_data');