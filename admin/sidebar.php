<!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <?php
            $role = new Role();
          ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/index.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
              <span class="menu-title"><?=Events?></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/halls.php'))):?>
           <li class="nav-item">
            <a class="nav-link" href="halls.php">
              <i class="mdi mdi-home-map-marker menu-icon"></i>
              <span class="menu-title"><?=Halls?></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/scanlog.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="scanlog.php">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title"><?=Log?></span>
            </a>
            <!--<div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>-->
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/hall.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="hall.php">
              <i class="mdi mdi-monitor menu-icon"></i>
              <span class="menu-title"><?=Monitor?></span>
            </a>
            <!--<div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>-->
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/stat.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="stat.php">
              <i class="mdi mdi-chart-bar menu-icon"> </i>
              <span class="menu-title"><?=Stat?></span>
            </a>
          </li>
          <?php endif; ?>

           <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/guests.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="#ui-basic" data-toggle="collapse" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi mdi-clipboard-check menu-icon"> </i>
              <span class="menu-title"><?=Guests?></span>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="load_guests.php"><?=load_guests?></a></li>
                <li class="nav-item"> <a class="nav-link" href="guests.php"><?=guests_list?></a></li>
                <li class="nav-item"> <a class="nav-link" href="scan_guest.php"><?=guests_scan?></a></li>
                <li class="nav-item"> <a class="nav-link" href="guestslog.php"><?=guests_log?></a></li>
              </ul>
            </div>
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/reports.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="reports.php">
              <i class="mdi mdi-library-books menu-icon"> </i>
              <span class="menu-title"><?=Report?></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/users.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="users.php">
              <i class="mdi mdi-account-multiple menu-icon"> </i>
              <span class="menu-title"><?=Users?></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if($_SESSION['user_role'] == 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="roles.php">
                <i class="mdi mdi-key-variant menu-icon"> </i>
                <span class="menu-title"><?=Role?></span>
              </a>
            </li>
          <?php endif;?>

          <?php if($role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url('/admin/users.php'))):?>
          <li class="nav-item">
            <a class="nav-link" href="settings.php">
              <i class="mdi mdi-settings menu-icon"> </i>
              <span class="menu-title"><?=Settings?></span>
            </a>
          </li>
        <?php endif; ?>
        </ul>
      </nav>