<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

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
    
    // Check slug uniqueness
    $check_query = "SELECT id FROM destinations WHERE slug = '$slug'";
    $check_result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($check_result) > 0) {
        $errors[] = "Slug already exists. Please use a different one.";
    }
    
    // Handle image upload
    $image_name = '';
    if(!empty($_FILES['image']['name'])) {
        $upload_result = upload_image($_FILES['image'], 'destinations');
        if($upload_result['success']) {
            $image_name = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Insert if no errors
    if(empty($errors)) {
        $insert_query = "INSERT INTO destinations (name, slug, state, country, description, image, display_order, is_active, created_at, updated_at) 
                        VALUES ('$name', '$slug', '$state', '$country', '$description', '$image_name', $display_order, $is_active, NOW(), NOW())";
        
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
            <h1 class="page-title">Add Destination</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Destinations</a></li>
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
                    <h5 class="mb-0">Destination Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Destination Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" 
                                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" class="form-control" 
                                       value="<?php echo isset($_POST['display_order']) ? $_POST['display_order'] : 0; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" 
                                   value="<?php echo isset($_POST['slug']) ? htmlspecialchars($_POST['slug']) : ''; ?>" 
                                   required>
                            <small class="text-muted">Auto-generated from name. Used in URL.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" 
                                       value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>" 
                                       placeholder="e.g., Himachal Pradesh">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" 
                                       value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : 'India'; ?>" 
                                       placeholder="e.g., India">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" 
                                      placeholder="Brief description about this destination..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destination Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended size: 800x600px. Max 5MB.</small>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                       <?php echo (!isset($_POST['is_active']) || $_POST['is_active']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Destination
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
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Use descriptive names</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Add high-quality images</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Include state/country</li>
                        <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Write helpful descriptions</li>
                    </ul>
                </div>
            </div>

            <!-- Examples -->
            <div class="admin-card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Popular Destinations</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><strong>Shimla</strong> - Himachal Pradesh</li>
                        <li class="mb-2"><strong>Manali</strong> - Himachal Pradesh</li>
                        <li class="mb-2"><strong>Jaipur</strong> - Rajasthan</li>
                        <li class="mb-2"><strong>Agra</strong> - Uttar Pradesh</li>
                        <li class="mb-0"><strong>Delhi</strong> - Delhi</li>
                    </ul>
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
