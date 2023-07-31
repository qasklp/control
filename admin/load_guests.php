<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php

   // include '../classes.php';

  $hall = new Hall($event->get_active_event_id());
  $guests = new Guests();
  $zone = new Zone();
  //$user = new User();
   //echo $user->login('admin', 'A7788a');
   //echo $user->get_users_table();
   //echo $user->get_modal_for_mob();
?>
<style>
  .center{
    text-align: center;
    margin: 10px auto;
  }

  .right{
    text-align: center;
    margin: 10px auto;
  }
</style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row" style='padding-top:10px;'>
            <div class="col-md-12">
               <h3 class="font-weight-bold" style='float:left; margin-top:10px;'>Формування списка запрошених</h3>
               <button type="button" class="btn btn-info btn-ti-star" id='add_hall' data-toggle="modal" data-target="#AddHallModal" style="margin:-20px 0 10px 10px;">
                      <i class="mdi mdi-plus-circle" style='vertical-align: middle;'></i>
                      Додати гостя
                  </button>
                  <button type="button" class="btn btn-social-icon btn-outline-youtube" style='margin-bottom: 30px;' title="Видалити список гостей" id="del_guest_list" data-toggle="modal" data-target="#DelGuestList" ><i class="mdi mdi mdi-delete" style="font-size: 1.5rem;"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="AddHallModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Додати гостя</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post" id="Add_event_form">
                            <div class="form-group">
                              <label for="GuestName">П.І.О</label>
                              <input type="text" class="form-control" id="GuestName" name="GuestName" placeholder="П.І.О запрошеного">
                            </div>
                            <div class="form-group">
                              <label for="GuestOrg">Організація</label>
                               <input type="text" class="form-control" id="GuestOrg" name="GuestOrg" placeholder="Організація">
                            </div>
                            <div class="form-group">
                              <label for="plus_count">Кількість плюсів</label>
                               <input type="text" class="form-control" id="plus_count" name="plus_count" value='0' placeholder="Кількість плюсів">
                            </div>
                            <div class="form-group">
                              <label for="comment">Коментар</label>
                               <input type="text" class="form-control" id="guest_comment" name="comment" placeholder="Коментар">
                            </div>
                            <div class="form-group">
                               <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" id="all_access" name="all_access">
                                  All access
                                <i class="input-helper"></i></label>
                              </div>
                            </div>
                            <br><br>
                                <button type="button" class="btn btn-primary mb-2" id="add_guest_btn">Додати</button>
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


                  <!-- Modal3 -->
                   <div class="modal fade" id="DelGuestList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Видалити cписок гостей?</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="del_event">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="del_guest" name="del_guest" placeholder="Введіть пароль">
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="del_guest_btn">Видалити</button>
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

                  <!-- Modal -->
                  <div class="modal fade" id="AddZoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Додати зону</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post" id="Add_event_form">
                            <div class="form-group">
                              <label for="halls">Список готових зон</label>
                              <?=$zone->get_zone_select();?>
                            </div>
                            <div class="form-group">
                              <label for="HallName">Назва зони</label>
                              <input type="text" class="form-control" id="ZoneName" name="ZoneName" placeholder="Назва зони">
                            </div>
                            <div class="form-group">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" id="ZoneFan" name="ZoneFan">
                                  Фанзона
                                <i class="input-helper"></i></label>
                              </div>
                            </div>
                            <!--<div class="form-group">
                              <label for="backimg">Фоновий малюнок</label>
                               <input type="text" class="form-control" id="backimg" name="backimg" placeholder="Фоновий малюнок">
                            </div>
                            <div class="form-group">
                              <label for="Viewbox">Viewbox</label>
                               <input type="text" class="form-control" id="Viewbox" name="Viewbox" placeholder="Viewbox">
                            </div>
                            <div class="form-group">
                              <label for="Scale">Scale</label>
                               <input type="text" class="form-control" id="Scale" name="Scale" placeholder="Scale">
                            </div>-->
                            <br><br>
                                <button type="button" class="btn btn-primary mb-2" id="add_zone_btn">Додати</button>
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
                  <br/>
               <form class="forms-sample" action="load_guests.php" enctype="multipart/form-data" method="post">

            </div>
          </div>


          <div class="row">
            <div id='hallinfo'></div>
          </div>

           <div class="row">
            <div class="col-md-12">
                  <br/>
                  <div class="table-responsive"><?= $guests->get_csv_str_table_guests() ?></div>
              </div>
            </div>
          <br/>
          <br/>

          <div class="row">
            <div class="col-md-6" style='width:70%; flex: 0 50%;'>
                <div class="form-group">
                    <h3>Завантажити файл структури гостей *.csv</h3>
                    <input type="file" id="passed_file" name="passed_file" class="file-upload-default">
                    <div class="input-group col-xs-12">
                      <input type="text" class="form-control file-upload-info" disabled="" placeholder="Файл *.csv">
                      <span class="input-group-append">
                       <button class="file-upload-browse btn btn-primary" type="button">Завантажити</button>
                      </span>
                     </div>
              </div>
            </div>
              <div class="col-md-6">
              <button style='margin-top: 30px;' type="button" class="btn btn-danger btn-icon-text" id='upload_guests'>
                  <i class="ti-upload btn-icon-prepend"></i>
                          Upload
                        </button>
                        <br /><br />
              </div>
            </div><br/>
            <h3>Статистика запрошених</h3><br/>
                <div class="row">
                  <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                          <div class="d-flex flex-wrap mb-6">
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Всього запрошених</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?= $guests->get_total_guest($event->get_active_event_id())?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none; margin-right:10px;'>Зареєструвались</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?= $guests->get_total_reg($event->get_active_event_id())?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Кількість плюсів</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?= $guests->get_total_plus($event->get_active_event_id())?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Зайшли по плюсах</p>
                                <h3 class="text-primary fs-30 font-weight-medium center"><?= $guests->get_inhall_plus($event->get_active_event_id())?></h3>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <br/>
              <!--<div id='hall_map'></div>-->
          </form>

<script type="text/javascript">



     $( document ).ready(function() {
      $('#del_guest_btn').click( function() {
           if($('#del_guest').val() != ''){
                // alert('Захід видалено!!!!');
                $.ajax({
                  //type: 'POST',
                 url: 'delete_guest_list.php?pass=' + $('#del_guest').val(),
                      //data: 'barode=bar',
                      //dataType: 'json',
                      success: function(data){
                       // alert(data);
                          if(data == 1){
                              alert('Захід видалено!');
                           }else{
                              alert(data);
                           }

                            window.location.reload();
                        }
                    });
                  }
        });

      $('#upload_guests').click( function() {

          var formData = new FormData();
          formData.append('passed_file', $('#passed_file')[0].files[0]);
          /*formData.append('event', $('#event').val());*/

          $.ajax({
            url : 'upload_guests.php',
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

      if($('#halls').val() == -1){
          $('#add_zone').prop( "disabled", true);
      }

      $('#halls').change( function() {

        if($('#halls').val() == -1){
          $('#add_zone').prop( "disabled", true);
        }else{
          $('#add_zone').prop( "disabled", false);
        }
          //alert($('#halls').val());

        $('#hall_map').html('');
          $.ajax({
            url: 'hallinfo.php?hall=' + $('#halls').val(),

            success: function(data){
              $('#hallinfo').html(data);
            }
          });

          $.ajax({
            url: 'hallmap.php?hall=' + $('#halls').val(),

            success: function(data){
              $('#hall_map').html(data);
            }
          });

      });

      $('#zones').change( function() {

        //alert($('#zones').val());
        if($('#zones').val() != 0){
          $('#ZoneName').prop( "disabled", true);
        }else{
          $('#ZoneName').prop( "disabled", false);
        }
        /*$('#hall_map').html('');
          $.ajax({
            url: 'hallinfo.php?hall=' + $('#halls').val(),

            success: function(data){
              $('#hallinfo').html(data);
            }
          });

          $.ajax({
            url: 'hallmap.php?hall=' + $('#halls').val(),

            success: function(data){
              $('#hall_map').html(data);
            }
          });*/

      });

      $('#add_guest_btn').click( function() {
          //alert($('#GuestName').val() + ' - ' + $('#GuestOrg').val() + ' - ' + $('#plus_count').val() + ' - ' + $('#guest_comment').val() + ' - ' + $('#all_access').val());
          var all_access = 0;

          if($('#all_access').prop( "checked")){
            all_access = 1;
          }

          $.ajax({
            url: 'add_guest.php?name=' + $('#GuestName').val() + '&org=' + $('#GuestOrg').val() + '&plus=' + $('#plus_count').val() + '&comment='+ $('#guest_comment').val() + '&all_access=' + all_access,
            success: function(date){
              alert(date);
              window.location.reload();
            }
          });


       });

      $('#add_zone_btn').click( function() {

        //alert($('#halls').val() + ' ' + $('#ZoneName').val() + ' ' + $('#ZoneFan').prop( "checked" ) + ' ' + $('#zones option:selected').text());
        var zone_name = '';
        if($('#zones').val() !=0 ){
          zone_name = $('#zones option:selected').text();
        }else{
          zone_name = $('#ZoneName').val();
        }

        //alert(zone_name);

        if(zone_name != ''){
          $.ajax({
              url: 'add_zone.php?name=' + zone_name + '&hall=' + $('#halls').val() + '&is_fan=' + $('#ZoneFan').prop( "checked"),
              success: function(date){
                alert(date);
                window.location.reload();
              }
          });
        }else{
           alert('Не введена назва зони!');
        }


      });


   });

</script>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

