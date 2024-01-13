<?php 


// Require $HOOKS;

function render_snippet_head_template() {

    $context = Timber::context();
    $context['files'] = get_template_contents(); // This contains your files data
    $context['state'] = $context;
    
    Timber::render('@admin/snippet-head.twig', $context);
}

add_action('lc_editor_before_body_closing', 'render_snippet_head_template', 200);