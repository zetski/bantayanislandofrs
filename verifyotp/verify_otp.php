<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp_code'];

    // Validate OTP
    if (isset($_SESSION['otp_code']) && $_SESSION['otp_email']) {
        if ($entered_otp == $_SESSION['otp_code']) {
            // OTP verified successfully
            $_SESSION['role'] = 'admin'; // Assign the admin role
            header("Location: login.php"); // Redirect to login page
            exit;
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    } else {
        $error = "No OTP found or session expired.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
</head>
<body>
    <form method="POST">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
        <button type="submit">Verify OTP</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
