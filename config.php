<?php
session_start();

function getDatabaseConnection() {
    $host     = 'mysql';                 // MySQL container service name
    $username = 'vehicles24_user';  
    $password = 'vehicles24_pass';
    $database = 'vehicles24';
    // $host     = 'localhost';       
    // $username = 'root';            
    // $password = '';                
    // $database = 'vehicle';      

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    return $conn;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit();
    }
}


function encrypt($data) {
    if (empty($data)) return $data;

    $key = 'Vehicle24SecretKey2024';        // Simplified for your project
    $iv  = substr(hash('sha256', $key), 0, 16);

    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($encrypted);
}

function decrypt($data) {
    if (empty($data)) return $data;

    $key = 'Vehicle24SecretKey2024';
    $iv  = substr(hash('sha256', $key), 0, 16);

    $decoded = base64_decode($data);
    $decrypted = openssl_decrypt($decoded, 'AES-256-CBC', $key, 0, $iv);

    return $decrypted !== false ? $decrypted : $data;
}
?>
