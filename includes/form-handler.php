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
