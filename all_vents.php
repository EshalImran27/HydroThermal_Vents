<?php
require_once 'includes/db.php';

$pageTitle = 'All Vents';

$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, name, location, type, depth_metres, discovery_year FROM vents');
$allvents = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<?php if (empty($allvents)): ?>
    <p>No vents found in the database.</p>
<?php else: ?>
    <table class="fauna-table">
        <thead class="fauna-table-header">
            <tr class="fauna-table-row">
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Depth (m)</th>
                <th>Discovery Year</th>
            </tr>
        </thead>
        <tbody class="fauna-table-body">
            <?php foreach ($allvents as $vent): ?>
                <tr>
                    <td><?php echo e($vent['id']); ?></td>
                    <td><?php echo e($vent['name']); ?></td>
                    <td><?php echo e($vent['location']); ?></td>
                    <td><?php echo e($vent['type']); ?></td>
                    <td><?php echo e($vent['depth_metres']); ?></td>
                    <td><?php echo e($vent['discovery_year']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>