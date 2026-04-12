<?php
$pageTitle = 'Contact Us';
require_once 'includes/header.php';
?>
<main class="contact-page">
    <h2>Contact Us</h2>
    <p>If you have any questions, feedback, or would like to contribute to our Hydrothermal Vent Database, please feel free to reach out to us using the contact form below.</p>
    <form class="contact-form">
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
                <input type="tel" id="phone" name="phone" required pattern="^\
                +?[0-9\s\-]{7,15}$">
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