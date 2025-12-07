<?php
require_once '../../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$conn = getDatabaseConnection();
$user_id = $_SESSION['user_id'];

// Get user details
$user_stmt = $conn->prepare("SELECT id, fullname, username, email, phonenumber, created_at FROM tb_user WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_details = $user_result->fetch_assoc();

// Decrypt sensitive data
$user_details['fullname'] = decrypt($user_details['fullname']);
$user_details['email'] = decrypt($user_details['email']);
$user_details['phonenumber'] = decrypt($user_details['phonenumber']);

// Get vehicles user is selling
$selling_stmt = $conn->prepare("SELECT * FROM sell_vehicles WHERE user_id = ? ORDER BY listed_on DESC");
$selling_stmt->bind_param("i", $user_id);
$selling_stmt->execute();
$selling_result = $selling_stmt->get_result();
$selling_vehicles = [];

while ($row = $selling_result->fetch_assoc()) {
    $row['make'] = decrypt($row['make']);
    $row['model'] = decrypt($row['model']);
    $row['state'] = decrypt($row['state']);
    $row['fuel_type'] = decrypt($row['fuel_type']);
    $row['year'] = intval(decrypt($row['year']));
    $row['mileage'] = intval(decrypt($row['mileage']));
    $row['price'] = floatval(decrypt($row['price']));
    $selling_vehicles[] = $row;
}

// Get vehicles user has scrapped
$scrap_stmt = $conn->prepare("SELECT * FROM scrap_vehicles WHERE user_id = ? ORDER BY created_at DESC");
$scrap_stmt->bind_param("i", $user_id);
$scrap_stmt->execute();
$scrap_result = $scrap_stmt->get_result();
$scrap_vehicles = [];

while ($row = $scrap_result->fetch_assoc()) {
    $scrap_vehicles[] = $row;
}

$response = [
    'userDetails' => $user_details,
    'selling' => $selling_vehicles,
    'scrap' => $scrap_vehicles
];

$conn->close();
echo json_encode($response);
?>