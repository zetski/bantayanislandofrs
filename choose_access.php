<?php
session_start();
if (isset($_SESSION['role'])) {
    // Redirect based on role if already logged in
    if ($_SESSION['role'] === 'guest') {
        header("Location: ./index");
        exit;
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: ../forgot/verify_email.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/r7logo.png" type="image/png">
    <title>Oline Fire Reporting System</title>
    <style>
        /* Basic styles for the gateway page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        .btn {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .guest-btn {
            background-color: #007bff;
        }
        .admin-btn {
            background-color: #ff4600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Bantayan BFP</h2>
        <button class="btn guest-btn" onclick="window.location.href='./set_guest'">Continue as Guest</button>
        <button class="btn admin-btn" onclick="window.location.href='forgot/verify_email.php'">Login as Admin</button>
    </div>
</body>
</html>
