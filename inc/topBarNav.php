<style>
  button[type="button"] {
    background-color: transparent !important;
    margin-left: 15px;
    margin: -10px;
  }

  /* Sidebar styling with formal hover effect */
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

  /* Navbar Dropdown - Show on Hover */
  .nav-item .dropdown-menu {
    display: none; /* Initially hide the dropdown */
    position: absolute;
    left: 0;
    top: 100%;
    background-color: #333333; /* Dark background to match the sidebar */
    border: none;
    min-width: 160px;
  }

  .nav-item:hover .dropdown-menu {
    display: block; /* Show the dropdown when hovering over the parent item */
  }

  .nav-item .dropdown-menu .dropdown-item {
    color: white; /* White text */
    padding: 0.5rem 1rem;
    transition: background-color 0.3s ease;
  }

  .nav-item .dropdown-menu .dropdown-item:hover {
    background-color: #ff4600; /* Highlight color on hover */
  }

  /* Sidebar dropdown styling */
  #sidebarAboutDropdown {
    padding-top: 5px;
    list-style: none;
    padding-left: 20px; /* Indent the dropdown items */
  }

  #sidebarAboutDropdown li a {
    color: #fff; /* White text */
    text-decoration: none;
    padding: 0.5rem 1rem;
    display: block;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  #sidebarAboutDropdown li a:hover {
    background-color: #ff4600; /* Formal orange hover background */
    color: #fff;
  }

  .navbar-brand,
  .navbar-nav {
    margin-left: -70px; /* Adjust this value to move more or less */
  }

  .navbar-brand img {
    border-radius: 50%;
  }

  #navbarNav a:hover {
    background-color: #ff4600;
    color: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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

  /* Hover effect for sidebar items */
  .sidebar ul li a:hover {
    background-color: #ff4600; /* Formal orange hover background */
    color: #fff; /* Ensure text stays white */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for more depth */
  }

  /* Active state styling */
  .sidebar ul li a.active {
    background-color: #ff4600; /* Keep the active state similar to hover */
    color: #fff; /* Ensure text stays white */
    font-weight: bold; /* Make the active link bold */
  }

  /* Responsive for smaller devices */
  @media (max-width: 768px) {
    .sidebar ul {
      padding-top: 4rem;
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
