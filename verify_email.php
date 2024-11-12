<?php
// Enable error reporting to diagnose any issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // Ensure the config file path is correct

// Check if session is not active, then start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } else {
        // Check if the email exists in the database for an admin user
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $_SESSION['email_verified'] = true;
                header("Location: login.php");
                exit;
            } else {
                $error = "Admin email not found.";
            }
            
            $stmt->close();
        } else {
            $error = "Database query error.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Admin Email</title>
    <style>
        /* Styling for the page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            max-width: 400px;
            width: 90%;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="email"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            color: #fff;
            background-color: #007bff;
            cursor: pointer;
            border-radius: 4px;
        }
        p {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Email Verification</h2>
        <form action="verify_email.php" method="post">
            <label for="email">Enter Admin Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Verify Email</button>
        </form>
        <?php if ($error) { echo "<p>$error</p>"; } ?>
    </div>
</body>
</html>
