<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'tajmahaldaytour'; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* Ensure SweetAlert2 popup is above Bootstrap modal */
    .swal2-container {
        z-index: 1000002 !important;
    }
    </style>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/main-style.css?v=<?php echo time(); ?>">
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    
    <!-- jQuery CDN (required for plugins and custom scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <style>
        /* Force modal and backdrop to be on top and interactive */
        .modal {
            z-index: 999999 !important;
        }
        .modal.show {
            z-index: 999999 !important;
        }
        .modal-backdrop,
        .modal-backdrop.show {
            z-index: 999998 !important;
        }
        .modal-dialog {
            z-index: 1000000 !important;
            position: relative;
        }
        .modal-content {
            z-index: 1000001 !important;
            position: relative;
        }
        /* Fix for some custom navbars with high z-index */
        .main-navbar, .top-info-bar {
            z-index: 1000 !important;
        }
        .modal-backdrop.fade {
            opacity: 0!important;
        }

        .modal-backdrop {
            position: absolute!important;
            height: auto;
        }
        
        /* Top Bar Orange */
        /* Top Bar Orange */
        .top-info-bar {
            background: #00185b;
            padding: 12px 0;
            color: #000;
            font-size: 14px;
            font-family: Arial, sans-serif !important;
        }
        .top-info-bar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
            font-size: 14px;
        }
        .top-info-bar i {
            margin-right: 6px;
            font-size: 15px;
        }
        .top-info-bar .social-icon {
            color: white;
            margin-left: 15px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .top-info-bar .social-icon:hover {
            color: #ffffff;
            transform: translateY(-2px);
        }
        @media (max-width: 767px) {
            .top-info-bar {
                font-size: 11px;
                padding: 7px 0;
            }
            .top-info-bar a {
                font-size: 11px;
                margin: 0 6px;
            }
            .top-info-bar i {
                font-size: 12px;
            }
            .custom-header-left, .custom-header-right {
                gap: 0.2rem !important;
            }
        }
        
        /* Main Navbar */
        .main-navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
            transition: all 0.3s;
            font-family: Arial, sans-serif !important;
        }
        .main-navbar.scrolled {
            padding: 10px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .navbar-brand-logo {
            height: 54px;
        }
        .main-navbar .nav-link {
            color: #000000;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 12px !important;
            transition: all 0.3s;
            text-transform: uppercase;
        }
        .main-navbar .nav-link:hover {
            color: #dc3545;
        }
        .navbar-dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            /* border-radius removed */
            border-radius: 0;
            padding: 15px 0;
            min-width: 300px;
            opacity: 0;
            transform: translateY(30px);
            visibility: hidden;
            transition: opacity 0.7s cubic-bezier(.4,0,.2,1), transform 0.7s cubic-bezier(.4,0,.2,1), visibility 0.7s cubic-bezier(.4,0,.2,1);
            will-change: opacity, transform, visibility;
            display: block;
            background: #000 !important;
        }
        .navbar-dropdown-item {
            padding: 14px 28px;
            transition: all 0.3s;
            color: #fff !important;
            font-weight: 500;
            font-size: 14px;
        }
        .navbar-dropdown-item:hover {
            background: #ffc722;
            color: #000236 !important;
            padding-left: 35px;
        }
        .navbar-contact-btn {
            background: #00185b;
            color: #ffffff !important;
            padding: 12px 35px !important;
            border-radius: 50px;
            font-weight: 700;
            margin-left: 15px;
            transition: all 0.3s;
        }
        .navbar-contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
            background: #2d0000;
            color: #fff !important;
        }
        @media (min-width: 992px) {
            .navbar-nav .dropdown:hover .dropdown-menu,
            .navbar-nav .dropdown:focus-within .dropdown-menu {
                opacity: 1;
                transform: translateY(0);
                visibility: visible;
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Custom Top Header Bar (as per image) -->
    <div class="top-info-bar" style="color: #fff; font-size: 15px; padding: 7px 0;">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center flex-wrap custom-header-left" style="gap: 0.5rem;">
                    <a href="<?php echo SITE_URL; ?>" style="color: #fff; text-decoration: none;">Home</a>
                    <span class="">/</span>
                    <a href="about.php" style="color: #fff; text-decoration: none;">About Us</a>
                    <span class="">/</span>
                    <a href="contact.php" style="color: #fff; text-decoration: none;">Contact</a>
                    <span class="">/</span>
                    <a class="nav-link" href="<?php echo SITE_URL; ?>vehicles">Car Rental</a>
                </div>
                <div class="d-flex align-items-center flex-wrap custom-header-right" style="gap: 0.5rem;">
                    <i class="fa fa-mobile-alt"></i>
                    <span><a href="tel:<?php echo getSetting('site_phone'); ?>"><?php echo getSetting('site_phone') ?: '+91 9310042916'; ?></a></span>
                    <span class="">/</span>
                    <i class="fa fa-mobile-alt"></i>
                    <span><a href="tel:9818249288?>"> +91 9818249288</a></span>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top d-none d-lg-block">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo SITE_URL; ?>">
                <img src="<?php echo SITE_URL; ?>assets/image/logo.png" alt="tajmahaldaytour Logo" class="navbar-brand-logo">
            </a>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php
                    $nav_categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 AND show_in_header = 1 ORDER BY display_order");
                    while($nav_cat = $nav_categories->fetch_assoc()):
                        $nav_packages = $conn->query("SELECT id, title, slug FROM tour_packages WHERE category_id = {$nav_cat['id']} AND is_active = 1 ORDER BY display_order LIMIT 10");
                        $has_nav_packages = $nav_packages->num_rows > 0;
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="<?php echo SITE_URL; ?>tour-packages?category=<?php echo $nav_cat['id']; ?>" 
                           <?php if($has_nav_packages): ?>data-bs-toggle="dropdown"<?php endif; ?>>
                            <?php echo htmlspecialchars($nav_cat['name']); ?>
                        </a>
                        <?php if($has_nav_packages): ?>
                        <ul class="dropdown-menu navbar-dropdown-menu">
                            <?php while($nav_pkg = $nav_packages->fetch_assoc()): ?>
                            <li>
                                <a class="dropdown-item navbar-dropdown-item" href="<?php echo SITE_URL; ?>package.php?<?php echo $nav_pkg['slug'] ? 'slug=' . urlencode($nav_pkg['slug']) : 'id=' . $nav_pkg['id']; ?>">
                                    <?php
                                    $words = preg_split('/\s+/', $nav_pkg['title']);
                                    if(count($words) > 5) {
                                        echo htmlspecialchars(implode(' ', array_slice($words, 0, 5))) . '...';
                                    } else {
                                        echo htmlspecialchars($nav_pkg['title']);
                                    }
                                    ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php endwhile; ?>
                    <li class="nav-item">
                        <a class="nav-link navbar-contact-btn" href="#" id="openBookTourModalHeader">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Toggle Button -->
    <div class="d-lg-none" style="position: sticky; top: 0; z-index: 10001; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.07);">
        <div class="container-fluid d-flex align-items-center justify-content-between" style="padding: 10px 0;">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo SITE_URL; ?>">
                <img src="<?php echo SITE_URL; ?>assets/image/logo.png" alt="tajmahaldaytour Logo" class="navbar-brand-logo" style="height: 40px;">
            </a>
            <button id="mobileMenuToggle" class="btn" style="font-size: 2rem; color: #000; background: none; border: none;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Slide Menu -->
    <div id="mobileSlideMenu" class="mobile-slide-menu">
        <div class="mobile-slide-menu-header d-flex align-items-center justify-content-between" style="padding: 18px 20px; border-bottom: 1px solid #eee;">
            <span style="font-size: 1.3rem; font-weight: 700;">Menu</span>
            <button id="mobileMenuClose" class="btn" style="font-size: 1.7rem; color: #000; background: none; border: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-menu-list">
            <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="vehicles.php">Our Vehicles</a></li>
            <li><a href="<?php echo SITE_URL; ?>vehicles">Car Rental</a></li>
            <li><a href="#" id="openBookTourModalMobile"><i class="fas fa-phone me-2"></i>Contact Us</a></li>
            <li style="padding: 10px 20px 0 20px; font-weight: 600; color: #888;">Categories</li>
            <?php
            $nav_categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 AND show_in_header = 1 ORDER BY display_order");
            while($nav_cat = $nav_categories->fetch_assoc()):
            ?>
            <li style="padding-left: 20px;"><a href="<?php echo SITE_URL; ?>tour-packages?category=<?php echo $nav_cat['id']; ?>"><?php
                $words = preg_split('/\s+/', $nav_cat['name']);
                if(count($words) > 6) {
                    echo htmlspecialchars(implode(' ', array_slice($words, 0, 6))) . '...';
                } else {
                    echo htmlspecialchars($nav_cat['name']);
                }
            ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <style>
    .mobile-slide-menu {
        position: fixed;
        top: 0;
        left: -320px;
        width: 300px;
        height: 100vh;
        background: #fff;
        box-shadow: 2px 0 20px rgba(0,0,0,0.08);
        z-index: 10002;
        transition: left 0.35s cubic-bezier(.4,0,.2,1);
        overflow-y: auto;
        padding-bottom: 40px;
    }
    .mobile-slide-menu.open {
        left: 0;
    }
    .mobile-slide-menu-header {
        background: #f8f8f8;
    }
    .mobile-menu-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .mobile-menu-list li {
        border-bottom: 1px solid #f0f0f0;
    }
    .mobile-menu-list li a {
        display: block;
        padding: 15px 20px;
        color: #222;
        font-size: 1.1rem;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }
    .mobile-menu-list li a:hover {
        background: #000;
        color: #fff;
    }
    @media (min-width: 992px) {
        .mobile-slide-menu, .d-lg-none { display: none !important; }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var mobileMenu = document.getElementById('mobileSlideMenu');
        var openBtn = document.getElementById('mobileMenuToggle');
        var closeBtn = document.getElementById('mobileMenuClose');
        var body = document.body;
        if(openBtn && mobileMenu) {
            openBtn.addEventListener('click', function() {
                mobileMenu.classList.add('open');
                body.style.overflow = 'hidden';
            });
        }
        if(closeBtn && mobileMenu) {
            closeBtn.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
                body.style.overflow = '';
            });
        }
        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if(mobileMenu.classList.contains('open') && !mobileMenu.contains(e.target) && !openBtn.contains(e.target)) {
                mobileMenu.classList.remove('open');
                body.style.overflow = '';
            }
        });
        // Open modal from mobile menu
        var openModalMobile = document.getElementById('openBookTourModalMobile');
        var bookTourModal = document.getElementById('bookTourModal');
        if(openModalMobile && bookTourModal) {
            openModalMobile.addEventListener('click', function(e) {
                e.preventDefault();
                var modal = new bootstrap.Modal(bookTourModal);
                modal.show();
                mobileMenu.classList.remove('open');
                body.style.overflow = '';
            });
        }
    });
    </script>

    <style>
    @media (max-width: 575.98px) {
        .modal-dialog {
            max-width: 95vw !important;
            margin: 1.75rem auto;
        }
        .modal-content {
            border-radius: 16px !important;
        }
    }
    </style>

<!-- Book This Tour Modal (Global, for header and all pages) -->
<div class="modal fade" id="bookTourModal" tabindex="-1" aria-labelledby="bookTourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="border-bottom: none;">
                <h3 class="modal-title w-100 text-center" id="bookTourModalLabel" style="font-size: 2rem; font-weight: 800; color: #333;">
                    <i class="fas fa-paper-plane" style="color: #000000;"></i> Book Your Tour
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 18px; top: 18px;"></button>
            </div>
            <div class="modal-body">
                <p style="text-align: center; color: #666; margin-bottom: 30px;">Fill in your details and we'll get back to you shortly</p>
                <form id="bookTourFormHome" method="POST" action="<?php echo SITE_URL; ?>submit-package.php">
                    <input type="hidden" name="package_id" value="0">
                    <input type="hidden" name="redirect_url" value="/index.php">
                    <input type="hidden" name="enquiry_back_url" value="/index.php">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-user"></i> Full Name *</label>
                        <input type="text" class="form-control" name="name" required style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-envelope"></i> Email Address *</label>
                        <input type="email" class="form-control" name="email" required style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;" placeholder="your@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-phone"></i> Phone Number *</label>
                        <input type="tel" class="form-control" name="phone" required style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;" placeholder="+91 98765 43210">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #333;"><i class="far fa-calendar"></i> Travel Date *</label>
                            <input type="date" class="form-control" name="travel_date" required style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-users"></i> Guests *</label>
                            <input type="number" class="form-control" name="people" required min="1" value="2" style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-comment"></i> Special Requirements</label>
                        <textarea class="form-control" name="message" rows="4" style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;" placeholder="Any special requirements or questions..."></textarea>
                    </div>
                    <button type="submit" class="btn-book-submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #1d2b53 0%, #000000 60%, #1d2b53 100%); color: white; border: none; border-radius: 50px; font-size: 1.1rem; font-weight: 700; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); transition: all 0.3s; cursor: pointer;">
                        <i class="fas fa-check-circle"></i> Submit Booking Request
                    </button>
                    <div id="formMessageHome" style="margin-top: 20px; display: none;"></div>
                    <!-- No AJAX: normal form submit for thankyou page redirect -->
                    <p style="text-align: center; margin-top: 20px; color: #999; font-size: 0.9rem;">
                        <i class="fas fa-lock"></i> Your information is safe and secure
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Modal open triggers (header, hero, mobile menu)
document.addEventListener('DOMContentLoaded', function() {
    var bookTourModal = document.getElementById('bookTourModal');
    var openBtnHeader = document.getElementById('openBookTourModalHeader');
    if (openBtnHeader && bookTourModal) {
        openBtnHeader.addEventListener('click', function(e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(bookTourModal);
            modal.show();
        });
    }
    var openBtnHero = document.getElementById('openBookTourModal');
    if (openBtnHero && bookTourModal) {
        openBtnHero.addEventListener('click', function(e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(bookTourModal);
            modal.show();
        });
    }
    // Delegated event for dynamically rendered/mobile button
    document.addEventListener('click', function(e) {
        var target = e.target;
        if (target && target.id === 'openBookTourModal') {
            e.preventDefault();
            var modal = new bootstrap.Modal(bookTourModal);
            modal.show();
        }
    });
});
</script>

</body>
</html>
