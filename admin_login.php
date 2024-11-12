<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // Ensure your DB connection is available here

function is_admin_email($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // Returns true if email exists in database
}

function send_verification_code($email) {
    $verification_code = rand(100000, 999999); // Generate a random 6-digit code
    $_SESSION['verification_code'] = $verification_code; // Store it in the session for now

    $subject = "Your Verification Code";
    $message = "Your verification code is: $verification_code";
    $headers = "From: no-reply@example.com";

    if (!mail($email, $subject, $message, $headers)) {
        throw new Exception("Failed to send email");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    if (is_admin_email($email)) {
        send_verification_code($email);
        $_SESSION['pending_verification'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: verify_email.php");
        exit;
    } else {
        $error = "Invalid admin email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
        }
        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .login-container .form-control {
            border-radius: 5px;
            height: 45px;
            margin-bottom: 15px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #ff4600;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #e04a00;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Admin Login</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="email">Admin Email:</label>
            <input type="email" name="email" class="form-control" required placeholder="Enter your admin email">
        </div>
        <button type="submit">Send Verification Code</button>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </form>
</div>

</body>
</html>
