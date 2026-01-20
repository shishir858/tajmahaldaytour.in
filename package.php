<?php
require_once 'includes/config.php';

// Get package by ID or slug
$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$package_slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';

// Build query based on ID or slug
if($package_id > 0) {
    $where = "p.id = $package_id";
} elseif(!empty($package_slug)) {
    $where = "p.slug = '$package_slug'";
} else {
    header('Location: tour-packages');
    exit;
}

// Get package details
$package_query = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                  FROM tour_packages p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE $where AND p.is_active = 1";

$package_result = $conn->query($package_query);
if ($package_result === false) {
    die('SQL Error: ' . $conn->error);
}
if($package_result->num_rows == 0) {
    header('Location: tour-packages');
    exit;
}

$package = $package_result->fetch_assoc();
$package_id = $package['id']; // Ensure package_id is set from the fetched package
$page_title = (isset($package['meta_title']) && !empty($package['meta_title']) ? $package['meta_title'] : $package['title']) . " - Tourist Drivers India";

// Get itinerary
$itinerary_query = "SELECT * FROM package_itinerary WHERE package_id = $package_id ORDER BY day_number ASC";
$itinerary = $conn->query($itinerary_query);

// Get destinations
$destinations_query = "SELECT d.* 
                       FROM package_destinations pd 
                       JOIN destinations d ON pd.destination_id = d.id 
                       WHERE pd.package_id = $package_id 
                       ORDER BY pd.display_order";
$destinations = $conn->query($destinations_query);

// Update views
$conn->query("UPDATE tour_packages SET views = views + 1 WHERE id = $package_id");

include 'includes/header.php';
?>

<style>
    .package-hero {
        height: 500px;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: flex-end;
    }
    .package-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
    }
    .package-hero-content {
        position: relative;
        z-index: 10;
        color: white;
        padding: 60px 0;
    }
    .package-hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 15px;
    }
    .package-hero-meta {
        display: flex;
        gap: 30px;
        font-size: 1.1rem;
    }
    .package-details-section {
        padding: 80px 0;
    }
    .package-sidebar {
        position: sticky;
        top: 100px;
    }
    .booking-card {
        background: white;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border: 1px solid #f0f0f0;
    }
    .booking-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: #FF6B35;
        margin-bottom: 30px;
        text-align: center;
    }
    .booking-btn {
        width: 100%;
        padding: 16px 30px;
        background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 15px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    }
    .booking-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(255, 107, 53, 0.5);
        color: white;
    }
    .booking-btn.btn-outline {
        background: white;
        color: #FF6B35;
        border: 2px solid #FF6B35;
        box-shadow: none;
    }
    .booking-btn.btn-outline:hover {
        background: #FF6B35;
        color: white;
        border-color: #FF6B35;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    }
    .package-info-list {
        list-style: none;
        padding: 0;
        margin: 25px 0 30px 0;
    }
    .package-info-list li {
        padding: 18px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1rem;
    }
    .package-info-list li:last-child {
        border-bottom: none;
    }
    .package-info-list li span {
        color: #666;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .package-info-list li span i {
        font-size: 1.1rem;
        color: #FF6B35;
    }
    .package-info-list li strong {
        color: #333;
        font-weight: 600;
        font-size: 1.05rem;
    }
    .itinerary-item {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-left: 5px solid #FF6B35;
    }
    .itinerary-day {
        background: #FF6B35;
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .itinerary-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    .tab-content-section {
        margin-top: 50px;
    }
    .nav-tabs {
        border: none;
        gap: 10px;
    }
    .nav-tabs .nav-link {
        border: 2px solid #eee;
        border-radius: 50px;
        padding: 12px 30px;
        color: #666;
        font-weight: 600;
    }
    .nav-tabs .nav-link.active {
        background: #FF6B35;
        color: white;
        border-color: #FF6B35;
    }
    
    /* Sidebar Widget Styles */
    .sidebar-widget {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .widget-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #FF6B35;
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .related-packages-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }
    
    .related-packages-list li {
        margin-bottom: 12px;
        padding-left: 5px;
    }
    
    .related-packages-list a {
        color: #0066cc;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .related-packages-list a:hover {
        color: #FF6B35;
        padding-left: 5px;
    }
    
    .related-packages-list a i {
        font-size: 0.75rem;
        transition: transform 0.3s;
    }
    
    .related-packages-list a:hover i {
        transform: translateX(3px);
    }
    
    .btn-explore-more {
        display: block;
        text-align: center;
        padding: 10px 20px;
        background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .btn-explore-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        color: white;
    }
    
    .btn-explore-more i {
        margin-left: 5px;
        transition: transform 0.3s;
    }
    
    .btn-explore-more:hover i {
        transform: translateX(3px);
    }
    
    /* Book Tour Form Styles */
    .book-tour-form-card .form-control:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
    }
    
    .btn-book-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(255, 107, 53, 0.5);
    }
    
    .btn-book-submit:active {
        transform: translateY(0);
    }
</style>


<!-- Package Hero -->
<section class="package-hero" style="background-image: url('<?php echo SITE_URL . 'uploads/packages/' . ($package['featured_image'] ?? 'default.jpg'); ?>')">
    <div class="container">
        <div class="package-hero-content">
            <div class="package-category mb-3">
                <span style="background: #FF6B35; padding: 8px 20px; border-radius: 50px; font-weight: 600;">
                    <?php echo htmlspecialchars($package['category_name']); ?>
                </span>
            </div>
            <h1 class="package-hero-title"><?php echo htmlspecialchars($package['title']); ?></h1>
            <div class="package-hero-meta">
                <span><i class="far fa-clock"></i> <?php echo $package['duration_days']; ?> Days / <?php echo $package['duration_nights']; ?> Nights</span>
                
                <span><i class="fas fa-signal"></i> <?php echo ucfirst($package['difficulty_level']); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Package Details -->
<section class="package-details-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Overview -->
                <div class="mb-5">
                    <h2 class="mb-4">Tour Overview</h2>
                    <div class="content">
                        <?php echo $package['description']; ?>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="tab-content-section">
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#itinerary">Itinerary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#inclusions">Inclusions/Exclusions</a>
                        </li>
                        <?php if($destinations->num_rows > 0): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#destinations">Destinations</a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content">
                        <!-- Itinerary Tab -->
                        <div class="tab-pane fade show active" id="itinerary">
                            <?php if($itinerary->num_rows > 0): ?>
                                <div class="accordion" id="itineraryAccordion">
                                    <?php 
                                    $day_count = 0;
                                    while($day = $itinerary->fetch_assoc()): 
                                        $day_count++;
                                        $collapse_id = "day" . $day['day_number'];
                                    ?>
                                    <div class="accordion-item" style="border: 1px solid #eee; margin-bottom: 15px; border-radius: 10px; overflow: hidden;">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button <?php echo $day_count > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapse_id; ?>" aria-expanded="<?php echo $day_count == 1 ? 'true' : 'false'; ?>" style="background: <?php echo $day_count == 1 ? '#FF6B35' : 'white'; ?>; color: <?php echo $day_count == 1 ? 'white' : '#333'; ?>; font-weight: 700; font-size: 1.1rem; padding: 20px;">
                                                <span style="background: <?php echo $day_count == 1 ? 'white' : '#FF6B35'; ?>; color: <?php echo $day_count == 1 ? '#FF6B35' : 'white'; ?>; padding: 8px 15px; border-radius: 20px; margin-right: 15px; font-size: 0.9rem;">Day <?php echo $day['day_number']; ?></span>
                                                <?php echo htmlspecialchars($day['title']); ?>
                                            </button>
                                        </h2>
                                        <div id="<?php echo $collapse_id; ?>" class="accordion-collapse collapse <?php echo $day_count == 1 ? 'show' : ''; ?>" data-bs-parent="#itineraryAccordion">
                                            <div class="accordion-body" style="padding: 25px; color: #666; line-height: 1.8; font-size: 1rem;">
                                                <?php echo nl2br(htmlspecialchars($day['description'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Itinerary details will be provided upon request.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Inclusions/Exclusions Tab -->
                        <div class="tab-pane fade" id="inclusions">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h4 class="mb-3"><i class="fas fa-check-circle text-success"></i> Inclusions</h4>
                                    <?php if($package['inclusions']): ?>
                                        <div class="content"><?php echo nl2br(htmlspecialchars($package['inclusions'])); ?></div>
                                    <?php else: ?>
                                        <p class="text-muted">Contact us for inclusion details.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h4 class="mb-3"><i class="fas fa-times-circle text-danger"></i> Exclusions</h4>
                                    <?php if($package['exclusions']): ?>
                                        <div class="content"><?php echo nl2br(htmlspecialchars($package['exclusions'])); ?></div>
                                    <?php else: ?>
                                        <p class="text-muted">Contact us for exclusion details.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Destinations Tab -->
                        <?php if($destinations->num_rows > 0): ?>
                        <div class="tab-pane fade" id="destinations">
                            <div class="row">
                                <?php while($dest = $destinations->fetch_assoc()): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="destination-card" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                            <?php if($dest['image']): ?>
                                                <img src="<?php echo htmlspecialchars($dest['image']); ?>" alt="<?php echo htmlspecialchars($dest['name']); ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                            <?php endif; ?>
                                            <h5><?php echo htmlspecialchars($dest['name']); ?></h5>
                                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($dest['state'] . ', ' . $dest['country']); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Book This Tour Form -->
                    <div class="book-tour-form-card mt-5" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                        <h3 style="font-size: 2rem; font-weight: 800; color: #333; margin-bottom: 10px; text-align: center;">
                            <i class="fas fa-paper-plane" style="color: #FF6B35;"></i> Book This Tour
                        </h3>
                        <p style="text-align: center; color: #666; margin-bottom: 30px;">Fill in your details and we'll get back to you shortly</p>
                        
                        <form id="bookTourForm" method="POST" action="<?php echo SITE_URL; ?>process-booking.php">
                            <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                            <input type="hidden" name="package_title" value="<?php echo htmlspecialchars($package['title']); ?>">
                            
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
                                    <input type="number" class="form-control" name="guests" required min="1" value="2" style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 600; color: #333;"><i class="fas fa-comment"></i> Special Requirements</label>
                                <textarea class="form-control" name="message" rows="4" style="padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;" placeholder="Any special requirements or questions..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn-book-submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%); color: white; border: none; border-radius: 50px; font-size: 1.1rem; font-weight: 700; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); transition: all 0.3s; cursor: pointer;">
                                <i class="fas fa-check-circle"></i> Submit Booking Request
                            </button>
                            
                            <div id="formMessage" style="margin-top: 20px; display: none;"></div>
                            
                            <p style="text-align: center; margin-top: 20px; color: #999; font-size: 0.9rem;">
                                <i class="fas fa-lock"></i> Your information is safe and secure
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="package-sidebar">
                    
                    <!-- Related Packages by Category -->
                    <?php
                    $categories_query = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order LIMIT 5");
                    while($cat = $categories_query->fetch_assoc()):
                        $cat_packages = $conn->query("SELECT id, title, slug FROM tour_packages WHERE category_id = {$cat['id']} AND is_active = 1 AND id != {$package_id} ORDER BY created_at DESC LIMIT 5");
                        if($cat_packages->num_rows > 0):
                    ?>


<!-- Removed AJAX booking script: now booking form submits directly to process-booking.php and shows server response page. -->
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">
                            <i class="fas fa-map-marker-alt text-primary"></i> 
                            <?php 
                            $cat_name = $cat['name'];
                            $cat_words = explode(' ', $cat_name);
                            echo htmlspecialchars(implode(' ', array_slice($cat_words, 0, 4)));
                            if(count($cat_words) > 4) echo '...';
                            ?>
                        </h5>
                        <ul class="related-packages-list">
                            <?php while($rel_pkg = $cat_packages->fetch_assoc()): ?>
                            <li>
                                <a href="<?php echo SITE_URL; ?>package/<?php echo $rel_pkg['slug'] ?: $rel_pkg['id']; ?>">
                                    <i class="fas fa-chevron-right"></i> 
                                    <?php 
                                    $pkg_title = $rel_pkg['title'];
                                    $title_words = explode(' ', $pkg_title);
                                    echo htmlspecialchars(implode(' ', array_slice($title_words, 0, 4)));
                                    if(count($title_words) > 4) echo '...';
                                    ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <a href="<?php echo SITE_URL; ?>tour-packages?category=<?php echo $cat['slug']; ?>" class="btn-explore-more">
                            Explore More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php 
                        endif;
                    endwhile; 
                    ?>
                    
                    <div class="booking-card">
                        <?php if($package['base_price'] > 0): ?>
                            <div class="booking-price">
                                ₹<?php echo number_format($package['discounted_price'] ?? $package['base_price']); ?>
                                <small style="font-size: 1rem; color: #666; font-weight: 400;">/<?php echo $package['price_type']; ?></small>
                            </div>
                        <?php else: ?>
                            <div class="booking-price" style="font-size: 1.8rem;">Contact for Price</div>
                        <?php endif; ?>
                        
                        <ul class="package-info-list">
                            <li>
                                <span><i class="far fa-clock"></i> Duration</span>
                                <strong><?php echo $package['duration_days']; ?>D / <?php echo $package['duration_nights']; ?>N</strong>
                            </li>
                            <?php if($package['max_group_size']): ?>
                            <?php endif; ?>
                            <?php if($package['min_age']): ?>
                            <li>
                                <span><i class="fas fa-child"></i> Min Age</span>
                                <strong><?php echo $package['min_age']; ?>+</strong>
                            </li>
                            <?php endif; ?>
                            <li>
                                <span><i class="fas fa-chart-line"></i> Difficulty</span>
                                <strong><?php echo ucfirst($package['difficulty_level'] ?? 'Easy'); ?></strong>
                            </li>
                        </ul>

                        <a href="<?php echo SITE_URL; ?>contact?package=<?php echo $package_id; ?>" class="booking-btn">
                            <i class="fas fa-paper-plane"></i> Contact Us
                        </a>
                        
                        <a href="tel:<?php echo getSetting('site_phone'); ?>" class="booking-btn btn-outline">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<style>
.tour-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
.tour-card:hover .tour-image img {
    transform: scale(1.1);
}
.btn-view-details:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
    color: white !important;
}
.related-tours-carousel .owl-nav {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
}
.related-tours-carousel .owl-nav button {
    width: 50px;
    height: 50px;
    background: white !important;
    color: #FF6B35 !important;
    border-radius: 50%;
    font-size: 1.5rem !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s;
}
.related-tours-carousel .owl-nav button:hover {
    background: #FF6B35 !important;
    color: white !important;
    transform: scale(1.1);
}
.related-tours-carousel .owl-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}
.related-tours-carousel .owl-dot {
    width: 12px;
    height: 12px;
    background: #ddd !important;
    border-radius: 50%;
    transition: all 0.3s;
}
.related-tours-carousel .owl-dot.active {
    background: #FF6B35 !important;
    width: 30px;
    border-radius: 10px;
}
</style>

<script>
$(document).ready(function(){
    $('.related-tours-carousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
