<?php
require_once 'includes/db.php';
$pageTitle = 'Edit Vent';
$pdo = getDbConnection();
$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: all_vents.php');
    exit;
}
$stmt = $pdo->prepare('SELECT id, name, location, type, depth_metres, discovery_year FROM vents WHERE id = ?');
$stmt->execute([$id]);
$vent = $stmt->fetch();
if (!$vent) {
    header('Location: all_vents.php');
    exit;
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = e(trim($_POST['name']));
    $location = e(trim($_POST['location']));
    $type = e(trim($_POST['type']));
    $depth = filter_input(INPUT_POST, 'depth', FILTER_VALIDATE_INT);
    $discovery_year = filter_input(INPUT_POST, 'discovery_year', FILTER_VALIDATE_INT);

    if ($name && $location && $type && $depth !== false && $discovery_year !== false) {
        $stmt = $pdo->prepare('UPDATE vents SET name = :name, location = :location, type = :type, depth_metres = :depth, discovery_year = :discovery_year WHERE id = :id');
        $stmt->execute([
            ':name' => $name,
            ':location' => $location,
            ':type' => $type,
            ':depth' => $depth,
            ':discovery_year' => $discovery_year,
            ':id' => $id
        ]);
        header('Location: all_vents.php');
        exit;
    } else {
        $errorMessage = 'Please fill in all fields correctly.';
    }
}
require_once 'includes/header.php';
?>
<h2 id="edit-vent-title">Edit Hydrothermal Vent</h2>
<div class="vent-form-container">
<form action="edit_vent.php?id=<?php echo (int)$id; ?>" method="POST" class="add-vent-form">
    <div class="form-group">
        <input type="text" id="name" name="name" required placeholder=" " value="<?php echo e($vent['name']); ?>">
         <label for="name">Vent Name:</label>
    </div>
    <div class="form-group">
        <input type="text" id="location" name="location" required placeholder=" " value="<?php echo e($vent['location']); ?>">
        <label for="location">Location:</label>
    </div>
    <div class="form-group">
        <input type="text" id="type" name="type" required placeholder=" " value="<?php echo e($vent['type']); ?>">
        <label for="type">Type:</label>
    </div>
    <div class="form-group">
        <input type="number" id="depth" name="depth" required min="0" placeholder=" " value="<?php echo e($vent['depth_metres']); ?>">
        <label for="depth">Depth (metres):</label>
    </div>
    <div class="form-group">
        <input type="number" id="discovery_year" name="discovery_year" required min="1900" max="<?php echo date('Y'); ?>" placeholder=" " value="<?php echo e($vent['discovery_year']); ?>">
        <label for="discovery_year">Discovery Year:</label>
    </div>
    <?php if(!empty($errorMessage)): ?>
        <p class="error-message"><?php echo e($errorMessage); ?></p>
    <?php endif; ?>
    <button type="submit">Update Vent</button>
</form>
</div>
<?php require_once 'includes/footer.php'; ?>
