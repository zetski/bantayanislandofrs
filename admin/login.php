<?php
session_start(); // Start session
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    echo "<script>
        alert('OTP not verified. Please verify it first.');
        window.location.href = 'https://bantayan-bfp.com/verifyotp/send_otp';
    </script>";
    exit;
}

require_once('../config.php'); // Include configuration

// HTTP Security Headers
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://www.google.com/recaptcha/; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Secure Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);

// Sanitize input function
function sanitize_input($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// reCAPTCHA Verification
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recaptchaSecret = '6Ldlu5IqAAAAAEKupyqazokK9AkLoYyxM4MX7ac2'; // Replace with your secret key
    $recaptchaResponse = sanitize_input($_POST['recaptcha_response'] ?? '');
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

    // Verify reCAPTCHA response
    $response = file_get_contents("$recaptchaUrl?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success'] || $responseKeys['score'] < 0.5) {
        echo "<script>alert('reCAPTCHA verification failed.');</script>";
        exit;
    }

    // Process login
    $username = sanitize_input($_POST['username'] ?? '');
    $password = sanitize_input($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo "<script>alert('Invalid username or password.');</script>";
        exit;
    }

    // Prepared statement to fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $storedHash = $user['password'];
        if (password_verify($password, $storedHash)) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['district'] = $user['district'];

            echo "<script>alert('Login successful! Redirecting...'); window.location.href = '../dashboard.php';</script>";
            exit;
        }
    }
    echo "<script>alert('Invalid username or password.');</script>";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Ldlu5IqAAAAAEKupyqazokK9AkLoYyxM4MX7ac2"></script>
    <style>
        body {
            background-image: url('<?php echo validate_image($_settings->info('cover')) ?>');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .login-box {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 class="text-center">Login</h2>
        <form id="login-frm" action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>
        <p class="text-center mt-3">
            <a href="forgot/forgot-password">Forgot Password?</a>
        </p>
    </div>
    <script>
        // reCAPTCHA integration
        grecaptcha.ready(function () {
            document.getElementById('login-frm').addEventListener('submit', function (event) {
                event.preventDefault();
                grecaptcha.execute('6Ldlu5IqAAAAAEKupyqazokK9AkLoYyxM4MX7ac2', { action: 'login' }).then(function (token) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'recaptcha_response';
                    input.value = token;
                    document.getElementById('login-frm').appendChild(input);
                    document.getElementById('login-frm').submit();
                });
            });
        });
    </script>
</body>
</html>
