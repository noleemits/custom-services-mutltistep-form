<form id="fixbee-step2-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step2">
    <input type="hidden" name="category" value="<?php echo esc_attr($_SESSION['fixbee_category']); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($_SESSION['fixbee_zip']); ?>">
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
