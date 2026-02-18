<?php
require_once 'includes/config.php';

$vehicle = null;
$vehicle_id = 0;
$vehicle_slug = '';

if (isset($_GET['slug'])) {
    $vehicle_slug = trim((string)$_GET['slug']);
}

if ($vehicle_slug !== '') {
    $stmt = $conn->prepare("SELECT * FROM vehicles_new WHERE slug = ? AND is_active = 1 LIMIT 1");
    $stmt->bind_param('s', $vehicle_slug);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();
    }
}

if (isset($_GET['id'])) {
    $vehicle_id = intval($_GET['id']);
}

if (!$vehicle && $vehicle_id <= 0 && $vehicle_slug !== '' && ctype_digit($vehicle_slug)) {
    $vehicle_id = intval($vehicle_slug);
}

if (!$vehicle && $vehicle_id <= 0) {
    header('Location: ' . SITE_URL . 'vehicles');
    exit;
}

if (!$vehicle) {
    $stmt = $conn->prepare("SELECT * FROM vehicles_new WHERE id = ? AND is_active = 1 LIMIT 1");
    $stmt->bind_param('i', $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();
    }
}

if (!$vehicle) {
    http_response_code(404);
    $page_title = 'Vehicle Not Found - Tourist Drivers India';
    include 'includes/header.php';
    ?>
    <section class="py-5" style="background:#f8f9fa;min-height:60vh;display:flex;align-items:center;">
        <div class="container text-center">
            <h1 style="font-weight:800;">Vehicle Not Found</h1>
            <p class="text-muted">The vehicle you are looking for is not available.</p>
            <a href="<?php echo SITE_URL; ?>vehicles" class="btn btn-primary px-4">Back to Vehicles</a>
        </div>
    </section>
    <?php
    include 'includes/footer.php';
    exit;
}

$page_title = !empty($vehicle['meta_title']) ? $vehicle['meta_title'] : ($vehicle['name'] . ' - Vehicle Details');
$meta_description = !empty($vehicle['meta_description'])
    ? $vehicle['meta_description']
    : substr(strip_tags($vehicle['description'] ?? ''), 0, 160);
$canonical_slug = !empty($vehicle['slug']) ? $vehicle['slug'] : ('vehicle-' . (int)$vehicle['id']);
$canonical_url = SITE_URL . 'vehicle/' . rawurlencode($canonical_slug);
$image = !empty($vehicle['image']) ? SITE_URL . 'uploads/vehicles/' . $vehicle['image'] : SITE_URL . 'uploads/vehicles/default.jpg';
$features = [];
$vehicle_booking_title = 'Vehicle Booking - ' . $vehicle['name'];

if (!empty($vehicle['features'])) {
    $features = array_filter(array_map('trim', explode(',', $vehicle['features'])));
}

include 'includes/header.php';
?>

<style>
    .vehicle-detail-hero {
        height: 230px;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: flex-end;
    }
    .vehicle-detail-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.60) 50%, rgba(0,0,0,0.40) 100%);
        z-index: 1;
    }
    .vehicle-detail-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(1, 7, 83, 0.25);
        z-index: 1;
    }
    .vehicle-hero-content {
        position: relative;
        z-index: 2;
        color: white;
        padding: 50px 0;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }
    .vehicle-details-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    .vehicle-sidebar {
        position: sticky;
        top: 100px;
    }
    .vehicle-detail-card,
    .booking-card,
    .book-tour-form-card,
    .sidebar-widget {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .vehicle-detail-card {
        padding: 35px;
    }
    .vehicle-main-image {
        width: 100%;
        height: 420px;
        object-fit: cover;
        border-radius: 14px;
        margin-bottom: 22px;
    }
    .vehicle-meta-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .vehicle-meta-list li {
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }
    .vehicle-meta-list li:last-child {
        border-bottom: none;
    }
    .vehicle-meta-list li span {
        color: #666;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .vehicle-meta-list li span i {
        color: #010753;
    }
    .vehicle-meta-list li strong {
        color: #222;
    }
    .vehicle-features-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .vehicle-features-list li {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 10px 12px;
    }
    .vehicle-features-list li i {
        color: #28a745;
        margin-right: 8px;
    }
    .booking-price {
        font-size: 2.2rem;
        font-weight: 800;
        color: #010753;
        margin-bottom: 25px;
        text-align: center;
    }
    .booking-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #010753 0%, #F7931E 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        margin-top: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px #ffc722;
    }
    .booking-btn:hover {
        transform: translateY(-2px);
        color: #fff;
        box-shadow: 0 6px 25px #ffc722;
    }
    .booking-btn.btn-outline {
        background: #fff;
        color: #010753;
        border: 2px solid #010753;
        box-shadow: none;
    }
    .booking-btn.btn-outline:hover {
        background: #010753;
        color: #fff;
    }
    .book-tour-form-card .form-control:focus {
        border-color: #010753;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
    }
    .btn-book-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(255, 107, 53, 0.5);
    }
    .sidebar-widget {
        padding: 25px;
    }
    .widget-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 14px;
        color: #333;
    }
    @media (max-width: 767px) {
        .vehicle-detail-hero {
            height: 360px;
        }
        .vehicle-main-image {
            height: 260px;
        }
        .vehicle-features-list {
            grid-template-columns: 1fr;
        }
        .vehicle-detail-card {
            padding: 22px;
        }
    }
</style>

<section class="vehicle-detail-hero" style="background-image: url('<?php echo $image; ?>');">
    <div class="container">
        <div class="vehicle-hero-content">
            <span style="background:#010753;padding:8px 18px;border-radius:50px;font-weight:600;display:inline-block;margin-bottom:14px;">
                <?php echo htmlspecialchars($vehicle['type'] ?: 'Vehicle'); ?>
            </span>
            <h1 style="font-weight:800;margin-bottom:10px;"><?php echo htmlspecialchars($vehicle['name']); ?></h1>
            <p class="mb-0">Premium comfort, trusted driver service, and reliable travel support.</p>
        </div>
    </div>
</section>

<section class="vehicle-details-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="vehicle-detail-card">
                    <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($vehicle['name']); ?>" class="vehicle-main-image">
                    <h2 style="font-weight:800;color:#222;margin-bottom:15px;"><?php echo htmlspecialchars($vehicle['name']); ?> Overview</h2>

                    <?php if (!empty($vehicle['description'])): ?>
                        <p style="color:#555;line-height:1.9;margin-bottom:20px;"><?php echo nl2br(htmlspecialchars($vehicle['description'])); ?></p>
                    <?php else: ?>
                        <p style="color:#555;line-height:1.9;margin-bottom:20px;">This vehicle is ideal for city rides, outstation trips, and family tours with comfortable seating and trusted service.</p>
                    <?php endif; ?>

                    <h4 style="font-weight:700;color:#222;margin-bottom:12px;">Vehicle Information</h4>
                    <ul class="vehicle-meta-list mb-4">
                        <li>
                            <span><i class="fas fa-car"></i> Vehicle Type</span>
                            <strong><?php echo htmlspecialchars($vehicle['type'] ?: 'N/A'); ?></strong>
                        </li>
                        <li>
                            <span><i class="fas fa-users"></i> Seating Capacity</span>
                            <strong><?php echo intval($vehicle['capacity']); ?> Seats</strong>
                        </li>
                        <li>
                            <span><i class="fas fa-rupee-sign"></i> Price per KM</span>
                            <strong>₹<?php echo number_format((float)$vehicle['price_per_km'], 2); ?></strong>
                        </li>
                        <li>
                            <span><i class="fas fa-calendar-day"></i> Price per Day</span>
                            <strong>₹<?php echo number_format((float)$vehicle['price_per_day'], 0); ?></strong>
                        </li>
                    </ul>

                    <?php if (!empty($features)): ?>
                        <h4 style="font-weight:700;color:#222;" class="mt-4">Features</h4>
                        <ul class="vehicle-features-list mt-3">
                            <?php foreach ($features as $feature): ?>
                                <li><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Book This Tour Form -->
                <div class="card shadow-lg rounded-4 mt-5 border-0 bg-white" style="">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center fw-bold" style="color:#010753;"><i class="fas fa-paper-plane me-2"></i> Book This Tour</h3>
                        <p class="text-center text-muted mb-4">Fill in your details and we'll get back to you shortly</p>
                        <?php if (!empty($_SESSION['enquiry_message'])): ?>
                            <div class="mb-4">
                                <?php echo $_SESSION['enquiry_message']; unset($_SESSION['enquiry_message']); ?>
                            </div>
                        <?php endif; ?>
                        <form class="needs-validation" method="POST" action="<?php echo (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? '/tajmahaldaytour/submit-package.php' : '/submit-package.php'); ?>">
                            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                            <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="bookName" class="form-label fw-semibold">Full Name *</label>
                                    <input type="text" class="form-control" id="bookName" name="name" required placeholder="Enter your full name">
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bookEmail" class="form-label fw-semibold">Email Address *</label>
                                    <input type="email" class="form-control" id="bookEmail" name="email" required placeholder="your@email.com">
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bookPhone" class="form-label fw-semibold">Phone Number *</label>
                                    <input type="tel" class="form-control" id="bookPhone" name="phone" required placeholder="+91 98765 43210">
                                    <div class="invalid-feedback">Please enter your phone number.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bookDate" class="form-label fw-semibold">Travel Date *</label>
                                    <input type="date" class="form-control" id="bookDate" name="travel_date" required min="<?php echo date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">Please select a travel date.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bookGuests" class="form-label fw-semibold">Guests *</label>
                                    <input type="number" class="form-control" id="bookGuests" name="people" required min="1" value="2">
                                    <div class="invalid-feedback">Please enter number of guests.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bookMessage" class="form-label fw-semibold">Special Requirements</label>
                                    <textarea class="form-control" id="bookMessage" name="message" rows="2" placeholder="Any special requirements or questions..."></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 fw-bold rounded-pill"><i class="fas fa-check-circle me-2"></i> Submit Booking Request</button>
                        </form>
                        <p class="text-center mt-3 text-muted small"><i class="fas fa-lock"></i> Your information is safe and secure</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="vehicle-sidebar">
                    <div class="booking-card p-4 mb-4">
                        <div class="booking-price">
                            ₹<?php echo number_format((float)$vehicle['price_per_day'], 0); ?>
                            <small style="font-size: 1rem; color: #666; font-weight: 400;">/day</small>
                        </div>

                        <ul class="vehicle-meta-list">
                            <li>
                                <span><i class="fas fa-rupee-sign"></i> Price per KM</span>
                                <strong>₹<?php echo number_format((float)$vehicle['price_per_km'], 2); ?></strong>
                            </li>
                            <li>
                                <span><i class="fas fa-users"></i> Capacity</span>
                                <strong><?php echo intval($vehicle['capacity']); ?> Seats</strong>
                            </li>
                            <li>
                                <span><i class="fas fa-check-circle"></i> Status</span>
                                <strong><?php echo $vehicle['is_active'] ? 'Available' : 'Unavailable'; ?></strong>
                            </li>
                        </ul>

                        <a href="<?php echo SITE_URL; ?>contact" class="booking-btn">
                            <i class="fas fa-paper-plane"></i> Contact Us
                        </a>

                        <a href="tel:<?php echo getSetting('site_phone'); ?>" class="booking-btn btn-outline">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                    </div>

                    <div class="sidebar-widget">
                        <h5 class="widget-title"><i class="fas fa-car-side" style="color:#010753;"></i> Need Help Choosing?</h5>
                        <p class="mb-3 text-muted">Tell us your trip plan and our team will suggest the best vehicle for your route, group size, and budget.</p>
                        <a href="<?php echo SITE_URL; ?>vehicles" class="btn btn-outline-secondary w-100">Back to All Vehicles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>