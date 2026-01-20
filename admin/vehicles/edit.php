<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get vehicle ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$vehicle_id = intval($_GET['id']);
$errors = [];

// Fetch vehicle details
$query = "SELECT * FROM vehicles_new WHERE id = $vehicle_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$vehicle = mysqli_fetch_assoc($result);

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $vehicle_type = mysqli_real_escape_string($conn, trim($_POST['vehicle_type']));
    $seating_capacity = intval($_POST['seating_capacity']);
    $price_per_km = floatval($_POST['price_per_km']);
    $price_per_day = floatval($_POST['price_per_day']);
    $features = mysqli_real_escape_string($conn, trim($_POST['features']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $is_active = isset($_POST['is_available']) ? 1 : 0;
    
    // Validation
    if(empty($name)) {
        $errors[] = "Vehicle name is required";
    }
    
    // Handle image upload
    $image_name = $vehicle['image'];
    if(!empty($_FILES['image']['name'])) {
        $upload_result = upload_image($_FILES['image'], 'vehicles');
        if($upload_result['success']) {
            // Delete old image
            if(!empty($vehicle['image'])) {
                delete_image('../uploads/vehicles/' . $vehicle['image']);
            }
            $image_name = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Update if no errors
    if(empty($errors)) {
        $update_query = "UPDATE vehicles_new SET
            name = '$name',
            type = '$vehicle_type',
            capacity = $seating_capacity,
            price_per_km = $price_per_km,
            price_per_day = $price_per_day,
            features = '$features',
            image = '$image_name',
            is_active = $is_active
        WHERE id = $vehicle_id";
        
        if(mysqli_query($conn, $update_query)) {
            header('Location: index.php?msg=updated');
            exit;
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Vehicle</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Vehicles</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    if(!empty($errors)) {
        foreach($errors as $error) {
            echo error_message($error);
        }
    }
    ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Vehicle Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($vehicle['name']); ?>" 
                                   placeholder="e.g., Toyota Innova Crysta" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_type" class="form-control" list="vehicleTypes"
                                       value="<?php echo htmlspecialchars($vehicle['type']); ?>" 
                                       placeholder="e.g., Sedan, SUV, Luxury Car" required>
                                <datalist id="vehicleTypes">
                                    <option value="Sedan">
                                    <option value="SUV">
                                    <option value="MUV">
                                    <option value="Luxury Car">
                                    <option value="Tempo Traveller">
                                    <option value="Bus">
                                    <option value="Mini Bus">
                                </datalist>
                                <small class="text-muted">Type to enter custom vehicle type or select from suggestions</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Seating Capacity <span class="text-danger">*</span></label>
                                <input type="number" name="seating_capacity" class="form-control" 
                                       value="<?php echo $vehicle['capacity']; ?>" 
                                       min="2" max="50" placeholder="e.g., 7" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price per Kilometer (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price_per_km" class="form-control" 
                                       value="<?php echo $vehicle['price_per_km']; ?>" 
                                       step="0.01" min="0" placeholder="e.g., 15" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price per Day (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price_per_day" class="form-control" 
                                       value="<?php echo $vehicle['price_per_day']; ?>" 
                                       step="0.01" min="0" placeholder="e.g., 2500" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Features</label>
                            <textarea name="features" class="form-control" rows="3" 
                                      placeholder="AC, Music System, GPS, etc. (comma separated)"><?php echo htmlspecialchars($vehicle['features']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" 
                                      placeholder="Brief description about the vehicle..."><?php echo htmlspecialchars($vehicle['description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vehicle Image</label>
                            
                            <?php if(!empty($vehicle['image'])): ?>
                            <div class="mb-2">
                                <img src="../uploads/vehicles/<?php echo $vehicle['image']; ?>" 
                                     class="img-thumbnail" style="max-width: 300px;">
                            </div>
                            <small class="text-muted d-block mb-2">Current image (upload new to replace)</small>
                            <?php endif; ?>
                            
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended size: 800x600px. Max 5MB.</small>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" 
                                       <?php echo ($vehicle['is_available'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_available">Available for Booking</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Vehicle
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Vehicle Stats -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Vehicle Statistics</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">Created On:</small><br>
                            <strong><?php echo date('d M Y, h:i A', strtotime($vehicle['created_at'])); ?></strong>
                        </li>
                        <li class="mb-0">
                            <small class="text-muted">Status:</small><br>
                            <?php if($vehicle['is_active'] == 1): ?>
                                <span class="badge bg-success">Available</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Unavailable</span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="admin-card mt-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">Delete this vehicle permanently. This action cannot be undone.</p>
                    <a href="delete.php?id=<?php echo $vehicle['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this vehicle?')">
                        <i class="fas fa-trash me-2"></i>Delete Vehicle
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 300px;">';
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

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
