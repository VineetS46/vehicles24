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

$input = json_decode(file_get_contents('php://input'), true);
$vehicle_id = intval($input['vehicle_id']);
$buyer_id = $_SESSION['user_id'];

if (!$vehicle_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid vehicle ID']);
    exit();
}

$conn = getDatabaseConnection();

// Check if vehicle exists and is available
$check_sql = "SELECT user_id FROM sell_vehicles WHERE vehicle_id = ? AND status = 'available'";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $vehicle_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Vehicle not available']);
    exit();
}

$vehicle = $check_result->fetch_assoc();

// Check if buyer is not the seller
if ($vehicle['user_id'] == $buyer_id) {
    echo json_encode(['success' => false, 'message' => 'You cannot buy your own vehicle']);
    exit();
}

// Update vehicle status to sold
$update_sql = "UPDATE sell_vehicles SET status = 'sold', buyer_id = ?, sold_on = NOW() WHERE vehicle_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("ii", $buyer_id, $vehicle_id);

if ($update_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Vehicle purchased successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error purchasing vehicle']);
}

$conn->close();
?>