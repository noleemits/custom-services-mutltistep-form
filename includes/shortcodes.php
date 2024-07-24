<?php
// Shortcode for Step 1 form
function fixbee_form_step1() {
    ob_start();
    include FIXBEE_PLUGIN_DIR . 'templates/form-step1.php';
    return ob_get_clean();
}
add_shortcode('fixbee_form_step1', 'fixbee_form_step1');
