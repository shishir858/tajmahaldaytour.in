<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// Get image ID
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Get image details
$query = "SELECT * FROM gallery_new WHERE id = $id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit;
}

$image = mysqli_fetch_assoc($result);

// Delete image file
if(!empty($image['image_path'])) {
    delete_image('../uploads/gallery/' . $image['image_path']);
}

// Delete from database
$delete_query = "DELETE FROM gallery_new WHERE id = $id";

if(mysqli_query($conn, $delete_query)) {
    header('Location: index.php?msg=deleted');
} else {
    header('Location: index.php?msg=error');
}
exit;
?>
