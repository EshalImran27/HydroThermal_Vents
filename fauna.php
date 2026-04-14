<?php
require_once 'includes/db.php';

$pageTitle = 'Vent Fauna';

$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, vent_id, name, scientific_name, description, image_url FROM fauna');
$fauna = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<?php if (empty($fauna)): ?>
    <p>No fauna found in the database.</p>
<?php else: ?>
    <table class="fauna-table">
        <thead class="fauna-table-header">
            <tr class="fauna-table-row">
                <th>ID</th>
                <th>Vent ID</th>
                <th>Name</th>
                <th>Scientific Name</th>
                <th>Description</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody class="fauna-table-body">
            <?php foreach ($fauna as $animal): ?>
                <tr>
                    <td><?php echo e($animal['id']); ?></td>
                    <td><?php echo e($animal['vent_id']); ?></td>
                    <td><?php echo e($animal['name']); ?></td>
                    <td><?php echo e($animal['scientific_name']); ?></td>
                    <td id="fauna-description"><?php echo e($animal['description']); ?></td>
                    <td><img src="<?php echo e($animal['image_url']); ?>" alt="<?php echo e($animal['name']); ?>" width="100"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>