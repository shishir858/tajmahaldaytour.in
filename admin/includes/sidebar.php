    <!-- Sidebar -->
    <aside class="admin-sidebar" style="font-family: 'Playfair Display', Georgia, serif;">
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>dashboard.php" class="menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>tajmahaldaytour Dashboard</span>
                </a>
            </li>
            
            <li class="menu-item">
                <hr class="my-2 mx-3">
                <small class="text-muted px-3 d-block mb-2">TOUR MANAGEMENT</small>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>categories/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/categories/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>destinations/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/destinations/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Destinations</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>packages/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/packages/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i>
                    <span>Tour Packages</span>
                </a>
            </li>
            
            <li class="menu-item">
                <hr class="my-2 mx-3">
                <small class="text-muted px-3 d-block mb-2">BOOKINGS & CUSTOMERS</small>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>bookings/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/bookings/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>customers/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/customers/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </li>
            
            <li class="menu-item">
                <hr class="my-2 mx-3">
                <small class="text-muted px-3 d-block mb-2">CONTENT</small>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>reviews/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/reviews/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i>
                    <span>Reviews</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>gallery/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/gallery/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-images"></i>
                    <span>Gallery</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>vehicles/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/vehicles/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-car"></i>
                    <span>Vehicles</span>
                </a>
            </li>
            
            <li class="menu-item">
                <hr class="my-2 mx-3">
                <small class="text-muted px-3 d-block mb-2">SETTINGS</small>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo BASE_URL; ?>settings/index.php" class="menu-link <?php echo (strpos($_SERVER['PHP_SELF'], '/settings/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    <span>Website Settings</span>
                </a>
            </li>
        </ul>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-content" style="font-family: 'Playfair Display', Georgia, serif;">
