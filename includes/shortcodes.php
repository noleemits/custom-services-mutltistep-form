<?php
// Shortcode for Step 1 form
function fixbee_form_step1() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step1.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step1', 'fixbee_form_step1');

// Shortcode for Step 2 form
function networx_form_step2() {
    ob_start();
    include NETWORX_PLUGIN_DIR . 'templates/form-step2.php';
    return ob_get_clean();
}
add_shortcode('networx_form_step2', 'networx_form_step2');
