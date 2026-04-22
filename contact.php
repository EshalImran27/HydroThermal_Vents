<?php
$pageTitle = 'Contact Us';
require_once 'includes/header.php';
?>
<!--  The contact.php file provides a contact form for users to reach out to the website administrators with 
questions, feedback, or contributions related to the Hydrothermal Vent Database.
 The form includes fields for the user's first name, last name, phone number, email, and message. Each 
field has validation requirements to ensure that the submitted data is complete and properly formatted.
the form is of type POST, so that the data is send only when the form is submitted in this way it is more secure
and data is not exposed in the URL, and it allows for a larger amount of data to be sent compared to GET method,
which is important for the message field where users may want to provide detailed information or feedback. -->
<main class="contact-page">
    <h2>Contact Us</h2>
    <p>If you have any questions, feedback, or would like to contribute to our Hydrothermal Vent Database, please feel free to reach out to us using the contact form below.</p>
    <form class="contact-form" action="contact_handler.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <input type="text" id="name" name="name" required minlength="2" >
                <label for="name">First Name:</label>
                <span class="underline"></span>
                <span class="error-message" id="first-name-error"></span>
            </div>
            <div class="form-group">
                <input type="text" id="last-name" name="last-name" required minlength="2">
                <label for="last-name">Last Name:</label>
                <span class="underline"></span>
                <span class="error-message" id="last-name-error"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <input type="tel" id="phone" name="phone" required pattern="^\+?[0-9\s\-]{7,15}$">
                <label for="phone">Phone Number:</label>
                <span class="underline"></span>
                <span class="error-message" id="phone-error"></span>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Email:</label>
                <span class="underline"></span>
                <span class="error-message" id="email-error"></span>
            </div>
        </div>
        <div class="form-group-message">
            <textarea id="message" name="message" rows="5" required></textarea>
            <label for="message">Message:</label>
            <span class="underline"></span>
            <span class="error-message" id="message-error"></span>
        </div>
        <button type="submit">Send Message</button>
    </form>
    <script src="js/contact.js"></script>
</main>

<?php require_once 'includes/footer.php'; ?>