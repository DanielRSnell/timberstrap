<?php

/**
 * Processes CSS content to extract, clean, and sort class names and CSS variables.
 *
 * @param string $css_contents The CSS content to process.
 * @return array An array of cleaned and sorted class names and CSS variables.
 */
function clean_sort($css_contents) {
    // Remove CSS comment blocks.
    // This regex pattern looks for /* followed by any character repeated any number of times, ending with */
    $css_contents = preg_replace('/\/\*.*?\*\//s', '', $css_contents);

    // Remove content within parentheses.
    // This is useful for removing things like content in url() or other CSS functions.
    $css_contents = preg_replace('/\([^)]*\)/s', '', $css_contents);

    // Extract CSS variables and class names using a regular expression.
    // This pattern looks for strings starting with '--' or '.' followed by any alphanumeric character or underscore or hyphen.
    preg_match_all('/(--[a-zA-Z0-9_-]+)|(\.[a-zA-Z0-9_-]+)/', $css_contents, $matches);

    // Process each matched item to extract the variable or class name.
    $processed_names = array_map(function($item) {
        // Split the item at the first occurrence of ':' or '{'.
        // This is useful for separating class names or variables from their values or declarations.
        $parts = preg_split('/[:{]/', $item);

        // Trim whitespace from the extracted name.
        $name = trim($parts[0]);

        // Return the processed name without any further modifications.
        return $name;
    }, array_merge($matches[1], $matches[2]));

    // Now, remove duplicate values, empty strings, and strings that start with a dot followed by a number.
    $classnames = array_unique($processed_names);
    $classnames = array_filter($classnames, function($item) {
        // Ensure the item is not an empty string and does not start with a dot followed by a number.
        return $item !== '' && !preg_match('/^\.[0-9]/', $item);
    });

    // Remove leading dots from the remaining class names.
    // This step cleans up the class names to be used as valid CSS class selectors.
    $classnames = array_map(function($item) {
        return ltrim($item, '.');
    }, $classnames);

    // Sort the class names alphabetically for easier readability and consistency.
    sort($classnames);

    // Return the cleaned and sorted list of class names and CSS variables.
    return $classnames;
}