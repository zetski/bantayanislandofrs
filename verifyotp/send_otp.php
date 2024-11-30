<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../initialize.php'); // Include database connection
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

$error_message = ""; // Variable to hold the error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if the email exists
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999); // Generate a random OTP
        $otp_expiry = date("Y-m-d H:i:s", time() + (3 * 60)); // 3 minutes expiry

        // Save OTP and expiry
        $update_stmt = $con->prepare("UPDATE users SET otp_code = ?, otp_expiry = ? WHERE email = ?");
        $update_stmt->bind_param("sss", $otp, $otp_expiry, $email);
        $update_stmt->execute();

        // Send OTP
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bantayanbfp@gmail.com'; // Your email
            $mail->Password = 'otrj ptcg karr ogdd';   // Your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('bantayanbfp@gmail.com', 'Bantayan BFP');
            $mail->addAddress($email); // Recipient email
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<p>Your OTP is: <strong>$otp</strong></p>
                          <p>This OTP is valid for 3 minutes only.</p>";

            $mail->send();

            // Set session variable for the next page
            $_SESSION['otp_email'] = $email;

            // Show an alert and redirect using JavaScript
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'OTP successfully sent! Click OK to proceed to the verification page.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './otp_verified.php';
                        }
                    });
                  </script>";
            exit;
        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $mail->ErrorInfo);
            echo "<script>alert('Failed to send OTP. Please try again later.');</script>";
        }
    } else {
        // Email not found in the database
        echo "<script>alert('Email not found in our records!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333333;
        }

        p {
            font-size: 14px;
            color: #666666;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #444444;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="email"] {
            padding: 10px 15px;
            font-size: 14px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 20px;
            outline: none;
        }

        input[type="email"]:focus {
            border-color: #007bff;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error, .success {
            font-size: 14px;
            margin-top: 15px;
        }

        .error {
            color: #ff4d4f;
        }

        .success {
            color: #28a745;
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Send OTP</h1>
        <p>Enter your registered admin email address to receive a one-time password (OTP).</p>
        <form method="POST">
            <label for="email">Admin Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <button type="submit">Send OTP</button>
        </form>
    </div>

    <?php if (!empty($error_message)) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $error_message; ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>
</html>
