<?php
require_once 'includes/db.php';
$pageTitle = 'Login';
require_once 'includes/header.php';
$pdo = getDbConnection();
?>
<main class="login-page">
    <div class="card-container">
        <div class="flipper">
            <div class="card-face card-front">
                <form class="login-form" action="login_handler.php" method="POST">
                    <h2 id="login-title">Login</h2>
                    <div class="form-group username">
                        <input type="text" id="username" name="username" required>
                        <label for="username">Username:</label>
            <span class="underline"></span>
            <span class="error-message" id="username-error"></span>
        </div>
        <div class="form-group password">
            <input type="password" id="password" name="password" required>
            <label for="password">Password:</label>
            <span class="underline"></span>
            <span class="error-message" id="password-error"></span>
        </div>
        <button type="submit">Login</button>
        <p class="register-link">Don't have an account? <button type="button" id="register-link">Register here</button>.</p>
    </form>
            </div>
            <div class="card-face card-back">
                <form class="register-form" action="register_handler.php" method="POST">
                    <h2 id="register-title">Register</h2>
                    <div class="form-group username">
                        <input type="text" id="reg-username" name="username" required>
                        <label for="reg-username">Username:</label>
            <span class="underline"></span>
            <span class="error-message" id="reg-username-error"></span>
        </div>
        <div class="form-group email">
            <input type="email" id="reg-email" name="email" required>
            <label for="reg-email">Email:</label>
            <span class="underline"></span>
            <span class="error-message" id="reg-email-error"></span>
        </div>
        <div class="form-group password">
            <input type="password" id="reg-password" name="password" required>
            <label for="reg-password">Password:</label>
            <span class="underline"></span>
            <span class="error-message" id="reg-password-error"></span>
        </div>
        <button type="submit">Register</button>
        <p class="login-link">Already have an account? <button type="button" id="login-link">Login here</button>.</p>
    </form>
            </div>
        </div>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
