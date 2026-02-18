<?php
session_start();
$page_title = 'Thank You - Tourist Drivers India';
$message = $_SESSION['enquiry_message'] ?? '';
$back_url = $_SESSION['enquiry_back_url'] ?? 'index.php';
// If direct access or invalid request, redirect to home
if (empty($message) || $message === 'Invalid request method.') {
    echo '<h2 style="color:red">No valid message found (empty or Invalid request method).</h2>';
    echo '<pre>_POST: ' . print_r($_POST, true) . '</pre>';
    echo '<pre>_SESSION: ' . print_r($_SESSION, true) . '</pre>';
    echo '<a href="index.php">Back to Home</a>';
    exit;
}
unset($_SESSION['enquiry_message'], $_SESSION['enquiry_back_url']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/main-style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f8faff;">
    <div class="container" style="max-width:600px;margin:60px auto;">
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-5 text-center">
                <h1 class="mb-4" style="color:#1d2b53;font-weight:900;">Thank You!</h1>
                <?php if ($message): ?>
                    <div class="mb-4" style="font-size:1.15em;">
                        <?php echo $message; ?>
                    </div>
                <?php else: ?>
                    <div class="mb-4 text-success" style="font-size:1.15em;">Your enquiry has been received. We will contact you soon!</div>
                <?php endif; ?>
                <a href="<?php echo htmlspecialchars($back_url); ?>" class="btn btn-primary rounded-pill px-4 py-2 mt-3">Back to Package</a>
            </div>
        </div>
    </div>
</body>
</html>
