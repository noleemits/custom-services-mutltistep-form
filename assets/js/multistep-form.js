document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('fixbee-multistep-form');

    if (!form) {
        return; // If the form is not present, do not proceed with the rest of the script
    }

    let currentStep = 1;
    const stepUrl = fixbee_multistep_form_vars.stepUrl;

    function nextStep() {
        const currentStepElement = document.getElementById('step-' + currentStep);
        if (currentStepElement) {
            currentStepElement.style.display = 'none';
            currentStep++;
            const nextStepElement = document.getElementById('step-' + currentStep);
            if (nextStepElement) {
                nextStepElement.style.display = 'block';

                // Update the URL without reloading the page
                const newUrl = stepUrl + '/step-' + currentStep;
                history.pushState(null, null, newUrl);
            } else {
                console.error('Next step element not found: step-' + currentStep);
            }
        } else {
            console.error('Current step element not found: step-' + currentStep);
        }
    }

    document.querySelectorAll('.next-step-button').forEach(button => {
        button.addEventListener('click', nextStep);
    });

    const container = document.getElementById('service-categories-container');
    if (container) {
        const zip = fixbee_multistep_form_vars.zip;

        fetch('/wp-json/fixbee/v1/services_by_category')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    displayServices(data, container);
                }
            })
            .catch(error => console.error('Error fetching services:', error));
    } else {
        console.error('Service categories container not found');
    }

    function displayServices(data, container) {
        container.innerHTML = '';

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

    const serviceSearch = document.getElementById('service-search');
    if (serviceSearch) {
        serviceSearch.addEventListener('input', function () {
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
    } else {
        console.error('Service search input not found');
    }

    const radiusInput = document.getElementById('travel_radius');
    if (radiusInput) {
        radiusInput.addEventListener('input', function () {
            const radius = this.value;
            // Update map zoom and circle radius based on input value
        });
    } else {
        console.error('Travel radius input not found');
    }
});
