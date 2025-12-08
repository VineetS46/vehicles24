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

$vehicle_type = trim($_POST['vehicle_type']);
$make = trim($_POST['make']);
$model = trim($_POST['model']);
$year = intval($_POST['year']);
$vehicle_number = trim($_POST['vehicle_number']);
$color = trim($_POST['color']);
$kms_driven = intval($_POST['kms_driven']);
$mileage = floatval($_POST['mileage']);
$condition = intval($_POST['condition']);
$gear_type = trim($_POST['gear_type']);
$owners = intval($_POST['owners']);
$state = trim($_POST['state']);
$fuel_type = trim($_POST['fuel_type']);
$price = floatval($_POST['price']);
$insurance_valid = trim($_POST['insurance_valid']);

// Validate required fields
if (empty($vehicle_type) || empty($make) || empty($model) || $year <= 0 || empty($vehicle_number) || empty($color) || $kms_driven < 0 || $mileage <= 0 || $condition < 1 || $condition > 5 || empty($gear_type) || $owners < 1 || empty($state) || empty($fuel_type) || $price <= 0 || empty($insurance_valid)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required and must be valid']);
    exit();
}

// Handle file upload
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Image upload failed']);
    exit();
}

$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$file_type = $_FILES['image']['type'];

if (!in_array($file_type, $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid image format. Only JPG, PNG, and GIF allowed']);
    exit();
}


$file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$unique_filename = uniqid() . '_' . time() . '.' . $file_extension;

$upload_dir = '/var/www/html/upload/';
$upload_path = $upload_dir . $unique_filename;

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save image']);
    exit();
}


// Insert into database
$conn = getDatabaseConnection();
$encrypted_make = encrypt($make);
$encrypted_model = encrypt($model);
$encrypted_year = encrypt(strval($year));
$encrypted_vehicle_number = encrypt($vehicle_number);
$encrypted_color = encrypt($color);
$encrypted_kms_driven = encrypt(strval($kms_driven));
$encrypted_mileage = encrypt(strval($mileage));
$encrypted_condition = encrypt(strval($condition));
$encrypted_gear_type = encrypt($gear_type);
$encrypted_owners = encrypt(strval($owners));
$encrypted_state = encrypt($state);
$encrypted_fuel_type = encrypt($fuel_type);
$encrypted_price = encrypt(strval($price));
$encrypted_insurance = encrypt($insurance_valid);
$stmt = $conn->prepare("INSERT INTO sell_vehicles (user_id, vehicle_type, make, model, year, vehicle_number, color, kms_driven, mileage, condition_rating, gear_type, owners, state, fuel_type, price, insurance_valid, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssssssssssss", $_SESSION['user_id'], $vehicle_type, $encrypted_make, $encrypted_model, $encrypted_year, $encrypted_vehicle_number, $encrypted_color, $encrypted_kms_driven, $encrypted_mileage, $encrypted_condition, $encrypted_gear_type, $encrypted_owners, $encrypted_state, $encrypted_fuel_type, $encrypted_price, $encrypted_insurance, $unique_filename);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Vehicle listed successfully']);
} else {
    // Delete uploaded file if database insert fails
    unlink($upload_path);
    echo json_encode(['success' => false, 'message' => 'Failed to list vehicle']);
}

$conn->close();
?>