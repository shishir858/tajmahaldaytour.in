<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Handle status toggle
if(isset($_GET['toggle']) && isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $new_status = $_GET['status'] == '1' ? 0 : 1;
    
    $update_query = "UPDATE tour_packages SET is_active = $new_status WHERE id = $id";
    if(mysqli_query($conn, $update_query)) {
        header('Location: index.php?msg=status_updated');
        exit;
    }
}

// Filters
$where = " WHERE 1=1 ";
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if($category_filter > 0) {
    $where .= " AND category_id = $category_filter ";
}

if($status_filter !== '') {
    $status_val = $status_filter == 'active' ? 1 : 0;
    $where .= " AND is_active = $status_val ";
}

if(!empty($search)) {
    $where .= " AND (p.title LIKE '%$search%' OR p.slug LIKE '%$search%') ";
}

// Get all packages
$query = "SELECT p.*, c.name as category_name 
          FROM tour_packages p 
          LEFT JOIN categories c ON p.category_id = c.id 
          $where 
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);

// Get categories for filter
$categories_query = "SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order";
$categories = mysqli_query($conn, $categories_query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tour Packages</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tour Packages</li>
                </ol>
            </nav>
        </div>
        <div class="page-actions">
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Package
            </a>
        </div>
    </div>

    <?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        if($msg == 'added') {
            echo success_message('Package added successfully!');
        } elseif($msg == 'updated') {
            echo success_message('Package updated successfully!');
        } elseif($msg == 'deleted') {
            echo success_message('Package deleted successfully!');
        } elseif($msg == 'status_updated') {
            echo success_message('Status updated successfully!');
        } elseif($msg == 'cannot_delete') {
            echo error_message('Cannot delete package! It has active bookings.');
        }
    }
    ?>

    <!-- Filters -->
    <div class="admin-card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search packages..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="0">All Categories</option>
                        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $category_filter == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status_filter == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
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

    <div class="admin-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="100">Image</th>
                            <th>Package Details</th>
                            <th width="120">Duration</th>
                            <th width="120">Price</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            while($package = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?php echo $package['id']; ?></span>
                            </td>
                            <td>
                                <?php if(!empty($package['featured_image'])): ?>
                                    <img src="<?php echo SITE_URL . 'uploads/packages/' . $package['featured_image']; ?>" 
                                         alt="<?php echo htmlspecialchars($package['title']); ?>" 
                                         class="package-thumb">
                                <?php else: ?>
                                    <div class="no-image-thumb">
                                        <i class="fas fa-box"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($package['title']); ?></strong>
                                <br>
                                <span class="badge bg-primary"><?php echo htmlspecialchars($package['category_name']); ?></span>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-link me-1"></i><?php echo htmlspecialchars($package['slug']); ?>
                                </small>
                            </td>
                            <td>
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo $package['duration_days']; ?>D / <?php echo $package['duration_nights']; ?>N
                            </td>
                            <td>
                                <?php if($package['base_price'] > 0): ?>
                                    <strong class="text-success"><?php echo format_price($package['base_price']); ?></strong>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="?toggle&id=<?php echo $package['id']; ?>&status=<?php echo $package['is_active']; ?>" 
                                   class="badge bg-<?php echo $package['is_active'] ? 'success' : 'danger'; ?>">
                                    <?php echo $package['is_active'] ? 'Active' : 'Inactive'; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?php echo $package['id']; ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $package['id']; ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete this package?')" 
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No packages found. <a href="add.php">Add your first package</a></p>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.package-thumb {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 2px solid #e9ecef;
}

.no-image-thumb {
    width: 80px;
    height: 60px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 24px;
}
</style>

<?php include '../includes/footer.php'; ?>
