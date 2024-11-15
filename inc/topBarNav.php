<style>
  button[type="button"]{
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

  /* Style for the About Us Dropdown */
.nav-item .dropdown-menu {
  background-color: #333333; /* Match sidebar background */
  border: none;
}

.nav-item .dropdown-menu .dropdown-item {
  color: white; /* White text */
}

.nav-item .dropdown-menu .dropdown-item:hover {
  background-color: #ff4600; /* Orange hover effect */
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

  .navbar-brand img{
    border-radius: 50%;
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
  @media (max-width: 767px) {
  .navbar {
    background-color: #ff4600; /* Keep the background color */
    padding: 10px 0; /* Adjust padding for mobile */
  }

  .navbar .container {
    padding: 0 15px; /* Ensure proper padding on smaller screens */
  }

  .navbar-collapse {
    display: block; /* Ensure the menu collapses on mobile */
    text-align: center; /* Center the items when collapsed */
  }

  .navbar-nav {
    flex-direction: column; /* Stack navbar items vertically */
    width: 100%;
  }

  .navbar-nav .nav-item {
    width: 100%; /* Ensure the nav items take up full width */
    text-align: center;
  }

  .navbar-toggler {
    border: 1px solid white; /* Optional: Add a border around the hamburger icon */
  }

  .navbar-toggler-icon {
    background-color: white; /* Change the hamburger icon color */
  }
}
</style>

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
        <!-- <li class="nav-item"><a class="nav-link text-white" href="./?p=contact">Contact Us</a></li> -->
         <li class="nav-item"><a href="./citizencharter.php" class="nav-link text-white">Citizen Charter</a></li>
         <li class="nav-item"><a href="./safetytips.php" class="nav-link text-white">Safetytips</li>
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
    <li><a href="./?p=safetytips">Safetytips</li>
    <li><a href="./admin">Login</a></li>
  </ul>
</div>

<script>
  //navbar dropdown about us
  $(document).ready(function() {
  $('.dropdown-toggle').dropdown();
});

$(document).ready(function() {
  // Sidebar toggle for About Us dropdown
  $('#aboutSidebarDropdown').click(function() {
    $('#sidebarAboutDropdown').collapse('toggle');
  });
});

  $(document).ready(function() {
    $('#sidebarToggle').click(function() {
      $('#sidebarMenu').toggleClass('show');
    });

    // Modal for search report
    $('#search_report, #search_report_sidebar').click(function() {
      uni_modal("Search Request Report", "report/search.php");
    });
  });
</script>
