<?php $__env->startSection('content'); ?>


<main id="contact-main"

style="padding-left: 370px;"        
>
  <!--  above is the padding making the page contents more to the right -->

    
    <section style="flex: 1; max-width: 400px; padding-right: 20px">
        <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 10px; margin-left: -100px;">
        Contact Us
        </h1>
        <p style="font-size: 16px; line-height: 1.5">
        We’d love to hear from you! Reach out with any questions or feedback.
        </p>
        <p style="font-family: 'Merriweather'; font-size: 16px; margin-top: 20px">       <!-- font have been changed to merriweather -->



        Email:
        <a
            href="mailto:support@essentials.com"
            style="color: #007bff; text-decoration: none"
            >info@glidedcanvas.com</a
        >
        </p>
        <p style="font-size: 16px">Phone: +447953456456</p>
    </section>

    <!-- Contact Form Section -->
    <section style="flex: 1; max-width: 400px">
        <form style="display: flex; flex-direction: column">
        <label for="name" style="font-size: 14px; margin-bottom: 5px"
            >Name <span style="color: #d00">(required)</span></label
        >
        <input
            type="text"
            id="name"
            name="name"
            required
            style="
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            "
        />

        <label for="email" style="font-size: 14px; margin-bottom: 5px"
            >Email <span style="color: #d00">(required)</span></label
        >
        <input
            type="email"
            id="email"
            name="email"
            required
            style="
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            "
        />

        <label for="message" style="font-size: 14px; margin-bottom: 5px"
            >Message <span style="color: #d00">(required)</span></label
        >
        <textarea
            id="message"
            name="message"
            rows="5"
            required
            style="
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            "
        ></textarea>

        <button
            type="submit"
            style="
            padding: 10px 20px;
            background-color:#d4af37;      
            color:black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            "
        >

          <!-- above is where i changed the colour and text of the button to gold and black -->

            Create Email
        </button>
        </form>    
    </section>
</main>
<script>
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
                // Mailto added by ProfProgram
                const subject = `Message from ${nameInput.value.trim()}`; // Construct subject
                const body = messageInput.value.trim(); // Get the body content

                const mailtoLink = `mailto:info@gildedcanvas.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

                window.location.href = mailtoLink;
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
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adams\Documents\GitHub\Gilded-Canvas\TheGuildedCanvas\resources\views/contact-us.blade.php ENDPATH**/ ?>