<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Initialize session variables if not set
$category = isset($_SESSION['fixbee_category']) ? $_SESSION['fixbee_category'] : '';
$zip = isset($_SESSION['fixbee_zip']) ? $_SESSION['fixbee_zip'] : '';
$company = isset($_SESSION['fixbee_company']) ? $_SESSION['fixbee_company'] : '';
$full_name = isset($_SESSION['fixbee_full_name']) ? $_SESSION['fixbee_full_name'] : '';
$phone = isset($_SESSION['fixbee_phone']) ? $_SESSION['fixbee_phone'] : '';
$email = isset($_SESSION['fixbee_email']) ? $_SESSION['fixbee_email'] : '';
$services = isset($_SESSION['fixbee_services']) && is_array($_SESSION['fixbee_services']) ? implode(',', $_SESSION['fixbee_services']) : '';

?>

<form id="fixbee-step4-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step4">
    <input type="hidden" name="category" value="<?php echo esc_attr($category); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($zip); ?>">
    <input type="hidden" name="company" value="<?php echo esc_attr($company); ?>">
    <input type="hidden" name="full_name" value="<?php echo esc_attr($full_name); ?>">
    <input type="hidden" name="phone" value="<?php echo esc_attr($phone); ?>">
    <input type="hidden" name="email" value="<?php echo esc_attr($email); ?>">
    <input type="hidden" name="services" value="<?php echo esc_attr($services); ?>">

    <label for="travel_radius">Travel Radius (miles)</label>
    <input type="range" name="travel_radius" id="travel_radius" min="0" max="100" value="40">
    <div id="map-container"></div>
    <button type="submit">Submit</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const zip = "<?php echo esc_js($zip); ?>";
        const mapContainer = document.getElementById('map-container');
        const radiusInput = document.getElementById('travel_radius');

        // Initialize map and radius slider
        // Assuming you are using a map API like Google Maps or Leaflet
        // Initialize map with zip code location and radius

        radiusInput.addEventListener('input', function () {
            const radius = this.value;
            // Update map zoom and circle radius based on input value
        });
    });
</script>
