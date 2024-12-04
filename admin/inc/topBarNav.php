<?php
// Assuming $conn is your database connection
// Fetch the logged-in admin's district or municipality
$admin_municipality = $_settings->userdata('district');

// Query to get new reports where the municipality matches the admin's district
$new_reports_query = $conn->query("
    SELECT id, lastname, firstname, middlename, date_created 
    FROM `request_list` 
    WHERE `status` = 0 
    AND `municipality` = '$admin_municipality' 
    ORDER BY `date_created` DESC
");

$new_reports_count = $new_reports_query->num_rows;
?>

<style>
  /* Existing CSS */
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }

  .btn-rounded {
    border-radius: 50px;
  }

  .navbar-separator {
    height: 25px;
    width: 1px;
    background-color: #ccc;
    margin: 0 15px;
  }

  .nav-icon {
    font-size: 18px;
    margin-right: 15px;
  }

  .badge-notification {
    position: absolute;
    top: 8px;
    right: 10px;
    background-color: red;
    color: white;
    padding: 2px 5px;
    border-radius: 50%;
    font-size: 5px;
    font-weight: bold;
  }

  .dropdown-menu {
    max-height: 300px;
    overflow-y: auto;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light shadow text-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li> -->
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="nav-link">
        <?php echo (!isMobileDevice()) ? $_settings->info('name') : $_settings->info('short_name'); ?> - Admin
      </a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notification Bell Icon -->
    <li class="nav-item dropdown">
      <a class="nav-link nav-icon" href="#" id="notificationDropdown" data-toggle="dropdown">
        <i class="fas fa-bell"></i>
        <?php if($new_reports_count > 0): ?>
          <span class="badge-notification"><?php echo $new_reports_count; ?></span>
        <?php endif; ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
        <span class="dropdown-header"><?php echo $new_reports_count; ?> New Report(s)</span>
        <div class="dropdown-divider"></div>
        <?php while($report = $new_reports_query->fetch_assoc()): ?>
          <a href="./?page=requests/view_request&id=<?php echo $report['id']; ?>" class="dropdown-item">
            <i class="fas fa-fire mr-2"></i>
            <?php echo $report['lastname'] . ', ' . $report['firstname'] . ', ' . $report['middlename']; ?>
            <span class="float-right text-muted text-sm"><?php echo date('Y-m-d', strtotime($report['date_created'])); ?></span>
          </a>
          <div class="dropdown-divider"></div>
        <?php endwhile; ?>
        <a href="./?page=requests&status=0" class="dropdown-item dropdown-footer">See All Reports</a>
      </div>
    </li>

    <!-- Email Message Icon -->
    <!-- <li class="nav-item">
      <a class="nav-link nav-icon" href="#">
        <i class="fas fa-envelope"></i>
      </a>
    </li> -->

    <!-- Vertical Line -->
    <li class="nav-item">
      <div class="navbar-separator"></div>
    </li>

    <!-- User Image and Dropdown -->
    <li class="nav-item">
      <div class="btn-group nav-link">
        <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>
          <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname')) ?></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="<?php echo base_url . 'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url . '/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
        </div>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
