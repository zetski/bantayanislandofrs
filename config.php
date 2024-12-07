<?php
// Content-Security-Policy header
header("Content-Security-Policy: default-src 'self';");
ob_start();

// Set session cookie parameters
ini_set('session.cookie_httponly', 1);

// Timezone settings
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// Start the session
session_start();

// Prevent caching of sensitive pages
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Check if the user is logged in (Replace with your actual session variable to check login status)
function is_logged_in() {
    return isset($_SESSION['user_id']);  // Check for a valid user session, update with your actual session variable
}

// Redirect function
function redirect($url = '') {
    if (!empty($url)) {
        echo '<script>location.href="' . base_url . $url . '"</script>';
        exit;
    }
}

// If user is not logged in, redirect to the login page
if (!is_logged_in()) {
    redirect('login.php');  // Redirect to login page
    exit;  // Ensure no further processing happens
}

// Include other required files
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// Database connection
$db = new DBConnection;
$conn = $db->conn;

// Function to validate image URL
function validate_image($file) {
    global $_settings;
    if (!empty($file)) {
        $ex = explode("?", $file);
        $file = $ex[0];
        $ts = isset($ex[1]) ? "?" . $ex[1] : '';
        if (is_file(base_app . $file)) {
            return base_url . $file . $ts;
        } else {
            return base_url . ($_settings->info('logo'));
        }
    } else {
        return base_url . ($_settings->info('logo'));
    }
}

// Function to format numbers
function format_num($number = '', $decimal = '') {
    if (is_numeric($number)) {
        $ex = explode(".", $number);
        $decLen = isset($ex[1]) ? strlen($ex[1]) : 0;
        if (is_numeric($decimal)) {
            return number_format($number, $decimal);
        } else {
            return number_format($number, $decLen);
        }
    } else {
        return "Invalid Input";
    }
}

// Function to check if the device is a mobile device
function isMobileDevice() {
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    // Return true if Mobile User Agent is detected
    foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
        if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
    }
    // Otherwise return false
    return false;
}

ob_end_flush();
?>
