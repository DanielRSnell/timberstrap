<?php 

function get_template_contents() {
    // Allowed file extensions
    $allowed_extensions = array('html', 'twig');

    // Core directories
    $core_directories = [
        'blocks' => 'template-livecanvas-blocks',
        'primitives' => 'template-livecanvas-primitives',
        'dynamic' => 'template-livecanvas-dynamic',
        'partials' => 'template-livecanvas-partials',
        'sections' => 'template-livecanvas-sections',
        'snippets' => 'template-livecanvas-snippets'
    ];

    // Allow external modification of the directories (e.g., via a child theme or plugin)
    $directories = apply_filters('modify_template_directories', $core_directories);

    $results = [];

    foreach ($directories as $key => $directory) {
        $fullPath = get_stylesheet_directory() . '/' . $directory;

        if (is_dir($fullPath)) {
            $files = scandir($fullPath);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($fullPath . '/' . $file)) {
                    $filePath = $fullPath . '/' . $file;

                    // Get the file extension
                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

                    // Check if the file has an allowed extension or no extension
                    if (in_array($fileExtension, $allowed_extensions) || empty($fileExtension)) {
                        $fileContent = file_get_contents($filePath);

                        // Sanitize the HTML content
                        $sanitizedContent = wp_kses_post($fileContent);

                        $results[] = [
                            'name' => 'file/' . $key . '/' . pathinfo($file, PATHINFO_FILENAME),
                            'content' => $sanitizedContent,
                        ];
                    }
                }
            }
        }
    }

    return $results;
}