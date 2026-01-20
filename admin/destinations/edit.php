<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get destination ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get destination details
$query = "SELECT * FROM destinations WHERE id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$destination = mysqli_fetch_assoc($result);

$errors = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $slug = mysqli_real_escape_string($conn, trim($_POST['slug']));
    $state = mysqli_real_escape_string($conn, trim($_POST['state']));
    $country = mysqli_real_escape_string($conn, trim($_POST['country']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $display_order = intval($_POST['display_order']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Validation
    if(empty($name)) {
        $errors[] = "Destination name is required";
    }
    
    if(empty($slug)) {
        $slug = generate_slug($name);
    }
    
    // Check slug uniqueness (excluding current destination)
    $check_query = "SELECT id FROM destinations WHERE slug = '$slug' AND id != $id";
    $check_result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($check_result) > 0) {
        $errors[] = "Slug already exists. Please use a different one.";
    }
    
    // Handle image upload
    $image_name = $destination['image'];
    if(!empty($_FILES['image']['name'])) {
        $upload_result = upload_image($_FILES['image'], 'destinations');
        if($upload_result['success']) {
            // Delete old image if exists
            if(!empty($destination['image'])) {
                delete_image('../uploads/destinations/' . $destination['image']);
            }
            $image_name = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Update if no errors
    if(empty($errors)) {
        $update_query = "UPDATE destinations SET 
                        name = '$name',
                        slug = '$slug',
                        state = '$state',
                        country = '$country',
                        description = '$description',
                        image = '$image_name',
                        display_order = $display_order,
                        is_active = $is_active,
                        updated_at = NOW()
                        WHERE id = $id";
        
        if(mysqli_query($conn, $update_query)) {
            $success = true;
            // Refresh destination data
            $destination = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM destinations WHERE id = $id"));
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

// Get statistics
$package_count_query = "SELECT COUNT(*) as count FROM package_destinations WHERE destination_id = $id";
$package_count_result = mysqli_query($conn, $package_count_query);
$package_count = mysqli_fetch_assoc($package_count_result)['count'];

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Destination</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Destinations</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    if($success) {
        echo success_message('Destination updated successfully!');
    }
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
                    <h5 class="mb-0">Destination Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Destination Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" 
                                       value="<?php echo htmlspecialchars($destination['name']); ?>" 
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" class="form-control" 
                                       value="<?php echo $destination['display_order']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" 
                                   value="<?php echo htmlspecialchars($destination['slug']); ?>" 
                                   required>
                            <small class="text-muted">Used in URL.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" 
                                       value="<?php echo htmlspecialchars($destination['state']); ?>" 
                                       placeholder="e.g., Himachal Pradesh">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" 
                                       value="<?php echo htmlspecialchars($destination['country']); ?>" 
                                       placeholder="e.g., India">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" 
                                      placeholder="Brief description about this destination..."><?php echo htmlspecialchars($destination['description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destination Image</label>
                            <?php if(!empty($destination['image'])): ?>
                                <div class="mb-2">
                                    <img src="<?php echo SITE_URL . 'uploads/destinations/' . $destination['image']; ?>" 
                                         alt="Current Image" class="img-thumbnail" style="max-width: 300px;">
                                    <p class="text-muted small mt-1">Current image</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image. Recommended: 800x600px, Max 5MB.</small>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                       <?php echo $destination['is_active'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Destination
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
            <!-- Statistics -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Packages</span>
                            <span class="badge bg-primary"><?php echo $package_count; ?></span>
                        </div>
                    </div>
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Created</span>
                            <span class="small"><?php echo format_date($destination['created_at']); ?></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Last Updated</span>
                            <span class="small"><?php echo format_date($destination['updated_at']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="admin-card mt-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Once you delete this destination, there is no going back.</p>
                    <?php if($package_count > 0): ?>
                        <p class="text-warning small mb-3">
                            <i class="fas fa-warning me-1"></i>
                            This destination is used in <?php echo $package_count; ?> package(s).
                        </p>
                    <?php endif; ?>
                    <a href="delete.php?id=<?php echo $id; ?>" 
                       class="btn btn-danger btn-sm w-100" 
                       onclick="return confirm('Are you sure you want to delete this destination? This action cannot be undone.')">
                        <i class="fas fa-trash me-2"></i>Delete Destination
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<div class="mt-2"><strong>New image preview:</strong><br><img src="' + e.target.result + '" class="img-thumbnail mt-1" style="max-width: 300px;"></div>';
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
