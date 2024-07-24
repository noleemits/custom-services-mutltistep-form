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
    // Enqueue the CSS file
    wp_enqueue_style('fixbee-form-style', FIXBEE_PLUGIN_URL . 'assets/css/form.css');

    // Enqueue other JavaScript files if they contain additional functionality
    wp_enqueue_script('fixbee-form-script', FIXBEE_PLUGIN_URL . 'assets/js/form.js', array('jquery'), null, true);

    // Enqueue the multistep form JavaScript file
    wp_enqueue_script('fixbee-multistep-form', plugin_dir_url(__FILE__) . 'assets/js/multistep-form.js', array('jquery'), null, true);

    // Localize script to pass PHP variables to JavaScript
    wp_localize_script('fixbee-multistep-form', 'fixbee_multistep_form_vars', array(
        'stepUrl' => esc_url(get_option('fixbee_multistep_form_url', '/form-steps')),
        'zip' => isset($_SESSION['fixbee_zip']) ? $_SESSION['fixbee_zip'] : '',
    ));
}
add_action('wp_enqueue_scripts', 'fixbee_enqueue_scripts');


// Add admin menu item for viewing entries
function fixbee_add_admin_menu() {
    add_menu_page(
        'Form Entries', // Page title
        'Form Entries', // Menu title
        'manage_options', // Capability
        'fixbee-form-entries', // Menu slug
        'fixbee_display_form_entries', // Function to display the page
        'dashicons-list-view', // Icon URL or dashicon class
        6 // Position
    );
}
add_action('admin_menu', 'fixbee_add_admin_menu');

// Function to create the service_entries table
function fixbee_create_service_entries_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'service_entries';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        category varchar(255) NOT NULL,
        zip varchar(10) NOT NULL,
        company varchar(255) NOT NULL,
        full_name varchar(255) NOT NULL,
        phone varchar(20) NOT NULL,
        email varchar(255) NOT NULL,
        services text NOT NULL,
        travel_radius int NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hook to run the table creation on plugin activation
register_activation_hook(__FILE__, 'fixbee_create_service_entries_table');


// Display the form entries
function fixbee_display_form_entries() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'service_entries';
    $entries = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1>Form Entries</h1>';
    echo '<table class="widefat fixed" cellspacing="0">';
    echo '<thead><tr>';
    echo '<th class="manage-column">ID</th>';
    echo '<th class="manage-column">Category</th>';
    echo '<th class="manage-column">Zip</th>';
    echo '<th class="manage-column">Company</th>';
    echo '<th class="manage-column">Full Name</th>';
    echo '<th class="manage-column">Phone</th>';
    echo '<th class="manage-column">Email</th>';
    echo '<th class="manage-column">Services</th>';
    echo '<th class="manage-column">Travel Radius</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    if ($entries) {
        foreach ($entries as $entry) {
            echo '<tr>';
            echo '<td>' . esc_html($entry->id) . '</td>';
            echo '<td>' . esc_html($entry->category) . '</td>';
            echo '<td>' . esc_html($entry->zip) . '</td>';
            echo '<td>' . esc_html($entry->company) . '</td>';
            echo '<td>' . esc_html($entry->full_name) . '</td>';
            echo '<td>' . esc_html($entry->phone) . '</td>';
            echo '<td>' . esc_html($entry->email) . '</td>';
            echo '<td>' . esc_html($entry->services) . '</td>';
            echo '<td>' . esc_html($entry->travel_radius) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">No entries found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// Add custom settings page
function fixbee_add_settings_page() {
    add_submenu_page(
        'fixbee-form-entries',
        'Form Settings',
        'Form Settings',
        'manage_options',
        'fixbee-form-settings',
        'fixbee_display_settings_page'
    );
}
add_action('admin_menu', 'fixbee_add_settings_page');

function fixbee_display_settings_page() {
    ?>
    <div class="wrap">
        <h1>Form Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('fixbee_form_settings');
            do_settings_sections('fixbee-form-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings for form URL and email recipient
function fixbee_register_settings() {
    register_setting('fixbee_form_settings', 'fixbee_admin_email', 'sanitize_email');
    register_setting('fixbee_form_settings', 'fixbee_multistep_form_url', 'sanitize_text_field');

    add_settings_section(
        'fixbee_form_settings_section',
        'Form Settings',
        null,
        'fixbee-form-settings'
    );

    add_settings_field(
        'fixbee_admin_email',
        'Admin Email',
        'fixbee_email_settings_field_callback',
        'fixbee-form-settings',
        'fixbee_form_settings_section'
    );

    add_settings_field(
        'fixbee_multistep_form_url',
        'Multistep Form URL',
        'fixbee_multistep_form_url_field_callback',
        'fixbee-form-settings',
        'fixbee_form_settings_section'
    );
}
add_action('admin_init', 'fixbee_register_settings');

function fixbee_email_settings_field_callback() {
    $email = get_option('fixbee_admin_email', get_option('admin_email'));
    echo '<input type="email" id="fixbee_admin_email" name="fixbee_admin_email" value="' . esc_attr($email) . '" size="25" />';
}

function fixbee_multistep_form_url_field_callback() {
    $multistep_form_url = get_option('fixbee_multistep_form_url', '/form-steps');
    echo '<input type="text" id="fixbee_multistep_form_url" name="fixbee_multistep_form_url" value="' . esc_attr($multistep_form_url) . '" size="25" />';
}
