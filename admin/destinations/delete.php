<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get destination ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Check if destination has packages
$package_count_query = "SELECT COUNT(*) as count FROM package_destinations WHERE destination_id = $id";
$package_count_result = mysqli_query($conn, $package_count_query);
$package_count = mysqli_fetch_assoc($package_count_result)['count'];

if($package_count > 0) {
    // Cannot delete destination with packages
    header('Location: index.php?msg=cannot_delete');
    exit;
}

// Get destination image to delete
$image_query = "SELECT image FROM destinations WHERE id = $id";
$image_result = mysqli_query($conn, $image_query);
$destination = mysqli_fetch_assoc($image_result);

// Delete destination
$delete_query = "DELETE FROM destinations WHERE id = $id";

if(mysqli_query($conn, $delete_query)) {
    // Delete image file if exists
    if(!empty($destination['image'])) {
        delete_image('../uploads/destinations/' . $destination['image']);
    }
    header('Location: index.php?msg=deleted');
} else {
    header('Location: index.php?msg=error');
}
exit;
?>
