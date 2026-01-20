<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get all gallery images
$query = "SELECT * FROM gallery_new ORDER BY display_order ASC, created_at DESC";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gallery Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Gallery</li>
                </ol>
            </nav>
        </div>
        <div class="page-actions">
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Images
            </a>
        </div>
    </div>

    <?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        if($msg == 'added') {
            echo success_message('Images uploaded successfully!');
        } elseif($msg == 'deleted') {
            echo success_message('Image deleted successfully!');
        }
    }
    ?>

    <div class="admin-card">
        <div class="card-body">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <div class="row g-3">
                    <?php while($image = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-3">
                        <div class="gallery-item">
                            <div class="gallery-image">
                                <img src="<?php echo SITE_URL . 'uploads/gallery/' . $image['image_path']; ?>" 
                                     alt="<?php echo htmlspecialchars($image['title']); ?>" 
                                     class="img-fluid">
                                <div class="gallery-overlay">
                                    <a href="<?php echo SITE_URL . 'uploads/gallery/' . $image['image_path']; ?>" 
                                       target="_blank" class="btn btn-sm btn-light me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $image['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="gallery-info p-2">
                                <h6 class="mb-1"><?php echo htmlspecialchars($image['title']); ?></h6>
                                <?php if(!empty($image['category'])): ?>
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($image['category']); ?></span>
                                <?php endif; ?>
                                <small class="text-muted d-block mt-1">Order: <?php echo $image['display_order']; ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No images in gallery. <a href="add.php">Upload your first images</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.gallery-item {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.gallery-image {
    position: relative;
    overflow: hidden;
    height: 200px;
    background: #f8f9fa;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-info {
    background: white;
}

.gallery-info h6 {
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<?php include '../includes/footer.php'; ?>
