<?php

/**
 * Adds 'lc-block' class and 'editable' attribute to parent elements of text nodes.
 *
 * @param DOMDocument $dom The DOMDocument object containing the HTML content.
 */
function set_editable_to_parent_of_text_nodes($dom) {
    $xpath = new DOMXPath($dom);
    $textNodes = $xpath->query('//text()');

    foreach ($textNodes as $node) {
        // Only process if the parent node is a DOMElement and contains non-whitespace text
        if ($node->parentNode instanceof DOMElement && trim($node->nodeValue) !== '') {
            $currentClass = $node->parentNode->getAttribute('class');

            // Add 'lc-block' class if not already present
            if (strpos($currentClass, 'lc-block') === false) {
                $newClass = $currentClass ? $currentClass . ' lc-block' : 'lc-block';
                $node->parentNode->setAttribute('class', $newClass);
            }

            // Add 'editable' attribute if not already present
            if (!$node->parentNode->hasAttribute('editable')) {
                $node->parentNode->setAttribute('editable', 'inline');
            }
        }
    }
}

/**
 * Adds 'lc-block' class to SVG elements.
 *
 * @param DOMDocument $dom The DOMDocument object containing the HTML content.
 */
function add_lc_block_to_svg_elements($dom) {
    $svgs = $dom->getElementsByTagName('svg');
    foreach ($svgs as $svg) {
        $currentClasses = $svg->getAttribute('class');

        // Add 'lc-block' class if not already present
        if (strpos($currentClasses, 'lc-block') === false) {
            $newClasses = $currentClasses ? $currentClasses . ' lc-block' : 'lc-block';
            $svg->setAttribute('class', $newClasses);
        }
    }
}

/**
 * Adds 'btn' class and 'role' attribute to link (a) elements.
 *
 * @param DOMDocument $dom The DOMDocument object containing the HTML content.
 */
function add_class_and_role_to_links_and_buttons($dom) {
    $buttonsAndLinks = $dom->getElementsByTagName('a');
    foreach ($buttonsAndLinks as $element) {
        $currentClasses = $element->getAttribute('class');

        // Add 'btn' class if not already present
        if (strpos($currentClasses, 'btn') === false) {
            $newClasses = $currentClasses ? $currentClasses . ' btn' : 'btn';
            $element->setAttribute('class', $newClasses);
        }

        // Add 'role' attribute if not already present
        if (!$element->hasAttribute('role')) {
            $element->setAttribute('role', 'button');
        }
    }
}

/**
 * Modifies post content upon save.
 *
 * @param int $post_ID Post ID.
 * @param WP_Post $post Post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function modify_post_content($post_ID, $post, $update) {
    // Check if the 'parse' field is set and true, if not return early
    $parse = get_post_meta($post_ID, 'parse', true);
    if (!$parse) {
        return;
    }

    // Remove action to prevent infinite loop
    remove_action('save_post', 'modify_post_content');

    // Load content into DOMDocument
    $content = $post->post_content;
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();

    // Apply modifications
    set_editable_to_parent_of_text_nodes($dom);
    add_lc_block_to_svg_elements($dom);
    add_class_and_role_to_links_and_buttons($dom);

    // Update post content
    update_post_content($post_ID, $dom);

    // Uncheck the 'parse' field
    update_post_meta($post_ID, 'parse', false);

    // Re-add action
    add_action('save_post', 'modify_post_content', 10, 3);
}


/**
 * Updates the post content with modified DOM.
 *
 * @param int $post_ID Post ID.
 * @param DOMDocument $dom The modified DOMDocument object.
 */
function update_post_content($post_ID, $dom) {
    $modified_content = $dom->saveHTML();
    wp_update_post(array(
        'ID' => $post_ID,
        'post_content' => $modified_content,
    ));
}

// Hook the function to WordPress 'save_post' action
add_action('save_post', 'modify_post_content', 10, 3);