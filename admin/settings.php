<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>
<?php



  $set = new Settings();

  if(isset($_POST['logo'])){
      $inv = 0;
      $saler = 0;
      $lenta = 0;
      $exit = 0;
      $audio = 0;
      $fan_procent = 0;
      $sel_img = 0;

      if(isset($_POST['inv'])) $inv = 1;
      if(isset($_POST['saler'])) $saler = 1;
      if(isset($_POST['lenta'])) $lenta = 1;
      if(isset($_POST['exit'])) $exit = 1;
      if(isset($_POST['audio'])) $audio = 1;
      if(isset($_POST['fan_procent'])) $fan_procent = 1;
      if(isset($_POST['sel_img'])) $sel_img = 1;

      $set->set_settings($_POST['logo'], $inv, $saler, $lenta, $exit, $audio, $_POST['voice'], $fan_procent, $sel_img, $_POST['lang']);
      echo '<script>
         $(document).ready(function(){

            $("#flash").css("display", "block");
         });
      </script>';
      //echo '<div class="text-light bg-dark pl-1" >Налаштування збережено!</div>';
  }
?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <div id='flash' class="text-light bg-dark pl-1" style='padding: 10px; background-color:#FF4747 !important; display:none; font-weight: bold;'><?=setsave?></div><br/>
              <h3 class="font-weight-bold" ><?=sysset?></h3>
               <form action="settings.php" method="post">
                 <div class='table-responsive'>
                    <table class="table table-striped table-borderless">
                    <thead></thead>
                    <tbody>
                    <tr>
                     <td style="font-size:16px;"><?=logo?></td>
                      <td style='color:black;'>
                        <div class="custom-control custom-radio" style='margin:20px;'>
                            <input id="logo1" name="logo" type="radio" class="custom-control-input" value='1' <?php if($set->logo == 1) echo 'checked'; ?> >
                            <label class="custom-control-label" for="logo1"><img src="../img/scan_logo.jpg" alt="scan_logo" style='border-radius:0; width: 100%; height: 100%;' /></label>
                        </div>
                         <div class="custom-control custom-radio" style='margin:20px;'>
                            <input id="logo2" name="logo" type="radio" class="custom-control-input" value='2' <?php if($set->logo == 2) echo 'checked'; ?> >
                            <label class="custom-control-label" for="logo2"><img src="../img/karabas.jpg" alt="karabas" style='border-radius:0; width: 100%; height: 100%;' /></label>
                        </div>
                      <!--<img src="../img/scan_logo.jpg" alt="">
                      <img src="../img/karabas.jpg" alt="">-->

                    </td>
                  </tr>
                    <td style="font-size:16px;"><?=invmark?></td>
                    <td style='text-align: center;'><input type="checkbox" style='position: inherit;' class="form-check-input" name="inv" <?php if($set->show_inv == 1) echo 'checked'; ?>></td>
                    </tr>
                  <tr>
                      <td style="font-size:16px;"><?=salemark?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;' class="form-check-input" name="saler" <?php if($set->show_sel == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                      <td style="font-size:16px;"><?=ribmark?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;' class="form-check-input" name="lenta" <?php if($set->show_lenta == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                      <td style="font-size:16px;"><?=exitmark?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;' class="form-check-input" name="exit" <?php if($set->exit == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                      <td style="font-size:16px;"><?=fanprocmark?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;'  class="form-check-input" name="fan_procent" <?php if($set->fan_procent == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                      <td style="font-size:16px;"><?=salelogomark?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;'  class="form-check-input" name="sel_img" <?php if($set->sel_img == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                      <td style="font-size:16px;"><?=audio?></td>
                      <td style='text-align: center;'><input type="checkbox" style='position: inherit;' class="form-check-input" name="audio" <?php if($set->audio == 1) echo 'checked'; ?>></td>
                  </tr>
                  <tr>
                    <td style="font-size:16px;"><?=audiotype?></td>
                    <td style='color:black;'>
                       <div class="custom-control custom-radio" style='margin:20px;'>
                                <input id="female" name="voice" type="radio" class="custom-control-input" value='female' <?php if($set->voice == 'female') echo 'checked'; ?> >
                                <label class="custom-control-label" for="female"><?=female?></label>
                              </div>
                         <div class="custom-control custom-radio" style='margin:20px;'>
                                <input id="male" name="voice" type="radio" class="custom-control-input" value='male' <?php if($set->voice == 'male') echo 'checked'; ?> >
                            <label class="custom-control-label" for="male"><?=male?></label>
                          </div>
                          <div class="custom-control custom-radio" style='margin:20px;'>
                            <input id="audio" name="voice" type="radio" class="custom-control-input" value='audio' <?php if($set->voice == 'audio') echo 'checked'; ?> >
                            <label class="custom-control-label" for="audio"><?=audio?></label>
                          </div>
                      <!--<img src="../img/scan_logo.jpg" alt="">
                      <img src="../img/karabas.jpg" alt="">-->

                    </td>
                  </tr>
                  <tr>
                    <td style="font-size:16px;"><?=langsys?></td>
                    <td style='color:black;'>
                       <div class="custom-control custom-radio" style='margin:20px;'>
                                <input id="ukr" name="lang" type="radio" class="custom-control-input" value='ukr' <?php if($set->lang == 'ukr') echo 'checked'; ?> >
                                <label class="custom-control-label" for="ukr"><?=ukrlang?></label><img src="/img/ukr.png" alt="ukr" style='margin: -10px 20px;'>
                          </div>
                         <div class="custom-control custom-radio" style='margin:20px;'>
                                <input id="eng" name="lang" type="radio" class="custom-control-input" value='eng' <?php if($set->lang == 'eng') echo 'checked'; ?> >
                            <label class="custom-control-label" for="eng"><?=englang?></label><img src="/img/eng.png" alt="eng" style='margin: -10px 20px;'>
                        </div>
                      <!--<img src="../img/scan_logo.jpg" alt="">
                      <img src="../img/karabas.jpg" alt="">-->

                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <br>
              <div><input type="submit" value="<?=setsave2?>" class='btn btn-danger' /></div>
            </form>
            <br /><br /><br />
            </div>
          </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

