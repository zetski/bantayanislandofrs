<style>
/* Reuse the styles from the first navbar for responsiveness */
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
* {
  margin: 0;
  padding: 0;
  outline: none;
  box-sizing: border-box;
  font-family: 'Montserrat', sans-serif;
}

nav {
  background: #ff4600; /* Match existing navbar color */
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  height: 70px;
  padding: 0 50px;
}

nav .navbar-brand {
  color: #fff;
  font-size: 25px;
  font-weight: 600;
  letter-spacing: -1px;
  display: flex;
  align-items: center;
}

nav .nav-items {
  display: flex;
  flex: 1;
  padding: 0 0 0 40px;
}

nav .nav-items li {
  list-style: none;
  padding: 0 15px;
}

nav .nav-items li a {
  color: #fff;
  font-size: 16px;
  font-weight: 500;
  text-decoration: none;
}

nav .nav-items li a:hover,
nav .nav-item a:hover {
  color: #333;
  background-color: #fff;
  padding: 5px 10px;
  border-radius: 5px;
}

nav .dropdown-menu {
  background-color: #333333;
  border: none;
}

nav .dropdown-menu .dropdown-item {
  color: #fff;
}

nav .dropdown-menu .dropdown-item:hover {
  background-color: #ff4600;
  color: #fff;
}

nav .menu-icon,
nav .cancel-icon {
  width: 40px;
  text-align: center;
  font-size: 18px;
  color: #fff;
  cursor: pointer;
  display: none;
}

/* Sidebar-specific styles */
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

.sidebar ul li a.active {
  background-color: #ff4600;
  color: #fff;
  font-weight: bold;
}

@media (max-width: 1140px) {
  nav {
    padding: 0 20px;
  }

  nav .nav-items {
    position: fixed;
    z-index: 99;
    top: 70px;
    width: 100%;
    left: -100%;
    height: 100%;
    padding: 10px 50px 0 50px;
    background: #333333;
    transition: left 0.3s ease;
  }

  nav .nav-items.active {
    left: 0px;
  }

  nav .menu-icon {
    display: block;
  }
}
</style>

<nav>
  <div class="navbar-brand">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" alt="Logo">
    <?php echo $_settings->info('short_name') ?>
  </div>
  <div class="menu-icon">
    <span class="fas fa-bars"></span>
  </div>
  <ul class="nav-items">
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a href="javascript:void(0)" id="search_report">View Status</a></li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">About Us</a>
      <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
        <li><a class="dropdown-item" href="./about/aboutB.php">Bantayan</a></li>
        <li><a class="dropdown-item" href="./about/aboutS.php">Santa Fe</a></li>
        <li><a class="dropdown-item" href="./about/aboutM.php">Madridejos</a></li>
      </ul>
    </li>
    <li><a href="./citizencharter.php">Citizen Charter</a></li>
    <li><a href="./safetytips.php">Safety Tips</a></li>
  </ul>
  <div class="cancel-icon">
    <span class="fas fa-times"></span>
  </div>
</nav>
<div class="sidebar" id="sidebarMenu">
  <ul>
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a href="javascript:void(0)" id="search_report_sidebar">View Status</a></li>
    <li>
      <a href="javascript:void(0)" id="aboutSidebarDropdown" data-bs-toggle="collapse" data-bs-target="#sidebarAboutDropdown" aria-expanded="false">About Us</a>
      <ul class="collapse" id="sidebarAboutDropdown">
        <li><a href="./about/aboutB.php">Bantayan</a></li>
        <li><a href="./about/aboutS.php">Santa Fe</a></li>
        <li><a href="./about/aboutM.php">Madridejos</a></li>
      </ul>
    </li>
    <li><a href="./citizencharter.php">Citizen Charter</a></li>
    <li><a href="./safetytips.php">Safety Tips</a></li>
  </ul>
</div>
<script>
  const menuIcon = document.querySelector('.menu-icon span');
  const cancelIcon = document.querySelector('.cancel-icon span');
  const navItems = document.querySelector('.nav-items');
  menuIcon.onclick = () => navItems.classList.add('active');
  cancelIcon.onclick = () => navItems.classList.remove('active');

  // Sidebar functionality
  document.querySelector('#sidebarToggle').addEventListener('click', () => {
    document.querySelector('#sidebarMenu').classList.toggle('show');
  });
</script>
