// Debug: Log POST data for troubleshooting
file_put_contents(__DIR__ . '/debug_submit_package.log', date('Y-m-d H:i:s') . ' POST: ' . print_r($_POST, true) . "\n", FILE_APPEND);
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php';

session_start();
$name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
$email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
$phone = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
$travel_date = isset($_POST['travel_date']) ? trim(strip_tags($_POST['travel_date'])) : '';
$guests = isset($_POST['guests']) ? trim(strip_tags($_POST['guests'])) : '';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';
$package_id = isset($_POST['package_id']) ? trim(strip_tags($_POST['package_id'])) : '';
$package_title = isset($_POST['package_title']) ? trim(strip_tags($_POST['package_title'])) : '';

// Always redirect back to package page
$redirect_url = '/package.php';
if (!empty($package_title)) {
    // Try to use slug if available (from hidden input, or you can add a hidden slug field in the form)
    if (!empty($_POST['package_slug'])) {
        $redirect_url .= '?slug=' . urlencode($_POST['package_slug']);
    } elseif (!empty($package_id)) {
        $redirect_url .= '?id=' . urlencode($package_id);
    }
} elseif (!empty($package_id)) {
    $redirect_url .= '?id=' . urlencode($package_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if ($name === '' || $phone === '' || $email === '' || $travel_date === '' || $guests === '') {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = 'Please fill all required fields.';
        header('Location: ' . $redirect_url);
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'vps136692.inmotionhosting.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@abdholispunjabidholwala.online';
        $mail->Password   = 'FVpvlgs1ZAvz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('contact@abdholispunjabidholwala.online', 'Website Booking');
        $mail->addAddress('shishir4.ssp@gmail.com', 'Abdholispunjab');
        $mail->addAddress('sandypanwar9507@gmail.com', 'Sandy Panwar');

        $mail->isHTML(true);
        $mail->Subject = 'New Tour Booking Request';
        $mail->Body = "<h2>New Tour Booking Request</h2>"
            . "<p><strong>Name:</strong> {$name}</p>"
            . "<p><strong>Email:</strong> {$email}</p>"
            . "<p><strong>Phone:</strong> {$phone}</p>"
            . "<p><strong>Travel Date:</strong> {$travel_date}</p>"
            . "<p><strong>Guests:</strong> {$guests}</p>"
            . "<p><strong>Package:</strong> {$package_title} (ID: {$package_id})</p>"
            . "<p><strong>Message:</strong> {$message}</p>"
            . "<p><strong>Date Submitted:</strong> ".date('d-m-Y H:i:s')."</p>";

        $mail->send();
        $_SESSION['form_status'] = 'success';
        $_SESSION['form_message'] = 'Thank you! Your booking request has been received. We will contact you shortly.';
    } catch (Exception $e) {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = 'Mail sending failed: ' . $mail->ErrorInfo;
    }
    header('Location: ' . $redirect_url);
    exit;
}

// For any GET or direct access, always redirect to package page
header('Location: ' . $redirect_url);
exit;
