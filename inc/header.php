<?php
require_once('sess_auth.php');

// Set Content Security Policy
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");

// Set additional HTTP security headers
header("X-Content-Type-Options: nosniff"); // Prevents MIME-type sniffing
header("X-Frame-Options: SAMEORIGIN"); // Prevents clickjacking
header("X-XSS-Protection: 1; mode=block"); // Enables XSS filtering
header("Referrer-Policy: no-referrer-when-downgrade"); // Controls referrer information

// HSTS (HTTP Strict Transport Security) - Requires HTTPS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Enable permissions policy to restrict browser features
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

// Set HttpOnly and Secure flags for PHP sessions (if applicable)
ini_set('session.cookie_httponly', 1); // Prevents JavaScript access to session cookies
ini_set('session.cookie_secure', 1); // Requires cookies to be sent over HTTPS
ini_set('session.use_only_cookies', 1); // Ensures sessions only use cookies, not URL parameters
session_start();

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Other necessary plugins and styles... -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url ?>assets/css/styles.css">

    <!-- jQuery and other scripts -->
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
    <script src="<?php echo base_url ?>assets/js/scripts.js"></script>

    <style>
      /* Custom styles */
      body {
          font-family: 'Source Sans Pro', sans-serif;
      }

      #main-header {
          position: relative;
          background: radial-gradient(circle, rgba(0,0,0,0.5) 22%, rgba(0,0,0,0.4) 49%, rgba(0,212,255,0) 100%) !important;
          display: flex;
          align-items: center;
          justify-center: center;
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

      /* Mobile adjustments */
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
</head>

<body class="bg-gray-100 text-gray-900">
    <header id="main-header" class="flex items-center justify-center p-10 md:p-20">
        <h1 class="text-3xl md:text-5xl font-bold"><?php echo $_settings->info('title') ?></h1>
    </header>

    <!-- Additional content goes here -->

    <!-- DataTables wrapper with Tailwind classes for responsiveness -->
    <div class="container mx-auto px-4 mt-8">
        <div class="dataTables_wrapper overflow-x-auto">
            <!-- Data table content -->
        </div>
    </div>
</body>
