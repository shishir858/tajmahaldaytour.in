<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Handle status toggle
if(isset($_GET['toggle']) && isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $new_status = $_GET['status'] == '1' ? 0 : 1;
    
    $update_query = "UPDATE destinations SET is_active = $new_status WHERE id = $id";
    if(mysqli_query($conn, $update_query)) {
        header('Location: index.php?msg=status_updated');
        exit;
    }
}

// Get all destinations
$query = "SELECT * FROM destinations ORDER BY display_order ASC, name ASC";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Destinations</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Destinations</li>
                </ol>
            </nav>
        </div>
        <div class="page-actions">
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Destination
            </a>
        </div>
    </div>

    <?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        if($msg == 'added') {
            echo success_message('Destination added successfully!');
        } elseif($msg == 'updated') {
            echo success_message('Destination updated successfully!');
        } elseif($msg == 'deleted') {
            echo success_message('Destination deleted successfully!');
        } elseif($msg == 'status_updated') {
            echo success_message('Status updated successfully!');
        } elseif($msg == 'cannot_delete') {
            echo error_message('Cannot delete destination! It is used in tour packages.');
        }
    }
    ?>

    <div class="admin-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">Order</th>
                            <th width="100">Image</th>
                            <th>Name</th>
                            <th>State</th>
                            <th width="150">Slug</th>
                            <th width="100" class="text-center">Packages</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            while($destination = mysqli_fetch_assoc($result)) {
                                // Count packages for this destination
                                $package_count_query = "SELECT COUNT(*) as count FROM package_destinations WHERE destination_id = {$destination['id']}";
                                $package_count_result = mysqli_query($conn, $package_count_query);
                                $package_count = mysqli_fetch_assoc($package_count_result)['count'];
                        ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?php echo $destination['display_order']; ?></span>
                            </td>
                            <td>
                                <?php if(!empty($destination['image'])): ?>
                                    <img src="<?php echo SITE_URL . 'uploads/destinations/' . $destination['image']; ?>" 
                                         alt="<?php echo htmlspecialchars($destination['name']); ?>" 
                                         class="destination-thumb">
                                <?php else: ?>
                                    <div class="no-image-thumb">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($destination['name']); ?></strong>
                                <?php if(!empty($destination['state'])): ?>
                                    <br><small class="text-muted"><?php echo htmlspecialchars($destination['state']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($destination['state'] ?? '-'); ?></td>
                            <td><code><?php echo htmlspecialchars($destination['slug']); ?></code></td>
                            <td class="text-center">
                                <span class="badge bg-info"><?php echo $package_count; ?></span>
                            </td>
                            <td class="text-center">
                                <a href="?toggle&id=<?php echo $destination['id']; ?>&status=<?php echo $destination['is_active']; ?>" 
                                   class="badge bg-<?php echo $destination['is_active'] ? 'success' : 'danger'; ?>">
                                    <?php echo $destination['is_active'] ? 'Active' : 'Inactive'; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?php echo $destination['id']; ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $destination['id']; ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete this destination?')" 
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
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No destinations found. <a href="add.php">Add your first destination</a></p>
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
.destination-thumb {
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
