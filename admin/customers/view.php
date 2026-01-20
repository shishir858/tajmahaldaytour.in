<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get customer ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get customer details
$query = "SELECT * FROM customers WHERE id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$customer = mysqli_fetch_assoc($result);

// Get customer statistics
$stats_query = "SELECT 
    COUNT(*) as total_bookings,
    SUM(CASE WHEN booking_status = 'completed' THEN 1 ELSE 0 END) as completed_bookings,
    SUM(CASE WHEN booking_status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_bookings,
    SUM(final_price) as total_spent
    FROM bookings WHERE customer_id = $id";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Get customer bookings
$bookings_query = "SELECT b.*, p.title as package_title 
                   FROM bookings b
                   LEFT JOIN tour_packages p ON b.package_id = p.id
                   WHERE b.customer_id = $id
                   ORDER BY b.created_at DESC";
$bookings_result = mysqli_query($conn, $bookings_query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Customer Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Customers</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </nav>
        </div>
        <div class="page-actions">
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Customer Info -->
            <div class="admin-card mb-3">
                <div class="card-body text-center">
                    <div class="customer-avatar mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h4 class="mb-1"><?php echo htmlspecialchars($customer['name']); ?></h4>
                    <p class="text-muted mb-3">Customer since <?php echo format_date($customer['created_at']); ?></p>
                    
                    <div class="d-grid gap-2">
                        <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-2"></i>Send Email
                        </a>
                        <a href="tel:<?php echo htmlspecialchars($customer['phone']); ?>" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="admin-card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-address-card me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Email</small>
                        <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>">
                            <?php echo htmlspecialchars($customer['email']); ?>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Phone</small>
                        <a href="tel:<?php echo htmlspecialchars($customer['phone']); ?>">
                            <?php echo htmlspecialchars($customer['phone']); ?>
                        </a>
                    </div>

                    <?php if(!empty($customer['address']) || !empty($customer['city']) || !empty($customer['state']) || !empty($customer['country'])): ?>
                    <div>
                        <small class="text-muted d-block mb-1">Address</small>
                        <p class="mb-0">
                            <?php 
                            $address_parts = array_filter([
                                $customer['address'],
                                $customer['city'],
                                $customer['state'],
                                $customer['country']
                            ]);
                            echo implode('<br>', array_map('htmlspecialchars', $address_parts));
                            ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistics -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="stat-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Total Bookings</span>
                            <span class="badge bg-primary"><?php echo $stats['total_bookings']; ?></span>
                        </div>
                    </div>
                    
                    <div class="stat-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Completed</span>
                            <span class="badge bg-success"><?php echo $stats['completed_bookings']; ?></span>
                        </div>
                    </div>
                    
                    <div class="stat-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Cancelled</span>
                            <span class="badge bg-danger"><?php echo $stats['cancelled_bookings']; ?></span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><strong>Total Spent</strong></span>
                            <strong class="text-success"><?php echo format_price($stats['total_spent']); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Booking History -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Booking History</h5>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($bookings_result) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Booking Code</th>
                                        <th>Package</th>
                                        <th>Travel Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($booking = mysqli_fetch_assoc($bookings_result)) {
                                        $status_colors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $status_color = $status_colors[$booking['booking_status']] ?? 'secondary';
                                    ?>
                                    <tr>
                                        <td>
                                            <strong class="text-primary"><?php echo htmlspecialchars($booking['booking_number'] ?? 'N/A'); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo format_date($booking['created_at']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['package_title']); ?></td>
                                        <td><?php echo format_date($booking['travel_date']); ?></td>
                                        <td><strong class="text-success"><?php echo format_price($booking['final_price'] ?? 0); ?></strong></td>
                                        <td>
                                            <span class="badge bg-<?php echo $status_color; ?>">
                                                <?php echo ucfirst($booking['booking_status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="../bookings/view.php?id=<?php echo $booking['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No bookings found for this customer.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
