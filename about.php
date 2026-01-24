

<?php
// About Us page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'About Us - tajmahaldaytour';
include 'includes/header.php';
?>

<!-- Header Banner -->
<section class="about-header-banner d-flex align-items-center justify-content-center text-center" style="position:relative;min-height:320px;background:linear-gradient(120deg, #000000 0%, #000000 60%, #1a237e 100%);overflow:hidden;">
    <img src="assets/image/banner/4.jpg" alt="About Banner" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.18;z-index:1;">
    <div class="container position-relative" style="z-index:2;">
        <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow:0 2px 12px #000a;">About Us</h1>
        <p class="lead text-white mb-0" style="font-size:1.25rem;">Your trusted partner for private tours, car rentals, and custom travel experiences across India.</p>
    </div>
</section>



<!-- Main About Section -->
<section id="about-us" class="section py-4" style="background:#fffbe7; margin: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="card-3d" style="padding:0;overflow:hidden;box-shadow:0 12px 48px rgba(44,62,80,0.18);">
                    <img src="assets/image/about.jpg" alt="About Us" class="img-fluid" style="border-radius:24px 24px 0 0;max-height:340px;object-fit:cover;width:100%;">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="section-title" style="color:#ffc722;">Why Choose Us?</h2>
                <div class="section-desc mb-3">We are passionate about creating memorable travel experiences, offering personalized service and local expertise for every guest.</div>
                <div class="about-feature-list mb-3">
                    <div class="d-flex align-items-center mb-2"><span style="font-size:1.5rem;color:#28a745;margin-right:10px;">✓</span> 1000+ Happy Customers</div>
                    <div class="d-flex align-items-center mb-2"><span style="font-size:1.5rem;color:#28a745;margin-right:10px;">✓</span> 10+ Years of Experience</div>
                    <div class="d-flex align-items-center mb-2"><span style="font-size:1.5rem;color:#28a745;margin-right:10px;">✓</span> 24/7 Customer Support</div>
                </div>
                <p class="lead">With years of experience and a passion for hospitality, we help you discover the real India, from the Taj Mahal to hidden gems. Let us make your trip unforgettable!</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="section" style="background:#fff; margin-bottom:48px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                <div class="card-3d" style="padding:0;overflow:hidden;box-shadow:0 8px 32px rgba(44,62,80,0.12);">
                    <img src="assets/image/banner/3.webp" alt="Our Story" class="img-fluid" style="border-radius:24px;max-height:320px;object-fit:cover;width:100%;">
                </div>
            </div>
            <div class="col-md-6 order-md-1">
                <h2 class="section-title" style="color:#ff2e63;">Our Story</h2>
                <div class="section-desc mb-3">From a small team in Agra to a leading travel company, our journey is built on passion and dedication.</div>
                <p class="lead">Founded in 2012, tajmahaldaytour started with a vision to offer authentic, safe, and memorable travel experiences. Today, we serve thousands of happy travelers every year, helping them discover the wonders of India with comfort and care.</p>
            </div>
        </div>
    </div>
</section>


<!-- Achievements Section -->
<section class="section" style="background:linear-gradient(120deg,#fffbe7 60%,#ffc72222 100%); margin-bottom:48px; margin-top:100px; padding-top:48px; padding-bottom:48px;">
    <div class="container">
        <h2 class="section-title text-center" style="color:#28a745;letter-spacing:2px;">Our Achievements</h2>
        <div class="row justify-content-center align-items-end" style="gap:24px;">
            <div class="col-md-3 col-6 mb-4">
                <div class="card-3d text-center p-4" style="box-shadow:0 12px 48px #ffc72244;border-radius:24px;background:#fff;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-30px;right:-30px;width:80px;height:80px;background:radial-gradient(circle,#ffc72255 60%,transparent 100%);"></div>
                    <h1 style="color:#ffc722;font-size:3rem;font-weight:800;line-height:1;">10+</h1>
                    <div style="height:3px;width:40px;background:#28a745;margin:10px auto 14px auto;border-radius:2px;"></div>
                    <p class="mb-0" style="font-size:1.1rem;font-weight:600;color:#222;">Years Experience</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card-3d text-center p-4" style="box-shadow:0 12px 48px #ffc72244;border-radius:24px;background:#fff;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-30px;right:-30px;width:80px;height:80px;background:radial-gradient(circle,#ffc72255 60%,transparent 100%);"></div>
                    <h1 style="color:#ffc722;font-size:3rem;font-weight:800;line-height:1;">1000+</h1>
                    <div style="height:3px;width:40px;background:#28a745;margin:10px auto 14px auto;border-radius:2px;"></div>
                    <p class="mb-0" style="font-size:1.1rem;font-weight:600;color:#222;">Happy Customers</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card-3d text-center p-4" style="box-shadow:0 12px 48px #ffc72244;border-radius:24px;background:#fff;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-30px;right:-30px;width:80px;height:80px;background:radial-gradient(circle,#ffc72255 60%,transparent 100%);"></div>
                    <h1 style="color:#ffc722;font-size:3rem;font-weight:800;line-height:1;">24/7</h1>
                    <div style="height:3px;width:40px;background:#28a745;margin:10px auto 14px auto;border-radius:2px;"></div>
                    <p class="mb-0" style="font-size:1.1rem;font-weight:600;color:#222;">Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
