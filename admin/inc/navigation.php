<style>
  [class*="sidebar-light-"] .nav-treeview > .nav-item > .nav-link.active, [class*="sidebar-light-"] .nav-treeview > .nav-item > .nav-link.active:hover {
      color: #ffffff !important;
  }
  .bg-maroon {
      background-color: #ff4600 !important;
  }
  /* Mobile First Design */
@media screen and (max-width: 768px) {
    .main-sidebar {
        width: 70px; /* Collapse sidebar on mobile */
    }

    .content-wrapper {
        margin-left: 70px; /* Adjust content width */
    }

    .brand-text {
        display: none; /* Hide brand text on mobile */
    }

    .nav-treeview {
        display: none; /* Hide submenu on mobile */
    }

    .nav-item:hover .nav-treeview {
        display: block; /* Show submenu on hover */
    }

    .nav-link {
        font-size: 12px; /* Smaller font size on mobile */
        text-align: center;
    }

    .nav-icon {
        margin-right: 0;
    }

    /* Toggle Sidebar button */
    .sidebar-toggle {
        display: block;
        background-color: #ff4600;
        border: none;
        color: #fff;
        padding: 10px;
        font-size: 18px;
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1001;
    }

    .sidebar-open {
        transform: translateX(0); /* Show sidebar */
    }

    .sidebar-closed {
        transform: translateX(-100%); /* Hide sidebar */
    }

    .main-sidebar.sidebar-open {
        width: 250px;
    }

    .main-sidebar.sidebar-closed {
        width: 70px;
    }

    /* Make Sidebar Full-Width on mobile */
    .main-sidebar {
        position: absolute;
        z-index: 1000;
        height: 100vh;
        width: 100%;
        background-color: #ff4600;
    }

    .content-wrapper {
        margin-left: 0;
    }

    .main-sidebar.sidebar-open {
        transform: translateX(0);
    }

    .main-sidebar.sidebar-closed {
        transform: translateX(-100%);
    }
}

/* Extra Small Devices (Phones) */
@media screen and (max-width: 480px) {
    .main-sidebar {
        width: 100% !important; /* Full-width sidebar on small screens */
    }
    .content-wrapper {
        margin-left: 0 !important;
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
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="./?page=teams" class="nav-link nav-teams">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          Control Teams
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-exclamation-triangle"></i>
                        <p>
                          Requests
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                        <!-- <li class="nav-item">
                          <a href="./?page=requests/manage_request" class="nav-link tree-item nav-requests_manage_request">
                            <i class="fas fa-plus nav-icon"></i>
                            <p>Create New</p>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a href="./?page=requests&status=0" class="nav-link tree-item nav-requests_0">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pending</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=requests&status=1" class="nav-link tree-item nav-requests_1">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Assigned to Team</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=requests&status=2" class="nav-link tree-item nav-requests_2">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Team on their Way</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=requests&status=3" class="nav-link tree-item nav-requests_3">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fire Refief on Progress</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=requests&status=4" class="nav-link tree-item nav-requests_4">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fire Refief Completed</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./?page=requests" class="nav-link tree-item nav-requests">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List All</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <?php if($_settings->userdata('type') == 1): ?>
                    <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                          Daily Report
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=reports/archive" class="nav-link nav-archive">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                          Archive
                        </p>
                      </a>
                    </li>
                    <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                      <a href="</?php echo base_url ?>admin/?page=system_info/contact_info" class="nav-link nav-system_info_contact_info">
                        <i class="nav-icon fas fa-phone-square-alt"></i>
                        <p>
                          Contact Info
                        </p>
                      </a>
                    </li> -->
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                                <i class="fas fa-info-circle nav-icon"></i>
                                <p>System Info</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url ?>admin/?page=system_info/event_info" class="nav-link nav-system_info_event_info">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Event</p>
                            </a>
                        </li>
                    <?php endif; ?>
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var status = '<?php echo isset($_GET['status']) ? $_GET['status'] : '' ?>';
      page = page.replace(/\//g,'_');
      page = status != '' ? page + "_" + status : page;
      console.log($('.nav-link.nav-'+page)[0])
      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
      $('.nav-link.active').addClass('bg-maroon')
    })
  </script>