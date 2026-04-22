<?php
/**
 * Hydrothermal Vent Database - Single Vent Page
 * Displays details of a single vent
 *
 * SET08101 Web Technologies Coursework Starter Code
 */
require_once 'includes/db.php';

// Validate the vent ID parameter
// if data is missing or invalid, the user is redirected back to the homepage to prevent errors and ensure a smooth user experience.
// the process is exited after the redirection to stop any further code execution which could lead to errors or unintended behavior.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

// Cast the vent ID to an integer to ensure it's a valid number and prevent SQL injection attacks.
$ventId = (int)$_GET['id'];
$pdo = getDbConnection();

// Fetch the vent details
$stmt = $pdo->prepare('SELECT id, name, location, type, depth_metres, discovery_year FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
$vent = $stmt->fetch();

// If vent not found, redirect to home
if (!$vent) {
    header('Location: index.php');
    exit;
}

$pageTitle = $vent['name'];
// The safeImageUrl function is used to validate and sanitize image URLs before displaying them on the vent detail page.

function safeImageUrl($url) {
    $url = trim((string)$url);
    if ($url === '') {
        return null;
    }
// Use parse_url to validate the URL structure and ensure it has a valid scheme (http or https).
    $parts = parse_url($url);
    if ($parts === false) {
        return null;
    }
// Only allow http and https schemes for image URLs to prevent potential security issues with other schemes.
    $scheme = strtolower($parts['scheme'] ?? '');
    if ($scheme !== '' && !in_array($scheme, ['http', 'https'], true)) {
        return null;
    }

    return $url;
}

require_once 'includes/header.php';
?>

<p><a href="index.php">&larr; Back to all vents</a></p>

<h2 class="vent-detail-heading"><?php echo e($vent['name']); ?></h2>

<dl class="vent-details">
    <dt>Location</dt>
    <dd><?php echo e($vent['location']); ?></dd>

    <dt>Type</dt>
    <dd><?php echo e($vent['type']); ?></dd>

    <dt>Depth</dt>
    <dd><?php echo e($vent['depth_metres']); ?> metres</dd>

    <dt>Discovery Year</dt>
    <dd><?php echo e($vent['discovery_year']); ?></dd>
</dl>

<h3 class="vent-detail-heading">Associated Fauna</h3>
<!-- wrap the url in the safeImageUrl function to ensure that only valid and safe image URLs are used when displaying fauna images on the vent detail page.
plus also make sure the url typed passes the htmlspecialchars function to prevent XSS attacks by escaping any special characters in the URL that could be used to inject malicious code into the page.
 using load="lazy" attribute to defer the loading of images until they are needed, which can improve page load times and overall performance, especially if there are many images on the page. -->
<?php
$stmt = $pdo->prepare('SELECT name, scientific_name, description, image_url FROM fauna WHERE vent_id = ?');
$stmt->execute([$ventId]);
$fauna = $stmt->fetchAll();
if (empty($fauna)) {
    echo '<p class="no-fauna" style="color: #a08160;">No fauna associated with this vent.</p>';
} else {
    echo '<div class="fauna-grid">';
    foreach ($fauna as $animal) {
        $safeImage = safeImageUrl($animal['image_url'] ?? '');
        echo '<div class="fauna-card">';
        if ($safeImage !== null) {
            echo '<div class="fauna-image">';
            echo '<img src="' . e($safeImage) . '" alt="' . e($animal['name']) . '" width="100" loading="lazy">';
            echo '</div>';
        }
        echo '<div class="fauna-info">';
        echo '<h4>' . e($animal['name']) . '</h4>';
        echo '<span class="scientific-name">' . e($animal['scientific_name']) . '</span>';
        echo '<p>' . e($animal['description']) . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

?>



<?php require_once 'includes/footer.php'; ?>
