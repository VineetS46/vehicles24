<?php
require_once '../../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn    = getDatabaseConnection();
    $user_id = $_SESSION['user_id'];

    // Get form data (make sure your HTML uses these exact names)
    $vehicleType   = $_POST['VehicleType'] ?? '';
    $brand         = $_POST['Brand'] ?? '';
    $model         = $_POST['Model'] ?? '';
    $year          = $_POST['Year'] ?? '';
    $vehicleNumber = $_POST['vehicleNumber'] ?? '';
    $kms           = $_POST['Kms'] ?? '';
    $state         = $_POST['state'] ?? '';
    $fuel          = $_POST['fuel'] ?? '';
    $condition     = $_POST['condition'] ?? '';
    $scrapValue    = $_POST['scrapValue'] ?? '';
    $reason        = $_POST['reason'] ?? '';

    // Handle file upload
    $imageName = "";
    if (!empty($_FILES['image']['name'])) {
        // Generate unique file name
        $imageName  = uniqid() . '_' . time() . '.' .
                      pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Build absolute path to /upload folder
        $uploadPath = __DIR__ . '/../../upload/' . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image is required']);
        exit();
    }

   $sql = "INSERT INTO scrap_vehicles (
            user_id, vehicle_type, brand, model, year, vehicle_number,
            kms_driven, state, fuel_type, vehicle_condition, scrap_value,
            reason, image
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "isssssssssdss",
    $user_id, $vehicleType, $brand, $model, $year, $vehicleNumber,
    $kms, $state, $fuel, $condition, $scrapValue, $reason, $imageName
);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Vehicle scrap request submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error submitting scrap request: ' . $stmt->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
