<?php
session_start(); // Start session at the beginning

// Check if OTP is verified
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
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Start session with secure settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);

// Sanitize and validate input
function sanitize_input($input) {
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
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

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    if (empty($username) || empty($password)) {
        echo 'Invalid input';
        exit;
    }

    // Initialize login attempts if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }

    // Check if the username is locked
    if (isset($_SESSION['login_attempts'][$username])) {
        $attemptData = $_SESSION['login_attempts'][$username];
        if ($attemptData['attempts'] >= 3 && time() - $attemptData['last_attempt'] < 300) {
            echo 'Too many login attempts. Try again after 5 minutes.';
            exit;
        }
    }

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user) {
        $storedHash = $user['password'];

        // Check if the password is in MD5 format
        if (strlen($storedHash) == 32 && md5($password) === $storedHash) {
            // Re-hash the password with bcrypt
            $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $newHashedPassword, $username);
            $updateStmt->execute();
            $updateStmt->close();

            // Reset login attempts
            unset($_SESSION['login_attempts'][$username]);

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['district'] = $user['district'];
            echo 'Login successful';
            exit;
        } elseif (password_verify($password, $storedHash)) {
            // Reset login attempts
            unset($_SESSION['login_attempts'][$username]);

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['district'] = $user['district'];
            echo 'Login successful';
            exit;
        } else {
            echo 'Invalid credentials';
        }
    } else {
        echo 'Invalid credentials';
    }

    // Track failed login attempts
    if (!isset($_SESSION['login_attempts'][$username])) {
        $_SESSION['login_attempts'][$username] = ['attempts' => 0, 'last_attempt' => time()];
    }

    $_SESSION['login_attempts'][$username]['attempts']++;
    $_SESSION['login_attempts'][$username]['last_attempt'] = time();

    if ($_SESSION['login_attempts'][$username]['attempts'] >= 3) {
        echo 'Too many login attempts. Try again after 5 minutes.';
    } else {
        echo 'Invalid credentials';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    body {
        background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
        background-size: cover; 
        background-position: center;
        background-repeat: no-repeat; 
        backdrop-filter: contrast(1);
        height: 100vh; 
        margin: 0;
    }
    #page-title {
        text-shadow: 6px 4px 7px black;
        font-size: 3.5em;
        color: #fff4f4 !important;
    }
    .login-box {
        margin: auto; 
        max-width: 400px; 
        width: 90%; 
    }

    /* Media queries for responsive design */
    @media (max-width: 768px) {
        #page-title {
            font-size: 2.5em; /* Reduce title size on smaller screens */
        }
        .login-box {
            width: 95%; /* Make the login box wider on smaller screens */
        }
    }
    @media (max-width: 480px) {
        #page-title {
            font-size: 2em; /* Further reduce title size on very small screens */
        }
    }
</style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
  <div class="login-box" style="height: 100%">
    <div class="card card-danger my-2">
      <div class="card-body">
        <p class="login-box-msg">Please enter your credentials</p>
        <form id="login-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" autofocus placeholder="Username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" disabled>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" disabled>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
              </div>
            </div>
          </div>
          <div class="g-recaptcha" data-sitekey="6Lc_f4AqAAAAAP79JvQbC6_KbdOJQt9TRXxabqP3" data-callback="enableRecaptcha"></div>
          <div class="row">
            <div class="col-8">
              <a href="forgot/forgot-password.php" style="display: inline-block; margin-top: 5px;" disabled>Forgot password?</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" disabled>Sign In</button>
            </div>
          </div>
        </form>
        <p class="mb-1 mt-3">
          <a href="<?php echo base_url ?>" disabled>Go to Website</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function(){
      end_loader();
    });

    // Automatically remove disallowed characters as they are typed
    document.querySelector('input[name="username"]').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[<>\/]/g, '');
    });

    document.querySelector('input[name="password"]').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[<>\/]/g, '');
    });

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

    // Disable inspect element and right-click
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function(e) {
        if (e.keyCode == 123 || 
            (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'J'.charCodeAt(0))) || 
            (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0))) {
            return false;
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
    // Initially disable the form fields and buttons
    const formElements = [
      document.querySelector('input[name="username"]'),
      document.querySelector('input[name="password"]'),
      document.querySelector('a[href="forgot/forgot-password.php"]'),
      document.querySelector('a[href="<?php echo base_url ?>"]'),
      document.querySelector('button[type="submit"]')	
    ];

    formElements.forEach(el => el.disabled = true);

    // Monitor reCAPTCHA state
    function enableFormElements() {
      const recaptchaResponse = grecaptcha.getResponse();
      if (recaptchaResponse.length > 0) {
        formElements.forEach(el => el.disabled = false);
      } else {
        formElements.forEach(el => el.disabled = true);
      }
    }

    // Add event listener for reCAPTCHA changes
    window.enableRecaptcha = enableFormElements; // Bind function to global scope
  });
</script>
</body>
</html>