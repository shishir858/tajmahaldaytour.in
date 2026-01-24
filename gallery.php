
<?php
// Gallery page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Gallery - tajmahaldaytour';
include 'includes/header.php';
?>

<!-- Header Banner -->
<section class="gallery-header-banner d-flex align-items-center justify-content-center text-center" style="position:relative;min-height:320px;background:linear-gradient(120deg, #000000 0%, #000000 60%, #1a237e 100%);overflow:hidden;">
    <img src="assets/image/banner/4.jpg" alt="Gallery Banner" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.18;z-index:1;">
    <div class="container position-relative" style="z-index:2;">
        <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow:0 2px 12px #000a;">Gallery</h1>
        <p class="lead text-white mb-0" style="font-size:1.25rem;">Explore our travel moments, destinations, and happy customers.</p>
    </div>
</section>

<!-- Main Gallery Section -->
<section id="gallery-main" class="section" style="background:#fffbe7; padding-top:48px; padding-bottom:48px;">
    <div class="container">
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM gallery_new WHERE is_active = 1 ORDER BY display_order");
            while($img = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card-3d" style="overflow:hidden;box-shadow:0 8px 32px rgba(44,62,80,0.12);border-radius:18px;">
                    <img src="<?php echo htmlspecialchars($img['image_url'] ?? 'uploads/gallery/default.jpg'); ?>" class="card-img-top" alt="Gallery Image" style="border-radius:18px;object-fit:cover;height:180px;width:100%;transition:transform 0.3s;">
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
