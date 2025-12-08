<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: pages/buy.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = trim($_POST['username']); // User enters either Username or Email here
    $password = $_POST['password'];
    
    if (empty($input) || empty($password)) {
        $error = 'Username/Email and password are required';
    } else {
        $conn = getDatabaseConnection();
        
        // Check if the input matches EITHER the username OR the email column
        $stmt = $conn->prepare("SELECT id, password FROM tb_user WHERE username = ? OR email = ?");
        
        // We bind "$input" to BOTH question marks (?) because we don't know if they typed a name or email
        $stmt->bind_param("ss", $input, $input);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: pages/buy.php');
                exit();
            } else {
                $error = 'Invalid credentials (Password incorrect)';
            }
        } else {
            $error = 'Invalid credentials (User not found)';
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - vehicles24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0">Welcome Back</h3>
                        <p class="mb-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Sign in to your vehicles24 account</p>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username or Email</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="text-center mt-4">
                            <p class="mb-0">Don't have an account? <a href="registration.php" class="text-decoration-none fw-semibold">Register here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>