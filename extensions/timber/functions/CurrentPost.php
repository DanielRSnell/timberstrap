<?php 

function getCurrentPost() {
    global $post;
    if ($post) {
        return Timber::get_post($post);
    }
    return null;
}

add_filter('timber/context', function ($context) {
    $context['CurrentPost'] = getCurrentPost();
    return $context;
});


// function getCurrentArchive() {
//     if (!is_archive()) {
//         return null;
//     }

//     $archive = [
//         'title' => get_the_archive_title(),
//         'description' => get_the_archive_description(),
//         'slug' => get_query_var('term'), // For term archives
//         'permalink' => get_post_type_archive_link(get_post_type()),
//         'is_category' => is_category(),
//         'is_tag' => is_tag(),
//         'related' => get_related_terms()
//     ];

//     return $archive;
// }

// function get_related_terms() {
//     $related = [];
//     $current_term_id = get_queried_object_id(); // Current term ID
//     $taxonomy = get_queried_object()->taxonomy; // Current taxonomy

//     $terms = get_terms([
//         'taxonomy' => $taxonomy,
//         'exclude' => [$current_term_id], // Exclude current term
//         'hide_empty' => true,
//     ]);

//     foreach ($terms as $term) {
//         $related[] = [
//             'title' => $term->name,
//             'description' => term_description($term->term_id, $taxonomy),
//             'slug' => $term->slug,
//             'permalink' => get_term_link($term),
//             'is_category' => ($taxonomy === 'category'),
//             'is_tag' => ($taxonomy === 'post_tag')
//         ];
//     }

//     return $related;
// }


// add_filter('timber/context', function ($context) {
//     $context['archive'] = getCurrentArchive();
//     return $context;
// });