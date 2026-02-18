<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

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
    
    // Check slug uniqueness
    $check_query = "SELECT id FROM tour_packages WHERE slug = '$slug'";
    $check_result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($check_result) > 0) {
        $errors[] = "Slug already exists. Please use a different one.";
    }
    
    // Handle featured image upload
    $featured_image = '';
    if(!empty($_FILES['featured_image']['name'])) {
        $upload_result = upload_image($_FILES['featured_image'], 'packages');
        if($upload_result['success']) {
            $featured_image = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // Insert if no errors
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
        
        $insert_query = "INSERT INTO tour_packages (
            category_id, title, slug, duration_days, duration_nights, base_price, 
            short_description, description, featured_image, 
            inclusions, exclusions,
            meta_title, meta_description, meta_keywords,
            is_active, is_featured, created_at
        ) VALUES (
            $category_id, '$title', '$slug', $duration_days, $duration_nights, $base_price,
            '$short_description', '$description', '$featured_image',
            '$inclusions_text', '$exclusions_text',
            '$meta_title', '$meta_description', '$meta_keywords',
            $is_active, $is_featured, NOW()
        )";
        
        if(mysqli_query($conn, $insert_query)) {
            $package_id = mysqli_insert_id($conn);
            
            // Handle destinations
            if(isset($_POST['destinations']) && !empty($_POST['destinations'])) {
                foreach($_POST['destinations'] as $dest_id) {
                    $dest_id = intval($dest_id);
                    mysqli_query($conn, "INSERT INTO package_destinations (package_id, destination_id) VALUES ($package_id, $dest_id)");
                }
            }
            
            // Handle itinerary
            if(isset($_POST['itinerary_day']) && !empty($_POST['itinerary_day'])) {
                $days = $_POST['itinerary_day'];
                $titles = $_POST['itinerary_title'];
                $descriptions = $_POST['itinerary_description'];
                
                for($i = 0; $i < count($days); $i++) {
                    $day = intval($days[$i]);
                    $title = mysqli_real_escape_string($conn, trim($titles[$i]));
                    $desc = mysqli_real_escape_string($conn, trim($descriptions[$i]));
                    
                    if(!empty($title)) {
                        mysqli_query($conn, "INSERT INTO package_itinerary (package_id, day_number, title, description, display_order) 
                                           VALUES ($package_id, $day, '$title_val', '$desc', $day)");
                    }
                }
            }
            
            header('Location: index.php?msg=added');
            exit;
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

// Get categories
$categories_query = "SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order";
$categories = mysqli_query($conn, $categories_query);

// Get destinations
$destinations_query = "SELECT * FROM destinations WHERE is_active = 1 ORDER BY name";
$destinations = mysqli_query($conn, $destinations_query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Tour Package</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Packages</a></li>
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
                                       value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" 
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
                                                <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" 
                                   value="<?php echo isset($_POST['slug']) ? htmlspecialchars($_POST['slug']) : ''; ?>" 
                                   required>
                            <small class="text-muted">Auto-generated from title. Used in URL.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" class="form-control" 
                                       value="<?php echo isset($_POST['duration_days']) ? $_POST['duration_days'] : '3'; ?>" 
                                       min="1" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Duration (Nights) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_nights" class="form-control" 
                                       value="<?php echo isset($_POST['duration_nights']) ? $_POST['duration_nights'] : '2'; ?>" 
                                       min="0" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Base Price (₹)</label>
                                <input type="number" name="base_price" class="form-control" 
                                       value="<?php echo isset($_POST['base_price']) ? $_POST['base_price'] : ''; ?>" 
                                       step="0.01" min="0" placeholder="Optional">
                                <small class="text-muted">Leave empty if not applicable</small>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                                           <?php echo (isset($_POST['is_featured'])) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_featured">Featured Package</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2" 
                                      placeholder="Brief one-line description (shown in listings)"><?php echo isset($_POST['short_description']) ? htmlspecialchars($_POST['short_description']) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                       <?php echo (!isset($_POST['is_active']) || $_POST['is_active']) ? 'checked' : ''; ?>>
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
                                      placeholder="Detailed package description..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
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
                            <!-- Itinerary days will be added here -->
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
                                    <div class="input-group mb-2">
                                        <input type="text" name="inclusions[]" class="form-control" placeholder="What's included?">
                                    </div>
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
                                    <div class="input-group mb-2">
                                        <input type="text" name="exclusions[]" class="form-control" placeholder="What's not included?">
                                    </div>
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
                                           value="<?php echo $dest['id']; ?>" id="dest_<?php echo $dest['id']; ?>">
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
                            <label class="form-label">Featured Image <span class="text-danger">*</span></label>
                            <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                            <small class="text-muted">Main image shown in listings. Recommended: 1200x800px, Max 5MB.</small>
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
                                   value="<?php echo isset($_POST['meta_title']) ? htmlspecialchars($_POST['meta_title']) : ''; ?>" 
                                   placeholder="Leave empty to use package title">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" 
                                      placeholder="Brief description for search engines..."><?php echo isset($_POST['meta_description']) ? htmlspecialchars($_POST['meta_description']) : ''; ?></textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" 
                                   value="<?php echo isset($_POST['meta_keywords']) ? htmlspecialchars($_POST['meta_keywords']) : ''; ?>" 
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
                <i class="fas fa-save me-2"></i>Save Package
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div>
    </form>
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
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 400px;">';
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Add itinerary day
let itineraryDayCount = 0;
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
document.querySelector('input[name="duration_days"]').addEventListener('change', function() {
    const days = parseInt(this.value);
    if(days > 0 && days <= 30) {
        const container = document.getElementById('itineraryContainer');
        container.innerHTML = ''; // Clear existing
        itineraryDayCount = 0;
        
        for(let i = 0; i < days; i++) {
            addItineraryDay();
        }
        
        // Show success message
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
