<?php 
session_start();
include("../../initialize.php");
// include("include/header.php");

$error="";
$msg="";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

    

    function sendemail($email,$reset_token)
    {
        $mail = new PHPMailer(true);

try {
    //Server settings
                        
    $mail->isSMTP();                                         //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'bantayanbfp@gmail.com';                     //SMTP username
    $mail->Password   = 'vavy uqrt eypg nbjp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bantayanbfp@gmail.com', 'Bantayan Island BFP');
    $mail->addAddress($email);     //Add a recipient
    $resetLink = 'https://bantayan-bfp.com/admin/forgot/reset_password.php?email=$email&token=' . $reset_token;
  

        
   

   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is your link to Reset the password of your Bantayan Island OFRS account';
    $mail->Body    ="
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 80%;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
                padding-bottom: 20px;
                border-bottom: 1px solid #ddd;
            }
            .logo {
                max-width: 150px;
                height: auto;
            }
            .content {
                padding: 20px 0;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
            }
        </style>
</head>
<body>
    <h1>Reset Password</h1>
        
<div class='container'>
<div class='header'>
<img src='images/NHA.png' alt='Logo'>
</div>
</div>
<div class='content'>
<p>Hello,</p>
<p>We received a request to reset your password. Click the button below to reset it:</p>
<p><a href='https://bantayan-bfp.com/admin/forgot/reset_password.php?email=$email&token=$reset_token' class='button'>Reset Password</a>
<p>If you did not request a password reset, please ignore this email.</p>
 
</div>
</body>
 </html>
     ";


    $mail->send();
    return true;
} catch (Exception $e) {
   return false;
}
}

// if (isset($_SESSION['login'])) 
// {
//  header("location: index.php");
// }

// else
// {
    if (isset($_POST['reset'])) {
        $email = mysqli_real_escape_string($bd, $_POST['email']); // Added mysqli_real_escape_string for security
        $check = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($bd, $check);
    
        if ($result && mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(10));
            $update = "UPDATE users SET reset_token = '$reset_token' WHERE email = '$email'";
    
            if (mysqli_query($bd, $update) && sendemail($email, $reset_token)) {
                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Success!",
                                text: "Reset password link sent to your email",
                                icon: "success"
                            });
                        };
                      </script>';
            } else {
                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to send reset password link. Please try again later.",
                                icon: "error"
                            });
                        };
                      </script>';
            }
        } else {
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "No account associated with this email. Please check your email.",
                            icon: "error"
                        });
                    };
                  </script>';
        }
    } else {
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid request. Please try again.",
                        icon: "error"
                    });
                };
              </script>';
    }
    

?>

    <style>
     
      #logo-img{
          width:5em;
          height:5em;
          object-fit:scale-down;
          object-position:center center;
      }
    
  </style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Forgot Password</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary" style="border-radius: 40px;">
    <div class="card-header text-center">
      <center><img src="images/NHA.png" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center>
      <a class="h1"><b>Retrieve</b>|Account</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="" method="post"> <!-- Removed the action to keep it in the same file -->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit"  name="reset" value="Reset" class="btn btn-primary btn-block">Request new password</button>
          </div>
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="index.php">Login</a>
      </p>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
