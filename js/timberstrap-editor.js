const timberstrap = true;
    
    function filterPreviewHTML(input) {
    console.log("Something changed");

    // Fix stretched links
    input = input.replace(/stretched-link/g, "");

    if (lc_editor_post_type == "lc_dynamic_template") {
        console.log(typeof input, "Dynamic template");

        // Wrap lc_ shortcodes
        input = input.replace(/\[lc_([^\]]+)\]/g, "<lc-dynamic-element hidden>[$&");
        input = input.replace(/\[\/lc_([^\]]+)\]/g, "$&</lc-dynamic-element>");

        // Wrap [agnostic] shortcode block
        input = input.replace(/\[agnostic\]([\s\S]*?)\[\/agnostic\]/g, "<lc-dynamic-element hidden>[agnostic]$1[/agnostic]</lc-dynamic-element>");

        console.log(input, "Dynamic template prepared for preview");
    } else {
        console.log(input, "Not a dynamic template");
    }

    return input;
}
