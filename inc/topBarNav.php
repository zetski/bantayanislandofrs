<style>
  /* General Button Styling */
  button[type="button"] {
    background-color: transparent !important;
    margin-left: 15px;
    margin: -10px;
  }

  /* Sidebar Styling */
  .sidebar {
    position: fixed;
    left: -250px;
    top: 0;
    width: 250px;
    height: 100%;
    background-color: #333333; /* Darker sidebar background */
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

  .sidebar ul li {
    padding: 0;
  }

  .sidebar ul li a {
    color: #fff; /* White text */
    text-decoration: none;
    display: block;
    padding: 0.75rem 1.5rem; /* Adjusted padding for better spacing */
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .sidebar ul li a:hover {
    background-color: #ff4600; /* Formal orange hover background */
    color: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
  }

  .sidebar ul li a.active {
    background-color: #ff4600; /* Active state similar to hover */
    color: #fff;
    font-weight: bold;
  }

  /* Sidebar Dropdown Styling */
  #sidebarAboutDropdown {
    padding-top: 5px;
    list-style: none;
    padding-left: 20px;
  }

  #sidebarAboutDropdown li a {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    display: block;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  #sidebarAboutDropdown li a:hover {
    background-color: #ff4600;
    color: #fff;
  }

  /* Navbar Styling */
  .navbar {
    background-color: #ff4600;
    flex-wrap: nowrap;
    overflow: hidden;
  }

  .navbar-brand img {
    border-radius: 50%;
    max-width: 30px;
    max-height: 30px;
  }

  .navbar-nav {
    flex-wrap: wrap;
  }

  .navbar-nav .nav-item {
    margin-right: 5px;
  }

  .nav-item .dropdown-menu {
    display: none; /* Initially hide the dropdown */
    position: absolute;
    left: 0;
    top: 100%;
    background-color: #333333;
    border: none;
    min-width: 160px;
  }

  .nav-item:hover .dropdown-menu {
    display: block; /* Show dropdown on hover */
  }

  .nav-item .dropdown-menu .dropdown-item {
    color: white;
    padding: 0.5rem 1rem;
    transition: background-color 0.3s ease;
  }

  .nav-item .dropdown-menu .dropdown-item:hover {
    background-color: #ff4600;
  }

  /* Navbar Responsiveness */
  .navbar-toggler {
    padding: 0.25rem 0.5rem;
    margin: 0 10px;
    border: none;
    outline: none;
  }

  .navbar-toggler-icon {
    background-image: none;
  }

  .navbar-brand {
    font-size: 16px;
    white-space: nowrap;
  }

  .navbar-nav .nav-link {
    font-size: 16px;
    padding: 0.5rem;
  }

  .navbar-collapse {
    max-height: calc(100vh - 56px);
    overflow-y: auto; /* Add scrolling for overflow */
  }

  #navbarNav a:hover {
    background-color: #ff4600;
    color: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .navbar-brand {
      font-size: 14px; /* Smaller font for smaller screens */
    }

    .navbar-nav {
      flex-direction: column;
    }

    .navbar-nav .nav-link {
      font-size: 14px;
      padding: 0.25rem 0.5rem;
    }

    .sidebar {
      width: 100%; /* Full width for smaller screens */
      max-height: calc(100vh - 56px);
      overflow-y: auto;
    }

    .sidebar ul {
      padding-top: 1rem;
    }

    .sidebar ul li a {
      font-size: 14px; /* Smaller font for sidebar */
    }
  }

  @media (max-width: 576px) {
    .navbar-nav {
      overflow-x: auto; /* Allow horizontal scrolling for very small screens */
      white-space: nowrap;
    }

    .navbar-nav .nav-link {
      font-size: 12px;
      padding: 0.2rem 0.4rem;
    }

    .sidebar ul li a {
      font-size: 12px;
      padding: 0.5rem 1rem;
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
