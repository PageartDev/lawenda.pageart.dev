<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Dodaje slug strony jako klasę w <body>
 */
function add_slug_to_body_class($classes)
{
    if (is_singular() || is_page()) {
        global $post;

        if (isset($post->post_name)) {
            $classes[] = 'page-' . sanitize_html_class($post->post_name);
        }
    } elseif (is_home()) {
        $classes[] = 'page-home';
    }

    return $classes;
}

add_filter('body_class', 'add_slug_to_body_class');