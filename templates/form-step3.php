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

?>

<form id="fixbee-step3-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="fixbee_step3">
    <input type="hidden" name="category" value="<?php echo esc_attr($category); ?>">
    <input type="hidden" name="zip" value="<?php echo esc_attr($zip); ?>">
    <input type="hidden" name="company" value="<?php echo esc_attr($company); ?>">
    <input type="hidden" name="full_name" value="<?php echo esc_attr($full_name); ?>">
    <input type="hidden" name="phone" value="<?php echo esc_attr($phone); ?>">
    <input type="hidden" name="email" value="<?php echo esc_attr($email); ?>">

    <!-- Dynamically populated services list -->
    <div id="service-categories-container"></div>
    <input type="search" id="service-search" placeholder="Want to add more services?">
    <button type="submit">Next</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('service-categories-container');
        console.log('Container:', container);

        if (container) {
            fetch('/wp-json/fixbee/v1/services_by_category')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Log the response for debugging
                    if (Array.isArray(data)) {
                        displayServices(data, container);
                    } else {
                        console.error('Expected an array but got:', data);
                    }
                })
                .catch(error => console.error('Error fetching services:', error));
        } else {
            console.error('Container element not found');
        }

        function displayServices(data, container) {
            console.log('Displaying services'); // Debug message
            container.innerHTML = ''; // Clear any existing content

            data.forEach(category => {
                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('service-category');

                const categoryTitle = document.createElement('h3');
                categoryTitle.innerText = category.category;

                const servicesList = document.createElement('div');
                servicesList.classList.add('services-list');

                category.services.forEach(service => {
                    const serviceLabel = document.createElement('label');
                    serviceLabel.classList.add('service-item');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'services[]';
                    checkbox.value = service.id;

                    const serviceName = document.createElement('span');
                    serviceName.innerText = service.name;

                    serviceLabel.appendChild(checkbox);
                    serviceLabel.appendChild(serviceName);
                    servicesList.appendChild(serviceLabel);
                });

                categoryDiv.appendChild(categoryTitle);
                categoryDiv.appendChild(servicesList);
                container.appendChild(categoryDiv);
            });
        }

        document.getElementById('service-search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.service-item').forEach(item => {
                const serviceName = item.querySelector('span').innerText.toLowerCase();
                if (serviceName.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>

