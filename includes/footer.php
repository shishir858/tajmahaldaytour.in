    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <!-- Categories with Packages -->
            <div class="row mb-5">
                <?php
                $footer_categories = $conn->query("SELECT * FROM categories WHERE is_active = 1 AND show_in_header = 1 ORDER BY display_order LIMIT 5");
                while($footer_cat = $footer_categories->fetch_assoc()):
                    $footer_packages = $conn->query("SELECT id, title, slug FROM tour_packages WHERE category_id = {$footer_cat['id']} AND is_active = 1 ORDER BY display_order LIMIT 5");
                ?>
                <div class="col-lg col-md-4 col-sm-6 mb-4">
                    <h5 class="footer-category-title"><?php echo htmlspecialchars($footer_cat['name']); ?></h5>
                    <ul class="footer-links-list">
                        <?php while($footer_pkg = $footer_packages->fetch_assoc()): ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>package/<?php echo $footer_pkg['slug'] ?: $footer_pkg['id']; ?>">
                                <i class="fas fa-angle-right"></i> <?php echo htmlspecialchars(substr($footer_pkg['title'], 0, 30)); ?>...
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- About Us Section -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h4 class="footer-section-title">About Us</h4>
                    <p class="footer-about-text">
                        tajmahaldaytour offers private drivers, custom tours, and car rentals across India. Our team ensures safe, comfortable, and memorable travel experiences. Discover India with us and experience every destination in a unique way.
                    </p>
                    <div class="footer-social-links mt-4">
                        <a href="<?php echo getSetting('facebook_url') ?: '#'; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo getSetting('instagram_url') ?: '#'; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo getSetting('youtube_url') ?: '#'; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="footer-section-title text-center">Quick Links</h4>
                    <ul class="footer-quick-links">
                        <li><a href="<?php echo SITE_URL; ?>"><i class="fas fa-circle"></i> Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>about"><i class="fas fa-circle"></i> About Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>tour-packages"><i class="fas fa-circle"></i> Tour Packages</a></li>
                        <li><a href="<?php echo SITE_URL; ?>gallery"><i class="fas fa-circle"></i> Gallery</a></li>
                        <li><a href="<?php echo SITE_URL; ?>vehicles"><i class="fas fa-circle"></i> Our Vehicles</a></li>
                        <li><a href="<?php echo SITE_URL; ?>contact"><i class="fas fa-circle"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="footer-section-title text-center">Contact Info</h4>
                    <div class="footer-contact-info">
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo getSetting('site_phone'); ?>"><?php echo getSetting('site_phone') ?: '+91 9310042916'; ?></a>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo getSetting('site_email'); ?>"><?php echo getSetting('site_email') ?: 'touristdriversindiapvttours@gmail.com'; ?></a>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo getSetting('site_address') ?: 'Plot No C 50 Ganesh Nagar Complex - New Delhi 110092'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="row mt-4 pt-4 border-top border-secondary">
                <div class="col-12 text-center">
                    <p class="footer-copyright mb-0">© <?php echo date('Y'); ?> tajmahaldaytour. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <?php if(getSetting('whatsapp_number')): ?>
    <a href="https://wa.me/<?php echo getSetting('whatsapp_number'); ?>" 
       class="whatsapp-float-btn" 
       target="_blank"
       title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <?php endif; ?>
    

    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top-btn" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Main Script (after jQuery) -->
    <script src="<?php echo SITE_URL; ?>assets/js/main-script.js?v=<?php echo time(); ?>"></script>
    
    <script>
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    
    <style>
        /* Footer */
        .main-footer {
            background: #00185b;
            color: #ffffff;
            padding: 60px 0 20px;
        }
        .footer-category-title {
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .footer-links-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links-list li {
            margin-bottom: 10px;
        }
        .footer-links-list a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-links-list a i {
            font-size: 10px;
        }
        .footer-links-list a:hover {
            color: #ffc722;
            padding-left: 5px;
        }
        .footer-section-title {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .footer-about-text {
            color: white;
            font-size: 14px;
            line-height: 1.8;
            max-width: 1000px;
            margin: 0 auto;
        }
        .footer-social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .footer-social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }
        .footer-social-links a:hover {
            background: #ffc722;
            transform: translateY(-4px);
        }
        .footer-quick-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            list-style: none;
            padding: 0;
            margin: 20px 0 0 0;
        }
        .footer-quick-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-quick-links a i {
            font-size: 6px;
        }
        .footer-quick-links a:hover {
            color: #ffc722;
        }
        .footer-contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 20px;
        }
        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 14px;
        }
        .contact-info-item i {
            color: #ffc722;
            font-size: 16px;
        }
        .contact-info-item a {
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        .contact-info-item a:hover {
            color: #ffc722;
        }
        .footer-copyright {
            color: #ededed;
            font-size: 14px;
        }
        
        /* WhatsApp Float Button */
        .whatsapp-float-btn {
            position: fixed;
            bottom: 140px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.5);
            z-index: 9999;
            transition: all 0.3s;
            text-decoration: none;
        }
        .whatsapp-float-btn:hover {
            background: #128C7E;
            transform: scale(1.1);
            color: white;
        }
        
        /* Call Float Button */
        .call-float-btn {
            position: fixed;
            bottom: 70px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: #ffc722;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.5);
            z-index: 9999;
            transition: all 0.3s;
            text-decoration: none;
            animation: pulse 2s infinite;
        }
        .call-float-btn:hover {
            background: #28a745;
            transform: scale(1.1);
            color: white;
        }
        
        /* Back to Top Button */
        .back-to-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(255, 196, 0, 0.5);
            z-index: 9999;
            cursor: pointer;
            transition: all 0.3s;
        }
        .back-to-top-btn:hover {
            background: #ffc722;
            transform: translateY(-5px);
        }
        .back-to-top-btn.show {
            display: flex;
        }
        
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 4px 15px rgba(255, 107, 53, 0.5);
            }
            50% {
                box-shadow: 0 4px 25px rgba(255, 107, 53, 0.7);
            }
        }
        
        @media (max-width: 768px) {
            .footer-quick-links {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            .footer-contact-info {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
        }
    </style>


<!-- Instagram Embed Script -->
<script async src="//www.instagram.com/embed.js"></script>

</body>
</html>
