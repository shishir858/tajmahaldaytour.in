<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Handle approve/reject
if(isset($_POST['update_status']) && isset($_POST['review_id']) && isset($_POST['status'])) {
    $review_id = intval($_POST['review_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_query = "UPDATE reviews SET is_approved = " . ($status == 'approved' ? 1 : 0) . " WHERE id = $review_id";
    if(mysqli_query($conn, $update_query)) {
        header('Location: index.php?msg=status_updated');
        exit;
    }
}

// Handle delete
if(isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $id");
    header('Location: index.php?msg=deleted');
    exit;
}

// Filters
$where = " WHERE 1=1 ";
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$rating_filter = isset($_GET['rating']) ? intval($_GET['rating']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if($status_filter !== '') {
    $status_val = $status_filter == 'approved' ? 1 : 0;
    $where .= " AND r.is_approved = $status_val ";
}

if($rating_filter > 0) {
    $where .= " AND r.rating = $rating_filter ";
}

if(!empty($search)) {
    $where .= " AND (c.name LIKE '%$search%' OR r.review_text LIKE '%$search%' OR p.title LIKE '%$search%') ";
}

// Get all reviews
$query = "SELECT r.*, 
          c.name as customer_name, c.email as customer_email,
          p.title as package_title
          FROM reviews r
          LEFT JOIN customers c ON r.customer_id = c.id
          LEFT JOIN tour_packages p ON r.package_id = p.id
          $where 
          ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Reviews Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        if($msg == 'status_updated') {
            echo success_message('Review status updated successfully!');
        } elseif($msg == 'deleted') {
            echo success_message('Review deleted successfully!');
        }
    }
    ?>

    <!-- Filters -->
    <div class="admin-card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by customer, package, or review text..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" <?php echo $status_filter == 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-select">
                        <option value="0">All Ratings</option>
                        <option value="5" <?php echo $rating_filter == 5 ? 'selected' : ''; ?>>⭐⭐⭐⭐⭐</option>
                        <option value="4" <?php echo $rating_filter == 4 ? 'selected' : ''; ?>>⭐⭐⭐⭐</option>
                        <option value="3" <?php echo $rating_filter == 3 ? 'selected' : ''; ?>>⭐⭐⭐</option>
                        <option value="2" <?php echo $rating_filter == 2 ? 'selected' : ''; ?>>⭐⭐</option>
                        <option value="1" <?php echo $rating_filter == 1 ? 'selected' : ''; ?>>⭐</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="index.php" class="btn btn-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php 
        if(mysqli_num_rows($result) > 0) {
            while($review = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-6 mb-3">
            <div class="admin-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1"><?php echo htmlspecialchars($review['customer_name']); ?></h6>
                            <small class="text-muted"><?php echo format_date($review['created_at']); ?></small>
                        </div>
                        <div class="text-end">
                            <div class="rating mb-1">
                                <?php 
                                for($i = 1; $i <= 5; $i++) {
                                    echo $i <= $review['rating'] ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-muted"></i>';
                                }
                                ?>
                            </div>
                            <span class="badge bg-<?php echo $review['is_approved'] ? 'success' : 'warning'; ?>">
                                <?php echo $review['is_approved'] ? 'Approved' : 'Pending'; ?>
                            </span>
                        </div>
                    </div>

                    <p class="mb-2"><strong>Package:</strong> 
                        <a href="../packages/edit.php?id=<?php echo $review['package_id']; ?>" target="_blank">
                            <?php echo htmlspecialchars($review['package_title']); ?>
                        </a>
                    </p>

                    <p class="mb-3"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>

                    <div class="d-flex gap-2">
                        <?php if(!$review['is_approved']): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" name="update_status" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i>Approve
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" name="update_status" class="btn btn-warning btn-sm">
                                <i class="fas fa-times me-1"></i>Unapprove
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <a href="?delete&id=<?php echo $review['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this review?')">
                            <i class="fas fa-trash me-1"></i>Delete
                        </a>

                        <a href="mailto:<?php echo htmlspecialchars($review['customer_email']); ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
        ?>
        <div class="col-12">
            <div class="admin-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No reviews found.</p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script>
// Auto-hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

<?php include '../includes/footer.php'; ?>
