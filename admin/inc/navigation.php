<style>
  [class*="sidebar-light-"] .nav-treeview > .nav-item > .nav-link.active, 
  [class*="sidebar-light-"] .nav-treeview > .nav-item > .nav-link.active:hover {
    color: #ffffff !important;
  }

  .bg-maroon {
    background-color: #ff4600 !important;
  }

  /* Basic styles for the sidebar */
  .main-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    z-index: 100;
    background-color: #343a40;
    transition: all 0.3s ease;
  }

  /* Ensure the sidebar has a default width */
  .sidebar-no-expand {
    width: 250px;
  }

  .sidebar-no-expand .nav-treeview {
    display: block;
  }

  /* Mobile-first styles (small screens) */
  @media (max-width: 768px) {
    .main-sidebar {
      width: 0;
      display: none;
    }

    /* On mobile, make the sidebar take full width when it’s visible */
    .main-sidebar.sidebar-open {
      width: 250px;
      display: block;
    }

    /* Collapsing the sidebar items on small screens */
    .sidebar .nav-item {
      text-align: center;
    }

    .sidebar .nav-link {
      padding: 10px 20px;
    }

    /* Adjust navigation for mobile layout */
    .main-sidebar .nav-pills {
      display: block;
    }

    .main-sidebar .nav-item {
      display: block;
    }
  }

  /* Tablet Screens (768px - 1024px) */
  @media (min-width: 768px) and (max-width: 1024px) {
    .main-sidebar {
      width: 220px; /* Slightly smaller for tablets */
    }

    /* Keep tree view items visible */
    .sidebar-no-expand .nav-treeview {
      display: block;
    }

    /* Adjust icon sizes and spacing for tablets */
    .main-sidebar .nav-item {
      text-align: left;
    }

    .main-sidebar .nav-link {
      padding: 12px 20px;
    }
  }

  /* Large Screens (Desktop - min-width: 1024px) */
  @media (min-width: 1024px) {
    .main-sidebar {
      width: 250px; /* Full sidebar width for desktops */
    }

    .sidebar-no-expand .nav-treeview {
      display: block;
    }

    /* Keep the nav item layout the same */
    .main-sidebar .nav-item {
      text-align: left;
    }

    .main-sidebar .nav-link {
      padding: 12px 20px;
    }
  }
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-maroon navbar-light elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-maroon text-sm">
    <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light">
    <!-- Sidebar Menu -->
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item dropdown">
          <a href="./" class="nav-link nav-home">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li> 
        <li class="nav-item dropdown">
          <a href="./?page=teams" class="nav-link nav-teams">
            <i class="nav-icon fas fa-users"></i>
            <p>Control Teams</p>
          </a>
        </li> 
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>Requests<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
              <a href="./?page=requests&status=0" class="nav-link tree-item nav-requests_0">
                <i class="far fa-circle nav-icon"></i><p>Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./?page=requests&status=1" class="nav-link tree-item nav-requests_1">
                <i class="far fa-circle nav-icon"></i><p>Assigned to Team</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./?page=requests&status=2" class="nav-link tree-item nav-requests_2">
                <i class="far fa-circle nav-icon"></i><p>Team on their Way</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./?page=requests&status=3" class="nav-link tree-item nav-requests_3">
                <i class="far fa-circle nav-icon"></i><p>Fire Refief on Progress</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./?page=requests&status=4" class="nav-link tree-item nav-requests_4">
                <i class="far fa-circle nav-icon"></i><p>Fire Refief Completed</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./?page=requests" class="nav-link tree-item nav-requests">
                <i class="far fa-circle nav-icon"></i><p>List All</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if($_settings->userdata('type') == 1): ?>
        <li class="nav-header">Maintenance</li>
        <li class="nav-item dropdown">
          <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
            <i class="nav-icon far fa-circle"></i>
            <p>Daily Report</p>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="<?php echo base_url ?>admin/?page=reports/archive" class="nav-link nav-archive">
            <i class="nav-icon fas fa-archive"></i>
            <p>Archive</p>
          </a>
        </li>
        <li class="nav-header">Maintenance</li>
        <li class="nav-item dropdown">
          <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>User List</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tools"></i>
            <p>Settings<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
              <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                <i class="fas fa-info-circle nav-icon"></i><p>System Info</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url ?>admin/?page=system_info/event_info" class="nav-link nav-system_info_event_info">
                <i class="fas fa-calendar-alt nav-icon"></i><p>Event</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</aside>

<script>
  $(document).ready(function(){
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var status = '<?php echo isset($_GET['status']) ? $_GET['status'] : '' ?>';
    page = page.replace(/\//g,'_');
    page = status != '' ? page + "_" + status : page;
    
    if($('.nav-link.nav-'+page).length > 0){
      $('.nav-link.nav-'+page).addClass('active');
      if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
        $('.nav-link.nav-'+page).addClass('active');
        $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open');
      }
      if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
        $('.nav-link.nav-'+page).parent().addClass('menu-open');
      }
    }
    $('.nav-link.active').addClass('bg-maroon');
  })
</script>
