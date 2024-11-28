<?php
// Enable error reporting to diagnose any issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../config.php'); // Ensure the config file path is correct
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php'; // Load PHPMailer classes

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
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                // Generate OTP
                $otp = random_int(100000, 999999);

                // Store OTP in session for validation
                $_SESSION['otp'] = $otp;
                $_SESSION['email'] = $email;

                // Send the OTP using PHPMailer
                $mail = new PHPMailer();

                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'bantayanbfp@gmail.com'; // Your Gmail address
                    $mail->Password   = 'otrj ptcg karr ogdd';  // Your Gmail app password
                    $mail->SMTPSecure = 'tls';  // Encryption: 'tls' or 'ssl'
                    $mail->Port       = 587;    // Port for TLS connection

                    //Recipients
                    $mail->setFrom('bantayanbfp@gmail.com', 'Bantayan Island BFP');
                    $mail->addAddress($email);     // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your OTP for Admin Verification';
                    $mail->Body    = "Hi, your OTP for email verification is: <strong>$otp</strong>. <br>Please use this OTP to verify your email.";

                    // Send mail
                    if ($mail->send()) {
                        // Redirect to OTP verification page
                        header("Location: verify_otp.php");
                        exit;
                    } else {
                        $error = "Failed to send OTP. Mailer Error: " . $mail->ErrorInfo;
                    }
                } catch (Exception $e) {
                    $error = "Error in sending OTP: " . $mail->ErrorInfo;
                }
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

        input[type="email"] {
            padding: 12px;
            width: 100%;
            margin-bottom: 20px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="email"]:focus {
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

            input[type="email"],
            button {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Email Verification</h2>
        <form action="verify_email.php" method="post">
            <label for="email">Enter Admin Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your admin email" required>
            <button type="submit">Send OTP</button>
        </form>
        <?php if ($error) { echo "<p>$error</p>"; } ?>
    </div>
</body>
</html>
