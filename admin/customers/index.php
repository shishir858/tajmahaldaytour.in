<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Filters
$where = " WHERE 1=1 ";
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if(!empty($search)) {
    $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%') ";
}

// Get all customers
$query = "SELECT c.*, 
          COUNT(DISTINCT b.id) as total_bookings,
          SUM(b.final_price) as total_spent
          FROM customers c
          LEFT JOIN bookings b ON c.id = b.customer_id
          $where
          GROUP BY c.id
          ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Customers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Search -->
    <div class="admin-card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="index.php" class="btn btn-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Customer Name</th>
                            <th>Contact Information</th>
                            <th width="120" class="text-center">Total Bookings</th>
                            <th width="150">Total Spent</th>
                            <th width="120">Joined Date</th>
                            <th width="100" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            while($customer = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?php echo $customer['id']; ?></span>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($customer['name']); ?></strong>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <i class="fas fa-envelope text-muted me-1"></i>
                                    <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>">
                                        <?php echo htmlspecialchars($customer['email']); ?>
                                    </a>
                                </div>
                                <div>
                                    <i class="fas fa-phone text-muted me-1"></i>
                                    <a href="tel:<?php echo htmlspecialchars($customer['phone']); ?>">
                                        <?php echo htmlspecialchars($customer['phone']); ?>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary"><?php echo $customer['total_bookings']; ?></span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    <?php echo $customer['total_spent'] > 0 ? format_price($customer['total_spent']) : '-'; ?>
                                </strong>
                            </td>
                            <td>
                                <?php echo format_date($customer['created_at']); ?>
                            </td>
                            <td class="text-center">
                                <a href="view.php?id=<?php echo $customer['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No customers found.</p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
