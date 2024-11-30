<?php
ob_start();
session_start();
require_once('../initialize.php'); // Include your database connection

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    // Validate OTP
    if (isset($_SESSION['otp_email'])) {
        $email = $_SESSION['otp_email'];

        // Check the OTP and expiry in the database
        $stmt = $con->prepare("SELECT otp_code, otp_expiry FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $otp_code = $row['otp_code'];
            $otp_expiry = $row['otp_expiry'];

            // Check if OTP matches and is still valid
            if ($entered_otp == $otp_code) {
                if (strtotime($otp_expiry) >= time()) {
                    // OTP verified successfully
                    $_SESSION['role'] = 'admin'; // Assign the admin role
                    header("Location: https://bantayan-bfp.com/admin/login");
                    exit;
                } else {
                    $error = "OTP has expired. Please request a new one.";
                }
            } else {
                $error = "Invalid OTP. Please try again.";
            }
        } else {
            $error = "No OTP record found. Please try again.";
        }
    } else {
        $error = "No OTP session found or session expired.";
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333333;
        }

        p {
            font-size: 14px;
            color: #666666;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #444444;
            margin-bottom: 10px;
            text-align: left;
        }

        input[type="text"] {
            padding: 10px 15px;
            font-size: 14px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 20px;
            outline: none;
        }

        input[type="text"]:focus {
            border-color: #007bff;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verify OTP</h1>
        <p>Enter the one-time password (OTP) sent to your registered email address.</p>
        <form method="POST">
            <label for="otp">Enter OTP</label>
            <input type="text" name="otp" id="otp" placeholder="Enter your OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>

    <?php if (!empty($error)) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error; ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>
</html>
