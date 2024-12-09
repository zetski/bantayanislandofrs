<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }
  .user-dd:hover {
    color: #fff !important;
  }
  .navbar-brand,
  .navbar-nav {
    margin-left: -70px; /* Adjust this value to move more or less */
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color:#ff4600">
  <div class="container px-4 px-lg-5">
    <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="./">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link text-white" aria-current="page" href="./">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="./?p=report">Report</a></li>
        <li class="nav-item"><a class="nav-link text-white" id="search_report" href="javascript:void(0)">View Status</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="./?p=about">About Us</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="./?p=contact">FireSafety</a></li>
      </ul>
      <div class="d-flex align-items-center">
        <a class="font-weight-bolder text-light mx-2 text-decoration-none" href="./admin">Login</a>
      </div>
    </div>
  </div>
</nav>

<script>
  $(function() {
    $('#search_report').click(function() {
      uni_modal("Search Request Report", "report/search.php");
    });

    $('#navbarResponsive').on('show.bs.collapse', function() {
      $('#mainNav').addClass('navbar-shrink');
    });

    $('#navbarResponsive').on('hidden.bs.collapse', function() {
      if ($('body').offset.top == 0)
        $('#mainNav').removeClass('navbar-shrink');
    });

    $('#search-form').submit(function(e) {
      e.preventDefault();
      var sTxt = $('[name="search"]').val();
      if (sTxt != '')
        location.href = './?p=products&search=' + sTxt;
    });
  });
</script>
