<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bantayan Fire Station</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
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
      background-color: #333333;
    }

    .dropdown-item {
      color: white;
    }

    .dropdown-item:hover {
      color: white;
      background-color: #ff4600;
    }
  </style>
</head>
<body>
  <?php
  session_start();
  ?>

  <div class="pos-f-t">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #ff4600;">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand">
          <img src="../img/r7logo.png" width="30" height="30" alt="Brand Logo" loading="lazy">
          Bantayan Fire Station
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
            <!-- <li class="nav-item"><a class="nav-link text-white" href="./">Home</a></li> -->
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
        </div>
      </div>
    </nav>
  </div>

  <div id="modal-container" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Loading content...</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#aboutDropdown').on('click', function() {
        var $el = $(this).next('.dropdown-menu');
        var isVisible = $el.is(':visible');
        $('.dropdown-menu').slideUp(400);
        if (!isVisible) {
          $el.stop(true, true).slideDown(400);
        }
      });

      // Open modal for "View Status"
      $('#search_report').click(function() {
        uni_modal("Search Request Report", "report/search.php");
      });

      function uni_modal(title, url) {
        $('#modal-container .modal-title').text(title);
        $('#modal-container .modal-body').load(url, function() {
          $('#modal-container').modal('show');
        });
      }
    });
  </script>
</body>
</html>
