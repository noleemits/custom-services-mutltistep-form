<form id="fixbee-step4-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step4">
    <input type="hidden" name="category" value="<?php echo esc_attr($_SESSION['fixbee_category']); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($_SESSION['fixbee_zip']); ?>">
    <input type="hidden" name="company" value="<?php echo esc_attr($_SESSION['fixbee_company']); ?>">
    <input type="hidden" name="full_name" value="<?php echo esc_attr($_SESSION['fixbee_full_name']); ?>">
    <input type="hidden" name="phone" value="<?php echo esc_attr($_SESSION['fixbee_phone']); ?>">
    <input type="hidden" name="email" value="<?php echo esc_attr($_SESSION['fixbee_email']); ?>">
    <input type="hidden" name="services" value="<?php echo esc_attr(implode(',', $_SESSION['fixbee_services'])); ?>">

    <label for="travel_radius">Travel Radius (miles)</label>
    <input type="range" name="travel_radius" id="travel_radius" min="0" max="100" value="40">
    <div id="map-container"></div>
    <button type="submit">Submit</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const zip = "<?php echo esc_js($_SESSION['fixbee_zip']); ?>";
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
