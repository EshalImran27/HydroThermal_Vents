<?php
require_once 'includes/db.php';
$pageTitle = 'Login';
require_once 'includes/header.php';
$pdo = getDbConnection();
?>
<main class="login-page">
    <form class="login-form" action="login_handler.php" method="POST">
        <h2>Login</h2>
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
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
    <script src="js/login.js"></script>
</main>
<?php require_once 'includes/footer.php'; ?>
