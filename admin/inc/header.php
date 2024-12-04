<?php
require_once('sess_auth.php');

// Set Content Security Policy
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-cdn.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; base-uri 'self';");
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");

// Set additional HTTP security headers
header("X-Content-Type-Options: nosniff"); // Prevents MIME-type sniffing
header("X-Frame-Options: SAMEORIGIN"); // Prevents clickjacking
header("X-XSS-Protection: 1; mode=block"); // Enables XSS filtering
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("Referrer-Policy: no-referrer-when-downgrade"); // Controls referrer information

// HSTS (HTTP Strict Transport Security) - Requires HTTPS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Enable permissions policy to restrict browser features
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

// Set HttpOnly and Secure flags for PHP sessions (if applicable)
ini_set('session.cookie_httponly', 1); // Prevents JavaScript access to session cookies
ini_set('session.cookie_secure', 1); // Requires cookies to be sent over HTTPS
ini_set('session.use_only_cookies', 1); // Ensures sessions only use cookies, not URL parameters
ini_set('session.cookie_samesite', 'Strict');
session_start();

?>

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('title') != false ? $_settings->info('title') . ' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <style type="text/css">/* Chart.js */
      body {
            overflow-x: hidden;
        }
        .content-wrapper {
            padding: 15px;
        }
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 10px;
            }
        }
        /* Remove white space issue */
        .wrapper {
            margin-left: 0;
        }
    </style>

     <!-- jQuery -->
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>


    <!-- SAKPANNNNN KA HAHAAHAHAHAHHAAHA -->
    <!-- </?php echo html_entity_decode($_settings->load_data()); ?> -->


  </head>