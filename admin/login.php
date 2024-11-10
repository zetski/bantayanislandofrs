<?php 
require_once('../config.php'); 

// Set HTTP security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Start the session with HttpOnly and Secure cookie settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_start();

function sanitize_input($input) {
    $input = strip_tags($input);
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    if (empty($username) || empty($password)) {
        echo 'Invalid input';
        exit;
    }

    // Verify reCAPTCHA
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha_secret = 'YOUR_SECRET_KEY_HERE';
        $recaptcha_response = $_POST['g-recaptcha-response'];

        $verify_url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response
        ];
        
        $ch = curl_init($verify_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo 'reCAPTCHA verification failed';
            exit;
        }
    } else {
        echo 'Please complete the reCAPTCHA';
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

        if (password_verify($password, $storedHash)) {
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
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
  <div class="login-box" style="height: 100%">
    <div class="card card-danger my-2">
      <div class="card-body">
        <p class="login-box-msg">Please enter your credentials</p>
        <form id="login-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" autofocus placeholder="Username">
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
          <!-- reCAPTCHA widget -->
          <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div>
          <div class="row">
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

  <!-- Load reCAPTCHA API script -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
</script>
</body>
</html>
