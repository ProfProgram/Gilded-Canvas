document.addEventListener('DOMContentLoaded', function () {
    // Get form and input elements
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    // Add event listener for form submission
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form from submitting normally

        // Validate inputs
        const isNameValid = validateInput(nameInput, 'Name is required.');
        const isEmailValid = validateEmail(emailInput);
        const isMessageValid = validateInput(messageInput, 'Message is required.');

        // If all inputs are valid, simulate form submission
        if (isNameValid && isEmailValid && isMessageValid) {
            alert('Your message has been sent successfully!');
            form.reset(); // Clear the form
        }
    });

    // Function to validate required input fields
    function validateInput(input, errorMessage) {
        const value = input.value.trim();
        if (value === '') {
            showError(input, errorMessage);
            return false;
        } else {
            clearError(input);
            return true;
        }
    }

    // Function to validate email format
    function validateEmail(input) {
        const value = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (value === '') {
            showError(input, 'Email is required.');
            return false;
        } else if (!emailRegex.test(value)) {
            showError(input, 'Enter a valid email address.');
            return false;
        } else {
            clearError(input);
            return true;
        }
    }

    // Function to display an error message
    function showError(input, message) {
        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('error-message')) {
            error = document.createElement('div');
            error.classList.add('error-message');
            error.style.color = 'red';
            error.style.fontSize = '12px';
            error.style.marginTop = '-10px';
            error.style.marginBottom = '10px';
            input.parentNode.insertBefore(error, input.nextSibling);
        }
        error.textContent = message;
    }

    // Function to clear the error message
    function clearError(input) {
        const error = input.nextElementSibling;
        if (error && error.classList.contains('error-message')) {
            error.remove();
        }
    }
});
