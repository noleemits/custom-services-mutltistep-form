<?php
add_action('rest_api_init', function () {
    register_rest_route('fixbee/v1', '/services_by_category', array(
        'methods' => 'GET',
        'callback' => 'fixbee_get_services_by_category',
    ));
});

function fixbee_get_services_by_category() {
    $categories = get_terms(array(
        'taxonomy' => 'service-category',
        'hide_empty' => false,
    ));

    $services_by_category = array();

    foreach ($categories as $category) {
        $services = get_posts(array(
            'post_type' => 'services',
            'tax_query' => array(
                array(
                    'taxonomy' => 'service-category',
                    'field' => 'slug',
                    'terms' => $category->slug,
                ),
            ),
        ));

        $services_list = array();
        foreach ($services as $service) {
            $services_list[] = array(
                'id' => $service->ID,
                'name' => $service->post_title,
            );
        }

        $services_by_category[] = array(
            'category' => $category->name,
            'services' => $services_list,
        );
    }

    return rest_ensure_response($services_by_category);
}
