<style>
  @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');

  * {
    margin: 0;
    padding: 0;
    outline: none;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
  }

  body {
    background: #f2f2f2;
  }

  nav {
    background: #171c24;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    padding: 0 100px;
  }

  nav .logo {
    color: #fff;
    font-size: 30px;
    font-weight: 600;
    letter-spacing: -1px;
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

  nav form {
    display: flex;
    height: 40px;
    padding: 2px;
    background: #1e232b;
    min-width: 18%!important;
    border-radius: 2px;
    border: 1px solid rgba(155,155,155,0.2);
  }

  nav form .search-data {
    width: 100%;
    height: 100%;
    padding: 0 10px;
    color: #fff;
    font-size: 17px;
    border: none;
    font-weight: 500;
    background: none;
  }

  nav form button {
    padding: 0 15px;
    color: #fff;
    font-size: 17px;
    background: #ff3d00;
    border: none;
    border-radius: 2px;
    cursor: pointer;
  }

  nav form button:hover {
    background: #e63600;
  }

  nav .menu-icon,
  nav .cancel-icon,
  nav .search-icon {
    width: 40px;
    text-align: center;
    margin: 0 50px;
    font-size: 18px;
    color: #fff;
    cursor: pointer;
    display: none;
  }

  nav .menu-icon span,
  nav .cancel-icon,
  nav .search-icon {
    display: none;
  }

  @media (max-width: 1140px) {
    nav .logo {
      flex: 2;
      text-align: center;
    }

    nav .nav-items {
      position: fixed;
      z-index: 99;
      top: 70px;
      width: 100%;
      left: -100%;
      height: 100%;
      padding: 10px 50px 0 50px;
      text-align: center;
      background: #14181f;
      display: inline-block;
      transition: left 0.3s ease;
    }

    nav .nav-items.active {
      left: 0px;
    }

    nav .menu-icon {
      display: block;
    }

    nav .search-icon {
      display: block;
    }
  }
</style>

<nav>
  <div class="menu-icon">
    <span class="fas fa-bars"></span>
  </div>
  <div class="logo">
    MyWebsite
  </div>
  <ul class="nav-items">
    <li><a href="./">Home</a></li>
    <li><a href="./?p=report">Report</a></li>
    <li><a href="javascript:void(0)" id="search_report">View Status</a></li>
    <li><a href="./about/aboutB.php">Bantayan</a></li>
    <li><a href="./about/aboutS.php">Santa Fe</a></li>
    <li><a href="./about/aboutM.php">Madridejos</a></li>
    <li><a href="./?p=citizencharter">Citizen Charter</a></li>
    <li><a href="./?p=safetytips">Safety Tips</a></li>
    <li><a href="./admin">Login</a></li>
  </ul>
</nav>

<script>
  const menuBtn = document.querySelector(".menu-icon span");
  const items = document.querySelector(".nav-items");
  menuBtn.onclick = () => {
    items.classList.toggle("active");
  };
</script>
