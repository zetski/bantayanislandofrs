<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    if (verify_code($_SESSION['admin_email'], $code)) { // Implement verification logic
        $_SESSION['role'] = 'admin';
        unset($_SESSION['pending_verification']);
        header("Location: admin/dashboard.php"); // Redirect to admin dashboard
        exit;
    } else {
        $error = "Invalid verification code.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
<form method="post" action="">
    <label for="code">Enter Verification Code:</label>
    <input type="text" name="code" required>
    <button type="submit">Verify</button>
</form>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
