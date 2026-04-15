<?php
/**
 * Hydrothermal Vent Database - Single Vent Page
 * Displays details of a single vent
 *
 * SET08101 Web Technologies Coursework Starter Code
 */
require_once 'includes/db.php';

// Validate the vent ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

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
<?php
$stmt = $pdo->prepare('SELECT name, scientific_name, description, image_url FROM fauna WHERE vent_id = ?');
$stmt->execute([$ventId]);
$fauna = $stmt->fetchAll();
if (empty($fauna)) {
    echo '<p class="no-fauna">No fauna associated with this vent.</p>';
} else {
    echo '<div class="fauna-grid">';
    foreach ($fauna as $animal) {
        echo '<div class="fauna-card">';
        if (!empty($animal['image_url'])) {
            echo '<div class="fauna-image">';
            echo '<img src="' . e($animal['image_url']) . '" alt="' . e($animal['name']) . '" width="100">';
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
