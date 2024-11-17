<style>
  @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
  * {
    margin: 0;
    padding: 0;
    outline: none;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
  }
  html, body{
    margin: 0;
    padding: 0;
  }
  /* body {
    background: #f2f2f2;
  } */
  nav {
    background: #f46000;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    margin: 0;
    padding: 0 100px;
  }
  nav .logo {
  text-align: center; /* Center align the logo */
  display: flex;
  align-items: center;
  justify-content: center;
  }
  nav .logo a{
  text-decoration: none; /* Remove underline */
  color: #fff; /* Change text color to white */
  display: flex;
  align-items: center;
  }
  nav .logo img {
  border-radius: 50%; /* Make the logo circular */
  width: 50px; /* Adjust the size if necessary */
  height: 50px; /* Ensure consistent dimensions */
  margin-right: 10px; /* Add space between the logo and the short name */
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
    font-size: 18px;
    font-weight: 500;
    text-decoration: none;
  }
  nav .nav-items li a:hover {
    color: #ff3d00;
  }
  nav .menu-icon,
  nav .cancel-icon {
    display: none;
    font-size: 18px;
    color: #fff;
    cursor: pointer;
    margin: 0 20px;
  }
  @media (max-width: 1140px) {
    nav {
      padding: 0 20px;
    }
    nav .nav-items {
      position: fixed;
      top: 70px;
      left: -100%;
      width: 100%;
      height: 100%;
      background: #14181f;
      text-align: center;
      display: block;
      transition: left 0.3s ease;
    }
    nav .nav-items.active {
      left: 0;
    }
    nav .nav-items li {
      margin: 30px 0;
    }
    nav .menu-icon,
    nav .cancel-icon {
      display: block;
    }
    nav .menu-icon {
      order: 1;
    }
    nav .cancel-icon {
      display: none;
    }
    nav .cancel-icon.show {
      display: block;
    }
  }
</style>

<nav class="fixed-top">
  <div class="menu-icon">
    <span class="fas fa-bars"></span>
  </div>
  <div class="logo">
    <a href="./">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" alt="Logo" loading="lazy" />
      <?php echo $_settings->info('short_name') ?>
    </a>
  </div>
  <div class="nav-items">
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a href="javascript:void(0)" id="search_report">View Status</a></li>
    <li class="dropdown">
      <a href="javascript:void(0)" id="aboutDropdown">About Us</a>
      <ul class="dropdown-menu">
        <li><a href="./about/aboutB.php">Bantayan</a></li>
        <li><a href="./about/aboutS.php">Santa Fe</a></li>
        <li><a href="./about/aboutM.php">Madridejos</a></li>
      </ul>
    </li>
    <li><a href="./citizencharter.php">Citizen Charter</a></li>
    <li><a href="./safetytips.php">Safetytips</a></li>
    <li><a href="./admin">Login</a></li>
  </div>
  <div class="cancel-icon">
    <span class="fas fa-times"></span>
  </div>
</nav>

<script>
  const menuIcon = document.querySelector(".menu-icon span");
  const cancelIcon = document.querySelector(".cancel-icon");
  const navItems = document.querySelector(".nav-items");

  menuIcon.onclick = () => {
    navItems.classList.add("active");
    menuIcon.style.display = "none";
    cancelIcon.classList.add("show");
  };

  cancelIcon.onclick = () => {
    navItems.classList.remove("active");
    cancelIcon.classList.remove("show");
    menuIcon.style.display = "block";
  };

  // About Us Dropdown Toggle
  const aboutDropdown = document.querySelector("#aboutDropdown");
  const dropdownMenu = document.querySelector(".dropdown-menu");

  aboutDropdown.onclick = () => {
    dropdownMenu.classList.toggle("show");
  };

  // Search Report Modal Trigger
  document.querySelectorAll("#search_report").forEach((element) => {
    element.addEventListener("click", () => {
      uni_modal("Search Request Report", "report/search.php");
    });
  });
</script>
