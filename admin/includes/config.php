<?php
// Database Configuration
// Auto-detect local vs live environment

$is_local = (
    $_SERVER['HTTP_HOST'] === 'localhost' || 
    $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
    strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
);

if ($is_local) {
    // Local Development Settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sspsof5_tajmahal"; // NEW DATABASE
    define('BASE_URL', '/admin/');
    define('SITE_URL', 'http://localhost/tajmahaldaytour/');
} else {
    // Live Server Settings
    $servername = "localhost";
    $username = "u507341251_tajmahal";
    $password = "Ak0OPED80o3c";
    $database = "u507341251_tajmahal";
    define('BASE_URL', 'https://tajmahaldaytour.in/admin/');
    define('SITE_URL', 'https://tajmahaldaytour.in/');
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Set charset to utf8mb4 for emoji and special characters support
mysqli_set_charset($conn, "utf8mb4");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Error reporting based on environment
if ($is_local) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1); // TEMPORARY: Show errors on live for debugging
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../error_log.txt');
}

// Timezone setting
date_default_timezone_set('Asia/Kolkata');

// Define upload paths
define('UPLOAD_PATH', __DIR__ . '/../../uploads/');
define('UPLOAD_URL', SITE_URL . 'uploads/');

// Create upload directories if they don't exist
$upload_dirs = [
    UPLOAD_PATH . 'packages',
    UPLOAD_PATH . 'destinations',
    UPLOAD_PATH . 'gallery',
    UPLOAD_PATH . 'vehicles'
];

foreach ($upload_dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', $is_local ? 0 : 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
