<style>
  /* General Body Styling */
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
  }

  /* Topbar Adjustment */
  nav.navbar {
    z-index: 1050;
    position: sticky;
    top: 0;
    width: 100%;
    background-color: #ff4600;
  }

  /* Ensure topbar doesn't overlap the carousel */
  body {
    padding-top: 60px; /* Adjust for fixed navbar height */
  }

  /* Carousel Styling */
  .carousel-item > img {
    object-fit: cover !important;
    height: 20em; /* Desktop height */
    width: 100%;
  }

  #carouselExampleControls .carousel-inner {
    height: 20em; /* Match carousel image height */
  }

  /* Button Styling */
  .btn {
    color: #fff;
    margin-top: 15px;
    background-color: #f46000;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .btn:focus,
  .btn:hover {
    outline: none;
    box-shadow: 0 12px 16px rgba(0, 0, 0, 0.24), 0 17px 50px rgba(0, 0, 0, 0.19);
    background-color: #e35000;
  }

  /* Card Section Styling */
  .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
  }

  .card-body {
    padding: 1.5rem;
  }

  /* Sidebar Styling */
  .sidebar {
    position: fixed;
    top: 60px; /* Matches the navbar height */
    left: -250px;
    width: 250px;
    height: 100%;
    background-color: #333333;
    z-index: 1000;
    transition: left 0.3s ease-in-out;
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
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    display: block;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .sidebar ul li a:hover {
    background-color: #ff4600;
  }

  /* Media Queries */
  @media (max-width: 992px) {
    .carousel-item > img {
      height: 15em; /* Tablet height */
    }

    #carouselExampleControls .carousel-inner {
      height: 15em; /* Match carousel image height */
    }

    .btn {
      font-size: 14px;
      padding: 8px 15px;
    }
  }

  @media (max-width: 768px) {
    .carousel-item > img {
      height: 12em; /* Mobile height */
    }

    #carouselExampleControls .carousel-inner {
      height: 12em; /* Match carousel image height */
    }

    .btn {
      font-size: 12px;
      padding: 6px 10px;
      margin-left: 10px;
    }

    .card-body {
      padding: 1rem;
    }

    .sidebar {
      width: 200px;
    }

    nav.navbar .navbar-toggler {
      margin-left: auto;
    }
  }

  @media (max-width: 576px) {
    .carousel-item > img {
      height: 10em; /* Smaller mobile height */
    }

    #carouselExampleControls .carousel-inner {
      height: 10em; /* Match carousel image height */
    }

    .btn {
      font-size: 10px;
      padding: 5px 8px;
      margin-left: 5px;
    }

    nav.navbar .navbar-brand {
      font-size: 14px;
    }

    .sidebar {
      width: 180px;
    }
  }
</style>

<?php
session_start();
// Example roles for testing
// Uncomment or modify these to simulate different roles.
// $_SESSION['role'] = 'guest'; // Uncomment to simulate guest role
// $_SESSION['role'] = 'admin'; // Uncomment to simulate admin role
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #ff4600;">
  <div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="./">
      <img src="../img/r7logo.png" width="30" height="30" alt="Brand Logo" loading="lazy">
      Bantayan Fire Station
    </a>
    <button class="navbar-toggler btn btn-sm" type="button" id="sidebarToggle" style="background-color: transparent !important; margin-left: 10px; border: none; padding-right: 10px; padding-top: 11px;">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link text-white" href="./">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="./?p=report">Report</a></li>
        <li class="nav-item"><a class="nav-link text-white" id="search_report" href="javascript:void(0)">View Status</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            About Us
          </a>
          <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
            <li><a class="dropdown-item" href="./about/aboutB.php">Bantayan</a></li>
            <li><a class="dropdown-item" href="./about/aboutS.php">Santa Fe</a></li>
            <li><a class="dropdown-item" href="./about/aboutM.php">Madridejos</a></li>
          </ul>
        </li>
        <li class="nav-item"><a href="./citizen_chart.html" class="nav-link text-white">Citizen Charter</a></li>
        <li class="nav-item"><a href="./safetips.html" class="nav-link text-white">Safety Tips</a></li>
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

<!-- Sidebar content -->
<div class="sidebar" id="sidebarMenu">
  <ul>
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a href="javascript:void(0)" id="search_report_sidebar">View Status</a></li>
    <!-- sidebar dropdown about us -->
    <li class="nav-item">
      <a href="javascript:void(0)" class="nav-link text-white" id="aboutSidebarDropdown" data-bs-toggle="collapse" data-bs-target="#sidebarAboutDropdown" aria-expanded="false">
        About Us
      </a>
      <ul class="collapse" id="sidebarAboutDropdown">
        <li><a class="nav-link text-white" href="./about/aboutB.php">Bantayan</a></li>
        <li><a class="nav-link text-white" href="./about/aboutM.php">Madridejos</a></li>
        <li><a class="nav-link text-white" href="./about/aboutS.php">Santa Fe</a></li>
      </ul>
    </li>
    <li><a href="./citizen_chart.html">Citizen Charter</a></li>
    <li><a href="./safetips.html">Safety Tips</a></li>
    <!-- <li><a href="./admin">Login</a></li> -->
  </ul>
</div>

<script>
  $(document).ready(function() {
    // Initialize the navbar dropdown for "About Us"
    $('#aboutDropdown').on('click', function (e) {
      var $el = $(this).next('.dropdown-menu');
      var isVisible = $el.is(':visible');
      // Slide up all dropdowns
      $('.dropdown-menu').slideUp('400');
      // If this wasn't already visible, slide it down
      if (!isVisible) {
        $el.stop(true, true).slideDown('400');
      }
    });

    // Sidebar toggle for About Us dropdown (sidebar version)
    $('#aboutSidebarDropdown').click(function() {
      $('#sidebarAboutDropdown').collapse('toggle');
    });

    // Sidebar toggle button (to show/hide the entire sidebar)
    $('#sidebarToggle').click(function() {
      $('#sidebarMenu').toggleClass('show');
    });

    // Modal for search report
    $('#search_report, #search_report_sidebar').click(function() {
      uni_modal("Search Request Report", "report/search.php");
    });
  });
</script>
