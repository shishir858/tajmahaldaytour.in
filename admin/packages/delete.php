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

// Check if package has bookings
$booking_count_query = "SELECT COUNT(*) as count FROM bookings WHERE package_id = ?";
$stmt = mysqli_prepare($conn, $booking_count_query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$booking_count_result = mysqli_stmt_get_result($stmt);
$booking_count = mysqli_fetch_assoc($booking_count_result)['count'];
mysqli_stmt_close($stmt);

if($booking_count > 0) {
    // Cannot delete package with bookings
    header('Location: index.php?msg=cannot_delete');
    exit;
}

// Get package image to delete
$image_query = "SELECT featured_image FROM tour_packages WHERE id = ?";
$stmt = mysqli_prepare($conn, $image_query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$image_result = mysqli_stmt_get_result($stmt);
$package = mysqli_fetch_assoc($image_result);
mysqli_stmt_close($stmt);

// Delete related data first
$stmt = mysqli_prepare($conn, "DELETE FROM package_destinations WHERE package_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "DELETE FROM package_itinerary WHERE package_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "DELETE FROM package_pricing WHERE package_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Delete package
$delete_query = "DELETE FROM tour_packages WHERE id = ?";
$stmt = mysqli_prepare($conn, $delete_query);
mysqli_stmt_bind_param($stmt, "i", $id);

if(mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    // Delete image file if exists
    if(!empty($package['featured_image'])) {
        delete_image('../uploads/packages/' . $package['featured_image']);
    }
    header('Location: index.php?msg=deleted');
} else {
    mysqli_stmt_close($stmt);
    header('Location: index.php?msg=error');
}
exit;
?>
