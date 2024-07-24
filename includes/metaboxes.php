<?php
// Add metabox for configuring email recipient
function fixbee_add_meta_boxes() {
    add_meta_box(
        'fixbee_email_recipient',
        'Email Recipient',
        'fixbee_render_meta_box',
        'settings_page_fixbee-form-entries', // Display this metabox on the settings page
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'fixbee_add_meta_boxes');

function fixbee_render_meta_box($post) {
    wp_nonce_field('fixbee_save_meta_box_data', 'fixbee_meta_box_nonce');
    $email = get_option('fixbee_admin_email', get_option('admin_email'));

    echo '<label for="fixbee_admin_email">Admin Email:</label>';
    echo '<input type="email" id="fixbee_admin_email" name="fixbee_admin_email" value="' . esc_attr($email) . '" size="25" />';
}

function fixbee_save_meta_box_data($post_id) {
    if (!isset($_POST['fixbee_meta_box_nonce']) || !wp_verify_nonce($_POST['fixbee_meta_box_nonce'], 'fixbee_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['fixbee_admin_email'])) {
        $email = sanitize_email($_POST['fixbee_admin_email']);
        update_option('fixbee_admin_email', $email);
    }
}
add_action('save_post', 'fixbee_save_meta_box_data');
