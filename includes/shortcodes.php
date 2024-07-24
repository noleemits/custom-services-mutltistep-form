<?php
// Shortcode for Step 1 form
function fixbee_form_step1() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step1.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step1', 'fixbee_form_step1');

// Shortcode for Step 2 form
function fixbee_form_step2() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step2.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step2', 'fixbee_form_step2');

// Shortcode for Step 3 form
function fixbee_form_step3() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step3.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step3', 'fixbee_form_step3');

// Shortcode for Step 4 form
function fixbee_form_step4() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step4.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step4', 'fixbee_form_step4');
