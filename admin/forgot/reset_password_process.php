<?php
include "../../initialize.php";

if (isset($_POST['email'], $_POST['token'], $_POST['password'], $_POST['password_confirm'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Passwords do not match.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back();
                });
              </script>";
        exit;
    }

    // Fetch the hashed token and expiry time from the database
    $query = "SELECT reset_token, token_expiry FROM users WHERE LOWER(email) = LOWER(?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_assoc();

    if ($users) {
        $hashedToken = $users['reset_token'];
        $tokenExpiry = $users['token_expiry'];

        // Check if token has expired
        if (new DateTime() > new DateTime($tokenExpiry)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'This password reset link has expired.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'https://bantayan-bfp.com/';
                    });
                  </script>";
            exit;
        }

        // Verify the token
        if (password_verify($token, $hashedToken)) {
            $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Update the password in the database
            $query = "UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ss", $newHashedPassword, $email);
            if ($stmt->execute()) {
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Your password has been reset successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'https://bantayan-bfp.com/';
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to reset your password. Please try again.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.history.back();
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Invalid or expired token.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'https://bantayan-bfp.com/';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No user found with that email.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'https://bantayan-bfp.com/';
                });
              </script>";
    }

    $stmt->close();
    $con->close();
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid request.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'https://bantayan-bfp.com/';
            });
          </script>";
}
?>
