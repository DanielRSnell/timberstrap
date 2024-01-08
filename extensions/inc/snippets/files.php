<?php 

function get_template_contents() {
    // Core directories
    $core_directories = [
        'blocks' => 'template-livecanvas-blocks',
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
                    $fileContent = file_get_contents($filePath);

                    $results[] = [
                        'name' => 'file/' . $key . '/' . pathinfo($file, PATHINFO_FILENAME),
                        'content' => $fileContent
                    ];
                }
            }
        }
    }

    return $results;
}