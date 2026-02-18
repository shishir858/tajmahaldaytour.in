<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get booking ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get booking details with all related data
$query = "SELECT b.*, 
          c.name as customer_name, c.email as customer_email, c.phone as customer_phone, 
          c.address as customer_address, c.city as customer_city, c.state as customer_state,
          p.title as package_title, p.duration_days, p.duration_nights,
          cat.name as category_name
          FROM bookings b
          LEFT JOIN customers c ON b.customer_id = c.id
          LEFT JOIN tour_packages p ON b.package_id = p.id
          LEFT JOIN categories cat ON p.category_id = cat.id
          WHERE b.id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$booking = mysqli_fetch_assoc($result);

$status_colors = [
    'pending' => 'warning',
    'confirmed' => 'info',
    'completed' => 'success',
    'cancelled' => 'danger'
];
$status_color = $status_colors[$booking['booking_status']] ?? 'secondary';

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Booking Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Bookings</a></li>
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
        <div class="col-lg-8">
            <!-- Booking Information -->
            <div class="admin-card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking Information</h5>
                    <span class="badge bg-<?php echo $status_color; ?> fs-6">
                        <?php echo ucfirst($booking['booking_status']); ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Booking Code:</strong></p>
                            <p class="text-primary fs-5"><?php echo htmlspecialchars($booking['booking_number'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Booking Date:</strong></p>
                            <p><?php echo format_date($booking['created_at']); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Travel Date:</strong></p>
                            <p><i class="fas fa-calendar text-primary me-2"></i><?php echo format_date($booking['travel_date']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Number of Guests:</strong></p>
                            <p><i class="fas fa-users text-primary me-2"></i><?php echo $booking['number_of_persons'] ?? 0; ?> Guest(s)</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-2"><strong>Special Requests:</strong></p>
                            <p class="text-muted"><?php echo !empty($booking['special_requests']) ? nl2br(htmlspecialchars($booking['special_requests'])) : '-'; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="admin-card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Package Details</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-primary mb-3"><?php echo htmlspecialchars($booking['package_title']); ?></h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Category:</strong></p>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($booking['category_name']); ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong>Duration:</strong></p>
                            <p class="mb-0"><?php echo $booking['duration_days']; ?> Days / <?php echo $booking['duration_nights']; ?> Nights</p>
                        </div>
                    </div>

                    <a href="../packages/view.php?id=<?php echo $booking['package_id']; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>View Package Details
                    </a>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Name:</strong></p>
                            <p><?php echo htmlspecialchars($booking['customer_name']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Email:</strong></p>
                            <p><a href="mailto:<?php echo htmlspecialchars($booking['customer_email']); ?>">
                                <?php echo htmlspecialchars($booking['customer_email']); ?>
                            </a></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Phone:</strong></p>
                            <p><a href="tel:<?php echo htmlspecialchars($booking['customer_phone']); ?>">
                                <?php echo htmlspecialchars($booking['customer_phone']); ?>
                            </a></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-2"><strong>Address:</strong></p>
                            <p class="text-muted">
                                <?php 
                                $address_parts = array_filter([
                                    $booking['customer_address'],
                                    $booking['customer_city'],
                                    $booking['customer_state']
                                ]);
                                echo !empty($address_parts) ? implode(', ', array_map('htmlspecialchars', $address_parts)) : '-';
                                ?>
                            </p>
                        </div>
                    </div>

                    <a href="../customers/view.php?id=<?php echo $booking['customer_id']; ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-user me-2"></i>View Customer Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Payment Summary -->
            <div class="admin-card mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Payment Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span>Total Amount:</span>
                        <strong class="text-success fs-5"><?php echo format_price($booking['final_price'] ?? 0); ?></strong>
                    </div>

                    <div class="mb-2">
                        <p class="mb-1"><strong>Payment Status:</strong></p>
                        <span class="badge bg-<?php echo $booking['payment_status'] == 'paid' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($booking['payment_status']); ?>
                        </span>
                    </div>

                    <?php if(!empty($booking['payment_method'])): ?>
                    <div class="mb-2">
                        <p class="mb-1"><strong>Payment Method:</strong></p>
                        <p class="text-muted"><?php echo ucfirst(htmlspecialchars($booking['payment_method'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Update Status -->
            <div class="admin-card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Update Booking Status</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Change Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" <?php echo $booking['booking_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $booking['booking_status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="completed" <?php echo $booking['booking_status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo $booking['booking_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" name="update_status" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="mailto:<?php echo htmlspecialchars($booking['customer_email']); ?>" class="btn btn-outline-primary btn-sm w-100 mb-2">
                        <i class="fas fa-envelope me-2"></i>Send Email
                    </a>
                    <a href="tel:<?php echo htmlspecialchars($booking['customer_phone']); ?>" class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fas fa-phone me-2"></i>Call Customer
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-print me-2"></i>Print Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .page-actions, .admin-card .card-header button, .quick-actions { display: none; }
}
</style>

<?php include '../includes/footer.php'; ?>
