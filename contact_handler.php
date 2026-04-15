<?php
require_once __DIR__ . '/includes/db.php';
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
$pdo = getDbConnection();
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
$firstName = htmlspecialchars(trim($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'));
$lastName = htmlspecialchars(trim($_POST['last-name'] ?? '', ENT_QUOTES, 'UTF-8'));
$phone = htmlspecialchars(trim($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8'));
$email = htmlspecialchars(trim($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
$message = htmlspecialchars(trim($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'));

$errors = [];
if (strlen($firstName) < 2) {
    $errors[] = 'First name must be at least 2 characters long.';
}
if (strlen($lastName) < 2) {
    $errors[] = 'Last name must be at least 2 characters long.';
}
if (!preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
    $errors[] = 'Invalid phone number format.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}
if (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters long.';
}

if(!empty($errors)) {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => implode(' ', $errors)]);
    exit;
}
try{
    $stmt = $pdo->prepare("INSERT INTO contact_messages (first_name, last_name, phone, email, message) VALUES (:firstName, :lastName, :phone, :email, :message)");
    $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(['success' => true, 'status' => 'success', 'message' => 'Your message has been sent successfully.']);
} catch (PDOException $e) {
    // In production, log this error instead of displaying it
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to send your message. Please try again later.']);
}
?>
