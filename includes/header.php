<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Hydrothermal Vent Database</title>
    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="/assignment_webtech/css/style.css">
    <!-- Students: Add your CSS stylesheet link here -->
</head>
<body>
    <header>
        <h1 id="page-title">The World of Hydrothermal Vents</h1>
        <h4 id="page-subtitle">Discover the mysteries of the deep sea</h4>
        <hr color="#1F4068" size="3">
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
