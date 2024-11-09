<?php
include "../../initialize.php"; // Include your database connection

if (
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['password_confirm'])
) {
    // Trim and lowercase email to avoid case and space issues
    $email = trim(strtolower($_POST['email']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Check if passwords match
    if ($password !== $password_confirm) {
        // Passwords do not match, display an error message using SweetAlert2
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Passwords Do Not Match</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Passwords do not match.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>
        <?php
        exit;
    }

    // Fetch the user from the database based on the email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo "Statement preparation failed: " . $con->error;
        exit;
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        echo "Query execution failed: " . $stmt->error;
        exit;
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Hash the new password using bcrypt
        $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update the password in the database
        $query = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $newHashedPassword, $email);
        if ($stmt->execute()) {
            // Password reset successful
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Password Reset Successful</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your password has been reset successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'https://bantayan-bfp.com/';
                    });
                </script>
            </body>
            </html>
            <?php
        } else {
            // Failed to reset password
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Error</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to reset your password. Please try again.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.history.back();
                    });
                </script>
            </body>
            </html>
            <?php
        }
    } else {
        // No user found with that email
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>User Not Found</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No user found with that email.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'https://bantayan-bfp.com/';
                });
            </script>
        </body>
        </html>
        <?php
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    // Invalid request
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invalid Request</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid request.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'https://bantayan-bfp.com/';
            });
        </script>
    </body>
    </html>
    <?php
}
?>
