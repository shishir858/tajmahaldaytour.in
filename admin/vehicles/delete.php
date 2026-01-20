<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get vehicle ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$vehicle_id = intval($_GET['id']);

// Fetch vehicle details
$query = "SELECT * FROM vehicles_new WHERE id = $vehicle_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$vehicle = mysqli_fetch_assoc($result);

// Delete image file if exists
if(!empty($vehicle['image'])) {
    delete_image('../uploads/vehicles/' . $vehicle['image']);
}

// Delete vehicle from database
$delete_query = "DELETE FROM vehicles_new WHERE id = $vehicle_id";

if(mysqli_query($conn, $delete_query)) {
    header('Location: index.php?msg=deleted');
} else {
    header('Location: index.php?error=delete_failed');
}
exit;
?>
