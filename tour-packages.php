<?php
// Tour Packages listing page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Tour Packages - tajmahaldaytour';
include 'includes/header.php';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
$where = $category_id ? "WHERE is_active = 1 AND category_id = $category_id" : "WHERE is_active = 1";
$result = $conn->query("SELECT * FROM tour_packages $where ORDER BY display_order");
?>


<!-- Page Header Banner -->
<section class="gallery-header-banner d-flex align-items-center justify-content-center text-center" style="position:relative;min-height:320px;background:linear-gradient(120deg, #000000 0%, #000000 60%, #1a237e 100%);overflow:hidden;">
    <img src="assets/image/banner/4.jpg" alt="Tour Packages Banner" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.18;z-index:1;">
    <div class="container position-relative" style="z-index:2;">
        <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow:0 2px 12px #000a;">Tour Packages</h1>
        <p class="lead text-white mb-0" style="font-size:1.25rem;">Browse our curated selection of tour packages for every kind of traveler.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row" id="packageCardsRow">
            <?php 
            $packages = [];
            while($pkg = $result->fetch_assoc()) {
                $packages[] = $pkg;
            }
            foreach($packages as $i => $pkg): 
            ?>
            <div class="col-lg-3 col-md-6 mb-4 package-card-item" style="<?php echo $i < 12 ? '' : 'display:none;'; ?>">
                <div class="card h-100 shadow-sm border-0 package-attractive-card" style="border-radius:14px;overflow:hidden;background:#fff;display:flex;flex-direction:column;">
                    <div class="card-img-top package-img-wrap" style="overflow:hidden; border-radius:14px 14px 0 0;">
                        <img src="<?php echo SITE_URL . 'uploads/packages/' . (!empty($pkg['featured_image']) ? htmlspecialchars($pkg['featured_image']) : 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($pkg['title']); ?>" style="width:100%;height:210px;object-fit:cover;transition:transform .3s;">
                    </div>
                    <div class="card-body d-flex flex-column" style="padding:1.25rem 1rem 1.1rem 1rem;">
                        <div class="d-flex align-items-center mb-2" style="color:#888;font-size:1rem;gap:18px;">
                            <span><i class="far fa-calendar"></i> <?php echo $pkg['duration_days']; ?> Nights / <?php echo $pkg['duration_nights']; ?> Days</span>
                            <span><i class="fas fa-users"></i> 4 Persons</span>
                        </div>
                        <h5 class="card-title mb-1" style="font-family: 'Playfair Display', Georgia, serif; color:#1a237e; font-weight:700; letter-spacing:0.5px; min-height:32px; font-size:1.18rem;">
                            <?php echo htmlspecialchars($pkg['title']); ?>
                        </h5>
                        <div class="mb-2" style="color:#555;font-size:1.01rem;min-height:22px;">
                            <?php echo htmlspecialchars(substr($pkg['description'],0,38)); ?>...
                        </div>
                        <div class="d-flex gap-2 mt-auto">
                            <a href="tel:+919876543210" class="btn btn-dark w-50" style="font-weight:600;letter-spacing:0.5px;background:#1a237e;color:#fff;">Call Now &rarr;</a>
                            <a href="package.php?<?php echo $pkg['slug'] ? 'slug=' . urlencode($pkg['slug']) : 'id=' . $pkg['id']; ?>" class="btn btn-warning w-50" style="font-weight:600;letter-spacing:0.5px;background:linear-gradient(90deg,#ffc722 60%,#ff9800 100%);color:#222;">Book Now &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <button id="loadMoreBtn" class="btn btn-outline-primary px-4 py-2" style="font-weight:600;display:<?php echo count($packages) > 12 ? 'inline-block' : 'none'; ?>;">Load More</button>
            <button id="showLessBtn" class="btn btn-outline-secondary px-4 py-2 ms-2" style="font-weight:600;display:none;">Show Less</button>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
