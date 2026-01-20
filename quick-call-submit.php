<?php
// quick-call-submit.php
include 'includes/config.php';

// Set admin email (from config or fallback)
$admin_email = defined('SMTP_ADMIN_EMAIL') ? SMTP_ADMIN_EMAIL : 'info@tajmahaldaytour.com';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $phone === '') {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $subject = "Quick Call Request from $name";
    $message = "You have received a new quick call request.\n\nName: $name\nPhone: $phone\nTime: ".date('Y-m-d H:i:s');
    $headers = "From: $admin_email\r\nReply-To: $admin_email\r\nContent-Type: text/plain; charset=UTF-8";

    if (mail($admin_email, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Thank you! We will call you soon.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
