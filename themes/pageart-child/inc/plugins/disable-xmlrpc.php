<?php

/**
 * Disable XML-RPC functionality
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Block access to xmlrpc.php by terminating the request early
 */
add_action('init', 'custom_disable_xmlrpc');

function custom_disable_xmlrpc()
{
    // Check if the request is for xmlrpc.php
    if (strpos($_SERVER['REQUEST_URI'], 'xmlrpc.php') !== false) {
        // Send a 403 Forbidden status
        status_header(403);
        // Optionally, display a message
        echo 'XML-RPC is disabled on this site.';
        exit;
    }
}

/**
 * Remove XML-RPC and REST API related links from the site header
 */
add_action('init', 'custom_remove_xmlrpc_links');

function custom_remove_xmlrpc_links()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
}