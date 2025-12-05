<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
    load_child_theme_textdomain(
        'understrap-child',
        get_stylesheet_directory() . '/languages'
    );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
    return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );

/**
 * Wyłączenie automatycznych <p> w Contact Form 7
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );