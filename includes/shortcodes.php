<?php
// Shortcode for Step 1 form
function fixbee_form_step1() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step1.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step1', 'fixbee_form_step1');

// Shortcode to display the multistep form
function fixbee_multistep_form_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/form-steps.php';
    return ob_get_clean();
}
add_shortcode('fixbee_multistep_form', 'fixbee_multistep_form_shortcode');
