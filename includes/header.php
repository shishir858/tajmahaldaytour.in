<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'tajmahaldaytour'; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/main-style.css?v=<?php echo time(); ?>">
    
    <!-- SweetAlert2 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <style>
        /* Top Bar Orange */
        .top-info-bar {
            background: linear-gradient(135deg, #000000 0%, #000000 100%);
            padding: 12px 0;
            color: #000;
            font-size: 14px;
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
        }
        .main-navbar.scrolled {
            padding: 10px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .navbar-brand-logo {
            height: 54px;
        }
        .main-navbar .nav-link {
            color: #333;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 12px !important;
            transition: all 0.3s;
        }
        .main-navbar .nav-link:hover {
            color: #dc3545;
        }
        .navbar-dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            border-radius: 10px;
            padding: 15px 0;
            min-width: 300px;
        }
        .navbar-dropdown-item {
            padding: 14px 28px;
            transition: all 0.3s;
            color: #000;
            font-weight: 500;
            font-size: 14px;
        }
        .navbar-dropdown-item:hover {
            background: #ffc722;
            color: #000 !important;
            padding-left: 35px;
        }
        .navbar-contact-btn {
            background: linear-gradient(135deg, #000000 0%, #000000 100%);
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
            .navbar-nav .dropdown:hover .dropdown-menu {
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
                    <a href="gallery.php" style="color: #fff; text-decoration: none;">Gallery</a>
                    <span class="">/</span>
                    <a href="vehicles.php" style="color: #fff; text-decoration: none;">Our Vehicles</a>
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
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo SITE_URL; ?>">
                <img src="<?php echo SITE_URL; ?>assets/image/logo.png" alt="tajmahaldaytour Logo" class="navbar-brand-logo">
                <!-- <span style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.6rem; color: #000; font-weight: bold;">tajmahaldaytour</span> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
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
                                <a class="dropdown-item navbar-dropdown-item" href="<?php echo SITE_URL; ?>package/<?php echo $nav_pkg['slug'] ?: $nav_pkg['id']; ?>">
                                    <?php echo htmlspecialchars($nav_pkg['title']); ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php endwhile; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>vehicles">Car Rental</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-contact-btn" href="<?php echo SITE_URL; ?>contact">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
