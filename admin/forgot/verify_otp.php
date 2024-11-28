<?php
// Enable error reporting to diagnose any issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if session is not active, then start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = ""; // Initialize error message

// Check if the session has the OTP and email
if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header("Location: verify_email.php"); // Redirect to email verification if session data is missing
    exit;
}

// Handle OTP submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = trim($_POST['otp']);

    // Validate OTP
    if ($entered_otp == $_SESSION['otp']) {
        // OTP is correct, clear the session and redirect to login
        unset($_SESSION['otp']); // Remove OTP from session for security
        $_SESSION['email_verified'] = true; // Set email verified session
        header("Location: login.php"); // Redirect to login page
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(135deg, #6d83f3, #b29df8);
            color: #333;
        }

        .container {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background: #fff;
            max-width: 420px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #444;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 1em;
            color: #555;
        }

        input[type="text"] {
            padding: 12px;
            width: 100%;
            margin-bottom: 20px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #6d83f3;
            box-shadow: 0 0 5px rgba(109, 131, 243, 0.5);
        }

        button {
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            color: #fff;
            background-color: #007bff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 15px;
            font-size: 0.9em;
            color: red;
        }

        @media (max-width: 500px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.5em;
            }

            input[type="text"],
            button {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form action="verify_otp.php" method="post">
            <label for="otp">Enter the OTP sent to your email:</label>
            <input type="text" id="otp" name="otp" placeholder="Enter your OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
        <?php if ($error) { echo "<p>$error</p>"; } ?>
    </div>
</body>
</html>
