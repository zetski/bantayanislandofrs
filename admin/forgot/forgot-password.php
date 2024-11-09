<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .forgot-password-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .forgot-password-img {
            object-fit: cover;
            border-radius: 10px 0 0 10px;
        }
        .col-md-8{
            position: center;
            padding-top: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card forgot-password-card">
                    <div class="row g-0">
                        <!-- Left side image -->
                        <div class="col-md-6">
                            <img src="../img/r7logo.png" class="img-fluid forgot-password-img h-100 w-100">
                        </div>
                        <!-- Right side form -->
                        <div class="col-md-6">
                            <div class="card-body p-4" style="padding-top: 20px; margin-top: 50px">
                                <h4 class="card-title text-center mb-4">Forgot Password</h4>
                                <form action="forgot_password.php" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Enter your email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </form>
                                <div class="text-center mt-3">
                                    <a href="../login.php" class="text-decoration-none">Back to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
