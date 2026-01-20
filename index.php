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
    <h1 class="display-3 fw-bold text-white mb-3">Discover <span class="hero-highlight">India</span> with <span class="hero-brand">tajmahaldaytour</span></h1>
    <p class="lead text-white mb-4">Private Tours, Car Rentals & Custom Experiences. Explore the Taj Mahal and beyond with our expert drivers and curated packages.</p>
    <a href="tour-packages" class="btn btn-primary btn-lg me-2">View Tour Packages</a>
    <a href="contact" class="btn btn-light btn-lg" style="color:#dc3545; font-weight:700;">Contact Us</a>
  </div>
  <div class="hero-3d-img d-none d-md-block">
    <img src="assets/image/banner/4.jpg" alt="Taj Mahal 3D">
    </div>
</section>

<!-- 3D Tour Categories Slider -->
<section id="categories" class="section bg-light">
  <div class="container">
    <h2 class="section-title">Explore Our Tour Categories</h2>
      <div class="section-desc">Browse our curated selection of tour categories designed for every kind of traveler. Find your perfect journey across India.</div>
    <div class="owl-carousel card-3d-slider" id="categoriesOwl">
      <div class="card-3d">
        <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=300&q=80" alt="Golden Triangle Tours" style="height:80px;width:80px;object-fit:cover;margin:0 auto 18px auto;display:block;border-radius:12px;">
        <h5>Golden Triangle Tours</h5>
      </div>
      <div class="card-3d">
        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=300&q=80" alt="Rajasthan Tours" style="height:80px;width:80px;object-fit:cover;margin:0 auto 18px auto;display:block;border-radius:12px;">
        <h5>Rajasthan Tours</h5>
      </div>
      <div class="card-3d">
        <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=300&q=80" alt="Wildlife & Nature" style="height:80px;width:80px;object-fit:cover;margin:0 auto 18px auto;display:block;border-radius:12px;">
        <h5>Wildlife & Nature</h5>
      </div>
      <div class="card-3d">
        <img src="https://images.unsplash.com/photo-1465156799763-2c087c332922?auto=format&fit=crop&w=300&q=80" alt="Spiritual Journeys" style="height:80px;width:80px;object-fit:cover;margin:0 auto 18px auto;display:block;border-radius:12px;">
        <h5>Spiritual Journeys</h5>
      </div>
    </div>
  </div>
</section>




<!-- More creative sections (Why Choose Us, About Us, Best Places, Vehicles, Testimonials, Videos, etc.) can be added here in the same 3D/animated style. -->

<!-- Why Choose Us Section -->
<section id="why-choose-us" class="section bg-fixed" style="background-image:url('assets/image/banner/3.webp');">
  <div class="container">
    <h2 class="section-title text-white">Why Choose Us</h2>
      <div class="section-desc">Discover why thousands trust us for their India adventures—expert guides, custom itineraries, and unbeatable value.</div>
    <div class="row g-4 justify-content-center why-choose-3d-row">
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" alt="Expert Guides" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Expert Guides</h5>
            <p>Local, experienced, and friendly guides for every tour.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="https://images.unsplash.com/photo-1509228468518-c5eeecbff44a?auto=format&fit=crop&w=400&q=80" alt="Custom Itineraries" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Custom Itineraries</h5>
            <p>Personalized tours to match your interests and schedule.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card-3d-model why-img-card text-center p-0">
          <img src="https://images.unsplash.com/photo-1465447142348-e9952c393450?auto=format&fit=crop&w=400&q=80" alt="Comfort & Safety" class="why-card-img">
          <div class="why-card-content p-3">
            <h5 class="mt-2">Comfort & Safety</h5>
            <p>Modern vehicles, safe drivers, and 24/7 support.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Us Section -->
<section id="about-us" class="section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="assets/image/about.jpg" alt="About Us" class="img-fluid rounded-4 shadow-lg">
      </div>
      <div class="col-md-6">
        <h2 class="section-title">About Us</h2>
          <div class="section-desc">We are passionate about creating memorable travel experiences, offering personalized service and local expertise for every guest.</div>
        <p class="lead">tajmahaldaytour is a leading travel company based in Agra, India, specializing in private tours, car rentals, and custom travel experiences. With years of expertise, we help travelers discover the best of India with comfort, safety, and local insight.</p>
        <ul class="list-unstyled fs-5">
          <li>✓ 1000+ Happy Customers</li>
          <li>✓ 10+ Years of Experience</li>
          <li>✓ 24/7 Customer Support</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Best Places Section (with fixed background) -->
<section id="best-places" class="section bg-fixed" style="background-image:url('https://images.unsplash.com/photo-1465156799763-2c087c332922?auto=format&fit=crop&w=1200&q=80');">
  <div class="container">
    <h2 class="section-title text-white">Best Places to Visit</h2>
      <div class="section-desc">Explore the most iconic and breathtaking destinations in India, handpicked for unforgettable memories.</div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-3 col-6">
        <div class="best-place-card taj-mahal-card">
          <div class="best-place-img-wrap">
            <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" alt="Taj Mahal" class="best-place-img">
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
            <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80" alt="Jaipur" class="best-place-img">
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
            <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Ranthambore" class="best-place-img">
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
            <img src="https://images.unsplash.com/photo-1465447142348-e9952c393450?auto=format&fit=crop&w=400&q=80" alt="Varanasi" class="best-place-img">
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
    <div class="section-desc">Handpicked tours and activities to make your journey in India truly memorable. Explore our most popular experiences, each crafted for adventure, culture, and discovery.</div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" alt="Sunrise Taj Mahal" class="experience-img">
          <div class="experience-overlay">
            <h5>Sunrise Taj Mahal Tour</h5>
            <p>Witness the Taj Mahal in the magical morning light with a guided tour.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Rajasthan Culture" class="experience-img">
          <div class="experience-overlay">
            <h5>Rajasthan Culture Trip</h5>
            <p>Experience folk music, dance, and cuisine in Rajasthan’s vibrant cities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="experience-3d-card">
          <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80" alt="Wildlife Safari" class="experience-img">
          <div class="experience-overlay">
            <h5>Wildlife Safari</h5>
            <p>Go on a thrilling safari in Ranthambore or other national parks.</p>
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
    <div class="section-desc">Follow these simple steps to book your dream tour and enjoy a seamless travel experience with us.</div>
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
    <div class="section-desc">Find answers to common questions about our tours, vehicles, and booking process. If you need more help, feel free to contact us!</div>
    <div class="row g-4 justify-content-center mt-4">
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" alt="Book Tour" class="faq-card-img">
          <div class="faq-card-content">
            <h5>How do I book a tour?</h5>
            <p>You can book directly on our website or contact us for custom itineraries.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Private or Group" class="faq-card-img">
          <div class="faq-card-content">
            <h5>Are your tours private or group?</h5>
            <p>All our tours are private and tailored to your needs for a personalized experience.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80" alt="Vehicles" class="faq-card-img">
          <div class="faq-card-content">
            <h5>What vehicles do you offer?</h5>
            <p>We offer sedans, SUVs, luxury cars, and tempo travellers for all group sizes.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="faq-3d-card">
          <img src="https://images.unsplash.com/photo-1465447142348-e9952c393450?auto=format&fit=crop&w=400&q=80" alt="Customize Tour" class="faq-card-img">
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
      <div class="section-desc">Choose from our wide range of well-maintained vehicles—taxis, sedans, SUVs, luxury cars, and tempo travellers—ensuring comfort, safety, and style for every journey across India.</div>
      <div class="owl-carousel card-3d-slider" id="vehiclesOwl">
      <div class="card-3d">
        <img src="assets/image/taxi.jpg" alt="Taxi" style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Taxi</h5>
        <p>Quick and comfortable rides for city and airport transfers.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/sedan.jpg" alt="Sedan" style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Sedan</h5>
        <p>Comfortable for small families and couples.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/suv.jpg" alt="SUV" style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>SUV</h5>
        <p>Spacious and perfect for group travel.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/luxurycar.jpg" alt="Luxury Car" style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
        <h5>Luxury Car</h5>
        <p>Travel in style and luxury for special occasions.</p>
      </div>
      <div class="card-3d">
        <img src="assets/image/tempotraveller.png" alt="Tempo Traveller" style="width:100%;height:120px;object-fit:contain;margin-bottom:18px;display:block;border-radius:12px;background:#fff;box-shadow:0 2px 8px #0001;">
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
    <p class="lead mb-4">Book your next adventure with tajmahaldaytour and experience the best of India with comfort, safety, and style.</p>
    <a href="contact" class="btn btn-lg btn-danger px-5 py-3 fw-bold">Contact Us Now</a>
  </div>
</section>

<!-- Video Gallery Section -->
<section id="videos" class="section">
  <div class="container">
    <h2 class="section-title">Our Videos Gallery</h2>
    <div class="section-desc">Watch our curated video gallery to experience the beauty, culture, and adventure of India. From breathtaking monuments to vibrant city life, our videos capture the essence of every journey we offer.</div>
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

<!-- Testimonials Section (Modern Glassmorphism) -->
<section id="testimonials" class="section testimonials-modern">
  <div class="container">
    <h2 class="section-title">What Our Customers Say</h2>
    <div class="row align-items-center testimonials-2col">
      <div class="col-lg-7 mb-4 mb-lg-0">
        <div class="testimonial-detail-card" id="testimonialDetail">
          <div class="testimonial-avatar-lg"><img src="assets/image/avatar1.png" alt="Priya S."></div>
          <div class="testimonial-quote-lg">“Amazing experience! Our driver was professional and friendly. Highly recommend tajmahaldaytour for anyone visiting India.”</div>
          <div class="testimonial-author-lg">— Priya S., Mumbai</div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="testimonial-list-slider" id="testimonialList">
          <div class="testimonial-list-card active" data-index="0">
            <div class="testimonial-avatar-sm"><img src="assets/image/avatar1.png" alt="Priya S."></div>
            <div class="testimonial-list-name">Priya S.<br><span>Mumbai</span></div>
          </div>
          <div class="testimonial-list-card" data-index="1">
            <div class="testimonial-avatar-sm"><img src="assets/image/avatar2.png" alt="John D."></div>
            <div class="testimonial-list-name">John D.<br><span>London</span></div>
          </div>
          <div class="testimonial-list-card" data-index="2">
            <div class="testimonial-avatar-sm"><img src="assets/image/avatar3.png" alt="Aditi R."></div>
            <div class="testimonial-list-name">Aditi R.<br><span>Delhi</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// Testimonials data
const testimonials = [
  {
    img: 'assets/image/avatar1.png',
    quote: '“Amazing experience! Our driver was professional and friendly. Highly recommend tajmahaldaytour for anyone visiting India.”',
    author: '— Priya S., Mumbai'
  },
  {
    img: 'assets/image/avatar2.png',
    quote: '“The custom tour was perfect for our family. Great service, clean car, and wonderful memories!”',
    author: '— John D., London'
  },
  {
    img: 'assets/image/avatar3.png',
    quote: '“Best way to see the Taj Mahal and more. Will book again!”',
    author: '— Aditi R., Delhi'
  }
];
document.addEventListener('DOMContentLoaded', function() {
  const listCards = document.querySelectorAll('#testimonialList .testimonial-list-card');
  const detail = document.getElementById('testimonialDetail');
  listCards.forEach(card => {
    card.addEventListener('click', function() {
      listCards.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      const idx = parseInt(this.getAttribute('data-index'));
      detail.innerHTML = `
        <div class="testimonial-avatar-lg"><img src="${testimonials[idx].img}" alt=""></div>
        <div class="testimonial-quote-lg">${testimonials[idx].quote}</div>
        <div class="testimonial-author-lg">${testimonials[idx].author}</div>
      `;
    });
  });
});
</script>



<?php include 'includes/footer.php'; ?>

<!-- Owl Carousel CSS/JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
  $('#categoriesOwl').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    dots:true,
    center:true,
    autoplay:true,
    autoplayTimeout:4000,
    smartSpeed:700,
    responsive:{
      0:{items:1},
      480:{items:2},
      768:{items:3},
      1200:{items:5}
    }
  });
  $('#vehiclesOwl').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    dots:true,
    center:true,
    autoplay:true,
    autoplayTimeout:4000,
    smartSpeed:700,
    responsive:{
      0:{items:1},
      480:{items:2},
      768:{items:3},
      1200:{items:5}
    }
  });
  $('#testimonialOwl').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    dots:true,
    autoplay:true,
    autoplayTimeout:5000,
    smartSpeed:700,
    responsive:{
      0:{items:1},
      768:{items:1},
      1200:{items:1}
    }
  });
});
</script>