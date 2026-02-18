<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Handle status toggle
if(isset($_GET['toggle']) && isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $new_status = $_GET['status'] == '1' ? 0 : 1;
    
    $update_query = "UPDATE vehicles_new SET is_active = $new_status WHERE id = $id";
    if(mysqli_query($conn, $update_query)) {
        header('Location: index.php?msg=status_updated');
        exit;
    }
}

// Get all vehicles
$query = "SELECT * FROM vehicles_new ORDER BY name ASC";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Vehicles Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Vehicles</li>
                </ol>
            </nav>
        </div>
        <div class="page-actions">
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Vehicle
            </a>
        </div>
    </div>

    <?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        if($msg == 'added') {
            echo success_message('Vehicle added successfully!');
        } elseif($msg == 'updated') {
            echo success_message('Vehicle updated successfully!');
        } elseif($msg == 'deleted') {
            echo success_message('Vehicle deleted successfully!');
        } elseif($msg == 'status_updated') {
            echo success_message('Status updated successfully!');
        }
    }
    ?>

    <div class="admin-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="120">Image</th>
                            <th>Vehicle Details</th>
                            <th width="120">Capacity</th>
                            <th width="150">Price Range</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            while($vehicle = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <?php if(!empty($vehicle['image'])): ?>
                                    <img src="<?php echo SITE_URL . 'uploads/vehicles/' . $vehicle['image']; ?>" 
                                         alt="<?php echo htmlspecialchars($vehicle['name']); ?>" 
                                         class="vehicle-thumb">
                                <?php else: ?>
                                    <div class="no-image-thumb">
                                        <i class="fas fa-car"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($vehicle['name']); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo htmlspecialchars($vehicle['type']); ?></small>
                            </td>
                            <td>
                                <i class="fas fa-users me-1"></i><?php echo $vehicle['capacity']; ?> Seats
                            </td>
                            <td>
                                <strong class="text-success"><?php echo format_price($vehicle['price_per_km']); ?>/km</strong>
                                <br>
                                <small class="text-muted"><?php echo format_price($vehicle['price_per_day']); ?>/day</small>
                            </td>
                            <td class="text-center">
                                <a href="?toggle&id=<?php echo $vehicle['id']; ?>&status=<?php echo $vehicle['is_active']; ?>" 
                                   class="badge bg-<?php echo $vehicle['is_active'] ? 'success' : 'danger'; ?>">
                                    <?php echo $vehicle['is_active'] ? 'Available' : 'Unavailable'; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?php echo $vehicle['id']; ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $vehicle['id']; ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete this vehicle?')" 
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
                                <i class="fas fa-car fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No vehicles found. <a href="add.php">Add your first vehicle</a></p>
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
.vehicle-thumb {
    width: 100px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
    border: 2px solid #e9ecef;
}

.no-image-thumb {
    width: 100px;
    height: 70px;
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
