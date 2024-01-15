const timberstrap = true;
    
    function filterPreviewHTML(input) {

    // Fix stretched links
    input = input.replace(/stretched-link/g, "");

    if (lc_editor_post_type == "lc_dynamic_template") {

        // Wrap lc_ shortcodes
        input = input.replace(/\[lc_([^\]]+)\]/g, "<lc-dynamic-element hidden>[$&");
        input = input.replace(/\[\/lc_([^\]]+)\]/g, "$&</lc-dynamic-element>");

        // Wrap [twig] shortcode block
        input = input.replace(/\[twig\]([\s\S]*?)\[\/twig\]/g, "<lc-dynamic-element hidden>[twig]$1[/twig]</lc-dynamic-element>");

        console.log(input, "Dynamic template prepared for preview");
    } else {
        console.log(input, "Not a dynamic template");
    }

    return input;
}


	// const timberstrap_editor = ace.edit('lc-html-editor');

    // timberstrap_editor.setTheme("ace/theme/monokai");
    // timberstrap_editor.session.setMode("ace/mode/twig");