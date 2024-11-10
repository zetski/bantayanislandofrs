<?php
require_once('sess_auth.php');

// Set Content Security Policy
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");

// Set additional HTTP security headers
header("X-Content-Type-Options: nosniff"); 
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />

    <!-- Bootstrap 5 CSS for Responsive Design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7ue4po5MEoK7vOTyZjUld8lG9dK0BSc2q7g" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        #main-header {
            position: relative;
            background: rgb(0, 0, 0) !important;
            background: radial-gradient(circle, rgba(0, 0, 0, 0.5) 22%, rgba(0, 0, 0, 0.4) 49%, rgba(0, 212, 255, 0) 100%) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
            color: white;
        }
        #main-header:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url(<?php echo base_url . $_settings->info('cover') ?>);
            background-repeat: no-repeat;
            background-size: cover;
            filter: drop-shadow(0px 7px 6px black);
            z-index: -1;
        }
        .dataTables_wrapper {
            width: 100%;
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            #main-header {
                padding: 10px;
                font-size: 14px;
            }
            .dataTables_wrapper {
                font-size: 12px;
            }
        }
    </style>

    <!-- jQuery and Bootstrap 5 JS for Responsive Design -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-uJfIJbUzPt1s0iZTkU5MYHbqykAsQ6s6KtC7EKyqElqlLRNPvT4aY1rcj0mJxzBg" crossorigin="anonymous"></script>
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
    <script src="<?php echo base_url ?>assets/js/scripts.js"></script>
</head>
