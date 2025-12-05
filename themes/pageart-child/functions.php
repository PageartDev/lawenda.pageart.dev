<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

defined('ABSPATH') || exit;

$child_inc_dir = 'inc';

$child_includes = array(
    '/child-enqueue.php',        // style + skrypty + Google Fonts + usunięcie parenta
    '/child-setup.php',          // textdomain, bootstrap5, CF7 autop
    '/child-customizer.php',     // skrypty dla customizera
    '/child-template-tags.php',     // skrypty dla customizera

    // PLUGINS
    '/plugins/body-classes.php',   // dodatkowe klasy w <body>
    '/plugins/svg-support.php',    // obsługa SVG
//    '/plugins/disable-comments.php', // globalne wyłączenie komentarzy
    '/plugins/disable-xmlrpc.php', // wylaczenie pliku xmlrpc
);

if (class_exists('WooCommerce')) {
    $child_includes[] = '/child-woocommerce.php'; // rzeczy do woocommerce
//    $child_includes[] = '/plugins/modified-gallery.php'; // zmodyfikowana galeria woocommerce
}

foreach ($child_includes as $file) {
    $path = get_stylesheet_directory() . '/' . $child_inc_dir . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}