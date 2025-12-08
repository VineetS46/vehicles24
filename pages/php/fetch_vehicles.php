<?php
require_once '../../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$conn = getDatabaseConnection();

$sql = "SELECT sv.*, u.username as seller_username 
        FROM sell_vehicles sv 
        JOIN tb_user u ON sv.user_id = u.id 
        WHERE sv.status = 'available' 
        ORDER BY sv.listed_on DESC";

$result = $conn->query($sql);
$vehicles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['make'] = decrypt($row['make']);
        $row['model'] = decrypt($row['model']);
        $row['state'] = decrypt($row['state']);
        $row['fuel_type'] = decrypt($row['fuel_type']);
        $row['year'] = intval(decrypt($row['year']));
        // $row['mileage'] = floatval(decrypt($row['mileage']));
        $row['price'] = floatval(decrypt($row['price']));
        $row['vehicle_number'] = decrypt($row['vehicle_number']);
        $row['color'] = decrypt($row['color']);
        $row['kms_driven'] = intval(decrypt($row['kms_driven']));
        $row['condition_rating'] = intval(decrypt($row['condition_rating']));
        $row['gear_type'] = decrypt($row['gear_type']);
        $row['owners'] = intval(decrypt($row['owners']));
        $row['insurance_valid'] = decrypt($row['insurance_valid']);
        $vehicles[] = $row;
    }
}

$conn->close();
echo json_encode($vehicles);
?>