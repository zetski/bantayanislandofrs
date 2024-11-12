

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
