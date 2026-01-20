<?php
// Tour Packages listing page for tajmahaldaytour
include 'includes/config.php';
$page_title = 'Tour Packages - tajmahaldaytour';
include 'includes/header.php';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
$where = $category_id ? "WHERE is_active = 1 AND category_id = $category_id" : "WHERE is_active = 1";
$result = $conn->query("SELECT * FROM tour_packages $where ORDER BY display_order");
?>

<section class="py-5" style="margin: 100px 0;">
    <div class="container">
        <h1 class="mb-4" style="color:#dc3545; font-family: 'Playfair Display', Georgia, serif;">Tour Packages</h1>
        <div class="row">
            <?php while($pkg = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="uploads/packages/<?php echo $pkg['image'] ?? 'default.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pkg['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: 'Playfair Display', Georgia, serif; color:#28a745;"><?php echo htmlspecialchars($pkg['title']); ?></h5>
                        <p class="card-text"><?php echo substr(strip_tags($pkg['description']),0,100); ?>...</p>
                        <a href="<?php echo SITE_URL; ?>package/<?php echo $pkg['slug'] ?: $pkg['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
