<?php 

/**
 * Fetches and decodes data from a specified JSON file.
 *
 * @param string $file_path The file path to the JSON file.
 * @return array|WP_Error An array of data from the JSON file or an error if the file is not found or cannot be decoded.
 */
function pico_get_json_file($file_path) {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Read the file contents
        $file_contents = file_get_contents($file_path);

        // Decode the file contents into an array
        $data = json_decode($file_contents, true);

        // Check if decoding was successful
        if (is_null($data)) {
            // Error handling for JSON decode failure
            return new WP_Error('json_decode_error', 'Error decoding JSON data', array('status' => 500));
        }

        // Return the decoded data as a PHP array
        return $data;
    } else {
        // File not found, return an error response
        return new WP_Error('file_not_found', 'JSON file not found', array('status' => 404));
    }
}