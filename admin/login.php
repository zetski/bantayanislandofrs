<?php
session_start(); // Start session at the beginning
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    echo "<script>
        alert('OTP not verified. Please verify it first.');
        window.location.href = 'https://bantayan-bfp.com/verifyotp/send_otp';
    </script>";
    exit;
}
require_once('../config.php'); 

// Set HTTP security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://www.google.com https://www.gstatic.com; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Enhance session security
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);

// Sanitize and validate input
function sanitize_input($input) {
    $input = strip_tags($input);
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// ReCAPTCHA v3 verification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaResponse = $_POST['recaptcha_response'] ?? '';
    $recaptchaSecret = '6LeDspIqAAAAABVjFu69hoeAVifRnOyxbevLfDCp'; // Replace with your secret key

    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success'] || $responseKeys['score'] < 0.5) {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.');</script>";
        exit;
    }

    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Invalid input. Please provide valid credentials.');</script>";
        exit;
    }

    // Query database for user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user) {
        $storedHash = $user['password'];

        // Verify password
        if (password_verify($password, $storedHash)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['district'] = $user['district'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Invalid credentials.');</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeDspIqAAAAABVjFu69hoeAVifRnOyxbevLfDCp"></script>
    <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
    <div class="login-box">
        <div class="card card-danger my-2">
            <div class="card-body">
                <p class="login-box-msg">Please enter your credentials</p>
                <form id="login-frm" action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <a href="forgot/forgot-password" style="display: inline-block; margin-top: 5px;">Forgot password?</a>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const siteKey = '6LeDspIqAAAAABVjFu69hoeAVifRnOyxbevLfDCp'; // Replace with your site key
            grecaptcha.ready(function() {
                document.getElementById('login-frm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    grecaptcha.execute(siteKey, { action: 'login' }).then(function(token) {
                        const recaptchaInput = document.createElement('input');
                        recaptchaInput.type = 'hidden';
                        recaptchaInput.name = 'recaptcha_response';
                        recaptchaInput.value = token;
                        document.getElementById('login-frm').appendChild(recaptchaInput);
                        document.getElementById('login-frm').submit();
                    });
                });
            });

            // Toggle password visibility
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>
