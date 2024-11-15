<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    /* Modal styling */
    .modal-content {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
      border-bottom: none;
    }
    .modal-body {
      text-align: center;
    }
    .form-control {
      border-radius: 30px;
      border: 1px solid #ccc;
      padding: 10px 20px;
      font-size: 16px;
    }
    .form-control:focus {
      box-shadow: 0 0 10px rgba(255, 70, 0, 0.5);
      border-color: #ff4600;
    }
    .btn-submit {
      background-color: #ff4600;
      border: none;
      color: #fff;
      border-radius: 30px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn-submit:hover {
      background-color: #e14500;
    }
    .g-recaptcha {
      display: inline-block;
      margin: 15px auto;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #ff4600;">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="./">
        <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" alt="Logo" loading="lazy">
        <?php echo $_settings->info('short_name') ?>
      </a>
      <button class="navbar-toggler btn btn-sm" type="button" id="sidebarToggle" style="background-color: transparent !important; margin-left: 10px; border: none; padding-right: 10px;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item"><a class="nav-link text-white" href="./">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="./?p=report">Report</a></li>
          <li class="nav-item"><a class="nav-link text-white" id="search_report" href="javascript:void(0)">View Status</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <a class="font-weight-bolder text-light mx-2 text-decoration-none" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#emailVerifyModal">Login</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Email Verification Modal -->
  <div class="modal fade" id="emailVerifyModal" tabindex="-1" aria-labelledby="emailVerifyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <form id="emailVerifyForm" method="POST" action="verify_email.php">
            <div class="mb-4">
              <input type="email" class="form-control" id="email" name="email" placeholder="Type your email" required>
            </div>
            <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
            <button type="submit" class="btn btn-submit">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    $(document).ready(function () {
      $('#search_report').click(function () {
        uni_modal("Search Request Report", "report/search.php");
      });
    });
  </script>
</body>
</html>
