<style>
  /* General Reset */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f2f2f2;
  }

  /* Navbar styling */
  nav.navbar {
    background-color: #171c24;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    position: fixed;
    width: 100%;
    z-index: 1000;
  }

  nav .navbar-brand {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
  }

  nav .navbar-brand img {
    border-radius: 50%;
    margin-right: 10px;
    width: 40px;
    height: 40px;
  }

  nav ul.navbar-nav {
    display: flex;
    align-items: center;
    list-style: none;
  }

  nav ul.navbar-nav li {
    margin: 0 10px;
  }

  nav ul.navbar-nav li a {
    color: #fff;
    font-size: 16px;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background 0.3s ease;
  }

  nav ul.navbar-nav li a:hover {
    background: #ff4600;
    color: #fff;
  }

  nav ul.navbar-nav .dropdown-menu {
    display: none;
    position: absolute;
    top: 70px;
    background: #333333;
    border: none;
    list-style: none;
    padding: 10px 0;
  }

  nav ul.navbar-nav .dropdown-menu a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 10px 20px;
  }

  nav ul.navbar-nav .dropdown-menu a:hover {
    background: #ff4600;
  }

  nav ul.navbar-nav .dropdown:hover .dropdown-menu {
    display: block;
  }

  nav .sidebar-toggle {
    display: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
  }

  /* Sidebar styling */
  .sidebar {
    position: fixed;
    left: -250px;
    top: 0;
    width: 250px;
    height: 100%;
    background-color: #333333;
    z-index: 999;
    transition: left 0.3s ease;
  }

  .sidebar.show {
    left: 0;
  }

  .sidebar ul {
    list-style: none;
    padding: 20px 0;
  }

  .sidebar ul li {
    padding: 0;
  }

  .sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 10px 20px;
    transition: background 0.3s ease;
  }

  .sidebar ul li a:hover {
    background: #ff4600;
  }

  .sidebar ul li .dropdown-menu {
    display: none;
    background: #444;
    padding-left: 20px;
  }

  .sidebar ul li a.dropdown-toggle:hover + .dropdown-menu {
    display: block;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    nav ul.navbar-nav {
      display: none;
    }

    nav .sidebar-toggle {
      display: block;
    }

    .sidebar {
      width: 100%;
    }

    .sidebar ul {
      padding-top: 4rem;
    }
  }
</style>

<nav class="navbar">
  <a class="navbar-brand" href="./">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Logo">
    <?php echo $_settings->info('short_name') ?>
  </a>
  <div class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </div>
  <ul class="navbar-nav">
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a id="search_report" href="javascript:void(0)">View Status</a></li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle">About Us</a>
      <ul class="dropdown-menu">
        <li><a href="./about/aboutB.php">Bantayan</a></li>
        <li><a href="./about/aboutS.php">Santa Fe</a></li>
        <li><a href="./about/aboutM.php">Madridejos</a></li>
      </ul>
    </li>
    <li><a href="./citizencharter.php">Citizen Charter</a></li>
    <li><a href="./safetytips.php">Safety Tips</a></li>
    <li><a href="./admin">Login</a></li>
  </ul>
</nav>

<div class="sidebar" id="sidebarMenu">
  <ul>
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a id="search_report_sidebar" href="javascript:void(0)">View Status</a></li>
    <li>
      <a class="dropdown-toggle" href="#">About Us</a>
      <ul class="dropdown-menu">
        <li><a href="./about/aboutB.php">Bantayan</a></li>
        <li><a href="./about/aboutS.php">Santa Fe</a></li>
        <li><a href="./about/aboutM.php">Madridejos</a></li>
      </ul>
    </li>
    <li><a href="./citizencharter.php">Citizen Charter</a></li>
    <li><a href="./safetytips.php">Safety Tips</a></li>
    <li><a href="./admin">Login</a></li>
  </ul>
</div>

<script>
  document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('show');
  });

  document.getElementById('search_report').addEventListener('click', function () {
    uni_modal("Search Request Report", "report/search.php");
  });

  document.getElementById('search_report_sidebar').addEventListener('click', function () {
    uni_modal("Search Request Report", "report/search.php");
  });
</script>
