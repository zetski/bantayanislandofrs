<?php 
require_once('../config.php'); 

// Set HTTP security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// Sanitize and validate input
function sanitize_input($input) {
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
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

        // Check if the password is stored as MD5 (32 characters long)
        if (strlen($storedHash) == 32) {
            // Verify with MD5
            if (md5($password) === $storedHash) {
                // Re-hash the password with bcrypt for future logins
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newHashedPassword, $username);
                $updateStmt->execute();
                $updateStmt->close();

                // Set session variables after successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['district'] = $user['district'];
                echo 'Login successful';
                exit;
            } else {
                echo 'Invalid credentials';
                exit;
            }
        } else {
            // Verify with password_verify for bcrypt or any other compatible algorithm
            if (password_verify($password, $storedHash)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['district'] = $user['district'];
                echo 'Login successful';
                exit;
            } else {
                echo 'Invalid credentials';
                exit;
            }
        }
    } else {
        echo 'Invalid credentials';
        exit;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
    <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
    <div class="login-box">
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
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <a href="forgot/forgot-password.php">Forgot password?</a>
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

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
