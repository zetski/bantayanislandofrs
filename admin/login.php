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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $storedHash = $user['password'];

        if (strlen($storedHash) == 32) {
            if (md5($password) === $storedHash) {
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newHashedPassword, $username);
                $updateStmt->execute();
                $updateStmt->close();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['district'] = $user['district'];
                error_log("User logged in with district: " . $_SESSION['district']);
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
                exit;
            }
        } else {
            if (password_verify($password, $storedHash)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['district'] = $user['district'];
                error_log("User logged in with district: " . $_SESSION['district']);
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
                exit;
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<script>
  start_loader()
</script>
<script src="https://www.google.com/recaptcha/api.js?render=6LflOZUqAAAAAOhcDi8kHNOcjwfQf6XJ4BN1fsVR"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</style>
<h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
<div class="login-box" style="height: 100%">
    <div class="card card-danger my-2">
        <div class="card-body">
            <p class="login-box-msg">Please enter your credentials</p>
            <form id="login-frm" action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" autofocus placeholder="Username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="recaptcha_token" id="recaptcha-token">
                <div class="row">
                    <div class="col-8">
                        <a href="forgot/forgot-password" style="display: inline-block; margin-top: 5px;">Forgot password?</a>
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

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
    $(document).ready(function(){
        end_loader();

        // Toggle password visibility
        $('#toggle-password').on('click', function() {
            const passwordField = $('#password');
            const icon = $(this);

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });

    $('#login-frm').on('submit', function(e) {
        e.preventDefault();

        grecaptcha.execute('6LflOZUqAAAAABPtamTAWplZnWIQqnk89Duk9jJ_', {action: 'login'}).then(function(token) {
            $('#recaptcha-token').val(token);

            $.ajax({
                url: '',
                method: 'POST',
                data: $('#login-frm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Welcome!',
                            text: response.message,
                            confirmButtonText: 'Continue',
                        }).then(() => {
                            location.reload();
                        });
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong. Please try again.',
                    });
                },
            });
        });
    });
</script>
</body>
</html>

