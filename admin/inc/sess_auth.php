<?php 
// Ensure HTTP-only session cookies for added security
ini_set('session.cookie_httponly', 1);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to check OTP verification status
function check_otp_verified() {
    if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
        // Redirect to OTP verification page if not verified
        header("Location: https://bantayan-bfp.com/verifyotp");
        exit;
    }
}

// Determine current page link
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

// Redirect if no session and not on login page
if (!isset($_SESSION['userdata']) && !strpos($link, 'login.php')) {
    redirect('admin/login');
}

// Redirect if logged in but trying to access login page
if (isset($_SESSION['userdata']) && strpos($link, 'login.php')) {
    redirect('admin/index.php');
}

// Protect admin pages and ensure OTP is verified
if (isset($_SESSION['userdata']) && strpos($link, 'admin/')) {
    check_otp_verified(); // Enforce OTP verification
}

// Validate user permissions based on login type
$module = array('','admin','tutor');
if (isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'admin/')) && $_SESSION['userdata']['login_type'] !=  1) {
    echo "<script>alert('Access Denied!');location.replace('".base_url.$module[$_SESSION['userdata']['login_type']]."');</script>";
    exit;
}
?>
