<?php
/**
 * Common Functions for Admin Panel
 */

// Check if user is logged in
function check_login() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

// Generate unique slug from title
function generate_slug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

// Upload image function
function upload_image($file, $folder = 'packages') {
    $target_dir = UPLOAD_PATH . $folder . '/';
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is actual image
    $check = getimagesize($file['tmp_name']);
    if($check === false) {
        return ['success' => false, 'message' => 'File is not an image.'];
    }
    
    // Check file size (5MB max)
    if ($file['size'] > 5000000) {
        return ['success' => false, 'message' => 'File is too large. Max 5MB allowed.'];
    }
    
    // Allow certain file formats
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if(!in_array($file_extension, $allowed)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG, GIF & WEBP files are allowed.'];
    }
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => true, 'filename' => $new_filename, 'path' => $folder . '/' . $new_filename];
    } else {
        return ['success' => false, 'message' => 'Error uploading file.'];
    }
}

// Delete image function
function delete_image($path) {
    $file = UPLOAD_PATH . $path;
    if (file_exists($file)) {
        unlink($file);
        return true;
    }
    return false;
}

// Format price
function format_price($price) {
    return '₹' . number_format($price, 0);
}

// Format date
function format_date($date) {
    return date('d M Y', strtotime($date));
}

// Get category name by ID
function get_category_name($conn, $id) {
    $query = "SELECT name FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
    return 'N/A';
}

// Get destination name by ID
function get_destination_name($conn, $id) {
    $query = "SELECT name FROM destinations WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
    return 'N/A';
}

// Sanitize input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Success message
function success_message($message) {
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> ' . $message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
}

// Error message
function error_message($message) {
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> ' . $message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
}

// Pagination function
function paginate($total_records, $records_per_page, $current_page, $url) {
    $total_pages = ceil($total_records / $records_per_page);
    
    if($total_pages <= 1) return '';
    
    $pagination = '<nav><ul class="pagination justify-content-center">';
    
    // Previous button
    if($current_page > 1) {
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($current_page - 1) . '">Previous</a></li>';
    }
    
    // Page numbers
    for($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $current_page) ? 'active' : '';
        $pagination .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
    }
    
    // Next button
    if($current_page < $total_pages) {
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($current_page + 1) . '">Next</a></li>';
    }
    
    $pagination .= '</ul></nav>';
    return $pagination;
}

// Get admin name
function get_admin_name($conn, $admin_id) {
    $query = "SELECT full_name, username FROM admin_users WHERE id = $admin_id";
    $result = mysqli_query($conn, $query);
    if($row = mysqli_fetch_assoc($result)) {
        return $row['full_name'] ?: $row['username'];
    }
    return 'Admin';
}

// Count records
function count_records($conn, $table, $where = '') {
    $query = "SELECT COUNT(*) as total FROM $table";
    if($where) {
        $query .= " WHERE $where";
    }
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>
