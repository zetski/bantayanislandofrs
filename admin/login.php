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
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff"); // Prevent MIME-type sniffing
header("X-Frame-Options: SAMEORIGIN"); // Prevent clickjacking
header("X-XSS-Protection: 1; mode=block"); // Enable XSS filtering
header("Referrer-Policy: no-referrer-when-downgrade"); // Control referrer information
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Require HTTPS (HSTS)
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0");

// Start the session with HttpOnly and Secure cookie settings
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookie
ini_set('session.cookie_secure', 1); // Ensure cookies are only sent over HTTPS
ini_set('session.use_only_cookies', 1); // Only use cookies for sessions, no URL parameters
session_start();

// Sanitize and validate input
function sanitize_input($input) {
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    
    // Disallow dangerous symbols and the word "script"
    $disallowed_symbols = ['<', '>', '/', '"', "'"];
    foreach ($disallowed_symbols as $symbol) {
        if (strpos($input, $symbol) !== false) {
            return '';
        }
    }

    if (preg_match('/script/i', $input)) {
        return '';
    }

    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Step 1: Verify reCAPTCHA response
  $recaptcha_secret = '6Ldlu5IqAAAAAFJmSpmDCIrtSwgEa4-eI0WDumKH'; // Replace with your actual secret key
  $recaptcha_response = $_POST['g-recaptcha-response']; // Get the reCAPTCHA response from the form submission
  
  // Google reCAPTCHA verification endpoint
  $recaptcha_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
  
  // Send the reCAPTCHA response to Google for validation
  $response = file_get_contents($recaptcha_verify_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
  $response_keys = json_decode($response, true);

  if(intval($response_keys["success"]) !== 1) {
      echo 'Please complete the reCAPTCHA.';
      exit;
  }

  // Step 2: Proceed with the rest of your logic if reCAPTCHA is successful
  $username = sanitize_input($_POST['username']);
  $password = sanitize_input($_POST['password']);

  if (empty($username) || empty($password)) {
      echo 'Invalid input';
      exit;
  }

  // Prepared statement to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  $user = $result->fetch_assoc();

  if ($user) {
      $storedHash = $user['password'];

      // Check if the password is in MD5 format (32 characters long)
      if (strlen($storedHash) == 32) {
          // Verify with MD5 first
          if (md5($password) === $storedHash) {
              // Re-hash the password with password_hash for future logins
              $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
              $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
              $updateStmt->bind_param("ss", $newHashedPassword, $username);
              $updateStmt->execute();
              $updateStmt->close();

              // Set session variables after successful login
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['username'] = $user['username'];
              $_SESSION['district'] = $user['district'];
              error_log("User logged in with district: " . $_SESSION['district']);
              echo 'Login successful';
              exit;
          } else {
              echo 'Invalid credentials';
          }
      } else {
          // Verify with password_verify for bcrypt or any other compatible algorithm
          if (password_verify($password, $storedHash)) {
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['username'] = $user['username'];
              $_SESSION['district'] = $user['district'];
              error_log("User logged in with district: " . $_SESSION['district']);
              echo 'Login successful';
              exit;
          } else {
              echo 'Invalid credentials';
          }
      }
  } else {
      echo 'Invalid credentials';
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            max-width: 400px;
            margin: auto;
        }
        #page-title {
            font-size: 3.5em;
            color: white;
            text-shadow: 6px 4px 7px black;
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%,
            100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
    </style>
</head>
<body>
    <h1 class="text-center text-white" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
    <div class="login-box">
        <div class="card card-danger my-2">
            <div class="card-body">
                <p class="login-box-msg">Please enter your credentials</p>
                <form id="login-frm" action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
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
                            <a href="forgot/forgot-password" style="display: inline-block; margin-top: 5px;" >Forgot password?</a>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1 mt-3">
                    <a href="<?php echo base_url ?>">Go to Website</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6Ldlu5IqAAAAAEKupyqazokK9AkLoYyxM4MX7ac2"></script>
    <script>
        // Toggle password visibility
        $('#toggle-password').on('click', function() {
            let passwordField = $('#password');
            let passwordFieldType = passwordField.attr('type');
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Disable form elements until reCAPTCHA is completed
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = [
                document.querySelector('input[name="username"]'),
                document.querySelector('input[name="password"]'),
                document.querySelector('a[href="forgot/forgot-password"]'),
                document.querySelector('a[href="<?php echo base_url ?>"]'),
                document.querySelector('button[type="submit"]')
            ];

            formElements.forEach(el => el.disabled = true);

            function enableFormElements() {
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse.length > 0) {
                    formElements.forEach(el => el.disabled = false); // Enable form fields if recaptcha is successful
                } else {
                    formElements.forEach(el => el.disabled = true); // Keep them disabled if recaptcha is incomplete
                }
            }

            window.enableRecaptcha = enableFormElements; // Bind function to global scope
        });
    </script>
</body>
</html>
