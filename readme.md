# Picostrap Child Theme with Timber 2.X

This child theme for Picostrap leverages the Timber 2.X library, enabling advanced templating in WordPress using the Twig engine. It introduces the 'Agnostic' shortcode for inline Twig templating, providing a seamless integration of Twig directly within WordPress posts and pages.

## Features

- **Timber 2.X Integration**: Utilizes the Timber library for a modern MVC-like development approach in WordPress.
- **Inline Twig Templating**: Employs the `[agnostic]...[/agnostic]` shortcode for inline Twig templating within WordPress editor.
- **Picostrap Parent Theme**: Inherits functionalities and styles from the Picostrap WordPress theme.

## Installation

1. Install the Picostrap parent theme.
2. Download and install this child theme.
3. Ensure Timber 2.X is installed and activated in your WordPress setup.

## Usage

### Inline Twig Templating with Agnostic Shortcode

The `[agnostic]...[/agnostic]` shortcode enables you to embed Twig code directly in WordPress posts or pages. This feature allows dynamic content rendering and advanced templating capabilities.

#### Basic Example:

To display the latest 10 posts using Twig, embed the following code in a post or page:

`Twig Files can be used in Child Theme Directories template-livecanvas-*`

```twig
{% set args = {
    'post_type': 'post',
    'posts_per_page': 10
} %}

{% set posts = function('get_posts', args) %}

{% for post in posts %}
    <h2 class="text-dark">{{ post.post_title }}</h2>
    <p class="text-dark">{{ post.post_content | raw }}</p>  {# Use 'raw' filter to render HTML #}
{% endfor %}
```

## Usage with Livecanvas

With livecanvas you can now use real time live updating TWIG by using the inline snippets provided below, this gives you the full access to the entire Timber Fraemwork and Twig syntax.

This will create an easy way to access data, files, shortcodes, or any functionality within wordpress without additional plugins.

Here's an example using the child theme directories and some simple twig markup within livecanvas.

```twig
<div class="live-shortcode">
  [agnostic]

    {# Define a Twig variable #}
    {% set example = "example" %}

    {# Display the variable #}
    {{example}}

    {# Include a custom block from the 'blocks' namespace, files in these directories don't require an extension to be used with Twig. However, .html is required for it to appear in the Livecanvas Custom Blocks section. #}
    {{ include('@blocks/custom') }}

    {# Include a loop template from the 'dynamic' namespace #}
    {{ include('@dynamic/loop') }}

    [/agnostic]
</div>
```

In this example, the Twig `{% set %}` tag is used to define a variable, and the `{{ }}` syntax displays the content of the variable. The `{{ include('@namespace/template') }}` syntax is used to include other Twig templates, enabling modular and reusable code. The `live-shortcode` class wraps the content, allowing for live updates within the Livecanvas Editor.

## Usage with File System / Custom Post Types

If you want to include a twig template that appears within Custom Blocks or Sections for the Livecanvas editor. Just add your markup to a `.html` file and add `live-shortcode` to the parent, then wrap your markup with `[agnostic] HTML or TWIG HERE [/agnostic]`.

## Customization

Further customization can be achieved by creating Twig templates in the child theme's directory. For detailed instructions on Twig usage in WordPress, consult [Timber's documentation](https://timber.github.io/docs/).

## Support

For support, refer to the [Picostrap theme documentation](#PicostrapDocumentationLink) and [Timber's official guides](https://timber.github.io/docs/). For issues specific to this child theme, please use the theme's issue tracker.
