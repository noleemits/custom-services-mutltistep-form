<?php
// Handle Step 1 form submission
function fixbee_handle_step1() {
    if (!isset($_POST['category']) || !isset($_POST['zip'])) {
        wp_redirect(home_url('/'));
        exit;
    }

    session_start();
    $_SESSION['fixbee_category'] = sanitize_text_field($_POST['category']);
    $_SESSION['fixbee_zip'] = sanitize_text_field($_POST['zip']);

    $multistep_form_url = get_option('fixbee_multistep_form_url', '/form-steps'); // Get the customizable URL for the multistep form page

    wp_redirect(home_url($multistep_form_url));
    exit;
}
add_action('admin_post_fixbee_step1', 'fixbee_handle_step1');
add_action('admin_post_nopriv_fixbee_step1', 'fixbee_handle_step1');


// Handle combined form submission for steps 2-4
function fixbee_handle_multistep_form() {
    if (!isset($_POST['category']) || !isset($_POST['zip']) || !isset($_POST['company']) || !isset($_POST['full_name']) || !isset($_POST['phone']) || !isset($_POST['email']) || !isset($_POST['services']) || !isset($_POST['travel_radius'])) {
        wp_redirect(home_url('/form-steps'));
        exit;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'service_entries';

    $data = array(
        'category' => sanitize_text_field($_POST['category']),
        'zip' => sanitize_text_field($_POST['zip']),
        'company' => sanitize_text_field($_POST['company']),
        'full_name' => sanitize_text_field($_POST['full_name']),
        'phone' => sanitize_text_field($_POST['phone']),
        'email' => sanitize_email($_POST['email']),
        'services' => sanitize_text_field(implode(',', $_POST['services'])),
        'travel_radius' => intval($_POST['travel_radius']),
    );

    $wpdb->insert($table_name, $data);

    // Send email notification
    $admin_email = get_option('fixbee_admin_email', get_option('admin_email'));
    $subject = 'New Form Entry Submitted';
    $message = "A new form entry has been submitted:\n\n";
    foreach ($data as $key => $value) {
        $message .= ucfirst(str_replace('_', ' ', $key)) . ": $value\n";
    }
    wp_mail($admin_email, $subject, $message);

    wp_redirect(home_url('/thank-you'));
    exit;
}
add_action('admin_post_fixbee_multistep_form', 'fixbee_handle_multistep_form');
add_action('admin_post_nopriv_fixbee_multistep_form', 'fixbee_handle_multistep_form');


