<?php
// Main Configuration File
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Detect environment (CLI defaults to local)
$is_local = true; // Default to local
if (isset($_SERVER['HTTP_HOST'])) {
    $is_local = (
        $_SERVER['HTTP_HOST'] === 'localhost' || 
        $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
        strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
    );
}

// Database Configuration
if ($is_local) {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "sspsof5_tajmahal";
    define('SITE_URL', 'http://localhost/tajmahaldaytour/');
} else {
    $db_host = "localhost";
    $db_user = "u507341251_tajmahal";
    $db_pass = "Ak0OPED80o3c";
    $db_name = "u507341251_tajmahal";
    define('SITE_URL', 'https://tajmahaldaytour.in/');
}

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Helper function to get settings
function getSetting($key) {
    global $conn;
    $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    return null;
}

// SMTP Configuration
// SMTP Configuration
define('SMTP_HOST', 'vps136692.inmotionhosting.com');
define('SMTP_USER', 'contact@tajmahaldaytour.in');
define('SMTP_PASS', 'TxWFzKR5K8x0');
define('SMTP_PORT', 465);
define('SMTP_FROM_EMAIL', 'contact@tajmahaldaytour.in');
define('SMTP_FROM_NAME', 'Tajmahal Day Tour');
define('SMTP_ADMIN_EMAIL', 'enquiry.tajmahaltour@gmail.com');
?>
