<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts()
{
    wp_dequeue_style('understrap-styles');
    wp_deregister_style('understrap-styles');

    wp_dequeue_script('understrap-scripts');
    wp_deregister_script('understrap-scripts');
}

add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles()
{
    // Get the theme data.
    $the_theme = wp_get_theme();

    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

    // Grab asset urls.
    $theme_styles = "/css/child-theme{$suffix}.css";
    $theme_scripts = "/js/child-theme{$suffix}.js";

    $stylesheet_dir = get_stylesheet_directory();
    $stylesheet_uri = get_stylesheet_directory_uri();

    $style_path  = $stylesheet_dir . $theme_styles;
    $script_path = $stylesheet_dir . $theme_scripts;

    $style_version  = file_exists($style_path)  ? filemtime($style_path)  : $the_theme->get('Version');
    $script_version = file_exists($script_path) ? filemtime($script_path) : $the_theme->get('Version');


    wp_enqueue_style(
        'child-understrap-styles',
        get_stylesheet_directory_uri() . $theme_styles,
        array(),
        $style_version
    );

    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'child-understrap-scripts',
        get_stylesheet_directory_uri() . $theme_scripts,
        array(),
        $style_version,
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

/**
 * Google Fonts (Inter)
 */
function mytheme_enqueue_google_fonts()
{
    wp_enqueue_style(
        'google-fonts-preconnect',
        'https://fonts.googleapis.com',
        array(),
        null
    );

    wp_enqueue_style(
        'google-fonts-preconnect2',
        'https://fonts.gstatic.com',
        array(),
        null
    );

    wp_enqueue_style(
        'google-fonts-inter',
        'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap',
        array(),
        null
    );
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_google_fonts');