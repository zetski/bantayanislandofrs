<?php
session_start();
require_once('../initialize.php'); // Include database connection
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Verify if the email exists in the admin database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $_SESSION['otp_code'] = $otp; // Store OTP in session
        $_SESSION['otp_email'] = $email; // Store the email to validate later

        // Send OTP using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bantayanbfp@gmail.com'; // Your email
            $mail->Password = 'otrj ptcg karr ogdd'; // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bantayanbfp@gmail.com', 'Bantayan BFP');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<p>Your OTP is: <strong>$otp</strong></p>";

            $mail->send();
            header("Location: verify_otp.php"); // Redirect to OTP verification page
            exit;
        } catch (Exception $e) {
            echo "Error sending OTP: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in admin records!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send OTP</title>
</head>
<body>
    <form method="POST">
        <label for="email">Enter your admin email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>