<?php
// the backend script for contact form submission which instead of refreshing the page and showing success or error
// message, it returns a JSON response that can be handled by frontend Javascript to provode a dynamic user
// experience without the need for page reloads. this allows for a more seamless and interactive user interface, as users can receive immediate feedback on their form submission without navigating away from the contact page.
// this file is responsible for handling the contact form submission. it takes the data submitted validates it and sanitises it to make sure there is not malicious code
// in the data and then stores it into the database. it also returns a JSON response  to indicate whether the 
// submission was successful or if there were any errors durin the submission process.
require_once __DIR__ . '/includes/db.php';
// header to lets the computer know that the data is in json format for javascript not a html page
header('Content-Type: application/json');
// security header to stop MIME sniffing byot letting the browser guess the file or content type of the 
// response, which can help prevent certain types of attacks such as XSS by ensuring that the browser 
// treats the response as JSON and not as executable code.
header('X-Content-Type-Options: nosniff');
$pdo = getDbConnection();
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
$firstName = e(trim($_POST['name'] ?? ''));
$lastName = e(trim($_POST['last-name'] ?? ''));
$phone = e(trim($_POST['phone'] ?? ''));
$email = e(trim($_POST['email'] ?? ''));
$message = e(trim($_POST['message'] ?? ''));

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
// using prepare statement to make sure the data is validated and sanotised before being added to the database 
// this helps to prevent any type of SQL injection attack and also make sure the data is in the correct format before being added to the database
// using bind value to make sure the data is treated as a string and not an executable code.
try{
    $stmt = $pdo->prepare("INSERT INTO contact_messages (first_name, last_name, phone, email, message) VALUES (:firstName, :lastName, :phone, :email, :message)");
    $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
// to translate the PHP response into a JSON format that can be easily handled by javascript on the frontend.
    echo json_encode(['success' => true, 'status' => 'success', 'message' => 'Your message has been sent successfully.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Failed to send your message. Please try again later.']);
}
?>
