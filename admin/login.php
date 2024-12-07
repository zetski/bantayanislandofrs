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

// // Allowed IP addresses
// $allowed_ips = ['124.217.6.22', '::1', '127.0.0.1'];

// // Get the user's IP address
// $user_ip = $_SERVER['REMOTE_ADDR'];

// // Check if the user's IP address matches any allowed IPs
// if (!in_array($user_ip, $allowed_ips)) {
//     http_response_code(404); // Set the 404 status code
//     include('./404.html'); // Include the 404 page content
//     exit();
// }
// Set HTTP security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff"); // Prevent MIME-type sniffing
header("X-Frame-Options: SAMEORIGIN"); // Prevent clickjacking
header("X-XSS-Protection: 1; mode=block"); // Enable XSS filtering
header("Referrer-Policy: no-referrer-when-downgrade"); // Control referrer information
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Require HTTPS (HSTS)

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
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
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
    .shake {
    animation: shake 0.5s;
  }

  @keyframes shake {
    0%,
    100% {
      transform: translateX(0);
    }
    25% {
      transform: translateX(-5px);
    }
    50% {
      transform: translateX(5px);
    }
    75% {
      transform: translateX(-5px);
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
            <input type="text" class="form-control" name="username" autofocus placeholder="Username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="forgot/forgot-password" style="display: inline-block; margin-top: 5px;" disabled>Forgot password?</a>
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

  <div id="alert-box"></div> 
  
  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
   let remainingAttempts = 3;
let isLocked = false;

function handleInvalidCredentials() {
    if (isLocked) return;

    remainingAttempts--;

    // Shake effect
    const cardBody = document.querySelector(".card-body");
    cardBody.classList.add("shake");
    setTimeout(() => cardBody.classList.remove("shake"), 500);

    // SweetAlert for login attempts
    if (remainingAttempts > 0) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Credentials!",
            html: `You have <b>${remainingAttempts}</b> login attempts left.`,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    } else {
        isLocked = true;
        Swal.fire({
            icon: "error",
            title: "Account Locked!",
            text: "You have been locked out for 3 minutes due to multiple failed login attempts.",
            showConfirmButton: false,
        });

        lockForm();

        setTimeout(() => {
            isLocked = false;
            remainingAttempts = 3;
            Swal.fire({
                icon: "info",
                title: "Lockout Expired",
                text: "You can now try logging in again.",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            });

            unlockForm();
        }, 3 * 60 * 1000); // 3 minutes
    }
}

function lockForm() {
    document.querySelector('input[name="username"]').disabled = true;
    document.querySelector('input[name="password"]').disabled = true;
    document.querySelector('button[type="submit"]').disabled = true;
}

function unlockForm() {
    document.querySelector('input[name="username"]').disabled = false;
    document.querySelector('input[name="password"]').disabled = false;
    document.querySelector('button[type="submit"]').disabled = false;
}

document.getElementById("login-frm").addEventListener("submit", function (e) {
    e.preventDefault();
    const isValid = false; // Simulated for testing
    if (!isValid) {
        handleInvalidCredentials();
    } else {
        Swal.fire({
            icon: "success",
            title: "Login Successful!",
        });
    }
});
  //end of limit attempt

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
</script>
</body>
</html>