<?php
// Handle Step 1 form submission
function fixbee_handle_step1() {
    if (!isset($_POST['category']) || !isset($_POST['zip'])) {
        wp_redirect(home_url('/step1'));
        exit;
    }

    // Store data in session or pass it via URL
    session_start();
    $_SESSION['fixbee_category'] = sanitize_text_field($_POST['category']);
    $_SESSION['fixbee_zip'] = sanitize_text_field($_POST['zip']);

    wp_redirect(home_url('/page2'));
    exit;
}
add_action('admin_post_fixbee_step1', 'fixbee_handle_step1');
add_action('admin_post_nopriv_fixbee_step1', 'fixbee_handle_step1');

// Handle Step 2 form submission
function fixbee_handle_step2() {
    if (!isset($_POST['company']) || !isset($_POST['full_name']) || !isset($_POST['phone']) || !isset($_POST['email'])) {
        wp_redirect(home_url('/page2'));
        exit;
    }

    session_start();
    $_SESSION['fixbee_company'] = sanitize_text_field($_POST['company']);
    $_SESSION['fixbee_full_name'] = sanitize_text_field($_POST['full_name']);
    $_SESSION['fixbee_phone'] = sanitize_text_field($_POST['phone']);
    $_SESSION['fixbee_email'] = sanitize_email($_POST['email']);

    wp_redirect(home_url('/page3'));
    exit;
}
add_action('admin_post_fixbee_step2', 'fixbee_handle_step2');
add_action('admin_post_nopriv_fixbee_step2', 'fixbee_handle_step2');
