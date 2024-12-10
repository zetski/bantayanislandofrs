<style>
    /* Remove sidebar-related styles */
    .navbar-brand img {
      border-radius: 50%;
    }

    #navbarNav a:hover {
      background-color: #ff4600;
      color: #fff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .dropdown-menu .dropdown-item:hover {
      background-color: #ff4600;
    }

    .dropdown-menu {
      background-color: #333333; /* Match the dark background */
    }

    .dropdown-item {
      color: white;
    }

    .dropdown-item:hover {
      color: white;
      background-color: #ff4600;
    }
  </style>
<?php
session_start();
// Example roles for testing
// Uncomment or modify these to simulate different roles.
// $_SESSION['role'] = 'guest'; // Uncomment to simulate guest role
// $_SESSION['role'] = 'admin'; // Uncomment to simulate admin role
?>

<div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <h4 class="text-white">Collapsed content</h4>
        <span class="text-muted">Toggleable via the navbar brand.</span>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #ff4600;">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="./">
          <img src="../img/r7logo.png" width="30" height="30" alt="Brand Logo" loading="lazy">
          Bantayan Fire Station
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize dropdown for "About Us"
      $('#aboutDropdown').on('click', function(e) {
        var $el = $(this).next('.dropdown-menu');
        var isVisible = $el.is(':visible');
        // Slide up all dropdowns
        $('.dropdown-menu').slideUp('400');
        // If this wasn't already visible, slide it down
        if (!isVisible) {
          $el.stop(true, true).slideDown('400');
        }
      });

      // Modal for search report
      $('#search_report').click(function() {
        alert('Search Report functionality coming soon!');
      });
    });
  </script>