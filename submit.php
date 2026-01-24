<?php
// Simple booking form submit handler (no AJAX, no modal, no redirects)
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
    $travel_date = isset($_POST['travel_date']) ? trim(strip_tags($_POST['travel_date'])) : '';
    $guests = isset($_POST['guests']) ? trim(strip_tags($_POST['guests'])) : '';
    $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

    // Validate required fields
    if ($name === '' || $phone === '' || $email === '' || $travel_date === '' || $guests === '') {
        echo '<div style="max-width:500px;margin:40px auto;padding:20px;border:1px solid #e74c3c;background:#fff0f0;color:#c0392b;font-family:sans-serif;text-align:center;">Please fill all required fields.<br><a href="javascript:history.back()">Go Back</a></div>';
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
            . "<p><strong>Message:</strong> {$message}</p>"
            . "<p><strong>Date Submitted:</strong> ".date('d-m-Y H:i:s')."</p>";

        $mail->send();
        echo '<div style="max-width:500px;margin:40px auto;padding:20px;border:1px solid #27ae60;background:#f0fff0;color:#27ae60;font-family:sans-serif;text-align:center;">Thank you! Your booking request has been received.<br>We will contact you shortly.<br><a href="/tajmahaldaytour/">Back to Home</a></div>';
    } catch (Exception $e) {
        echo '<div style="max-width:500px;margin:40px auto;padding:20px;border:1px solid #e74c3c;background:#fff0f0;color:#c0392b;font-family:sans-serif;text-align:center;">'
            . 'Mail sending failed: ' . htmlspecialchars($mail->ErrorInfo)
            . '<br>Exception: ' . htmlspecialchars($e->getMessage())
            . '<br><a href="javascript:history.back()">Go Back</a></div>';
    }
    exit;
}
// If not POST, show nothing or redirect as needed (optional)
