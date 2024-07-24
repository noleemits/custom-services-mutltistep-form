<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Initialize session variables if not set
$category = isset($_SESSION['fixbee_category']) ? $_SESSION['fixbee_category'] : '';
$zip = isset($_SESSION['fixbee_zip']) ? $_SESSION['fixbee_zip'] : '';

?>

<form id="fixbee-step2-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step2">
    <input type="hidden" name="category" value="<?php echo esc_attr($category); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($zip); ?>">
    <label for="company">Company</label>
    <input type="text" name="company" id="company" required>
    <label for="full_name">Full Name</label>
    <input type="text" name="full_name" id="full_name" required>
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone" id="phone" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Next</button>
</form>
