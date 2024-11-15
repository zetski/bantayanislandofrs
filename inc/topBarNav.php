<style>
  /* General styling */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  
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

  /* Sidebar list items */
  .sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar ul li {
    padding: 0;
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

  .sidebar ul li a.active {
    background-color: #ff4600;
    color: #fff;
    font-weight: bold;
  }

  /* Navbar styling */
  .navbar {
    background-color: #ff4600;
    padding: 10px 0;
  }

  .navbar-brand img {
    border-radius: 50%;
  }

  .navbar-nav {
    margin-left: -70px;
  }

  .navbar-nav .nav-link {
    color: #fff;
    padding-left: 1rem;
  }

  .navbar-toggler {
    border: none;
    background-color: transparent;
  }

  .navbar-toggler-icon {
    background-color: #fff;
  }

  /* Navbar Dropdown */
  .nav-item .dropdown-menu {
    background-color: #333333;
    border: none;
  }

  .nav-item .dropdown-item {
    color: white;
  }

  .nav-item .dropdown-item:hover {
    background-color: #ff4600;
  }

  /* Responsive design for mobile */
  @media (max-width: 768px) {
    /* Adjust the navbar for mobile */
    .navbar-nav {
      margin-left: 0;
    }

    .sidebar {
      width: 200px;
    }

    .sidebar ul li a {
      padding: 1rem 1.5rem;
      font-size: 14px;
    }

    .navbar-toggler {
      margin-left: 10px;
    }
  }

  /* For very small mobile screens */
  @media (max-width: 480px) {
    .navbar-brand img {
      width: 25px;
      height: 25px;
    }

    .navbar-nav .nav-link {
      font-size: 14px;
    }

    .sidebar ul li a {
      padding-top: 20px;
      font-size: 14px;
      padding: 0.75rem;
    }

    .sidebar {
      width: 180px;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="./">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" alt="Logo" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>
    <button class="navbar-toggler btn btn-lg" type="button" id="sidebarToggle" style="border: none;">
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
        <li class="nav-item"><a href="./citizencharter.php" class="nav-link text-white">Citizen Charter</a></li>
        <li class="nav-item"><a href="./safetytips.php" class="nav-link text-white">Safetytips</a></li>
      </ul>
      <div class="d-flex align-items-center">
        <a class="font-weight-bolder text-light mx-2 text-decoration-none" href="./admin">Login</a>
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
    <li><a href="./?p=citizencharter">Citizen Charter</a></li>
    <li><a href="./?p=safetytips">Safetytips</a></li>
    <li><a href="./admin">Login</a></li>
  </ul>
</div>

<script>
  $(document).ready(function() {
    // Sidebar toggle for About Us dropdown
    $('#aboutSidebarDropdown').click(function() {
      $('#sidebarAboutDropdown').collapse('toggle');
    });

    // Sidebar toggle for menu
    $('#sidebarToggle').click(function() {
      $('#sidebarMenu').toggleClass('show');
    });

    // Modal for search report
    $('#search_report, #search_report_sidebar').click(function() {
      uni_modal("Search Request Report", "report/search.php");
    });
  });
</script>
