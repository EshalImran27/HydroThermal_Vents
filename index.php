<?php
/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */
require_once 'includes/db.php';

$pageTitle = 'Hydrothermal Vents';

// Fetch all vents from the database
$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, name, location, type, depth_metres, discovery_year FROM vents ORDER BY name');
$vents = $stmt->fetchAll();

require_once 'includes/header.php';
?>
<div class="home-banner">
    <h1>Welcome to the Hydrothermal Vent Database</h1>
    <p>Discover the fascinating world of hydrothermal vents in the Western Pacific region.</p>
</div>

<form class="search-form" method="get" action="search.php">
    <input type="text" name="q" placeholder="Search vents by name or location..." required>
    <button type="submit">Search</button>
</form>

<?php if (empty($vents)): ?>
    <p>No vents found in the database.</p>
<?php else: ?>
<div class="cards">
    <?php foreach ($vents as $vent): ?>
        <div class="card">
            <h3><?php echo e($vent['name']); ?></h3>
            <p><strong>Location:</strong> <?php echo e($vent['location']); ?></p>
            <p><strong>Type:</strong> <?php echo e($vent['type']); ?></p>
            <p><strong>Depth:</strong> <?php echo e($vent['depth_metres']); ?> m</p>
            <a href="vent.php?id=<?php echo e($vent['id']); ?>" class="card-link">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>


<?php require_once 'includes/footer.php'; ?>
