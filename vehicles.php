<?php
// Vehicles page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Our Vehicles - tajmahaldaytour';
include 'includes/header.php';
?>

<!-- Header Banner -->
<section class="vehicles-header-banner d-flex align-items-center justify-content-center text-center" style="position:relative;min-height:320px;background:linear-gradient(120deg, #000000 0%, #000000 60%, #1a237e 100%);overflow:hidden;">
    <img src="assets/image/banner/4.jpg" alt="Vehicles Banner" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.18;z-index:1;">
    <div class="container position-relative" style="z-index:2;">
        <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow:0 2px 12px #000a;">Our Vehicles</h1>
        <p class="lead text-white mb-0" style="font-size:1.25rem;">Choose from our fleet of modern, comfortable vehicles for your journey.</p>
    </div>
</section>

<!-- Main Vehicles Section -->
<section id="vehicles-main" class="section" style="background:#fffbe7; padding-top:48px; padding-bottom:48px;">
    <div class="container">
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM vehicles_new WHERE is_active = 1");
            while($v = $result->fetch_assoc()):
                $img = !empty($v['image']) ? 'uploads/vehicles/' . $v['image'] : 'uploads/vehicles/default.jpg';
                $name = htmlspecialchars($v['name'] ?? '');
                $type = htmlspecialchars($v['type'] ?? '');
                $capacity = intval($v['capacity'] ?? 0);
                $price_per_km = isset($v['price_per_km']) ? number_format($v['price_per_km'], 2) : '';
                $price_per_day = isset($v['price_per_day']) ? number_format($v['price_per_day'], 0) : '';
                $desc = isset($v['description']) ? substr(strip_tags($v['description']),0,100) . '...' : '';
            ?>
            <div class="col-lg-3 col-md-4 col-6 mb-4 d-flex align-items-stretch">
                <div class="card-3d vehicle-card glass-card position-relative w-100" style="border-radius:24px;overflow:hidden;box-shadow:0 12px 36px rgba(44,62,80,0.18);background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);transition:transform 0.2s,box-shadow 0.2s;display:flex;flex-direction:column;">
                    <div style="position:relative;">
                        <img src="<?php echo SITE_URL . $img; ?>" class="card-img-top" alt="<?php echo $name; ?>" style="border-radius:24px 24px 0 0;object-fit:cover;height:180px;width:100%;filter:brightness(0.97);">
                        <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:linear-gradient(120deg,rgba(40,167,69,0.10) 0%,rgba(26,35,126,0.10) 100%);border-radius:24px 24px 0 0;"></div>
                        <span style="position:absolute;top:14px;right:14px;background:linear-gradient(90deg,#28a745 60%,#1a237e 100%);color:#fff;padding:6px 16px;border-radius:16px;font-weight:700;font-size:1rem;box-shadow:0 2px 12px rgba(44,62,80,0.14);letter-spacing:0.5px;">₹<?php echo $price_per_day; ?>/day</span>
                        <span style="position:absolute;top:14px;left:14px;background:rgba(255,255,255,0.85);color:#1a237e;padding:6px 12px;border-radius:16px;font-weight:600;font-size:0.98rem;box-shadow:0 2px 8px rgba(44,62,80,0.10);display:flex;align-items:center;"><i class="fas fa-car-side me-2"></i><?php echo $type; ?></span>
                    </div>
                    <div class="card-body vehicle-card-body" style="background:linear-gradient(120deg,#f8fafc 0%,#e3f9e5 100%);border-radius:0 0 24px 24px;flex:1 1 auto;display:flex;flex-direction:column;box-shadow:0 2px 12px rgba(44,62,80,0.08);border-top:1px solid #e0e0e0;padding:1.25rem 1rem;">
                        <h5 class="card-title mb-2" style="font-family: 'Playfair Display', Georgia, serif; color:#1a237e;font-size:1.18rem;font-weight:700;letter-spacing:0.5px;"> <?php echo $name; ?> </h5>
                        <div class="mb-2 d-flex flex-wrap gap-2">
                            <span class="badge bg-warning text-dark d-flex align-items-center" style="font-size:0.98rem;padding:7px 14px;border-radius:14px;"><i class="fas fa-users me-1"></i>Seats: <?php echo $capacity; ?></span>
                            <span class="badge bg-success d-flex align-items-center" style="font-size:0.98rem;padding:7px 14px;border-radius:14px;"><i class="fas fa-rupee-sign me-1"></i><?php echo $price_per_km; ?>/km</span>
                        </div>
                        <p class="card-text mb-3" style="min-height:44px;color:#333;font-size:1.02rem;line-height:1.6;"> <?php echo $desc; ?> </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-gradient w-100" style="border-radius:12px;font-weight:700;font-size:1rem;padding:10px 0;letter-spacing:0.5px;box-shadow:0 2px 8px rgba(44,62,80,0.10);">View Details <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<style>
.glass-card {
    background:rgba(255,255,255,0.18);
    backdrop-filter:blur(8px);
    border:1px solid rgba(44,62,80,0.08);
}
.vehicle-card:hover {
    transform: translateY(-8px) scale(1.04);
    box-shadow:0 28px 64px rgba(44,62,80,0.28);
}
.vehicle-card .card-img-top {
    transition:filter 0.3s;
}
.vehicle-card:hover .card-img-top {
    filter:brightness(1.10) saturate(1.15);
}
.btn-gradient {
    background:linear-gradient(90deg,#28a745 0%,#1a237e 100%);
    color:#fff;
    border:none;
    transition:background 0.3s,box-shadow 0.3s;
    box-shadow:0 2px 8px rgba(44,62,80,0.10);
}
.btn-gradient:hover {
    background:linear-gradient(90deg,#1a237e 0%,#28a745 100%);
    color:#fff;
    box-shadow:0 4px 16px rgba(44,62,80,0.18);
}
</style>
<style>
.vehicle-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow:0 20px 48px rgba(44,62,80,0.22);
}
.vehicle-card .card-img-top {
    transition:filter 0.3s;
}
.vehicle-card:hover .card-img-top {
    filter:brightness(1.08) saturate(1.1);
}
</style>
<style>
.vehicle-card-body {
    background:linear-gradient(120deg,#f8fafc 0%,#e3f9e5 100%);
    border-radius:0 0 24px 24px;
    box-shadow:0 2px 12px rgba(44,62,80,0.08);
    border-top:1px solid #e0e0e0;
    padding:1.25rem 1rem;
}
.vehicle-card-body .card-title {
    font-size:1.18rem;
    font-weight:700;
    color:#1a237e;
    margin-bottom:0.5rem;
}
.vehicle-card-body .badge {
    font-size:0.98rem;
    padding:7px 14px;
    border-radius:14px;
    box-shadow:0 1px 4px rgba(44,62,80,0.08);
}
.vehicle-card-body .card-text {
    color:#333;
    font-size:1.02rem;
    line-height:1.6;
    margin-bottom:1rem;
}
</style>
