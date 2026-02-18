<?php
// Home page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Home - tajmahaldaytour';
include 'includes/header.php';
?>
<link rel="stylesheet" href="assets/css/home-modern.css?v=<?php echo time(); ?>">

<!-- Modern Hero Section -->
<section id="hero" class="hero-section d-flex align-items-center justify-content-center text-center">
  <div class="hero-overlay"></div>
  <div class="container position-relative">
    <h1 class="display-3 text-white mb-3">Discover <span class="hero-highlight">India</span> with <span
        class="hero-brand">Expert Guided Tours</span></h1>
    <p class="lead fw-bold mb-4" style="color: rgb(255, 255, 255);">Private Day Tours • Taj Mahal Specialists • Trusted Drivers & Guides</p>
    <a href="tour-packages" class="btn btn-primary btn-lg me-2 mt-3">View Tour Packages</a>
    <a href="#" class="btn btn-light btn-lg mt-3" id="openBookTourModal" style="color:#dc3545; font-weight:700;">Contact Us</a>
  </div>
  <div class="hero-3d-img d-none d-md-block">
    <img src="assets/image/banner/8.jpg" alt="Taj Mahal 3D">
  </div>
</section>

<!-- About Us Section -->
<section id="about-us" class="section" style="background-color: #e1f0ff85;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="assets/image/about.jpg" alt="About Us" class="img-fluid rounded-4 shadow-lg">
      </div>
      <div class="col-md-6">
        <h2 class="section-title">About Us</h2>
        <div class="section-desc">We are passionate about creating memorable travel experiences, offering personalized
          service and local expertise for every guest.</div>
        <p class="lead">tajmahaldaytour is a leading travel company based in Agra, India, specializing in private tours,
          car rentals, and custom travel experiences. With years of expertise, we help travelers discover the best of
          India with comfort, safety, and local insight.</p>
        <ul class="list-unstyled fs-5">
          <li>✓ 1000+ Happy Customers</li>
          <li>✓ 10+ Years of Experience</li>
          <li>✓ 24/7 Customer Support</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Special Offer + Sliding Cards Section -->
<section class="section offer-slider-section" style="background:transparent;">
  <div class="container px-0">
    <div class="d-flex flex-row flex-wrap offer-slider-row">
      <!-- Left: Offer Text -->
      <div class="offer-slider-left d-flex align-items-center justify-content-center">
        <div class="offer-slider-bg-night">
          <div class="offer-slider-overlay-night"></div>
          <div class="offer-slider-content-night">
            <h2 class="fw-bold mb-3 offer-slider-title-night">
              Discover the Taj Mahal Like Never Before<br><span class="offer-slider-highlight-night">Exclusive Agra Day Tours</span>
            </h2>
            <p class="mb-0 offer-slider-desc-night">Handpicked Taj Mahal tour packages for every traveler.<br>Experience Agra's wonders with our expert guides!</p>
          </div>
        </div>
      </div>
      <!-- Right: Sliding Cards -->
      <div class="offer-slider-right">
        <div class="owl-carousel offer-cards-carousel-night">
          <?php
          // Show all categories statically as offer cards
          $all_categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order");
          while ($cat = $all_categories->fetch_assoc()):
            $img = isset($cat['image']) ? trim($cat['image']) : '';
            if ($img && $img !== 'default.jpg') {
                if (strpos($img, 'assets/') === 0) {
                    $img_url = SITE_URL . $img;
                } else if (strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0) {
                    $img_url = $img;
                } else {
                    $img_url = SITE_URL . 'uploads/categories/' . $img;
                }
                ?>
                <div class="offer-card-night">
                  <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
                  <div class="offer-card-caption-night"><?php echo htmlspecialchars($cat['name']); ?></div>
                </div>
                <?php
            }
          endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Category Wise Tour Packages (New Design) -->
<section class="category-packages-section py-5">
  <div class="container">
    <div class="section-heading-wrapper mb-4 text-center">
      <h2 class="section-main-heading">Top Tour Packages by Category</h2>
      <div class="section-desc mb-3" style="margin:0 auto;font-size:1.08rem;color:#555;">
        Browse our most popular and highly rated tour packages, handpicked for each category. Find the perfect trip for your interests and travel style.
      </div>
    </div>
  </div>
</section>
<!-- ...existing code... -->
<?php
$categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order");
while ($category = $categories->fetch_assoc()):
  $cat_id = $category['id'];
  $packages = $conn->query("SELECT * FROM tour_packages WHERE category_id = $cat_id AND is_active = 1 ORDER BY created_at DESC LIMIT 10");

  // DEBUG: Show number of packages for each category
  // echo '<div style="color:red;text-align:center;font-size:18px;">Category: '.htmlspecialchars($category['name']).' | Packages found: '.$packages->num_rows.'</div>';

  if ($packages->num_rows > 0):
?>
    <section class="category-packages-section" style="padding-top: 0!important;">
      <div class="container">
        <div class="section-heading-wrapper">
          <p class="section-label text-dark">Best Packages</p>
          <h2 class="section-main-heading section-title"><?php echo htmlspecialchars($category['name']); ?></h2>
          <div class="section-desc mb-3" style="margin:0 auto;font-size:1.08rem;color:#555;">
            <?php echo htmlspecialchars($category['description'] ?? ''); ?>
          </div>
        </div>

        <div class="category-packages-carousel owl-carousel owl-theme">
          <?php while ($package = $packages->fetch_assoc()): ?>
            <div class="category-package-card">
              <div class="category-package-image-wrapper">
                <?php
                $img = $package['featured_image'] ?? 'default.jpg';
                if (strpos($img, 'assets/') === 0) {
                  $img_url = SITE_URL . $img;
                } else {
                  $img_url = SITE_URL . 'uploads/packages/' . $img;
                }
                ?>
                <img class="category-package-image"
                  src="<?php echo $img_url; ?>"
                  alt="<?php echo htmlspecialchars($package['title']); ?>">
              </div>

              <div class="category-package-details">
                <div class="category-package-meta">
                  <span><i class="far fa-calendar"></i>
                    <?php echo $package['duration_days']; ?> Nights /
                    <?php echo $package['duration_nights']; ?> Days
                  </span>
                  <span><i class="fas fa-users"></i> 4 Persons</span>
                </div>

                <h3 class="category-package-location">
                  <?php echo htmlspecialchars(substr($package['title'], 0, 50)); ?>
                </h3>

                <h4 class="category-package-title">
                  <?php
                  $words = explode(' ', $package['title']);
                  echo implode(' ', array_slice($words, 0, 4));
                  if (count($words) > 4) echo '...';
                  ?>
                </h4>

                <div class="category-package-actions">
                  <a href="tel:+919876543210" class="btn-call-now">
                    Call Now <i class="fas fa-arrow-right"></i>
                  </a>
                  <a href="<?php echo SITE_URL; ?>package.php?<?php echo $package['slug'] ? 'slug=' . urlencode($package['slug']) : 'id=' . $package['id']; ?>"
                    class="btn-book-now">
                    Book Now<i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
<?php endif;
endwhile; ?>

<!-- Best Places Section (with fixed background) -->
<section id="best-places" class="section  bg-fixed"
  style="background-image:url('https://images.unsplash.com/photo-1465156799763-2c087c332922?auto=format&fit=crop&w=1200&q=80');">
  <div class="container">
    <h2 class="section-title">Best Places to Visit</h2>
    <div class="section-desc">Explore the most iconic and breathtaking destinations in India, handpicked for
      unforgettable memories.</div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-3 col-6">
        <div class="best-place-card taj-mahal-card">
          <div class="best-place-img-wrap">
            <img src="assets/image/tajmahal.jpg" alt="Taj Mahal" class="best-place-img">
          </div>
          <div class="best-place-content">
            <h5 class="taj-title">Taj Mahal</h5>
            <p>World’s most iconic symbol of love in Agra.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="best-place-card jaipur-card">
          <div class="best-place-img-wrap">
            <img src="assets/image/jaipur.jpg" alt="Jaipur" class="best-place-img">
            <span class="jaipur-badge">Pink City</span>
          </div>
          <div class="best-place-content">
            <h5 class="jaipur-title">Jaipur</h5>
            <p>Forts, palaces, and vibrant markets.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="best-place-card ranthambore-card">
          <div class="best-place-img-wrap">
            <img src="assets/image/ranthambore.jpg" alt="Ranthambore" class="best-place-img">
            <span class="ranthambore-icon"><i class="fas fa-paw"></i></span>
          </div>
          <div class="best-place-content">
            <h5 class="ranthambore-title">Ranthambore</h5>
            <p>Wildlife safaris and tiger spotting adventures.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="best-place-card varanasi-card">
          <div class="best-place-img-wrap">
            <img src="assets/image/varanasi.jpg" alt="Varanasi" class="best-place-img">
            <span class="varanasi-wave"></span>
          </div>
          <div class="best-place-content">
            <h5 class="varanasi-title">Varanasi</h5>
            <p>Spiritual city on the banks of the Ganges.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Best Destinations Section (Professional, Creative) -->


<!-- Popular Experiences Section -->
<section id="popular-experiences" class="section bg-light">
  <div class="container">
    <h2 class="section-title">Popular Experiences</h2>
    <div class="section-desc">Handpicked tours and activities to make your journey in India truly memorable. Explore our
      most popular experiences, each crafted for adventure, culture, and discovery.</div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="assets/image/sunrise.jpg" alt="Sunrise Taj Mahal" class="experience-img">
          <div class="experience-overlay">
            <h5>Sunrise Taj Mahal Tour</h5>
            <p>Witness the Taj Mahal in the magical morning light with a guided tour.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="assets/image/rajasthan-culture.png" alt="Rajasthan Culture" class="experience-img">
          <div class="experience-overlay">
            <h5>Rajasthan Culture Trip</h5>
            <p>Experience folk music, dance, and cuisine in Rajasthan’s vibrant cities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="assets/image/wildlife-safari.jpg" alt="Wildlife Safari" class="experience-img">
          <div class="experience-overlay">
            <h5>Wildlife Safari</h5>
            <p>Go on a thrilling safari in Ranthambore or other national parks.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-choose-us" class="section bg-fixed" style="background-image:url('assets/image/banner/3.webp');">
  <div class="container">
    <h2 class="section-title text-white">Why Choose Us</h2>
    <div class="section-desc">Discover why thousands trust us for their India adventures—expert guides, custom
      itineraries, and unbeatable value.</div>
    <div class="row g-4 justify-content-center why-choose-3d-row">
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="assets/image/guide-1.jpg" alt="Expert Guides" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Expert Guides</h5>
            <p>Local, experienced, and friendly guides for every tour.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="assets/image/Itineraries.jpg" alt="Custom Itineraries" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Custom Itineraries</h5>
            <p>Personalized tours to match your interests and schedule.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="assets/image/safety.jpg" alt="Comfort & Safety" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Comfort & Safety</h5>
            <p>Modern vehicles, safe drivers, and 24/7 support.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="section">
  <div class="container">
    <h2 class="section-title">How It Works</h2>
    <div class="section-desc">Follow these simple steps to book your dream tour and enjoy a seamless travel experience
      with us.</div>
    <div class="how-works-timeline">
      <div class="how-step">
        <div class="how-icon"><i class="fas fa-search-location"></i></div>
        <div class="how-content">
          <h5>Choose Destination</h5>
          <p>Pick your favorite place or tour package from our curated list.</p>
        </div>
      </div>
      <div class="how-step">
        <div class="how-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="how-content">
          <h5>Book Online</h5>
          <p>Reserve your tour or car rental easily through our website.</p>
        </div>
      </div>
      <div class="how-step">
        <div class="how-icon"><i class="fas fa-car"></i></div>
        <div class="how-content">
          <h5>Enjoy Your Trip</h5>
          <p>Relax and explore with our expert drivers and guides.</p>
        </div>
      </div>
      <div class="how-step">
        <div class="how-icon"><i class="fas fa-star"></i></div>
        <div class="how-content">
          <h5>Share Your Experience</h5>
          <p>Leave a review and inspire other travelers!</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->

<section id="faqs" class="section faq-3d-bg">
  <div class="container">
    <h2 class="section-title">Frequently Asked Questions</h2>
    <div class="section-desc">Find answers to common questions about our tours, vehicles, and booking process. If you
      need more help, feel free to contact us!</div>
    <div class="row g-4 justify-content-center mt-4">
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="assets/image/faq1.jpeg" alt="Book Tour" class="faq-card-img">
          <div class="faq-card-content">
            <h5>How do I book a tour?</h5>
            <p>You can book directly on our website or contact us for custom itineraries.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="assets/image/faq2.avif" alt="Private or Group" class="faq-card-img">
          <div class="faq-card-content">
            <h5>Are your tours private or group?</h5>
            <p>All our tours are private and tailored to your needs for a personalized experience.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="assets/image/faq3.avif" alt="Vehicles" class="faq-card-img">
          <div class="faq-card-content">
            <h5>What vehicles do you offer?</h5>
            <p>We offer sedans, SUVs, luxury cars, and tempo travellers for all group sizes.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="assets/image/faq4.jfif" alt="Customize Tour" class="faq-card-img">
          <div class="faq-card-content">
            <h5>Can I customize my tour?</h5>
            <p>Absolutely! We specialize in custom tours to fit your interests and schedule.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Vehicles Section -->
<section id="vehicles" class="section">
  <div class="container">
    <h2 class="section-title">Our Vehicles</h2>
    <div class="section-desc">Choose from our wide range of well-maintained vehicles—taxis, sedans, SUVs, luxury cars,
      and tempo travellers—ensuring comfort, safety, and style for every journey across India.</div>
    <div class="owl-carousel card-3d-slider" id="vehiclesOwl">
      <div class="card-3d">
        <img src="assets/image/taxi.jpg" alt="Taxi"
          style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Taxi</h5>
        <p>Quick and comfortable rides for city and airport transfers.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/sedan.jpg" alt="Sedan"
          style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Sedan</h5>
        <p>Comfortable for small families and couples.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/suv.jpg" alt="SUV"
          style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>SUV</h5>
        <p>Spacious and perfect for group travel.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/luxurycar.jpg" alt="Luxury Car"
          style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Luxury Car</h5>
        <p>Travel in style and luxury for special occasions.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/tempotraveller.png" alt="Tempo Traveller"
          style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Tempo Traveller</h5>
        <p>Ideal for large groups and family tours.</p>
      </div>
    </div>
  </div>
</section>


<!-- Call to Action Section -->
<section id="cta" class="section text-center">
  <div class="container">
    <h2 class="section-title mb-3">Ready to Explore India?</h2>
    <p class="lead mb-4">Book your next adventure with tajmahaldaytour and experience the best of India with comfort,
      safety, and style.</p>
    <a href="contact" class="btn btn-lg btn-danger px-5 py-3 fw-bold">Contact Us Now</a>
  </div>
</section>

<!-- Video Gallery Section -->
<section id="videos" class="section">
  <div class="container">
    <h2 class="section-title">Our Videos Gallery</h2>
    <div class="section-desc">Watch our curated video gallery to experience the beauty, culture, and adventure of India.
      From breathtaking monuments to vibrant city life, our videos capture the essence of every journey we offer.</div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="video-card">
          <iframe src="https://www.youtube.com/embed/4Wrc4fHSCpw" title="Taj Mahal Tour" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-4">
        <div class="video-card">
          <iframe src="https://www.youtube.com/embed/1La4QzGeaaQ" title="Incredible India" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-4">
        <div class="video-card">
          <iframe src="https://www.youtube.com/embed/2OEL4P1Rz04" title="Travel India" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section (Old Design) -->
<section id="testimonials" class="section testimonials-old">
  <div class="container">
    <h2 class="section-title text-center mb-5"
      style="font-family:'Playfair Display',Georgia,serif;font-size:2.5rem;font-weight:700;">Our <span
        style="color:#ffc722;">Reviews</span></h2>
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="video-block-lg">
          <img src="assets/image/tetimonial.png" alt="Guest Video">
          <div class="video-content">
            <h3>Our Guest Video</h3>
            <p>Tourist Drivers India Day Tours-OTI</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="testimonial-slider">
          <div class="testimonial-slide active">
            <div class="testimonial-text">We had a great experience with Taj Mahal Day Tours. Communicated with Jay via
              email and made payment online with no problems to eliminate handling cash.</div>
            <div class="testimonial-user d-flex align-items-center mt-3">
              <img src="assets/image/testi-1.jfif" alt="Guest" class="testimonial-user-img">
              <div class="ms-3">
                <div class="testimonial-title">"4 Days In Delhi"</div>
                <div class="testimonial-name">Guest Name: Vanessa R</div>
              </div>
            </div>
          </div>
          <div class="testimonial-slide">
            <div class="testimonial-text">Great day, driver Mr Sam was great, don't the round trip from Delhi. They
              organise a personal guide with great knowledge of the Taj.</div>
            <div class="testimonial-user d-flex align-items-center mt-3">
              <img src="assets/image/testi-2.jfif" alt="Guest" class="testimonial-user-img">
              <div class="ms-3">
                <div class="testimonial-title">"Taj Mahal"</div>
                <div class="testimonial-name">Guest Name: Troy N</div>
              </div>
            </div>
          </div>
          <div class="testimonial-pagination mt-4 text-center">
            <span class="testimonial-dot active"></span>
            <span class="testimonial-dot"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Simple slider for testimonials
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.testimonial-slide');
    const dots = document.querySelectorAll('.testimonial-dot');
    let current = 0;

    function showSlide(idx) {
      slides.forEach((s, i) => s.classList.toggle('active', i === idx));
      dots.forEach((d, i) => d.classList.toggle('active', i === idx));
      current = idx;
    }
    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => showSlide(i));
    });
    showSlide(0);
  });
</script>


<?php include 'includes/footer.php'; ?>

<!-- Owl Carousel CSS/JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize the main category slider (top)
    $('#categoriesOwl').owlCarousel({
      loop: true,
      margin: 30,
      nav: true,
      dots: true,
      center: true,
      autoplay: true,
      autoplayTimeout: 4000,
      smartSpeed: 700,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        768: {
          items: 3
        },
        1200: {
          items: 5
        }
      }
    });
    // Initialize the dynamic category packages carousels
    $('.category-packages-carousel').owlCarousel({
      loop: true,
      margin: 25,
      nav: true,
      dots: false,
      autoplay: true,
      autoplayTimeout: 4000,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1200: {
          items: 3
        }
      }
    });
    // Vehicles carousel
    $('#vehiclesOwl').owlCarousel({
      loop: true,
      margin: 30,
      nav: true,
      dots: true,
      center: true,
      autoplay: true,
      autoplayTimeout: 4000,
      smartSpeed: 700,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        768: {
          items: 3
        },
        1200: {
          items: 5
        }
      }
    });
    // Testimonial carousel (if present)
    if ($('#testimonialOwl').length) {
      $('#testimonialOwl').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        center: true,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 700,
        responsive: {
          0: {
            items: 1
          },
          480: {
            items: 2
          },
          768: {
            items: 3
          },
          1200: {
            items: 5
          }
        }
      });
    }
  });
</script>

<script>
  $(document).ready(function() {
    $('.offer-cards-carousel-night').owlCarousel({
      loop: true,
      margin: 18,
      nav: true,
      dots: false,
      autoplay: true,
      autoplayTimeout: 4000,
      smartSpeed: 700,
      items: 2,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        }
      }
    });
  });
</script>