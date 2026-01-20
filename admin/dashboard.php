<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
check_login();

$page_title = 'tajmahaldaytour Dashboard';

// Get statistics
$stats = [
    'total_packages' => count_records($conn, 'tour_packages'),
    'active_packages' => count_records($conn, 'tour_packages', 'is_active = 1'),
    'total_categories' => count_records($conn, 'categories'),
    'total_destinations' => count_records($conn, 'destinations'),
    'total_bookings' => count_records($conn, 'bookings'),
    'pending_bookings' => count_records($conn, 'bookings', "booking_status = 'pending'"),
    'total_customers' => count_records($conn, 'customers'),
];

// Recent bookings
$recent_bookings_query = "SELECT b.*, c.name as customer_name, p.title as package_name 
                          FROM bookings b
                          LEFT JOIN customers c ON b.customer_id = c.id
                          LEFT JOIN tour_packages p ON b.package_id = p.id
                          ORDER BY b.created_at DESC
                          LIMIT 5";
$recent_bookings = mysqli_query($conn, $recent_bookings_query);

// Popular packages
$popular_packages_query = "SELECT p.*, c.name as category_name, 
                           (SELECT COUNT(*) FROM bookings WHERE package_id = p.id) as booking_count
                           FROM tour_packages p
                           LEFT JOIN categories c ON p.category_id = c.id
                           WHERE p.is_active = 1
                           ORDER BY booking_count DESC
                           LIMIT 5";
$popular_packages = mysqli_query($conn, $popular_packages_query);

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="page-header" style="font-family: 'Playfair Display', Georgia, serif;">
    <h1><i class="fas fa-home"></i> tajmahaldaytour Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">tajmahaldaytour Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['active_packages']; ?></h3>
                <p>Active Packages</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_bookings']; ?></h3>
                <p>Total Bookings</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_customers']; ?></h3>
                <p>Total Customers</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['pending_bookings']; ?></h3>
                <p>Pending Bookings</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Bookings -->
    <div class="col-lg-8 mb-4">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2><i class="fas fa-calendar-check"></i> Recent Bookings</h2>
                <a href="<?php echo BASE_URL; ?>bookings/index.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($recent_bookings) > 0): ?>
                            <?php while($booking = mysqli_fetch_assoc($recent_bookings)): ?>
                            <tr>
                                <td><strong><?php echo $booking['booking_number']; ?></strong></td>
                                <td><?php echo $booking['customer_name']; ?></td>
                                <td><?php echo substr($booking['package_name'], 0, 30) . '...'; ?></td>
                                <td><?php echo format_date($booking['travel_date']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo ($booking['booking_status'] == 'confirmed') ? 'success' : 
                                             (($booking['booking_status'] == 'pending') ? 'warning' : 'secondary'); 
                                    ?>">
                                        <?php echo ucfirst($booking['booking_status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No bookings yet</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-lg-4 mb-4">
        <div class="admin-card">
            <h2><i class="fas fa-chart-pie"></i> Quick Stats</h2>
            
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-folder text-primary"></i> Categories</span>
                    <span class="badge bg-primary rounded-pill"><?php echo $stats['total_categories']; ?></span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-map-marker-alt text-info"></i> Destinations</span>
                    <span class="badge bg-info rounded-pill"><?php echo $stats['total_destinations']; ?></span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-box text-success"></i> Total Packages</span>
                    <span class="badge bg-success rounded-pill"><?php echo $stats['total_packages']; ?></span>
                </div>
            </div>
        </div>
        
        <div class="admin-card mt-3">
            <h2><i class="fas fa-fire text-danger"></i> Popular Packages</h2>
            
            <div class="list-group list-group-flush">
                <?php if(mysqli_num_rows($popular_packages) > 0): ?>
                    <?php while($package = mysqli_fetch_assoc($popular_packages)): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?php echo substr($package['title'], 0, 30); ?></h6>
                                <small class="text-muted"><?php echo $package['category_name']; ?></small>
                            </div>
                            <span class="badge bg-primary"><?php echo $package['booking_count']; ?> bookings</span>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="list-group-item text-center text-muted">No packages yet</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
