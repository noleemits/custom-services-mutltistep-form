<?php
/*
Plugin Name: fixbee Form Plugin
Description: A custom multi-step form for fixbee.
Version: 1.0
Author: STephen Lee Hernandez
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FIXBEE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIXBEE_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once FIXBEE_PLUGIN_DIR . 'includes/form-handler.php';
require_once FIXBEE_PLUGIN_DIR . 'includes/rest-api.php';
require_once FIXBEE_PLUGIN_DIR . 'includes/shortcodes.php';
require_once FIXBEE_PLUGIN_DIR . 'includes/metaboxes.php';

// Enqueue scripts and styles
function fixbee_enqueue_scripts() {
    wp_enqueue_style('fixbee-form-style', FIXBEE_PLUGIN_URL . 'assets/css/form.css');
    wp_enqueue_script('fixbee-form-script', FIXBEE_PLUGIN_URL . 'assets/js/form.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'fixbee_enqueue_scripts');
