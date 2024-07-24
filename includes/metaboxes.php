<?php
function fixbee_add_meta_boxes() {
    add_meta_box(
        'fixbee_texts',
        'fixbee Form Texts',
        'fixbee_render_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'fixbee_add_meta_boxes');

function fixbee_render_meta_box($post) {
    wp_nonce_field('fixbee_save_meta_box_data', 'fixbee_meta_box_nonce');
    
    $texts = get_post_meta($post->ID, '_fixbee_texts', true);
    
    echo '<label for="fixbee_text">Text:</label>';
    echo '<input type="text" id="fixbee_text" name="fixbee_text" value="' . esc_attr($texts) . '" size="25" />';
}

function fixbee_save_meta_box_data($post_id) {
    if (!isset($_POST['fixbee_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['fixbee_meta_box_nonce'], 'fixbee_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (!isset($_POST['fixbee_text'])) {
        return;
    }

    $texts = sanitize_text_field($_POST['fixbee_text']);
    update_post_meta($post_id, '_fixbee_texts', $texts);
}
add_action('save_post', 'fixbee_save_meta_box_data');
