
<?php
// Contact page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Contact - tajmahaldaytour';
include 'includes/header.php';
?>

<!-- Header Banner -->
<section class="contact-header-banner d-flex align-items-center justify-content-center text-center" style="position:relative;min-height:320px;background:linear-gradient(120deg,#ffc722 0%,#ff7b00 60%,#ff2e63 100%);overflow:hidden;">
    <img src="assets/image/banner/4.jpg" alt="Contact Banner" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.18;z-index:1;">
    <div class="container position-relative" style="z-index:2;">
        <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow:0 2px 12px #000a;">Contact Us</h1>
        <p class="lead text-white mb-0" style="font-size:1.25rem;">Get in touch for private tours, car rentals, and custom travel experiences across India.</p>
    </div>
</section>

<!-- Main Contact Section -->
<section id="contact-main" class="section" style="background:#fffbe7; padding-top:48px; padding-bottom:48px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card-3d" style="padding:32px 24px;box-shadow:0 12px 48px rgba(44,62,80,0.18);">
                    <h2 class="section-title" style="color:#ffc722;">Send Us a Message</h2>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card-3d" style="padding:32px 24px;box-shadow:0 12px 48px rgba(44,62,80,0.18);">
                    <h2 class="section-title" style="color:#ffc722;">Contact Info</h2>
                    <p class="mb-2"><i class="fas fa-phone"></i> <a href="tel:<?php echo getSetting('site_phone'); ?>" style="color:#28a745;font-weight:600;"> <?php echo getSetting('site_phone') ?: '+91 9310042916'; ?></a></p>
                    <p class="mb-2"><i class="fas fa-envelope"></i> <a href="mailto:<?php echo getSetting('site_email'); ?>" style="color:#dc3545;font-weight:600;"> <?php echo getSetting('site_email') ?: 'info@tajmahaldaytour.com'; ?></a></p>
                    <p class="mb-2"><i class="fas fa-map-marker-alt"></i> <span style="color:#ff7b00;font-weight:600;"> <?php echo getSetting('site_address') ?: 'Plot No C 50 Ganesh Nagar Complex - New Delhi 110092'; ?></span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
