<?php
include "../../initialize.php"; // Include your database connection

$status = ''; // Initialize status
$message = ''; // Initialize message

if (
    isset($_POST['email']) &&
    isset($_POST['token']) &&
    isset($_POST['password']) &&
    isset($_POST['password_confirm'])
) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Check if passwords match
    if ($password !== $password_confirm) {
        $status = 'error';
        $message = 'Passwords do not match.';
    } else {
        // Fetch the hashed token and expiry time from the database
        $query = "SELECT reset_token, token_expiry FROM users WHERE LOWER(email) = LOWER(?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $hashedToken = $user['reset_token'];
            $tokenExpiry = $user['token_expiry'];

            // Check if token has expired
            if (new DateTime() > new DateTime($tokenExpiry)) {
                $status = 'error';
                $message = 'This password reset link has expired.';
            } else if (password_verify($token, $hashedToken)) {
                // Token is valid, proceed with password update
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Update the password in the database
                $query = "UPDATE users SET pass = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ss", $newHashedPassword, $email);

                if ($stmt->execute()) {
                    $status = 'success';
                    $message = 'Your password has been reset successfully.';
                } else {
                    $status = 'error';
                    $message = 'Failed to reset your password. Please try again.';
                }
            } else {
                $status = 'error';
                $message = 'Invalid or expired token.';
            }
        } else {
            $status = 'error';
            $message = 'No user found with that email.';
        }

        // Close the statement and connection
        $stmt->close();
    }
    $con->close();
} else {
    $status = 'error';
    $message = 'Invalid request.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset Status</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Display alert based on PHP variables
        const status = "<?php echo $status; ?>";
        const message = "<?php echo $message; ?>";
        
        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'https://bantayan-bfp.com/';
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        }
    });
</script>
</body>
</html>
