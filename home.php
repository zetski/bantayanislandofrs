<style>
  /* General Body Styling */
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
  }

  /* Topbar Adjustment */
  nav.navbar {
    z-index: 1050;
    position: sticky;
    top: 0;
    width: 100%;
    background-color: #ff4600;
  }

  /* Ensure topbar doesn't overlap the carousel */
  body {
    padding-top: 60px; /* Adjust for fixed navbar height */
  }

  /* Carousel Styling */
  .carousel-item > img {
    object-fit: cover !important;
    height: 20em; /* Desktop height */
    width: 100%;
  }

  #carouselExampleControls .carousel-inner {
    height: 20em; /* Match carousel image height */
  }

  /* Button Styling */
  .btn {
    color: #fff;
    margin-top: 15px;
    background-color: #f46000;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .btn:focus,
  .btn:hover {
    outline: none;
    box-shadow: 0 12px 16px rgba(0, 0, 0, 0.24), 0 17px 50px rgba(0, 0, 0, 0.19);
    background-color: #e35000;
  }

  /* Card Section Styling */
  .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
  }

  .card-body {
    padding: 1.5rem;
  }

  /* Sidebar Styling */
  .sidebar {
    position: fixed;
    top: 60px; /* Matches the navbar height */
    left: -250px;
    width: 250px;
    height: 100%;
    background-color: #333333;
    z-index: 1000;
    transition: left 0.3s ease-in-out;
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
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    display: block;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .sidebar ul li a:hover {
    background-color: #ff4600;
  }

  /* Media Queries */
  @media (max-width: 992px) {
    .carousel-item > img {
      height: 15em; /* Tablet height */
    }

    #carouselExampleControls .carousel-inner {
      height: 15em; /* Match carousel image height */
    }

    .btn {
      font-size: 14px;
      padding: 8px 15px;
    }
  }

  @media (max-width: 768px) {
    .carousel-item > img {
      height: 12em; /* Mobile height */
    }

    #carouselExampleControls .carousel-inner {
      height: 12em; /* Match carousel image height */
    }

    .btn {
      font-size: 12px;
      padding: 6px 10px;
      margin-left: 10px;
    }

    .card-body {
      padding: 1rem;
    }

    .sidebar {
      width: 200px;
    }

    nav.navbar .navbar-toggler {
      margin-left: auto;
    }
  }

  @media (max-width: 576px) {
    .carousel-item > img {
      height: 10em; /* Smaller mobile height */
    }

    #carouselExampleControls .carousel-inner {
      height: 10em; /* Match carousel image height */
    }

    .btn {
      font-size: 10px;
      padding: 5px 8px;
      margin-left: 5px;
    }

    nav.navbar .navbar-brand {
      font-size: 14px;
    }

    .sidebar {
      width: 180px;
    }
  }
</style>
<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleControls" class="carousel slide bg-dark" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                            $upload_path = "uploads/banner";
                            if (is_dir(base_app . $upload_path)): 
                                $file = scandir(base_app . $upload_path);
                                $_i = 0;
                                foreach ($file as $img):
                                    if (in_array($img, array('.', '..')))
                                        continue;
                                    $_i++;
                        ?>
                        <div class="carousel-item <?php echo $_i == 1 ? "active" : '' ?>">
                            <img src="<?php echo validate_image($upload_path . '/' . $img) ?>" class="d-block w-100" alt="<?php echo $img ?>">
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-n3">
            <div class="col-lg-10 col-md-11 col-sm-11">
                <div class="card card-outline rounded-0">
                    <div class="card-body">
                        <div class="container-fluid">
                            <center>
                                <hr class="bg-navy opacity-100" style="width:8em;height:3px;opacity:1">
                            </center>
                            <?= htmlspecialchars_decode(file_get_contents('./welcome.html')) ?>
                            <div>
                                <button class="btn" onclick="window.location.href='./upcoming_events.php';">Upcoming Events</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
