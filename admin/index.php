<?php
require_once 'includes/config.php';

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM admin_users WHERE username = '$username' AND is_active = 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verify password
        if(password_verify($password, $admin['password'])) {
            // Set session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'] ?: $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];
            
            // Update last login
            mysqli_query($conn, "UPDATE admin_users SET last_login = NOW() WHERE id = {$admin['id']}");
            
            header('Location: ' . BASE_URL . 'dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - tajmahaldaytour</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #ffc722;
            --secondary-color: #000000;
            --accent-red: #dc3545;
            --accent-green: #28a745;
            --accent-white: #fff;
        }
        
        body {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), #dc3545);
            padding: 40px 30px;
            text-align: center;
            color: #000;
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        .login-header i {
            font-size: 50px;
            margin-bottom: 15px;
        }
        
        .login-header h1 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #000;
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 15px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.15);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), #28a745);
            color: #000;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            border: none;
            width: 100%;
            font-size: 16px;
            font-family: 'Playfair Display', Georgia, serif;
            transition: transform 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: #fff;
            background: linear-gradient(135deg, #dc3545, #28a745);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="assets/image/logo.png" alt="tajmahaldaytour Logo" style="height:54px;width:auto;object-fit:contain;margin-bottom:10px;">
                <!-- <h1>tajmahaldaytour</h1> -->
                <p>Admin Panel Login</p>
            </div>
            
            <div class="login-body">
                <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
            
            <div class="login-footer">
                &copy; <?php echo date('Y'); ?> tajmahaldaytour. All rights reserved.
            </div>
        </div>
        
        <div class="text-center mt-3">
            <small class="text-white">
                Default: <strong>admin</strong> / <strong>admin123</strong>
            </small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
