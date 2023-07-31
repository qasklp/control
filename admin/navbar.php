<body>
  <style>
    .navbar .navbar-brand-wrapper .brand-logo-mini img {
        width: 100% !important;
        height:  100% !important;
    }
  </style>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        <a class="navbar-brand brand-logo mr-5" href="/admin"><img src="<?php
              $set = new Settings();
              $set->get_img_path(2);

          ?>" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/"><img src="/img/scan_logo_ss.png" alt="logo"/></a>

        <?php
            $log = new Scanlog();
            $guests = new Guests();
            $stat = new Stat();
            $stat->get_total($event->get_active_event_id());

        ?>

      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search" style='font-weight:bold; font-size:16px;'>
                  <!--<i class="ti-star" style='margin-right:10px;'></i>-->
                   <?=active?> <?=$event->get_active_event_name();?>
                </span>
              </div>
              <!--<input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">-->
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown"><a href="/" target='_blank'><i class="mdi mdi-barcode-scan icon-md"></i></a></li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-tablet-ipad mx-0 icon-lg"></i>
              <!--<span class="count"></span>-->
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h4 style="text-align:center; margin:20px;">Загальна інформація</h4>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal" style='text-decoration: underline; font-weight:600!important;'>Заповненість заходу</h6>
                  <p>
                    Увійшли на захід: <?=$stat->total['inhall']?>
                  </p>
                  <p>
                    Заповненість заходу:
                    <?php if($stat->total['total'] != 0){
                        echo round(($stat->total['inhall']*100)/$stat->total['total'],0)."%";
                    }else{
                        echo 0;
                    }?>
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-qrcode-scan mx-0" style='vertical-align: middle;'></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal" style='text-decoration: underline; font-weight:600!important;'>Проскановано</h6>
                  <p>На вхід: <?=$log->get_log_status_count(1, $event->get_active_event_id());?></p>
                  <p>Повторний вхід: <?=$log->get_log_status_count(2, $event->get_active_event_id());?></p>
                  <p>На вихід: <?=$log->get_log_status_count(3, $event->get_active_event_id());?></p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal" style='text-decoration: underline; font-weight:600!important;'>Список запрошенних</h6>
                  <p >
                    Зареєструвалося: <?= $guests->get_total_reg($event->get_active_event_id())?>
                  </p>
                  <p>
                    Зайшло плюсів: <?= $guests->get_inhall_plus($event->get_active_event_id())?>
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <?php
                $usr = new User();
                echo $usr->get_user_photo($_SESSION['user_id']);
              ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown" style="min-width: 200px;">
              <h4 style='padding:10px 20px;'>ID:<?=$_SESSION['user_id']?> - <?=$_SESSION['user_login']?><br/><br/>
              <?=$usr->get_name_by_id($_SESSION['user_id'])?></h4>
              <a class="dropdown-item" href="usersprofile.php?id=<?=$_SESSION['user_id']?>">
                <i class="ti-settings text-primary"></i>
                Профіль
              </a>
              <a class="dropdown-item" href='logout.php'>
                <i class="ti-power-off text-primary"></i>
                Вихід
              </a>
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>