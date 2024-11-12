<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    // Check if email belongs to an admin
    if (is_admin_email($email)) { // Implement this function for email validation
        send_verification_code($email); // Implement this to send a code
        $_SESSION['pending_verification'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: verify_email.php"); // Redirect to email verification page
        exit;
    } else {
        $error = "Invalid admin email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
<form method="post" action="">
    <label for="email">Admin Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Verification Code</button>
</form>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
