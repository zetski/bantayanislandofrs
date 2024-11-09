<?php
include "../../initialize.php";
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

// Check if form is submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email Format',
                    text: 'Please enter a valid email address.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../?home';
                });
              </script>";
        exit;
    }

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE LOWER(email) = LOWER(?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, proceed to generate token
        $rawToken = bin2hex(random_bytes(50));  // The raw token that will be sent to the user
        $hashedToken = password_hash($rawToken, PASSWORD_DEFAULT);  // Hashed token to store in the database

        // Set token expiry time (1 hour from now)
        $expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store hashed token and token expiry in the database
        $query = "UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $hashedToken, $expiryTime, $email);
        if ($stmt->execute()) {
            // Send reset password email using PHPMailer
            $mail = new PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bantayanbfp@gmail.com';
                $mail->Password = 'vavy uqrt eypg nbjp';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('bantayanbfp@gmail.com', 'Bantayan Island BFP');
                $mail->addAddress($email);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Hi, click the link below to reset your password:<br><br>
                               <a href='https://bantayan-bfp.com/admin/forgot/reset_password.php?token=" . $rawToken . "&email=" . urlencode($email) . "'>Reset Password</a>";

                if ($mail->send()) {
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Password reset link has been sent to your email.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '../?home';
                            });
                          </script>";
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Mailer Error',
                                text: 'Failed to send the password reset email.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '../?home';
                            });
                          </script>";
                }
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "<script>alert('Failed to save reset token.');</script>";
        }
    } else {
        // No user found with that email
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No user found with that email.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../?home';
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
                text: 'Email is required.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../?home';
            });
          </script>";
}
?>
