// This file contains JavaScript code for client-side functionality, enhancing user interaction on the web pages.

// Example of a simple function to handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[name="form1"]');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            // Perform form validation here
            if (validateForm(form)) {
                // If valid, submit the form via AJAX or any other method
                submitForm(form);
            } else {
                alert('Please fill in all required fields correctly.');
            }
        });
    }
});

// Function to validate form inputs
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(function(field) {
        if (!field.value) {
            isValid = false;
            field.classList.add('is-invalid'); // Add invalid class for styling
        } else {
            field.classList.remove('is-invalid'); // Remove invalid class if valid
        }
    });
    
    return isValid;
}

// Function to submit the form data via AJAX
function submitForm(form) {
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data successfully submitted!');
            window.location.href = 'jadwal_penanganan.php'; // Redirect on success
        } else {
            alert('Error submitting data: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    });
}