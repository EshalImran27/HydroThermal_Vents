<!-- Header -->
 <!-- the header includes the title of the website along with a navigation bar which contains links to 
  different sections of the website. It also contains the login functionality which is yet to be implemented -->
  <!-- as all the pages include the same header I have decided to include config.php here. -->
<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Hydrothermal Vent Database</title>
    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="/assignment_webtech/css/style.css">
</head>
<body>
    <header>
        <h1 id="page-title">The World of Hydrothermal Vents</h1>
        <h4 id="page-subtitle">Discover the mysteries of the deep sea</h4>
        <nav class="main-nav">
            <div class="logo">HydroCore</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="all_vents.php">Vents</a></li>
                <li><a href="fauna.php">Fauna</a></li>
                <li><a href="map.php">Map</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="login-container">
                <button class="login-btn">Login</button>
            </div>
        </nav>
    </header>
    <main>
    <!-- javascript is added inside the header as there is no more logic required other than the login functionality
     thus that function will be implemented here -->
    <script>
        const loginBtn = document.querySelector('.login-btn');
        loginBtn.addEventListener('click', () => {
            window.location.href = 'login.php';
        });
    </script>
