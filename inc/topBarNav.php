<?php
session_start();
// Example roles for testing
// Uncomment or modify these to simulate different roles.
// $_SESSION['role'] = 'guest'; // Uncomment to simulate guest role
// $_SESSION['role'] = 'admin'; // Uncomment to simulate admin role
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role-Based Navigation with Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        button[type="button"] {
            background-color: transparent !important;
            margin-left: 15px;
            margin: -10px;
        }
        /* Sidebar styling */
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            width: 250px;
            height: 100%;
            background-color: #333333;
            transition: left 0.3s ease;
            z-index: 1000;
        }
        .sidebar.show {
            left: 0;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1.5rem;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar ul li a:hover {
            background-color: #ff4600;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        #sidebarAboutDropdown {
            padding-left: 20px;
        }
        #sidebarAboutDropdown li a {
            padding: 0.5rem 1.5rem;
        }
        
        /* Navbar styling */
        .navbar {
            background-color: #ff4600;
        }
        .navbar-brand img {
            border-radius: 50%;
        }
        .nav-link {
            color: white !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar ul {
                padding-top: 4rem;
            }
        }
    </style>
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="./">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" alt="Logo" loading="lazy">
            <?php echo $_settings->info('short_name') ?>
        </a>
        <button class="navbar-toggler btn btn-sm" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="./">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="./?p=report">Report</a></li>
                <li class="nav-item"><a class="nav-link" id="search_report" href="javascript:void(0)">View Status</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="./about/aboutB.php">Bantayan</a></li>
                        <li><a class="dropdown-item" href="./about/aboutS.php">Santa Fe</a></li>
                        <li><a class="dropdown-item" href="./about/aboutM.php">Madridejos</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="./citizencharter.php" class="nav-link">Citizen Charter</a></li>
                <li class="nav-item"><a href="./safetytips.php" class="nav-link">Safety Tips</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Show Login link for admin only -->
                    <!-- <a class="font-weight-bolder text-light mx-2 text-decoration-none" href="logout.php">Logout</a> -->
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebarMenu">
    <ul>
        <li><a href="./">Home</a></li>
        <li><a href="./?p=report">Report</a></li>
        <li><a href="javascript:void(0)" id="search_report_sidebar">View Status</a></li>
        <li>
            <a href="javascript:void(0)" class="nav-link text-white" id="aboutSidebarDropdown" data-toggle="collapse" data-target="#sidebarAboutDropdown" aria-expanded="false">
                About Us
            </a>
            <ul class="collapse" id="sidebarAboutDropdown">
                <li><a class="nav-link text-white" href="./about/aboutB.php">Bantayan</a></li>
                <li><a class="nav-link text-white" href="./about/aboutM.php">Madridejos</a></li>
                <li><a class="nav-link text-white" href="./about/aboutS.php">Santa Fe</a></li>
            </ul>
        </li>
        <li><a href="./?p=citizencharter">Citizen Charter</a></li>
        <li><a href="./?p=safetytips">Safety Tips</a></li>
    </ul>
</div>

<!-- JavaScript for Sidebar Toggle and Dropdowns -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle sidebar
        $('#sidebarToggle').click(function() {
            $('#sidebarMenu').toggleClass('show');
        });

        // Toggle About Us dropdown in sidebar
        $('#aboutSidebarDropdown').click(function() {
            $('#sidebarAboutDropdown').collapse('toggle');
        });

        // Modal functionality for search report
        $('#search_report, #search_report_sidebar').click(function() {
          uni_modal("Search Request Report", "report/search.php");
      });
    });
</script>

</body>
</html>
