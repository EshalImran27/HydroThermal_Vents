<?php
require_once 'includes/db.php';
$pageTitle = 'Add New Vent';
require_once 'includes/header.php';

$pdo = getDbConnection();
// use post method to add new vent to the database, and validate the input data before inserting it into 
// the database to ensure that all required fields are filled in correctly and that the data is in the 
// expected format.
// POST method makes sure the data is sent in the request body, which is more secure than GET method as it 
// does not expose the data in the URL and has a larger capacity for sending data, allowing for more complex
//  and detailed information to be submitted through the form. 
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $type = trim($_POST['type']);
    $depth = filter_input(INPUT_POST, 'depth', FILTER_VALIDATE_INT);
    $discovery_year = filter_input(INPUT_POST, 'discovery_year', FILTER_VALIDATE_INT);

    if ($name && $location && $type && $depth !== false && $discovery_year !== false) {
        $stmt = $pdo->prepare('INSERT INTO vents (name, location, type, depth_metres, discovery_year) VALUES (:name, :location, :type, :depth, :discovery_year)');
        $stmt->execute([
            ':name' => $name,
            ':location' => $location,
            ':type' => $type,
            ':depth' => $depth,
            ':discovery_year' => $discovery_year
        ]);
        header('Location: all_vents.php');
        exit;
        //echo '<p class="success-message">Vent added successfully!</p>';
    } else {
        $errorMessage = 'Please fill in all fields correctly.';
        //echo '<p class="error-message">Please fill in all fields correctly.</p>';
    }
}
?>

<h2 id="add-vent-title">Add New Hydrothermal Vent</h2>
<div class="vent-form-container">
<form action="add_vent.php" method="POST" class="add-vent-form">
    <div class="form-group">
        <input type="text" id="name" name="name" required placeholder=" ">
         <label for="name">Vent Name:</label>
    </div>
    <div class="form-group">
        <input type="text" id="location" name="location" required placeholder=" ">
        <label for="location">Location:</label>
    </div>
    <div class="form-group">
        <input type="text" id="type" name="type" required placeholder=" ">
        <label for="type">Type:</label>
    </div>
    <div class="form-group">
        <input type="number" id="depth" name="depth" required min="0" placeholder=" ">
        <label for="depth">Depth (metres):</label>
    </div>
    <div class="form-group">
        <input type="number" id="discovery_year" name="discovery_year" required min="1900" max="<?php echo date('Y'); ?>" placeholder=" ">
        <label for="discovery_year">Discovery Year:</label>
    </div>
    <?php if(!empty($errorMessage)): ?>
        <p class="error-message"><?php echo e($errorMessage); ?></p>
    <?php endif; ?>
    <button type="submit">Add Vent</button>
</form>
</div>
<?php require_once 'includes/footer.php'; ?>
