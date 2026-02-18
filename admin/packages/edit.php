<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get package ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get package details
$query = "SELECT * FROM tour_packages WHERE id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$package = mysqli_fetch_assoc($result);

$errors = [];
$success = false;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Basic Info
    $category_id = intval($_POST['category_id']);
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $slug = mysqli_real_escape_string($conn, trim($_POST['slug']));
    $duration_days = intval($_POST['duration_days']);
    $duration_nights = intval($_POST['duration_nights']);
    $base_price = !empty($_POST['base_price']) ? floatval($_POST['base_price']) : 0;
    $short_description = mysqli_real_escape_string($conn, trim($_POST['short_description']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // SEO
    $meta_title = mysqli_real_escape_string($conn, trim($_POST['meta_title']));
    $meta_description = mysqli_real_escape_string($conn, trim($_POST['meta_description']));
    $meta_keywords = mysqli_real_escape_string($conn, trim($_POST['meta_keywords']));
    
    // Validation
    if(empty($title)) {
        $errors[] = "Package title is required";
    }
    
    if($category_id == 0) {
        $errors[] = "Please select a category";
    }
    
    if(empty($slug)) {
        $slug = generate_slug($title);
    }
    
    // Check slug uniqueness (excluding current package)
    $check_query = "SELECT id FROM tour_packages WHERE slug = '$slug' AND id != $id";
    $check_result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($check_result) > 0) {
        $errors[] = "Slug already exists. Please use a different one.";
    }
    
    // Handle featured image upload
    $featured_image = $package['featured_image'];
    if(!empty($_FILES['featured_image']['name'])) {
        $upload_result = upload_image($_FILES['featured_image'], 'packages');
        if($upload_result['success']) {
            // Delete old image if exists
            if(!empty($package['featured_image'])) {
                delete_image('../uploads/packages/' . $package['featured_image']);
            }
            $featured_image = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Update if no errors
    if(empty($errors)) {
        // Prepare inclusions and exclusions text
        $inclusions_text = '';
        if(isset($_POST['inclusions']) && !empty($_POST['inclusions'])) {
            $inclusions = array_filter(array_map('trim', $_POST['inclusions']));
            $inclusions_text = implode("\n", $inclusions);
        }
        $inclusions_text = mysqli_real_escape_string($conn, $inclusions_text);
        
        $exclusions_text = '';
        if(isset($_POST['exclusions']) && !empty($_POST['exclusions'])) {
            $exclusions = array_filter(array_map('trim', $_POST['exclusions']));
            $exclusions_text = implode("\n", $exclusions);
        }
        $exclusions_text = mysqli_real_escape_string($conn, $exclusions_text);
        
        $update_query = "UPDATE tour_packages SET 
            category_id = $category_id,
            title = '$title',
            slug = '$slug',
            duration_days = $duration_days,
            duration_nights = $duration_nights,
            base_price = $base_price,
            short_description = '$short_description',
            description = '$description',
            featured_image = '$featured_image',
            inclusions = '$inclusions_text',
            exclusions = '$exclusions_text',
            meta_title = '$meta_title',
            meta_description = '$meta_description',
            meta_keywords = '$meta_keywords',
            is_active = $is_active,
            is_featured = $is_featured
            WHERE id = $id";
        
        if(mysqli_query($conn, $update_query)) {
            
            // Update destinations
            mysqli_query($conn, "DELETE FROM package_destinations WHERE package_id = $id");
            if(isset($_POST['destinations']) && !empty($_POST['destinations'])) {
                foreach($_POST['destinations'] as $dest_id) {
                    $dest_id = intval($dest_id);
                    mysqli_query($conn, "INSERT INTO package_destinations (package_id, destination_id) VALUES ($id, $dest_id)");
                }
            }
            
            // Update itinerary
            mysqli_query($conn, "DELETE FROM package_itinerary WHERE package_id = $id");
            if(isset($_POST['itinerary_day']) && !empty($_POST['itinerary_day'])) {
                $days = $_POST['itinerary_day'];
                $titles = $_POST['itinerary_title'];
                $descriptions = $_POST['itinerary_description'];
                
                for($i = 0; $i < count($days); $i++) {
                    $day = intval($days[$i]);
                    $title_val = mysqli_real_escape_string($conn, trim($titles[$i]));
                    $desc = mysqli_real_escape_string($conn, trim($descriptions[$i]));
                    
                    if(!empty($title_val)) {
                        mysqli_query($conn, "INSERT INTO package_itinerary (package_id, day_number, title, description) 
                                           VALUES ($id, $day, '$title_val', '$desc')");
                    }
                }
            }
            
            $success = true;
            // Refresh package data
            $package = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tour_packages WHERE id = $id"));
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

// Get existing itinerary
$itinerary_query = "SELECT * FROM package_itinerary WHERE package_id = $id ORDER BY day_number";
$itinerary_result = mysqli_query($conn, $itinerary_query);

// Get selected destinations
$package_destinations_query = "SELECT destination_id FROM package_destinations WHERE package_id = $id";
$package_destinations_result = mysqli_query($conn, $package_destinations_query);
$selected_destinations = [];
while($pd = mysqli_fetch_assoc($package_destinations_result)) {
    $selected_destinations[] = $pd['destination_id'];
}

// Parse inclusions and exclusions from package data (stored as text in tour_packages table)
$existing_inclusions = !empty($package['inclusions']) ? explode("\n", trim($package['inclusions'])) : [];
$existing_exclusions = !empty($package['exclusions']) ? explode("\n", trim($package['exclusions'])) : [];

// Get categories
$categories_query = "SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order";
$categories = mysqli_query($conn, $categories_query);

// Get destinations
$destinations_query = "SELECT * FROM destinations WHERE is_active = 1 ORDER BY name";
$destinations = mysqli_query($conn, $destinations_query);

// Get statistics
$booking_count_query = "SELECT COUNT(*) as count FROM bookings WHERE package_id = $id";
$booking_count_result = mysqli_query($conn, $booking_count_query);
$booking_count = mysqli_fetch_assoc($booking_count_result)['count'];

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tour Package</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Packages</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    if($success) {
        echo success_message('Package updated successfully!');
    }
    if(!empty($errors)) {
        foreach($errors as $error) {
            echo error_message($error);
        }
    }
    ?>

    <div class="row">
        <div class="col-lg-9">
            <form method="POST" enctype="multipart/form-data" id="packageForm">
                
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#basic">
                            <i class="fas fa-info-circle me-2"></i>Basic Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#description">
                            <i class="fas fa-align-left me-2"></i>Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#itinerary">
                            <i class="fas fa-list-ol me-2"></i>Itinerary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#inclusions">
                            <i class="fas fa-check-circle me-2"></i>Inclusions/Exclusions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#destinations">
                            <i class="fas fa-map-marker-alt me-2"></i>Destinations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#media">
                            <i class="fas fa-image me-2"></i>Media
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#seo">
                            <i class="fas fa-search me-2"></i>SEO
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic">
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Package Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" 
                                               value="<?php echo htmlspecialchars($package['title']); ?>" 
                                               required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="0">Select Category</option>
                                            <?php 
                                            mysqli_data_seek($categories, 0);
                                            while($cat = mysqli_fetch_assoc($categories)): 
                                            ?>
                                                <option value="<?php echo $cat['id']; ?>" 
                                                        <?php echo $package['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($cat['name']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control" 
                                           value="<?php echo htmlspecialchars($package['slug']); ?>" 
                                           required>
                                    <small class="text-muted">Used in URL.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                        <input type="number" name="duration_days" id="duration_days" class="form-control" 
                                               value="<?php echo $package['duration_days']; ?>" 
                                               min="1" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Duration (Nights) <span class="text-danger">*</span></label>
                                        <input type="number" name="duration_nights" class="form-control" 
                                               value="<?php echo $package['duration_nights']; ?>" 
                                               min="0" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Base Price (₹)</label>
                                        <input type="number" name="base_price" class="form-control" 
                                               value="<?php echo $package['base_price']; ?>" 
                                               step="0.01" min="0" placeholder="Optional">
                                        <small class="text-muted">Leave empty if not applicable</small>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                                                   <?php echo $package['is_featured'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_featured">Featured Package</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="2" 
                                              placeholder="Brief one-line description (shown in listings)"><?php echo htmlspecialchars($package['short_description'] ?? ''); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                               <?php echo $package['is_active'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Tab -->
                    <div class="tab-pane fade" id="description">
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0">Package Description</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Full Description</label>
                                    <textarea name="description" class="form-control" rows="10" 
                                              placeholder="Detailed package description..."><?php echo htmlspecialchars($package['description']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Itinerary Tab -->
                    <div class="tab-pane fade" id="itinerary">
                        <div class="admin-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Day-wise Itinerary</h5>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addItineraryDay()">
                                    <i class="fas fa-plus me-2"></i>Add Day
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="itineraryContainer">
                                    <?php 
                                    $day_count = 0;
                                    while($itin = mysqli_fetch_assoc($itinerary_result)): 
                                        $day_count++;
                                    ?>
                                    <div class="itinerary-day mb-3 p-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Day <?php echo $itin['day_number']; ?></h6>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="itinerary_day[]" value="<?php echo $itin['day_number']; ?>">
                                        <div class="mb-2">
                                            <input type="text" name="itinerary_title[]" class="form-control" 
                                                   value="<?php echo htmlspecialchars($itin['title']); ?>" 
                                                   placeholder="Day title (e.g., Arrival in Delhi)">
                                        </div>
                                        <div>
                                            <textarea name="itinerary_description[]" class="form-control" rows="3" 
                                                      placeholder="Day description..."><?php echo htmlspecialchars($itin['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inclusions/Exclusions Tab -->
                    <div class="tab-pane fade" id="inclusions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="admin-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Inclusions</h5>
                                        <button type="button" class="btn btn-sm btn-success" onclick="addInclusion()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="inclusionsContainer">
                                            <?php 
                                            if(!empty($existing_inclusions)):
                                                foreach($existing_inclusions as $inc): 
                                                    if(trim($inc)):
                                            ?>
                                            <div class="input-group mb-2">
                                                <input type="text" name="inclusions[]" class="form-control" 
                                                       value="<?php echo htmlspecialchars(trim($inc)); ?>">
                                                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <?php 
                                                    endif;
                                                endforeach;
                                            else: 
                                            ?>
                                            <div class="input-group mb-2">
                                                <input type="text" name="inclusions[]" class="form-control" placeholder="What's included?">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="admin-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Exclusions</h5>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="addExclusion()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="exclusionsContainer">
                                            <?php 
                                            if(!empty($existing_exclusions)):
                                                foreach($existing_exclusions as $exc): 
                                                    if(trim($exc)):
                                            ?>
                                            <div class="input-group mb-2">
                                                <input type="text" name="exclusions[]" class="form-control" 
                                                       value="<?php echo htmlspecialchars(trim($exc)); ?>">
                                                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <?php 
                                                    endif;
                                                endforeach;
                                            else: 
                                            ?>
                                            <div class="input-group mb-2">
                                                <input type="text" name="exclusions[]" class="form-control" placeholder="What's not included?">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Destinations Tab -->
                    <div class="tab-pane fade" id="destinations">
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0">Package Destinations</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Select destinations covered in this package:</p>
                                <div class="row">
                                    <?php 
                                    mysqli_data_seek($destinations, 0);
                                    while($dest = mysqli_fetch_assoc($destinations)): 
                                    ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="destinations[]" class="form-check-input" 
                                                   value="<?php echo $dest['id']; ?>" id="dest_<?php echo $dest['id']; ?>"
                                                   <?php echo in_array($dest['id'], $selected_destinations) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="dest_<?php echo $dest['id']; ?>">
                                                <?php echo htmlspecialchars($dest['name']); ?>
                                                <?php if(!empty($dest['state'])): ?>
                                                    <small class="text-muted">(<?php echo htmlspecialchars($dest['state']); ?>)</small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Tab -->
                    <div class="tab-pane fade" id="media">
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0">Package Images</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    <?php if(!empty($package['featured_image'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo SITE_URL . 'uploads/packages/' . $package['featured_image']; ?>" 
                                                 alt="Current Image" class="img-thumbnail" style="max-width: 400px;">
                                            <p class="text-muted small mt-1">Current image</p>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Leave empty to keep current image. Recommended: 1200x800px, Max 5MB.</small>
                                    <div id="featuredImagePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div class="tab-pane fade" id="seo">
                        <div class="admin-card">
                            <div class="card-header">
                                <h5 class="mb-0">SEO Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" 
                                           value="<?php echo htmlspecialchars($package['meta_title']); ?>" 
                                           placeholder="Leave empty to use package title">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="3" 
                                              placeholder="Brief description for search engines..."><?php echo htmlspecialchars($package['meta_description']); ?></textarea>
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control" 
                                           value="<?php echo htmlspecialchars($package['meta_keywords']); ?>" 
                                           placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Comma separated keywords</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Package
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="col-lg-3">
            <!-- Statistics -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Bookings</span>
                            <span class="badge bg-primary"><?php echo $booking_count; ?></span>
                        </div>
                    </div>
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Created</span>
                            <span class="small"><?php echo format_date($package['created_at']); ?></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Views</span>
                            <span class="badge bg-info"><?php echo $package['views']; ?></span>
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
                    <p class="text-muted small mb-3">Once you delete this package, there is no going back.</p>
                    <?php if($booking_count > 0): ?>
                        <p class="text-warning small mb-3">
                            <i class="fas fa-warning me-1"></i>
                            This package has <?php echo $booking_count; ?> booking(s).
                        </p>
                    <?php endif; ?>
                    <a href="delete.php?id=<?php echo $id; ?>" 
                       class="btn btn-danger btn-sm w-100" 
                       onclick="return confirm('Are you sure you want to delete this package? This action cannot be undone.')">
                        <i class="fas fa-trash me-2"></i>Delete Package
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Featured image preview
document.getElementById('featured_image').addEventListener('change', function(e) {
    const preview = document.getElementById('featuredImagePreview');
    const file = e.target.files[0];
    
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<div class="mt-2"><strong>New image preview:</strong><br><img src="' + e.target.result + '" class="img-thumbnail mt-1" style="max-width: 400px;"></div>';
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Add itinerary day
let itineraryDayCount = <?php echo $day_count; ?>;
function addItineraryDay() {
    itineraryDayCount++;
    const container = document.getElementById('itineraryContainer');
    const div = document.createElement('div');
    div.className = 'itinerary-day mb-3 p-3 border rounded';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Day ${itineraryDayCount}</h6>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <input type="hidden" name="itinerary_day[]" value="${itineraryDayCount}">
        <div class="mb-2">
            <input type="text" name="itinerary_title[]" class="form-control" placeholder="Day title (e.g., Arrival in Delhi)">
        </div>
        <div>
            <textarea name="itinerary_description[]" class="form-control" rows="3" placeholder="Day description..."></textarea>
        </div>
    `;
    container.appendChild(div);
}

// Auto-generate itinerary days based on duration
document.getElementById('duration_days').addEventListener('change', function() {
    const days = parseInt(this.value);
    const currentDays = document.querySelectorAll('#itineraryContainer .itinerary-day').length;
    
    if(days > 0 && days <= 30 && days > currentDays) {
        for(let i = currentDays; i < days; i++) {
            addItineraryDay();
        }
        
        const itineraryTab = document.querySelector('a[href="#itinerary"]');
        itineraryTab.classList.add('text-success');
        setTimeout(() => {
            itineraryTab.classList.remove('text-success');
        }, 2000);
    }
});

// Add inclusion
function addInclusion() {
    const container = document.getElementById('inclusionsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="inclusions[]" class="form-control" placeholder="What's included?">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

// Add exclusion
function addExclusion() {
    const container = document.getElementById('exclusionsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="exclusions[]" class="form-control" placeholder="What's not included?">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

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

<style>
.nav-tabs .nav-link {
    color: #6c757d;
}
.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-color: #dee2e6 #dee2e6 #fff;
}
.itinerary-day {
    background: #f8f9fa;
}
</style>

<?php include '../includes/footer.php'; ?>
