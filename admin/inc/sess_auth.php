<?php
// HTTPOnly session cookie setting
ini_set('session.cookie_httponly', 1);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get current URL
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];

// Redirect to login page if not logged in and not already on the login page
if (!isset($_SESSION['userdata']) && strpos($link, 'login') === false) {
    redirect('admin/login');  // Clean URL without .php
}

// Redirect to index page if already logged in and trying to access login page
if (isset($_SESSION['userdata']) && strpos($link, 'login') !== false) {
    redirect('admin/index');  // Clean URL without .php
}

// Modules for different user types
$module = array('', 'admin', 'tutor');

// Deny access if user type doesn't match the expected role
if (isset($_SESSION['userdata']) && (strpos($link, 'index') !== false || strpos($link, 'admin/login') !== false) && $_SESSION['userdata']['login_type'] != 1) {
    echo "<script>alert('Access Denied!');location.replace('" . base_url . $module[$_SESSION['userdata']['login_type']] . "');</script>";
    exit;
}

// Function to handle redirection
function redirect($url) {
    // Strip .php extension from URL
    $url = rtrim($url, '.php');  // Ensure there is no .php in the URL
    header("Location: $url");
    exit();
}
?>
