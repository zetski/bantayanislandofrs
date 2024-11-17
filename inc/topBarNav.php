<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Navbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }
    body {
      background: #f2f2f2;
      margin: 0;
      padding-top: 70px; /* Fixes the top spacing issue */
    }
    nav {
      background: #ff4600;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      height: 70px;
      padding: 0 20px;
    }
    nav .logo {
      display: flex;
      align-items: center;
    }
    nav .logo img {
      border-radius: 50%;
      margin-right: 10px;
    }
    nav .logo span {
      color: #fff;
      font-size: 22px;
      font-weight: 600;
    }
    nav .nav-items {
      display: flex;
      flex: 1;
      justify-content: flex-end;
    }
    nav .nav-items li {
      list-style: none;
      margin: 0 15px;
    }
    nav .nav-items li a {
      color: #fff;
      font-size: 16px;
      text-decoration: none;
    }
    nav .nav-items li a:hover {
      color: #ffdab3;
    }
    nav .menu-icon {
      display: none;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
    }
    @media (max-width: 768px) {
      nav .nav-items {
        display: none;
        flex-direction: column;
        background: #ff4600;
        position: absolute;
        top: 70px;
        right: 0;
        width: 100%;
        padding: 10px 0;
      }
      nav .nav-items.active {
        display: flex;
      }
      nav .nav-items li {
        margin: 10px 0;
        text-align: center;
      }
      nav .menu-icon {
        display: block;
      }
    }
  </style>
</head>
<body>
  <nav>
    <div class="logo">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Logo" width="40" height="40">
      <span><?php echo $_settings->info('short_name') ?></span>
    </div>
    <ul class="nav-items">
      <li><a href="./">Home</a></li>
      <li><a href="./?p=report">Report</a></li>
      <li><a href="javascript:void(0)" id="search_report">View Status</a></li>
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
      <li><a href="./citizencharter.php">Citizen Charter</a></li>
      <li><a href="./safetytips.php">Safetytips</a></li>
      <li><a href="./admin">Login</a></li>
    </ul>
    <div class="menu-icon">
      <i class="fas fa-bars"></i>
    </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar dropdown for About Us
    $(document).ready(function () {
      $('.dropdown-toggle').dropdown();
    });

    // View Status functionality
    document.getElementById('search_report').addEventListener('click', function () {
      alert('View Status functionality triggered!');
      // Add the actual implementation here.
    });

    // Responsive menu toggle
    const menuIcon = document.querySelector(".menu-icon");
    const navItems = document.querySelector(".nav-items");

    menuIcon.addEventListener("click", () => {
      navItems.classList.toggle("active");
    });
  </script>
</body>
</html>
