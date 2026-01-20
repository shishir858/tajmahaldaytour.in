<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

$page_title = 'Edit Category';
$error = '';

// Get category ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get category data
$query = "SELECT * FROM categories WHERE id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$category = mysqli_fetch_assoc($result);

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = generate_slug($_POST['slug'] ?: $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $display_order = intval($_POST['display_order']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $show_in_header = isset($_POST['show_in_header']) ? 1 : 0;
    
    // Check if slug already exists (excluding current category)
    $check_query = "SELECT id FROM categories WHERE slug = '$slug' AND id != $id";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $error = 'Slug already exists. Please use a different name or slug.';
    } else {
        $update_query = "UPDATE categories SET 
                         name = '$name',
                         slug = '$slug',
                         description = '$description',
                         icon = '$icon',
                         display_order = $display_order,
                         is_active = $is_active,
                         show_in_header = $show_in_header
                         WHERE id = $id";
        
        if(mysqli_query($conn, $update_query)) {
            header('Location: index.php?msg=updated');
            exit;
        } else {
            $error = 'Error updating category: ' . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-edit"></i> Edit Category</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Categories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<?php if($error): ?>
    <?php echo error_message($error); ?>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <h2>Category Information</h2>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required 
                           value="<?php echo $category['name']; ?>">
                </div>
                
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" 
                           value="<?php echo $category['slug']; ?>">
                    <small class="text-muted">URL-friendly version (lowercase, hyphens only)</small>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $category['description']; ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon (Font Awesome)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i id="iconPreview" class="<?php echo $category['icon'] ?: 'fas fa-folder'; ?>"></i>
                            </span>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   value="<?php echo $category['icon']; ?>">
                        </div>
                        <small class="text-muted">
                            <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                        </small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="<?php echo $category['display_order']; ?>" min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               <?php echo $category['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">
                            Active (visible on website)
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_in_header" name="show_in_header" 
                               <?php echo $category['show_in_header'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="show_in_header">
                            <i class="fas fa-bars me-1"></i> Show in Header Menu
                        </label>
                        <small class="d-block text-muted mt-1">Display this category in the header navigation dropdown</small>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Category
                    </button>
                    <a href="index.php" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="admin-card">
            <h3>Category Stats</h3>
            <?php
            // Get package count
            $package_count_query = "SELECT COUNT(*) as count FROM tour_packages WHERE category_id = $id";
            $package_count_result = mysqli_query($conn, $package_count_query);
            $package_count = mysqli_fetch_assoc($package_count_result)['count'];
            ?>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between">
                    <span><i class="fas fa-box"></i> Total Packages</span>
                    <span class="badge bg-primary"><?php echo $package_count; ?></span>
                </div>
                <div class="list-group-item d-flex justify-content-between">
                    <span><i class="fas fa-calendar"></i> Created</span>
                    <span><?php echo format_date($category['created_at']); ?></span>
                </div>
                <div class="list-group-item d-flex justify-content-between">
                    <span><i class="fas fa-clock"></i> Updated</span>
                    <span><?php echo format_date($category['updated_at']); ?></span>
                </div>
            </div>
        </div>
        
        <div class="admin-card">
            <h3>Danger Zone</h3>
            <p class="text-muted small">Deleting this category will require reassigning all packages.</p>
            <a href="delete.php?id=<?php echo $id; ?>" 
               class="btn btn-danger btn-sm w-100"
               onclick="return confirmDelete('Delete this category? All packages will remain but need reassignment.')">
                <i class="fas fa-trash"></i> Delete Category
            </a>
        </div>
    </div>
</div>

<?php 
$custom_js = "
// Icon preview
document.getElementById('icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('iconPreview');
    iconPreview.className = this.value || 'fas fa-folder';
});
";
include '../includes/footer.php'; 
?>
