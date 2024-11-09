<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantayan Island BFP - Reset Password</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-image: url('firebg.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        overflow: hidden;
    }
    .reset-container {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 2.5em;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        width: 320px;
        text-align: center;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }
    .reset-container:hover {
        transform: translateY(-5px);
    }
    .reset-container h2 {
        color: #333;
        margin-bottom: 1.2em;
        font-size: 1.5em;
    }
    .reset-container p {
        font-size: 0.95em;
        margin-bottom: 1.8em;
        color: #555;
    }
    .reset-container form {
        display: flex;
        flex-direction: column;
    }
    .reset-container label {
        margin-bottom: 0.5em;
        font-weight: 600;
        text-align: left;
        font-size: 0.9em;
        color: #555;
    }
    .reset-container input[type="email"], 
    .reset-container input[type="password"],
    .reset-container button {
        padding: 0.85em;
        border-radius: 6px;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 1.2em;
    }
    .reset-container input[type="email"], 
    .reset-container input[type="password"] {
        border: 1px solid #ddd;
        font-size: 0.95em;
        transition: border-color 0.3s;
    }
    .reset-container input[type="email"]:focus,
    .reset-container input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }
    .reset-container button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .reset-container button:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>

<div class="reset-container">
    <h2>Reset Your Password</h2>
    <p>Bantayan Island BFP</p>
    <form action="reset_password_process.php" method="POST">
        <label for="email">Email Address:</label>
        <input type="email" name="email" required placeholder="Enter your email">

        <label for="password">New Password:</label>
        <input type="password" name="password" required placeholder="Enter new password">

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" required placeholder="Confirm new password">

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>