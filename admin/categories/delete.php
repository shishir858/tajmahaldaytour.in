<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get category ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Check if category has packages
$package_count_query = "SELECT COUNT(*) as count FROM tour_packages WHERE category_id = $id";
$package_count_result = mysqli_query($conn, $package_count_query);
$package_count = mysqli_fetch_assoc($package_count_result)['count'];

if($package_count > 0) {
    // Cannot delete category with packages
    header('Location: index.php?msg=cannot_delete');
    exit;
}

// Delete category
$delete_query = "DELETE FROM categories WHERE id = $id";

if(mysqli_query($conn, $delete_query)) {
    header('Location: index.php?msg=deleted');
} else {
    header('Location: index.php?msg=error');
}
exit;
?>
