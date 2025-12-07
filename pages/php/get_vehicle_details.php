<?php
require_once '../../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$vehicle_id = intval($_GET['id']);

if (!$vehicle_id) {
    echo json_encode(['error' => 'Invalid vehicle ID']);
    exit();
}

$conn = getDatabaseConnection();

$sql = "SELECT sv.*, u.username as seller_username, u.email as seller_email, u.fullname as seller_fullname, u.phonenumber as seller_phone 
        FROM sell_vehicles sv 
        JOIN tb_user u ON sv.user_id = u.id 
        WHERE sv.vehicle_id = ? AND sv.status = 'available'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Vehicle not found']);
    exit();
}

$vehicle = $result->fetch_assoc();

// Decrypt seller contact details
$vehicle['seller_email'] = decrypt($vehicle['seller_email']);
$vehicle['seller_fullname'] = decrypt($vehicle['seller_fullname']);
$vehicle['seller_phone'] = decrypt($vehicle['seller_phone']);

// Get seller statistics
$seller_id = $vehicle['user_id'];
$stats_sql = "SELECT 
    COUNT(*) as total_vehicles,
    SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_vehicles
    FROM sell_vehicles WHERE user_id = ?";
$stats_stmt = $conn->prepare($stats_sql);
$stats_stmt->bind_param("i", $seller_id);
$stats_stmt->execute();
$stats_result = $stats_stmt->get_result();
$seller_stats = $stats_result->fetch_assoc();

$vehicle['seller_total_vehicles'] = $seller_stats['total_vehicles'];
$vehicle['seller_sold_vehicles'] = $seller_stats['sold_vehicles'];
$vehicle['seller_rating'] = min(5.0, 3.5 + ($seller_stats['sold_vehicles'] * 0.1)); // Dynamic rating based on sales

// Decrypt all encrypted fields
$vehicle['make'] = decrypt($vehicle['make']);
$vehicle['model'] = decrypt($vehicle['model']);
$vehicle['state'] = decrypt($vehicle['state']);
$vehicle['fuel_type'] = decrypt($vehicle['fuel_type']);
$vehicle['year'] = intval(decrypt($vehicle['year']));
$vehicle['mileage'] = floatval(decrypt($vehicle['mileage']));
$vehicle['price'] = floatval(decrypt($vehicle['price']));
$vehicle['vehicle_number'] = decrypt($vehicle['vehicle_number']);
$vehicle['color'] = decrypt($vehicle['color']);
$vehicle['kms_driven'] = intval(decrypt($vehicle['kms_driven']));
$vehicle['condition_rating'] = intval(decrypt($vehicle['condition_rating']));
$vehicle['gear_type'] = decrypt($vehicle['gear_type']);
$vehicle['owners'] = intval(decrypt($vehicle['owners']));
$vehicle['insurance_valid'] = decrypt($vehicle['insurance_valid']);

$conn->close();
echo json_encode($vehicle);
?>