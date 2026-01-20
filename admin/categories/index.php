<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

$page_title = 'Categories';

// Handle status toggle
if(isset($_GET['toggle']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'] == '1' ? 0 : 1;
    mysqli_query($conn, "UPDATE categories SET is_active = $status WHERE id = $id");
    header('Location: index.php?msg=status_updated');
    exit;
}

// Get all categories
$query = "SELECT * FROM categories ORDER BY display_order ASC, id DESC";
$categories = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-folder"></i> Categories</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </nav>
        </div>
        <a href="add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] == 'added'): ?>
        <?php echo success_message('Category added successfully!'); ?>
    <?php elseif($_GET['msg'] == 'updated'): ?>
        <?php echo success_message('Category updated successfully!'); ?>
    <?php elseif($_GET['msg'] == 'deleted'): ?>
        <?php echo success_message('Category deleted successfully!'); ?>
    <?php elseif($_GET['msg'] == 'status_updated'): ?>
        <?php echo success_message('Status updated successfully!'); ?>
    <?php endif; ?>
<?php endif; ?>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="80">Order</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th width="120">Packages</th>
                    <th width="100">Status</th>
                    <th width="100">Header Menu</th>
                    <th width="80">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($categories) > 0): ?>
                    <?php while($category = mysqli_fetch_assoc($categories)): ?>
                        <?php
                        // Count packages in this category
                        $package_count_query = "SELECT COUNT(*) as count FROM tour_packages WHERE category_id = {$category['id']}";
                        $package_count_result = mysqli_query($conn, $package_count_query);
                        $package_count = mysqli_fetch_assoc($package_count_result)['count'];
                        ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary"><?php echo $category['display_order']; ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($category['icon']): ?>
                                        <i class="<?php echo $category['icon']; ?> me-2 text-primary" style="font-size: 20px;"></i>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?php echo $category['name']; ?></strong>
                                        <?php if($category['description']): ?>
                                            <br><small class="text-muted"><?php echo substr($category['description'], 0, 60); ?>...</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code><?php echo $category['slug']; ?></code>
                            </td>
                            <td>
                                <span class="badge bg-info"><?php echo $package_count; ?> packages</span>
                            </td>
                            <td>
                                <a href="?toggle&id=<?php echo $category['id']; ?>&status=<?php echo $category['is_active']; ?>" 
                                   class="badge <?php echo $category['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                    <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                </a>
                            </td>
                            <td>
                                <?php if($category['show_in_header']): ?>
                                    <span class="badge bg-primary" title="Visible in header navigation">
                                        <i class="fas fa-check"></i> In Header
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark" title="Not shown in header">
                                        <i class="fas fa-times"></i> Hidden
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="edit.php?id=<?php echo $category['id']; ?>" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $category['id']; ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirmDelete('Delete this category? All packages will remain but need reassignment.')"
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No categories found. <a href="add.php">Add your first category</a></p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
