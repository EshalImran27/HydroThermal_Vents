<?php
require_once 'includes/db.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    header('Location: all_vents.php');
    exit;
}
$ventId = (int)($_POST['id'] ?? 0);
if($ventId <= 0) {
    header('Location: all_vents.php');
    exit;
}
// Cast the vent ID to an integer to ensure it's a valid number and prevent SQL injection attacks.
$pdo = getDbConnection();
$stmt = $pdo->prepare('SELECT id FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
if(!$stmt->fetch()) {
    header('Location: all_vents.php');
    exit;
}
// The deletion process is handled securely by using a prepared statement to execute the DELETE query, 
// which helps prevent SQL injection attacks.
$stmt = $pdo->prepare('DELETE FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
header('Location: all_vents.php');
exit;
?>