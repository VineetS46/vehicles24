<?php
require_once '../../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$fullname = trim($_POST['fullname']);
$phonenumber = trim($_POST['phonenumber']);

if (empty($fullname) || empty($phonenumber)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

$conn = getDatabaseConnection();
$encrypted_fullname = encrypt($fullname);
$encrypted_phone = encrypt($phonenumber);
$stmt = $conn->prepare("UPDATE tb_user SET fullname = ?, phonenumber = ? WHERE id = ?");
$stmt->bind_param("ssi", $encrypted_fullname, $encrypted_phone, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}

$conn->close();
?>