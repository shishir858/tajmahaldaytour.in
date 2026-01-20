<?php
// Single Package Details page for tajmahaldaytour
include 'includes/config.php';
$slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$page_title = 'Package Details - tajmahaldaytour';
$pkg = $conn->query("SELECT * FROM tour_packages WHERE slug = '$slug' OR id = '$slug' LIMIT 1")->fetch_assoc();
if(!$pkg) { header('Location: '.SITE_URL.'tour-packages'); exit; }
include 'includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?php echo SITE_URL; ?>uploads/packages/<?php echo $pkg['image'] ?? 'default.jpg'; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($pkg['title']); ?>">
            </div>
            <div class="col-md-6 mb-4">
                <h1 style="color:#dc3545; font-family: 'Playfair Display', Georgia, serif;"><?php echo htmlspecialchars($pkg['title']); ?></h1>
                <p><?php echo $pkg['description']; ?></p>
                <a href="<?php echo SITE_URL; ?>contact" class="btn btn-primary btn-lg mt-3">Book Now</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
