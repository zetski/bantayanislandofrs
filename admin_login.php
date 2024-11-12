<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    // Check if email belongs to an admin
    if (is_admin_email($email)) { // Implement this function for email validation
        send_verification_code($email); // Implement this to send a code
        $_SESSION['pending_verification'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: ./verify_email.php"); // Redirect to email verification page
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
