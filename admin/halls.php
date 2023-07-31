<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php

   // include '../classes.php';

  $hall = new Hall($event->get_active_event_id());
  $zone = new Zone();
  //$user = new User();
   //echo $user->login('admin', 'A7788a');
   //echo $user->get_users_table();
   //echo $user->get_modal_for_mob();
?>
<script type="text/javascript">
function play_audio(path){
    var p = "'" + path + "'";
    var obj = document.createElement('audio');
    obj.src = path;
    obj.play();

  }
</script>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row" style='padding-top:10px;'>
            <div class="col-md-12">
               <!--<h3 class="font-weight-bold" style='float:left; margin-bottom: 20px;'>Список локацій</h3>-->
               <button type="button" class="btn btn-info btn-ti-star" id='add_hall' data-toggle="modal" data-target="#AddHallModal" style="margin-right:10px; float:left;">
                      <i class="mdi mdi-plus-circle" style='vertical-align: middle;'></i>
                      <?=addhall?>
                  </button>

                  <button type="button" class="btn btn-info btn-ti-star" id='add_zone' data-toggle="modal" data-target="#AddZoneModal">
                      <i class="mdi mdi-plus-circle" style='vertical-align: middle;'></i>
                      <?=addzone?>
                    </button>
                    <br/>

                  <!-- Modal -->
                  <div class="modal fade" id="AddHallModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle"><?=addhall?></h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post" id="Add_event_form">
                            <div class="form-group">
                              <label for="HallName"><?=hallname?></label>
                              <input type="text" class="form-control" id="HallName" name="HallName" placeholder="<?=hallname?>">
                            </div>
                            <div class="form-group">
                              <label for="HallAddr"><?=halladdr?></label>
                               <input type="text" class="form-control" id="HallAddr" name="HallAddr" placeholder="<?=halladdr?>">
                            </div>
                            <div class="form-group">
                              <label for="backimg"><?=backimg?></label>
                               <input type="text" class="form-control" id="backimg" name="backimg" placeholder="<?=backimg?>">
                            </div>
                            <div class="form-group">
                              <label for="Viewbox">Viewbox</label>
                               <input type="text" class="form-control" id="Viewbox" name="Viewbox" placeholder="Viewbox">
                            </div>
                            <div class="form-group">
                              <label for="Scale">Scale</label>
                               <input type="text" class="form-control" id="Scale" name="Scale" placeholder="Scale">
                            </div>
                            <br><br>
                                <button type="button" class="btn btn-primary mb-2" id="add_hall_btn"><?=addbtn?></button>
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
                  <!-- Modal -->
                  <div class="modal fade" id="AddZoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle"><?=addzone?></h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post" id="Add_event_form">
                            <div class="form-group">
                              <label for="halls" style='margin:10px 5px 0 0;'><?=zonelist?></label>
                              <?=$zone->get_zone_select();?>
                            </div>
                            <div class="form-group">
                              <label for="HallName"><?=zonename?></label>
                              <input type="text" class="form-control" id="ZoneName" name="ZoneName" placeholder="<?=zonename?>">
                            </div>
                            <div class="form-group">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" id="ZoneFan" name="ZoneFan">
                                  <?=fanzone?>
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
                                <button type="button" class="btn btn-primary mb-2" id="add_zone_btn"><?=addbtn?></button>
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
               <form class="forms-sample" action="halls.php" enctype="multipart/form-data" method="post">
                <div class="row">
                  <div class="col-md-12">
                    <?= $hall->get_halls_select();?>
                  </div>
                  </div>
            </div>
          </div>
          <br/>

          <div class="row">
            <div id='hallinfo'></div>
          </div>

           <div class="row">
            <div class="col-md-12">
                  <br/>
                  <div class="table-responsive"><?= $hall->get_csv_str_table_hall() ?></div>
              </div>
            </div>
          <br/>
          <br/>

          <div class="row">
            <div class="col-md-6" style='width:70%; flex: 0 50%;'>
                <div class="form-group">
                    <h3><?=hallscv?></h3>
                    <input type="file" id="hall_file" name="hall_file" class="file-upload-default">
                    <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="<?=csvload2?>">
                    <span class="input-group-append">
                     <button class="file-upload-browse btn btn-primary" type="button"><?=upload?></button>
                    </span>
                    </div>
              </div>
            </div>

              <?php
                if(isset($_POST['halls'])){
                 // echo $_POST['halls'];
                  $hall->import_hallplace_from_csv();
                }
              ?>


              <div class="col-md-6">
              <button style='margin-top: 30px;' type="submit" class="btn btn-danger btn-icon-text">
                  <i class="ti-upload btn-icon-prepend"></i>
                          Upload
                        </button>
                        <br /><br />
              </div>
            </div>
              <!--<div id='hall_map'></div>-->
          </form>

<script type="text/javascript">



   $( document ).ready(function() {

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

      $('#add_hall_btn').click( function() {
          //alert($('#HallName').val() + ' - ' + $('#HallAddr').val() + ' - ' + $('#Viewbox').val() + ' - ' + $('#Scale').val());

          $.ajax({
            url: 'add_hall.php?name=' + $('#HallName').val() + '&addr=' + $('#HallAddr').val() + '&viewbox=' + $('#Viewbox').val() + '&scale='+ $('#Scale').val(),
            success: function(date){
              alert(date);
              window.location.reload();
            }
          });


       });

      $('#add_zone_btn').click( function() {

        //alert($('#halls').val() + ' ' + $('#ZoneName').val() + ' ' + $('#ZoneFan').prop( "checked" ) + ' ' + $('#zones option:selected').text());
        var zone_name = '';
        var isfan = 0;
        if($('#zones').val() !=0 ){
          zone_name = $('#zones option:selected').text();
        }else{
          zone_name = $('#ZoneName').val();

        }

        //alert(zone_name + " - " + isfan);
        if($('#ZoneFan').prop("checked")){
          isfan = 1;
        }else{
          isfan = 0;
        }
        //isfan = $('#ZoneFan').prop("checked");

        if(zone_name != ''){
          $.ajax({
              url: 'add_zone.php?name=' + zone_name + '&hall=' + $('#halls').val() + '&is_fan=' + isfan,
              success: function(date){
                alert(date);
                window.location.reload();
              }
          });
        }else{
           alert('<?=zonaempty?>');
        }


      });


   });

  function showTooltip(evt, text) {
      let tooltip = document.getElementById("tooltip");
      //alert($('#tooltip').html());
      $.ajax({
            url: 'placeresponse.php?place='+text,
            success: function(data) {
                tooltip.innerHTML = data;
                tooltip.style.display = "block";
                tooltip.style.left = evt.pageX - 240 + "px";
                tooltip.style.top = evt.pageY - 100 + "px";
          }
       });

  }

  function hideTooltip() {
    var tooltip = document.getElementById("tooltip");
    tooltip.style.display = "none";
  }
</script>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

