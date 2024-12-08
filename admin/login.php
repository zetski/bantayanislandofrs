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

function sanitize_input($input) {
    $input = htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
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

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user) {
        $storedHash = $user['password'];

        if (strlen($storedHash) == 32 && md5($password) === $storedHash) {
            $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $newHashedPassword, $username);
            $updateStmt->execute();
            $updateStmt->close();
        }

        if (password_verify($password, $storedHash)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['district'] = $user['district'];
            error_log("User logged in with district: " . $_SESSION['district']);
            echo 'Login successful';
            exit;
        }
    }

    echo 'Invalid credentials';
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<script src="https://www.google.com/recaptcha/api.js?render=6LflOZUqAAAAAOhcDi8kHNOcjwfQf6XJ4BN1fsVR"></script>
<style>
    body {
        background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
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
    @media (max-width: 768px) {
        #page-title {
            font-size: 2.5em;
        }
        .login-box {
            width: 95%;
        }
    }
</style>
<h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo htmlspecialchars($_settings->info('name')) ?></b></h1>
<div class="login-box">
    <div class="card card-danger my-2">
        <div class="card-body">
            <p class="login-box-msg">Please enter your credentials</p>
            <form id="login-frm" action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
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
                <input type="hidden" name="recaptcha_token" id="recaptcha-token">
                <div class="row">
                    <div class="col-8">
                        <a href="forgot/forgot-password">Forgot password?</a>
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
<script>
    $('#toggle-password').on('click', function() {
        let passwordField = $('#password');
        let passwordFieldType = passwordField.attr('type');
        passwordField.attr('type', passwordFieldType === 'password' ? 'text' : 'password');
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#login-frm').on('submit', function(e) {
        e.preventDefault();
        grecaptcha.execute('6LflOZUqAAAAAOhcDi8kHNOcjwfQf6XJ4BN1fsVR', {action: 'login'}).then(function(token) {
            $('#recaptcha-token').val(token);
            $('#login-frm')[0].submit();
        });
    });
</script>
</body>
</html>
