<?php
// Start a session with secure configuration
ini_set('session.cookie_secure', '1'); // Send cookies over HTTPS only
ini_set('session.cookie_httponly', '1'); // Prevent JavaScript access to cookies
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
session_set_cookie_params([
    'lifetime' => 3600, // 1-hour session duration
    'path' => '/',
    'domain' => '', // Specify domain if needed
    'secure' => true, // Ensure cookie is sent over HTTPS
    'httponly' => true, // Prevent access via JavaScript
    'samesite' => 'Strict', // CSRF protection
]);

session_start();

// Handle session expiration
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    // Session expired after 1 hour
    session_unset(); // Clear session data
    session_destroy(); // Destroy the session
    header("Location: ./index"); // Redirect to the entry point
    exit;
}
$_SESSION['last_activity'] = time(); // Update last activity time

// Role-based redirection
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'guest') {
        header("Location: ./index");
        exit;
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: ./admin");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/r7logo.png" type="image/png">
    <title>Online Fire Reporting System</title>
    <style>
        /* Basic styles for the gateway page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        .btn {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .guest-btn {
            background-color: #007bff;
        }
        .admin-btn {
            background-color: #ff4600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Bantayan BFP</h2>
        <button class="btn guest-btn" onclick="window.location.href='./set_guest'">Continue as Guest</button>
        <button class="btn admin-btn" onclick="window.location.href='./verifyotp/send_otp'">Login as Admin</button>
    </div>
</body>
</html>
