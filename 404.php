
<?php
// 404 Not Found page for tajmahaldaytour
http_response_code(404);
$page_title = '404 Not Found - tajmahaldaytour';
include 'includes/header.php';
?>

<style>
.error-404-hero {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fff7f0 0%, #ffe3d3 100%);
    position: relative;
    overflow: hidden;
}
.error-404-content {
    text-align: center;
    z-index: 2;
    position: relative;
}
.error-404-title {
    font-size: 8rem;
    font-weight: 900;
    background: linear-gradient(90deg, #000000 0%, #ffc722 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
    margin-bottom: 10px;
    letter-spacing: -5px;
    text-shadow: 0 8px 40px rgba(255,107,53,0.15);
}
.error-404-message {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 18px;
}
.error-404-desc {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 32px;
}
.error-404-btn {
    padding: 16px 40px;
    background: linear-gradient(135deg, #1d2b53 0%, #000000 60%, #1d2b53 100%);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
    transition: all 0.3s;
    display: inline-block;
}
.error-404-btn:hover {
    background: #000000;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
}
.error-404-svg {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 1;
    opacity: 0.12;
}
</style>

<section class="error-404-hero">
    <div class="container error-404-content">
        <div class="error-404-title">404</div>
        <div class="error-404-message">Oops! Page Not Found</div>
        <div class="error-404-desc">
            Sorry, the page you are looking for doesn’t exist, has been moved, or is temporarily unavailable.<br>
            Please check the URL or return to the homepage.
        </div>
        <a href="<?php echo SITE_URL; ?>" class="error-404-btn"><i class="fas fa-home"></i> Go to Home</a>
    </div>
    <svg class="error-404-svg" viewBox="0 0 1440 320"><path fill="#000000" fill-opacity="1" d="M0,224L48,197.3C96,171,192,117,288,117.3C384,117,480,171,576,197.3C672,224,768,224,864,197.3C960,171,1056,117,1152,128C1248,139,1344,213,1392,250.7L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
</section>

<?php include 'includes/footer.php'; ?>
