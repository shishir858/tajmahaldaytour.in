<?php
// 404 Not Found page for tajmahaldaytour
http_response_code(404);
$page_title = '404 Not Found - tajmahaldaytour';
include 'includes/header.php';
?>

<section class="py-5 text-center">
    <div class="container">
        <h1 class="display-3 mb-4" style="color:#dc3545; font-family: 'Playfair Display', Georgia, serif;">404</h1>
        <h2 class="mb-3">Page Not Found</h2>
        <p class="mb-4">Sorry, the page you are looking for does not exist or has been moved.</p>
        <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Go to Home</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
