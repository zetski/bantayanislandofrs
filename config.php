<?php
// CSP (Content-Security-Policy) Security Header
header("Content-Security-Policy: default-src 'self';");

// Start output buffering to prevent any output before headers
ob_start();

// Set session cookie parameters for security
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Ensure cookies are transmitted over HTTPS
ini_set('session.cookie_samesite', 'Strict'); // Restrict cross-site cookies

// Set the timezone
ini_set('date.timezone','Asia/Manila');
date_default_timezone_set('Asia/Manila');

// Start the session (Ensure session starts on every page load)
session_start();

// Check if the session has expired or user is logged out
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    // If no user session exists, redirect to the login page
    redirect('login.php');
    exit();
}

// Clear session and redirect to login on logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Remove all session variables
    session_destroy(); // Destroy the session
    redirect('login.php');
    exit();
}

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');
$db = new DBConnection;
$conn = $db->conn;

// Redirect function to handle page redirection
function redirect($url=''){
    if(!empty($url))
        echo '<script>location.href="'.base_url .$url.'"</script>';
}

// Image validation function (for validation and displaying logos)
function validate_image($file){
    global $_settings;
    if(!empty($file)){
        $ex = explode("?", $file);
        $file = $ex[0];
        $ts = isset($ex[1]) ? "?".$ex[1] : '';
        if(is_file(base_app.$file)){
            return base_url.$file.$ts;
        } else {
            return base_url.($_settings->info('logo'));
        }
    } else {
        return base_url.($_settings->info('logo'));
    }
}

// Format number with appropriate decimal places
function format_num($number = '', $decimal = '') {
    if(is_numeric($number)){
        $ex = explode(".", $number);
        $decLen = isset($ex[1]) ? strlen($ex[1]) : 0;
        if(is_numeric($decimal)){
            return number_format($number, $decimal);
        } else {
            return number_format($number, $decLen);
        }
    } else {
        return "Invalid Input";
    }
}

// Check if the user is using a mobile device
function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    // Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    // Otherwise return false..  
    return false;
}

// Ensure no sensitive data is exposed through caching
ob_end_flush();
?>
