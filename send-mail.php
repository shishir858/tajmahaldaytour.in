<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/includes/config.php';

function sendEnquiryEmail($data) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress(SMTP_ADMIN_EMAIL);
        if (!empty($data['email'])) {
            $mail->addReplyTo($data['email'], $data['name']);
        }

        $mail->isHTML(true);
        $mail->Subject = 'New Tour Enquiry: ' . ($data['package_title'] ?? 'General Enquiry');
        $mail->Body = '<h2>New Tour Enquiry</h2>' .
            '<b>Name:</b> ' . htmlspecialchars($data['name']) . '<br>' .
            '<b>Phone:</b> ' . htmlspecialchars($data['phone']) . '<br>' .
            (!empty($data['email']) ? ('<b>Email:</b> ' . htmlspecialchars($data['email']) . '<br>') : '') .
            '<b>Package:</b> ' . htmlspecialchars($data['package_title']) . '<br>' .
            '<b>Travel Date:</b> ' . htmlspecialchars($data['travel_date']) . '<br>' .
            '<b>Guests:</b> ' . htmlspecialchars($data['people']) . '<br>' .
            (!empty($data['message']) ? ('<b>Message:</b> ' . nl2br(htmlspecialchars($data['message'])) . '<br>') : '') .
            '<b>Reference:</b> ' . htmlspecialchars($data['booking_number']);

        $mail->AltBody =
            'Name: ' . $data['name'] . "\n" .
            'Phone: ' . $data['phone'] . "\n" .
            (!empty($data['email']) ? ('Email: ' . $data['email'] . "\n") : '') .
            'Package: ' . $data['package_title'] . "\n" .
            'Travel Date: ' . $data['travel_date'] . "\n" .
            'Guests: ' . $data['people'] . "\n" .
            (!empty($data['message']) ? ('Message: ' . $data['message'] . "\n") : '') .
            'Reference: ' . $data['booking_number'];

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
