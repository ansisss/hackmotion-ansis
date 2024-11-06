<?php
function custom_theme_enqueue_styles()
{
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/dist/style.css', array(), '1.2', 'all');
    add_filter('style_loader_tag', function ($html, $handle) {
        if ($handle === 'tailwindcss') {
            $html = str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html);
        }
        return $html;
    }, 10, 2);
}

add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');

add_action('wp_head', function () {
    echo '
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    ';
});
