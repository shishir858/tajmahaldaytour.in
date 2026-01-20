<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

$errors = [];

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
    $image_name = '';
    if(!empty($_FILES['image']['name'])) {
        $upload_result = upload_image($_FILES['image'], 'vehicles');
        if($upload_result['success']) {
            $image_name = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Insert if no errors
    if(empty($errors)) {
        $insert_query = "INSERT INTO vehicles_new (
            name, type, capacity, price_per_km, price_per_day, 
            features, image, is_active, created_at
        ) VALUES (
            '$name', '$vehicle_type', $seating_capacity, $price_per_km, $price_per_day,
            '$features', '$image_name', $is_active, NOW()
        )";
        
        if(mysqli_query($conn, $insert_query)) {
            header('Location: index.php?msg=added');
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
            <h1 class="page-title">Add Vehicle</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Vehicles</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                   placeholder="e.g., Toyota Innova Crysta" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_type" class="form-control" list="vehicleTypes"
                                       value="<?php echo isset($_POST['vehicle_type']) ? htmlspecialchars($_POST['vehicle_type']) : ''; ?>" 
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
                                       value="<?php echo isset($_POST['seating_capacity']) ? $_POST['seating_capacity'] : ''; ?>" 
                                       min="2" max="50" placeholder="e.g., 7" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price per Kilometer (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price_per_km" class="form-control" 
                                       value="<?php echo isset($_POST['price_per_km']) ? $_POST['price_per_km'] : ''; ?>" 
                                       step="0.01" min="0" placeholder="e.g., 15" >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price per Day (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price_per_day" class="form-control" 
                                       value="<?php echo isset($_POST['price_per_day']) ? $_POST['price_per_day'] : ''; ?>" 
                                       step="0.01" min="0" placeholder="e.g., 2500" >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Features</label>
                            <textarea name="features" class="form-control" rows="3" 
                                      placeholder="AC, Music System, GPS, etc. (comma separated)"><?php echo isset($_POST['features']) ? htmlspecialchars($_POST['features']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" 
                                      placeholder="Brief description about the vehicle..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vehicle Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended size: 800x600px. Max 5MB.</small>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" 
                                       <?php echo (!isset($_POST['is_available']) || $_POST['is_available']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_available">Available for Booking</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Vehicle
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
            <!-- Quick Tips -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Quick Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Use clear vehicle names</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Add high-quality images</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Set competitive pricing</li>
                        <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>List all features</li>
                    </ul>
                </div>
            </div>

            <!-- Popular Vehicles -->
            <div class="admin-card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-car me-2"></i>Popular Vehicles</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><strong>Sedan:</strong> Swift Dzire, Honda City</li>
                        <li class="mb-2"><strong>SUV:</strong> Innova Crysta, Ertiga</li>
                        <li class="mb-2"><strong>Tempo:</strong> 12-seater, 17-seater</li>
                        <li class="mb-0"><strong>Luxury:</strong> Mercedes, BMW</li>
                    </ul>
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
