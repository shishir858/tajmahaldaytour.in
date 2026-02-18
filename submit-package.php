<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
        $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
        $package_id = intval($_POST['package_id'] ?? 0);
        $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date'] ?? '');
        $people = mysqli_real_escape_string($conn, $_POST['people'] ?? '1');
        $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
        $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');
        $redirect_url = !empty($_POST['redirect_url']) ? $_POST['redirect_url'] : 'index.php';

        // Validation - name and phone both required
        if(empty($name)) {
            $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">Please enter your name.</div>';
            $_SESSION['enquiry_back_url'] = $redirect_url;
            header('Location: thankyou.php');
            exit;
        }
        if(empty($phone)) {
            $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">Please enter your phone number.</div>';
            $_SESSION['enquiry_back_url'] = $redirect_url;
            header('Location: thankyou.php');
            exit;
        }
        
        // Use provided name
        $customer_name = $name;
        
        // If package not selected, use default message
        $package_title = 'General Enquiry';
        if($package_id > 0) {
            $package_result = $conn->query("SELECT title FROM tour_packages WHERE id = $package_id");
            if($package_result && $package_result->num_rows > 0) {
                $package = $package_result->fetch_assoc();
                $package_title = $package['title'];
            }
        }
        
        // Use default date if not provided
        if(empty($travel_date)) {
            $travel_date = date('Y-m-d', strtotime('+7 days')); // Default to 7 days from now
        }
        
        // Check if customer exists with phone number
        $check_customer = $conn->query("SELECT id, name, email FROM customers WHERE phone = '$phone' LIMIT 1");
        
        if($check_customer && $check_customer->num_rows > 0) {
            // Customer exists - update name if provided
            $customer = $check_customer->fetch_assoc();
            $customer_id = $customer['id'];
            
            // Update name if new name is provided and current is 'Guest'
            if(!empty($name) && $customer['name'] == 'Guest') {
                $conn->query("UPDATE customers SET name = '$customer_name' WHERE id = $customer_id");
            }
        } else {
            // Create new customer with unique email based on phone
            $guest_email = 'guest_' . $phone . '@example.com';
            $insert_customer = "INSERT INTO customers (name, email, phone, created_at) 
                               VALUES ('$customer_name', '$email', '$phone', NOW())";
            if(!$conn->query($insert_customer)) {
                $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">Database Error: Unable to save customer details.</div>';
                $_SESSION['enquiry_back_url'] = $redirect_url;
                header('Location: thankyou.php');
                exit;
            }
            $customer_id = $conn->insert_id;
        }
        
        // Generate unique booking number
        $booking_number = 'ENQ' . date('Ymd') . str_pad($customer_id, 4, '0', STR_PAD_LEFT) . rand(100, 999);
        
        // Create message
        $enquiry_message = "Quick Enquiry - Name: $customer_name | Phone: $phone";
        if(!empty($people)) {
            $enquiry_message .= " | Guests: $people";
        }
        if($package_id > 0) {
            $enquiry_message .= " | Package: $package_title";
        }
        if(!empty($message)) {
            $enquiry_message .= " | Message: $message";
        }
        
        // Insert into bookings table (use package_id = 1 if not selected)

        // Always use a valid package_id (fallback to first available if needed)
        $final_package_id = 1;
        if ($package_id > 0) {
            // Check if this package_id exists
            $check_pkg = $conn->query("SELECT id FROM tour_packages WHERE id = $package_id LIMIT 1");
            if ($check_pkg && $check_pkg->num_rows > 0) {
                $final_package_id = $package_id;
            } else {
                // fallback to first available package
                $pkg_row = $conn->query("SELECT id FROM tour_packages ORDER BY id ASC LIMIT 1");
                if ($pkg_row && $pkg_row->num_rows > 0) {
                    $final_package_id = $pkg_row->fetch_assoc()['id'];
                }
            }
        } else {
            // fallback to first available package
            $pkg_row = $conn->query("SELECT id FROM tour_packages ORDER BY id ASC LIMIT 1");
            if ($pkg_row && $pkg_row->num_rows > 0) {
                $final_package_id = $pkg_row->fetch_assoc()['id'];
            }
        }
        
        $insert_query = "INSERT INTO bookings (
            booking_number,
            customer_id, 
            package_id, 
            travel_date,
            number_of_persons,
            number_of_days,
            total_price,
            final_price,
            booking_status,
            special_requests,
            created_at
        ) VALUES (
            '$booking_number',
            $customer_id, 
            $final_package_id, 
            '$travel_date',
            " . intval($people) . ",
            1,
            0.00,
            0.00,
            'pending',
            '$enquiry_message',
            NOW()
        )";
        
        if(!$conn->query($insert_query)) {
            $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">Database Error: Unable to save enquiry.</div>';
            $_SESSION['enquiry_back_url'] = $redirect_url;
            header('Location: thankyou.php');
            exit;
        }
        
        // Enquiry saved successfully
        $enquiry_id = $conn->insert_id;
        
        // Send email notification
        require_once __DIR__ . '/send-mail.php';
        $mailResult = sendEnquiryEmail([
            'booking_number' => $booking_number,
            'name' => $customer_name,
            'phone' => $phone,
            'email' => $email,
            'package_title' => $package_title,
            'travel_date' => $travel_date,
            'people' => $people,
            'message' => $message
        ]);

        if ($mailResult !== true) {
            $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">Enquiry saved, but mail sending failed:<br>' . htmlspecialchars($mailResult) . '</div>';
            $_SESSION['enquiry_back_url'] = $redirect_url;
            header('Location: thankyou.php');
            exit;
        }

        // Success HTML page
        $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#f3fff3;border:1px solid #ccffcc;color:#080;font-size:1.2em;">Thank you! Your enquiry has been submitted successfully.<br><br><strong>Reference:</strong> ' . htmlspecialchars($booking_number) . '<br>We will contact you within 24 hours!</div>';
        $_SESSION['enquiry_back_url'] = $redirect_url;
        header('Location: thankyou.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['enquiry_message'] = '<div style="max-width:600px;margin:40px auto;padding:30px;background:#fff3f3;border:1px solid #ffcccc;color:#a00;font-size:1.2em;">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        $_SESSION['enquiry_back_url'] = !empty($_POST['redirect_url']) ? $_POST['redirect_url'] : 'index.php';
        header('Location: thankyou.php');
        exit;
    }
    
} else {
    // Debug output for non-POST requests
    echo '<h2 style="color:red">Invalid request method (debug)</h2>';
    echo '<pre>_SERVER: ' . print_r($_SERVER, true) . '</pre>';
    echo '<pre>_POST: ' . print_r($_POST, true) . '</pre>';
    echo '<pre>_GET: ' . print_r($_GET, true) . '</pre>';
    echo '<a href="index.php">Back to Home</a>';
    exit;
}
?>
