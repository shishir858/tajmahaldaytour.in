<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

$page_title = 'Add Category';
$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = generate_slug($_POST['slug'] ?: $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $display_order = intval($_POST['display_order']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $show_in_header = isset($_POST['show_in_header']) ? 1 : 0;
    
    // Check if slug already exists
    $check_query = "SELECT id FROM categories WHERE slug = '$slug'";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $error = 'Slug already exists. Please use a different name or slug.';
    } else {
        $query = "INSERT INTO categories (name, slug, description, icon, display_order, is_active, show_in_header) 
                  VALUES ('$name', '$slug', '$description', '$icon', $display_order, $is_active, $show_in_header)";
        
        if(mysqli_query($conn, $query)) {
            header('Location: index.php?msg=added');
            exit;
        } else {
            $error = 'Error adding category: ' . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-plus-circle"></i> Add Category</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Categories</a></li>
                    <li class="breadcrumb-item active">Add</li>
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
                           placeholder="e.g., Golden Triangle Tours"
                           value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                    <small class="text-muted">Main category name displayed on website</small>
                </div>
                
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="slug" name="slug" 
                           placeholder="e.g., golden-triangle-tours (auto-generated if left empty)"
                           value="<?php echo isset($_POST['slug']) ? $_POST['slug'] : ''; ?>">
                    <small class="text-muted">URL-friendly version (lowercase, hyphens only). Leave empty to auto-generate.</small>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" 
                              placeholder="Brief description of this category"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                    <small class="text-muted">Short description for SEO and display purposes</small>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon (Font Awesome)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i id="iconPreview" class="fas fa-folder"></i>
                            </span>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   placeholder="e.g., fas fa-mountain"
                                   value="<?php echo isset($_POST['icon']) ? $_POST['icon'] : ''; ?>">
                        </div>
                        <small class="text-muted">
                            <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                        </small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="<?php echo isset($_POST['display_order']) ? $_POST['display_order'] : '0'; ?>"
                               min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               <?php echo (isset($_POST['is_active']) || !isset($_POST['name'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">
                            Active (visible on website)
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_in_header" name="show_in_header" 
                               <?php echo (isset($_POST['show_in_header']) || !isset($_POST['name'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="show_in_header">
                            <i class="fas fa-bars me-1"></i> Show in Header Menu
                        </label>
                        <small class="d-block text-muted mt-1">Display this category in the header navigation dropdown</small>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Category
                    </button>
                    <a href="index.php" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="admin-card">
            <h3>Quick Tips</h3>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="fas fa-check text-success"></i> Use clear, descriptive names</li>
                <li class="mb-2"><i class="fas fa-check text-success"></i> Slug will auto-generate from name</li>
                <li class="mb-2"><i class="fas fa-check text-success"></i> Icon is optional but recommended</li>
                <li class="mb-2"><i class="fas fa-check text-success"></i> Set display order to control positioning</li>
            </ul>
        </div>
        
        <div class="admin-card">
            <h3>Examples</h3>
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td><i class="fas fa-mountain text-primary"></i></td>
                        <td><code>fas fa-mountain</code></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-umbrella-beach text-info"></i></td>
                        <td><code>fas fa-umbrella-beach</code></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-plane text-danger"></i></td>
                        <td><code>fas fa-plane</code></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-hiking text-success"></i></td>
                        <td><code>fas fa-hiking</code></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$custom_js = "
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Icon preview
document.getElementById('icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('iconPreview');
    iconPreview.className = this.value || 'fas fa-folder';
});
";
include '../includes/footer.php'; 
?>
