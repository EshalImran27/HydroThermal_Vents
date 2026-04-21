<?php
require_once 'includes/db.php';

$pageTitle = 'All Vents';

$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, name, location, type, depth_metres, discovery_year FROM vents');
$allvents = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<?php if (empty($allvents)): ?>
    <p style="color: #a08160;">No vents found in the database.</p>
<?php else: ?>
    // the table is named same as fauna table because of time constraint
    // in future, it can be changed to something more appropriate like vents-table or something like that.
    <table class="fauna-table">
        <thead class="fauna-table-header">
            <tr class="fauna-table-row">
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Depth (m)</th>
                <th>Discovery Year</th>
                <th>Actions</th>
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
                    <td class="update-vents-actions">
                        // the edit and delete actions for each vent are implemented as links and forms respectively, allowing users to easily manage the vents in the database.
                        // it makes sure the value of the vent ID is properly escaped and cast to an integer to prevent potential security issues such as SQL injection or XSS 
                        // attacks when generating the edit link and delete form for each vent.
                        // the delete form includes a confirmation prompt to prevent accidental deletions, enhancing the user experience and data integrity of the application.
                        <a href="edit_vent.php?id=<?php echo (int) $vent['id']; ?>">Edit</a>
                        <form action="del_vent.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this vent?');" class="delete-vent-form">
                            <input type="hidden" name="id" value="<?php echo (int) $vent['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="update-vents-link">
        <a href="add_vent.php">Add New Vent</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>