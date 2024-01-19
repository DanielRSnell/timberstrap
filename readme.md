# Picostrap Child Theme with Timber 2.X (Updates Coming)

This child theme for Picostrap leverages the Timber 2.X library, enabling advanced templating in WordPress using the Twig engine. It introduces the 'twig' shortcode for inline Twig templating, providing a seamless integration of Twig directly within WordPress posts and pages.

## Features

- **Timber 2.X Integration**: Utilizes the Timber library for a modern MVC-like development approach in WordPress.
- **Inline Twig Templating**: Employs the `[twig]...[/twig]` shortcode for inline Twig templating within WordPress editor.
- **Picostrap Parent Theme**: Inherits functionalities and styles from the Picostrap WordPress theme.

## Installation

1. Install the Picostrap parent theme.
2. Download and install this child theme.
3. Ensure Timber 2.X is installed and activated in your WordPress setup.

## Usage

### Inline Twig Templating with twig Shortcode

The `[twig]...[/twig]` shortcode enables you to embed Twig code directly in WordPress posts or pages. This feature allows dynamic content rendering and advanced templating capabilities.

#### Basic Example:

To display the latest 10 posts using Twig, embed the following code in a post or page:

`Twig Files can be used in Child Theme Directories template-livecanvas-*`

```twig
{% set args = {
    'post_type': 'post',
    'posts_per_page': 10
} %}

{% set posts = Post(args) %}

{% for post in posts %}
    <h2 class="text-dark">{{ post.post_title }}</h2>
    <p class="text-dark">{{ post.post_content | raw }}</p>  {# Use 'raw' filter to render HTML #}
{% endfor %}
```

## Special Helpers

Special helpers allow you to use Twig to acheive key functionalities that are often needed when writing templates. This would include scenarios where you need to get a Query Param or get the current post.

```twig

<section class="live-shortcode">
[twig]

<h1>{{CurrentPost.title}}</h1>

[/twig]
</section>

```

```twig
<section class="live-shortcode">
[twig]

{# Declare Current Post #}

{% set post = CurrentPost %}

<h1>{{post.title}}</h1>

[/twig]
</section>

```

The benefit in this scenario is that it's a semantically friendly way to fetch the current post, while controlly the markup for any variable. When you use `set variableName = CurrentPost` it gives you access to all the data attached to the current post.

### Query Params

This allows you to use query params easily within any template, you can either use specific ones or a series of Query Params.

```twig

<section class="live-shortcode">
[twig]

{% set email = get_any_var('email') %}

{% if email %}

{# Do Something #}

{% else %}

<span>Whoops, there was no email found</span>

{% endif %}

[/twig]
</section>


```

You can also get all current Query Params like this:

```twig

<section class="live-shortcode">
[twig]

{% set params = get_params_object %}

{% if params.email %}

{# Do Something #}

{% else %}

<span>Whoops, there was no email found</span>

{% endif %}

[/twig]
</section>

```

In the above example it returns a group of params, also known as an `object` which then let's you access any param on the current url.

This works great for situations where you're passing data from one page to another.

## Usage with Livecanvas

With livecanvas you can now use real time live updating TWIG by using the inline snippets provided below, this gives you the full access to the entire Timber Fraemwork and Twig syntax.

This will create an easy way to access data, files, shortcodes, or any functionality within wordpress without additional plugins.

Here's an example using the child theme directories and some simple twig markup within livecanvas.

```twig
<div class="live-shortcode">
  [twig]

    {# Define a Twig variable #}
    {% set example = "example" %}

    {# Display the variable #}
    {{example}}

    {# Include a custom block from the 'blocks' namespace #}
    {{ include('@blocks/custom') }}

    {# Include a loop template from the 'dynamic' namespace #}
    {{ include('@dynamic/loop') }}

    [/twig]
</div>
```

In this example, the Twig `{% set %}` tag is used to define a variable, and the `{{ }}` syntax displays the content of the variable. The `{{ include('@namespace/template') }}` syntax is used to include other Twig templates, enabling modular and reusable code. The `live-shortcode` class wraps the content, allowing for live updates within the Livecanvas Editor.

## Customization

Further customization can be achieved by creating Twig templates in the child theme's directory. For detailed instructions on Twig usage in WordPress, consult [Timber's documentation](https://timber.github.io/docs/).

## Support

For support, refer to the [Picostrap theme documentation](#PicostrapDocumentationLink) and [Timber's official guides](https://timber.github.io/docs/). For issues specific to this child theme, please use the theme's issue tracker.
