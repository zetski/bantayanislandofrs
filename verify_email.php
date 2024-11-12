<?php
require_once('../config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } else {
        // Check if the email exists in the database for an admin user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['email_verified'] = true;
            header("Location: login.php");
            exit;
        } else {
            $error = "Admin email not found.";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Admin Email</title>
</head>
<body>
    <div class="container">
        <h2>Admin Email Verification</h2>
        <form action="verify_email.php" method="post">
            <label for="email">Enter Admin Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Verify Email</button>
        </form>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </div>
</body>
</html>
