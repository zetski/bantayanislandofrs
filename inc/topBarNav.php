<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Updated Navbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }
    body {
      margin: 0;
      padding-top: 70px; /* Adjust based on navbar height */
    }
    nav {
      background: #ff4600;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
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
    nav .nav-items li ul {
      display: none;
      position: absolute;
      background: #fff;
      padding: 10px;
      list-style: none;
      margin-top: 10px;
      border-radius: 5px;
    }
    nav .nav-items li:hover ul {
      display: block;
    }
    nav .nav-items li ul li {
      margin: 5px 0;
    }
    nav .nav-items li ul li a {
      color: #000;
    }
    nav .menu-icon {
      display: none;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
    }
    .sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      width: 250px;
      background: #333;
      color: #fff;
      height: 100%;
      z-index: 1001;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      margin: 20px 0;
    }
    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      font-size: 18px;
    }
    .sidebar ul li a:hover {
      text-decoration: underline;
    }
    .content {
      margin-left: 270px; /* Account for sidebar width */
      padding: 20px;
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
      }
      nav .nav-items.active {
        display: flex;
      }
      nav .menu-icon {
        display: block;
      }
      .sidebar {
        width: 200px;
      }
      .content {
        margin-left: 220px;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav>
    <div class="logo">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Logo" width="40" height="40">
      <span><?php echo $_settings->info('short_name') ?></span>
    </div>
    <ul class="nav-items">
      <li><a href="./">Home</a></li>
      <li><a href="./?p=report">Report</a></li>
      <li><a href="javascript:void(0)" id="search_report">View Status</a></li>
      <li>
        <a href="javascript:void(0)">About Us</a>
        <ul>
          <li><a href="./about/aboutB.php">Bantayan</a></li>
          <li><a href="./about/aboutS.php">Santa Fe</a></li>
          <li><a href="./about/aboutM.php">Madridejos</a></li>
        </ul>
      </li>
      <li><a href="./citizencharter.php">Citizen Charter</a></li>
      <li><a href="./safetytips.php">Safety Tips</a></li>
      <li><a href="./admin">Login</a></li>
    </ul>
    <div class="menu-icon">
      <i class="fas fa-bars"></i>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar">
    <ul>
      <li><a href="#">Sidebar Link 1</a></li>
      <li><a href="#">Sidebar Link 2</a></li>
      <li><a href="#">Sidebar Link 3</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div class="content">
    <h1>Welcome</h1>
    <p>Your content goes here.</p>
  </div>

  <script>
    // Toggle mobile menu
    const menuIcon = document.querySelector(".menu-icon");
    const navItems = document.querySelector(".nav-items");

    menuIcon.addEventListener("click", () => {
      navItems.classList.toggle("active");
    });

    // View Status functionality
    document.getElementById('search_report').addEventListener('click', () => {
      alert('View Status functionality triggered!');
      // Add your functionality here
    });
  </script>
</body>
</html>
