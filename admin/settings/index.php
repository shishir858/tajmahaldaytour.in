<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
check_login();

// ...existing code...

// Insert default settings if not exists
$default_settings = [
    // Site Information
    ['site_name', 'tajmahaldaytour', 'site_info'],
    ['site_tagline', 'Your Trusted Travel Partner in India', 'site_info'],
    ['site_email', 'info@tajmahaldaytour.com', 'site_info'],
    ['site_phone', '+91-9876543210', 'site_info'],
    ['site_address', 'Delhi, India', 'site_info'],
    
    // Meta Tags
    ['meta_title', 'tajmahaldaytour - Private Tours & Car Rentals', 'meta'],
    ['meta_description', 'Experience India with professional drivers and private tours. Book Golden Triangle, Rajasthan, Himachal tours.', 'meta'],
    ['meta_keywords', 'india tours, car rental, private driver, golden triangle, rajasthan tour', 'meta'],
    
    // Social Links
    ['facebook_url', 'https://facebook.com/', 'social'],
    ['instagram_url', 'https://instagram.com/', 'social'],
    ['twitter_url', 'https://twitter.com/', 'social'],
    ['youtube_url', 'https://youtube.com/', 'social'],
    
    // Contact Details
    ['contact_email', 'contact@tajmahaldaytour.com', 'contact'],
    ['support_email', 'support@tajmahaldaytour.com', 'contact'],
    ['whatsapp_number', '+91-9876543210', 'contact'],
    ['office_hours', 'Mon-Sat: 9:00 AM - 6:00 PM', 'contact'],
];

foreach($default_settings as $setting) {
    $check = mysqli_query($conn, "SELECT * FROM site_settings WHERE setting_key = '{$setting[0]}'");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES ('{$setting[0]}', '{$setting[1]}', '{$setting[2]}')");
    }
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach($_POST as $key => $value) {
        if($key != 'submit') {
            $key = mysqli_real_escape_string($conn, $key);
            $value = mysqli_real_escape_string($conn, $value);
            
            $update_query = "UPDATE site_settings SET setting_value = '$value' WHERE setting_key = '$key'";
            mysqli_query($conn, $update_query);
        }
    }
    
    header('Location: index.php?msg=updated');
    exit;
}

// Fetch all settings
$settings_query = "SELECT * FROM site_settings ORDER BY setting_group, setting_key";
$settings_result = mysqli_query($conn, $settings_query);

$settings = [];
while($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Site Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
        <?php echo success_message('Settings updated successfully!'); ?>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-lg-8">
                <!-- Site Information -->
                <div class="admin-card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Site Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Site Name</label>
                            <input type="text" name="site_name" class="form-control" 
                                   value="<?php echo htmlspecialchars($settings['site_name']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="site_tagline" class="form-control" 
                                   value="<?php echo htmlspecialchars($settings['site_tagline']); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="site_email" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['site_email']); ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="site_phone" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['site_phone']); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label">Address</label>
                            <textarea name="site_address" class="form-control" rows="2"><?php echo htmlspecialchars($settings['site_address']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Meta Tags (SEO) -->
                <div class="admin-card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Meta Tags (SEO)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" 
                                   value="<?php echo htmlspecialchars($settings['meta_title']); ?>"
                                   maxlength="60">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" 
                                      maxlength="160"><?php echo htmlspecialchars($settings['meta_description']); ?></textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" 
                                   value="<?php echo htmlspecialchars($settings['meta_keywords']); ?>">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="admin-card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Social Media Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-facebook text-primary me-2"></i>Facebook</label>
                                <input type="url" name="facebook_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['facebook_url']); ?>"
                                       placeholder="https://facebook.com/yourpage">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-instagram text-danger me-2"></i>Instagram</label>
                                <input type="url" name="instagram_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['instagram_url']); ?>"
                                       placeholder="https://instagram.com/yourpage">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-twitter text-info me-2"></i>Twitter</label>
                                <input type="url" name="twitter_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['twitter_url']); ?>"
                                       placeholder="https://twitter.com/yourpage">
                            </div>
                            
                            <div class="col-md-6 mb-0">
                                <label class="form-label"><i class="fab fa-youtube text-danger me-2"></i>YouTube</label>
                                <input type="url" name="youtube_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['youtube_url']); ?>"
                                       placeholder="https://youtube.com/yourchannel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="admin-card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" name="contact_email" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['contact_email']); ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Support Email</label>
                                <input type="email" name="support_email" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['support_email']); ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['whatsapp_number']); ?>">
                            </div>
                            
                            <div class="col-md-6 mb-0">
                                <label class="form-label">Office Hours</label>
                                <input type="text" name="office_hours" class="form-control" 
                                       value="<?php echo htmlspecialchars($settings['office_hours']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Save All Settings
                </button>
            </div>

            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="admin-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Important Notes</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Settings are applied site-wide</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Meta tags improve SEO</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Social links appear in footer</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Contact details used in forms</li>
                            <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Changes are instant</li>
                        </ul>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="admin-card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Last Updated</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $last_update = mysqli_query($conn, "SELECT MAX(updated_at) as last_update FROM site_settings");
                        $update_row = mysqli_fetch_assoc($last_update);
                        if($update_row['last_update']) {
                            echo '<p class="mb-0">' . date('d M Y, h:i A', strtotime($update_row['last_update'])) . '</p>';
                        } else {
                            echo '<p class="mb-0 text-muted">Never updated</p>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Settings Count -->
                <div class="admin-card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Settings Overview</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $groups = ['site_info', 'meta', 'social', 'contact'];
                        $group_names = [
                            'site_info' => 'Site Information',
                            'meta' => 'Meta Tags',
                            'social' => 'Social Links',
                            'contact' => 'Contact Details'
                        ];
                        
                        foreach($groups as $group) {
                            $count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM site_settings WHERE setting_group = '$group'");
                            $count_row = mysqli_fetch_assoc($count_query);
                            echo '<div class="d-flex justify-content-between mb-2">';
                            echo '<span class="small">' . $group_names[$group] . '</span>';
                            echo '<span class="badge bg-primary">' . $count_row['count'] . '</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-hide success messages
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const siteName = document.querySelector('input[name="site_name"]').value;
    if(siteName.trim() === '') {
        e.preventDefault();
        alert('Site name is required!');
    }
});
</script>

<?php include '../includes/footer.php'; ?>
