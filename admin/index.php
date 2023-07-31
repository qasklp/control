<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>

<?php
  //$role = new Role();
  //echo $_SERVER['PHP_SELF'].'<br/>';
  //echo $role->get_page_by_url($_SERVER['PHP_SELF']);
  //echo $role->get_id_by_name($_SESSION['user_role']);

  /*if(!$role->get_role_to_page($role->get_id_by_name($_SESSION['user_role']), $role->get_page_by_url($_SERVER['PHP_SELF']))){
    echo "<h3 style='margin:30px auto; font-weight:bold; text-align:center;'>Перегляд сторінки заборонено!</h3>";
    exit;
  }*/

  $hall = new Hall($event->get_active_event_id());
  $zone = new Zone();
  $validation = new Validation();
?>
      <!-- partial -->
<style>

  .valid_table_head{
      margin: 15px 0;
      background-color: #FF4747;
      /* height: 30px; */
      padding: 10px;
      color: white;
      font-weight: bold;
      border-radius: 0px 10px 0px 0px;
      text-align: center;
  }
</style>
      <div class="main-panel">
        <div class="content-wrapper">
          <?php
                if(isset($_POST['EventName'])){
                  echo" <div class='row'><div class='col-md-12 grid-margin' style='width:100%; flex: 0 100%;' id='event_info'>";
                    if($_POST['EventName'] != ''){
                      /*echo $_POST['EventName']."<br/>";
                      echo date('Y-m-d H:i:s', strtotime($_POST['EventDate']))."<br/>";
                      echo $_POST['halls']."<br/>";
                      echo $_POST['Strevent']."<br/>";
                      echo $_POST['Importbars']."<br/>";
                      echo "</div></div><br/><br/>";*/

                      if($event->add_event($validation->text_validation($_POST['EventName']), date('Y-m-d H:i:s', strtotime($_POST['EventDate'])), $_POST['halls'], $_POST['Strevent'], $_POST['Importbars']) == 1){

                          echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Захід створенно</div>";
                          echo $event->success_add_event_table($validation->text_validation($_POST['EventName']), date('d.m.Y H:i', strtotime($_POST['EventDate'])), $hall->get_hall_name_by_id($_POST['halls']), $_POST['Importbars']);
                      }
                    }else{
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Не введена назва заходу</div>";
                    }
                    echo "</div></div>";

                }


        ?>

              <div class="row">
                <div class="col-md-12">

                  <button type="button" class="btn btn-info btn-ti-star" id='add_event' data-toggle="modal" data-target="#AddEventModal">
                      <i class="mdi mdi-plus-circle" style='vertical-align: middle;'></i>
                      <?=add_event?>
                  </button>
                   <button type="button" class="btn btn-success btn-ti-star" id='active_event_set'>
                      <i class="ti-star btn-ti-star"></i>
                      <?=active2?>
                  </button>

                        <button type="button" class="btn btn-success btn-icon-text" data-toggle="modal" data-target="#AddEventModal5">
                          <i class="mdi mdi-library-plus btn-icon-prepend"></i>
                         <?=addtk?>
                        </button>
                  <button type="button" class="btn btn-social-icon btn-outline-youtube" title="<?=clearbr?>" id="clear_barcodes" data-toggle="modal" data-target="#AddEventModal2"><i class="mdi mdi-eraser" style="font-size: 1.5rem;"></i></button>

                  <button type="button" class="btn btn-social-icon btn-outline-youtube" title="<?=hallout?>" id="all_out" data-toggle="modal" data-target="#AddEventModal4"><i class="mdi mdi-numeric-0-box-multiple-outline" style="font-size: 1.5rem;"></i></button>


                  <button type="button" class="btn btn-social-icon btn-outline-youtube" title="<?=delev?>" id="event_delete" data-toggle="modal" data-target="#AddEventModal3" ><i class="mdi mdi mdi-delete" style="font-size: 1.5rem;"></i></button>
                  <!--<h3 class="font-weight-bold" style='float:left; margin-bottom: 20px;'><?=events_list?></h3>-->



                  <!-- Modal -->
                  <div class="modal fade" id="AddEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Додати подію</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post" id="Add_event_form">
                            <div class="form-group">
                              <label for="EventName">Назва заходу</label>
                              <input type="text" class="form-control" id="EventName" name="EventName" placeholder="Назва заходу">
                            </div>
                            <div class="form-group">
                              <label for="halls"><?=venue?></label>
                               <?= $hall->get_halls_select()?>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="event_date">Дата заходу:</label>


                              <input type="datetime-local" id="event_date"
       name="EventDate" value="2022-12-01 19:00" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}"
       min="2018-06-07 00:00" max="2024-06-14 00:00">

                            </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Структура заходу</label>
                                  <div class="col-sm-4">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Strevent" id="strevent1" value="0" checked>
                                        Звичайна
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Strevent" id="strevent2" value="1">
                                        Розширена
                                      </label>
                                    </div>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Імпорт штрихкодів</label>
                                  <div class="col-sm-4">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Importbars" id="importb1" value="1" checked>
                                        Заливка *.csv файлу
                                        <i class="input-helper"></i>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Importbars" id="importb2" value="2">
                                        Довільне завантаження штрихкодів
                                        <i class="input-helper"></i>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <button type="button" class="btn btn-primary mb-2" id="add_event_btn">Додати</button>
                              </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                  <!-- Modal2 -->
                   <div class="modal fade" id="AddEventModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Очистити базу штрихкодів ?</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="clear_barcode">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="clear_barcode" name="clear_barcode" placeholder="Введіть пароль">
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="clear_barcode_btn">Очистка</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>
                  <!-- Modal2 -->
                  <!-- Modal3 -->
                   <div class="modal fade" id="AddEventModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Видалити захід?</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="del_event">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="del_event" name="del_event" placeholder="Введіть пароль">
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="del_event_btn">Видалити</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>
                  <!-- Modal3 -->

                  <!-- Modal4 -->
                   <div class="modal fade" id="AddEventModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Всі штрихкоди не в залі</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="del_event">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="all_out2" name="all_out" placeholder="Введіть пароль">
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="all_out_btn">Підтвердити</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>
                  <!-- Modal4 -->

                  <!--<button type="button" class="btn btn-info btn-rounded btn-icon" id='active_event_set' disabled><i class="ti-star"></i></button>-->

                  <form id="loadForm" action="index.php" enctype="multipart/form-data" method="post">

                  <div style='float:left; margin: 20px 20px 0 0;'>

                    <?= $event->get_events_select('event')?>

                  </div>
                  <div style='float:left; margin: 10px 20px 0 0;'>



                  <!--<button type="button" class="btn btn-info btn-rounded btn-icon" id='active_event_set' disabled><i class="ti-star"></i></button>-->
                  </div>

                    <!--<div class="form-check form-check-flat form-check-primary" style='display: inline-block;'>
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="addon" name='addon'>
                          Розширена структура
                      <i class="input-helper"></i></label>
                    </div>-->
                </div>
                </div>

                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <div id='hall' style='margin-top: 30px; font-size: 18px; line-height: 30px;'></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-xl-12 mb-4 mb-xl-0">
                <div id='validation' style='margin-top: 20px;' class='row' style='width:100%; flex: 0 100%;'></div>
                <!--<div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>-->

             </div>

          </div>
          <div class="row" style='border-top: 1px solid rgba(0, 0, 0, 0.06); padding-top:10px;'>
            <div class="col-md-12 grid-margin" style='width:100%; flex: 0 100%;'>
              <h3 style="float:left; margin-right:10px;"><?=csv?></h3><span id="zone_ids" style="font-size:18px;"></span>
              <div id='str_tbl' class="table-responsive"><?= $event->get_csv_str_table(false)?></div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8" style='width:70%; flex: 0 50%;'>
                <div class="form-group">
                    <h3><?=csvload?></h3>
                    <input type="file" id="passed_file" name="passed_file" class="file-upload-default">
                    <div class="input-group col-xs-12">
                      <input type="text" class="form-control file-upload-info" disabled="" placeholder="<?=csvload2?>">
                      <span class="input-group-append">
                       <button class="file-upload-browse btn btn-primary" type="button"><?=upload?></button>
                      </span>
                     </div>
               </div>
              </div>
            </div>
            <!--<div class="row">
              <div class="col-md-6 grid-margin" style='width:70%; flex: 0 50%;'>
                  <div class="form-group">
                        <label for="add_tickets">-->
                          <!--<h3><a hraf='#' data-toggle="modal" data-target="#AddEventModal5" style="cursor: pointer; text-decoration:underline;">Додаткові квитки</a></h3>-->
                        </label>
                        <!-- Modal4 -->
                   <div class="modal fade" id="AddEventModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Додати вхідні квитки</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <?=$zone->get_zone_select();?>
                            </div>
                            <div class="form-group">
                              <!--<label for="del_event">Введіть пароль</label>-->
                              <textarea class="form-control" id="add_tickets" name="add_tickets" zone="-1" rows="10" style='line-height: 20px;'></textarea>
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="add_tickets_b">Завантажити</button>
                          </form>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      <!--</div>
                    </div>
                  </div>-->
                  <!-- Modal4 -->
                        <!--<textarea class="form-control" id="add_tickets" name="add_tickets" zone="-1" rows="10" style='line-height: 20px;'></textarea>
                        <button type="button" class="btn btn-primary mr-2" id="add_tickets_b" style='margin:10px 0;'>Завантажити</button>-->
                  </div>
              </div>
          </div>


          <div class="row">
            <div class="col-md-12">
              <?php if(isset($_POST['event'])): ?>
                   <?php if($event->is_addon_event($_POST['event'])== 1): ?>
                      <?php $event->import_barcods_from_csv($_POST['event'], true);?>
                    <?php else: ?>
                      <?php $event->import_barcods_from_csv($_POST['event'], false); ?>
                    <?php endif; ?>
                        <div id='validation' style='margin-top: 30px;' class='row' style='width:100%; flex: 0 100%;'>
                            <?= $validation->get_double_barcodes($_POST['event'],5)."<br/>"?>
                            <?= $validation->get_same_zone_col_row($_POST['event'],5)?>
                        </div>
                    <?php endif; ?>
            </div>
          </div>
          <!--<div class="row" style='border-top: 1px solid rgba(0, 0, 0, 0.06); padding-top:10px;'>
            <div class="col-md-12">
               <h3 class="font-weight-bold">Список площадок</h3>
                <?php

                    echo $hall->get_halls_select();
                ?>
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-12">
                  <br/>
                  <div class="table-responsive"><?= $hall->get_csv_str_table_hall() ?></div>
              </div>
            </div>
          <br/>
          <br/>
          <div class="row">
            <div class="col-md-12" style='width:70%; flex: 0 50%;'>
                <div class="form-group">
                    <h3>Завантажити файл структури залу *.csv</h3>
                    <input type="file" id="hall_file" name="hall_file" class="file-upload-default">
                    <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Файл csv">
                    <span class="input-group-append">
                     <button class="file-upload-browse btn btn-primary" type="button">Завантажити</button>
                    </span>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <?php
                if(isset($_POST['halls'])){
                  //echo $_POST['halls'];
                  $hall->import_hallplace_from_csv();
                }
              ?>
              </div>
            </div>-->
<button type="button" class="btn btn-danger btn-icon-text" id='upload_barcodes'>
                  <i class="ti-upload btn-icon-prepend"></i>
                          Upload
                        </button>
            </div>

          </form>

         <script>
            $( document ).ready(function() {

              $('#upload_barcodes').click( function() {

                  var formData = new FormData();
                  formData.append('passed_file', $('#passed_file')[0].files[0]);
                  formData.append('event', $('#event').val());

                  $.ajax({
                         url : 'upload_bacodes.php',
                         type : 'POST',
                         cache: false,
                         global: false,
                         beforeSend: function() {
                           $('#loader').html("<img src='/img/loader3.gif' />");
                          },
                         data : formData,
                         processData: false,  // tell jQuery not to process the data
                         contentType: false,  // tell jQuery not to set contentType
                         success : function(data) {
                             alert(data);
                            window.location.reload();
                         }
                  });
              });

                $.ajax({
                    url: 'hallresponse.php?event='+$('#event').val(),
                    success: function(xmldata){
                      $('#hall').html(xmldata);

                      /*$(xmldata).find('item').each(function(){
                          $('<li></li>').html( $(this).text() ).appendTo('.results');
                      });*/
                    }
                });

                $.ajax({
                  url: 'validation.php?event=' + $('#event').val(),
                  success: function(check){
                      //alert(check);
                      $('#validation').html(check);
                  }
              });

                 $.ajax({
                  url: 'zones_ids.php?event=' + $('#event').val(),
                  success: function(check){
                      //alert(check);
                      $('#zone_ids').html(check);
                  }
              });

                 $.ajax({
                  url: 'addonresponse.php?event='+$('#event').val(),
                  success: function(check){
                      //var event = $("#event").val();
                      //alert(event);
                      if(check == '1'){
                        $("#addon").prop('checked', true);
                        $('#str_tbl').html('<?= $event->get_csv_str_table(true)?>');

                      }else{
                        $("#addon").prop('checked', false);
                        $('#str_tbl').html('<?= $event->get_csv_str_table(false)?>');

                      }

                        /*$(xmldata).find('item').each(function(){
                            $('<li></li>').html( $(this).text() ).appendTo('.results');
                        });*/
                  }
            });

          });
          </script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

