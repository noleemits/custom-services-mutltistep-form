<?php
session_start();

$category = isset($_SESSION['fixbee_category']) ? $_SESSION['fixbee_category'] : '';
$zip = isset($_SESSION['fixbee_zip']) ? $_SESSION['fixbee_zip'] : '';
?>

<form id="fixbee-multistep-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_multistep_form">
    <input type="hidden" name="category" value="<?php echo esc_attr($category); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($zip); ?>">
    
    <div class="step" id="step-1">
        <h2>Step 1</h2>
        <label for="company">Company</label>
        <input type="text" name="company" id="company" required>
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" required>
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <button type="button" class="next-step-button">Next</button>
    </div>

    <div class="step" id="step-2" style="display: none;">
        <h2>Step 2</h2>
        <div id="service-categories-container"></div>
        <input type="search" id="service-search" placeholder="Want to add more services?">
        <button type="button" class="next-step-button">Next</button>
    </div>

    <div class="step" id="step-3" style="display: none;">
        <h2>Step 3</h2>
        <label for="travel_radius">Travel Radius (miles)</label>
        <input type="range" name="travel_radius" id="travel_radius" min="0" max="100" value="40">
        <div id="map-container"></div>
        <button type="submit">Submit</button>
    </div>
</form>
