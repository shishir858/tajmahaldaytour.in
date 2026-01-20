<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

$errors = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $display_order = intval($_POST['display_order']);
    
    // Handle multiple image uploads
    if(!empty($_FILES['images']['name'][0])) {
        $upload_count = 0;
        
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if(!empty($_FILES['images']['name'][$key])) {
                $file = [
                    'name' => $_FILES['images']['name'][$key],
                    'type' => $_FILES['images']['type'][$key],
                    'tmp_name' => $_FILES['images']['tmp_name'][$key],
                    'error' => $_FILES['images']['error'][$key],
                    'size' => $_FILES['images']['size'][$key]
                ];
                
                $upload_result = upload_image($file, 'gallery');
                
                if($upload_result['success']) {
                    $image_name = $upload_result['filename'];
                    $title = !empty($_POST['titles'][$key]) ? mysqli_real_escape_string($conn, trim($_POST['titles'][$key])) : 'Gallery Image';
                    
                    $insert_query = "INSERT INTO gallery_new (title, image_path, category, display_order, uploaded_at) 
                                    VALUES ('$title', '$image_name', '$category', $display_order, NOW())";
                    
                    if(mysqli_query($conn, $insert_query)) {
                        $upload_count++;
                    }
                } else {
                    $errors[] = "Failed to upload " . $_FILES['images']['name'][$key] . ": " . $upload_result['error'];
                }
            }
        }
        
        if($upload_count > 0) {
            header('Location: index.php?msg=added');
            exit;
        }
    } else {
        $errors[] = "Please select at least one image to upload";
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Upload Gallery Images</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Gallery</a></li>
                    <li class="breadcrumb-item active">Upload</li>
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
                    <h5 class="mb-0">Upload Images</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="galleryForm">
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" 
                                       placeholder="e.g., Golden Triangle, Himachal, Destinations">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" class="form-control" value="0" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Images <span class="text-danger">*</span></label>
                            <input type="file" name="images[]" id="images" class="form-control" 
                                   accept="image/*" multiple required>
                            <small class="text-muted">You can select multiple images. Max 5MB per image.</small>
                        </div>

                        <div id="imagePreviewContainer" class="mb-3"></div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload Images
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
            <!-- Tips -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Upload Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Use high-quality images</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Recommended: 1200x800px</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Max size: 5MB per image</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Supported: JPG, PNG, WEBP, GIF</li>
                        <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Select multiple at once</li>
                    </ul>
                </div>
            </div>

            <!-- Categories -->
            <div class="admin-card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Suggested Categories</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1">• Tour Packages</li>
                        <li class="mb-1">• Destinations</li>
                        <li class="mb-1">• Golden Triangle</li>
                        <li class="mb-1">• Himachal Tours</li>
                        <li class="mb-1">• Rajasthan Tours</li>
                        <li class="mb-1">• Pilgrimage</li>
                        <li class="mb-1">• Vehicles</li>
                        <li class="mb-0">• Hotels & Resorts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview with titles
document.getElementById('images').addEventListener('change', function(e) {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    
    const files = e.target.files;
    
    if(files.length > 0) {
        container.innerHTML = '<div class="alert alert-info"><strong>' + files.length + '</strong> image(s) selected</div>';
        
        for(let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item mb-3 p-3 border rounded';
                div.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label mb-1">Image Title (Optional)</label>
                            <input type="text" name="titles[]" class="form-control" 
                                   placeholder="Enter title for this image...">
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }
            
            reader.readAsDataURL(file);
        }
    }
});

// Auto-hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if(!alert.classList.contains('alert-info')) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    });
}, 5000);
</script>

<style>
.preview-item {
    background: #f8f9fa;
}
</style>

<?php include '../includes/footer.php'; ?>
