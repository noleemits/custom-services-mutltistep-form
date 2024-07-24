<form id="fixbee-step1-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step1">
    <label for="category">Choose your category</label>
    <select name="category" id="category" required>
        <?php
        $terms = get_terms(array('taxonomy' => 'service-category', 'hide_empty' => false));
        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
        }
        ?>
    </select>
    <label for="zip">Enter Zip Code</label>
    <input type="text" name="zip" id="zip" required>
    <button type="submit">Join for free</button>
</form>
