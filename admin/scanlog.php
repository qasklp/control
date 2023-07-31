<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <!--<h3 class="font-weight-bold" style='margin-bottom: 20px;'>Список подій</h3>-->
                  <div style='float:left; margin: 10px 20px 0 0; '>
                      <?= $event->get_events_select('scanlog')?>
                  </div>
                  <div style='display:inline-block; margin: 10px 20px 0 0;'>
                    <button type="button" id='update_log' class="btn btn-warning btn-icon-text">
                          <i class="ti-reload btn-icon-prepend"></i>
                          <?=renewlog?>
                        </button>
                  </div>
                  <button type="button" class="btn btn-social-icon btn-outline-youtube" title="<?=clerlog2?>" id="clear_log" data-toggle="modal" data-target="#ClearLog"><i class="mdi mdi-eraser" style="font-size: 1.5rem;"></i></button>
                  <div style='float:left; margin: 10px 20px 0 0;'>
                      <input type="text" id="barcontrol" class='form-control' style='float: left;'>
                  </div>
                  <div id='bcode-card' style='margin-top: 27px;'>
                    <div class="card-body" style='padding:0;'>
                      <div id="display">
                        <center></center>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <div id='hall' style='font-size: 16px; margin:10px 0;'>
                      <?php $sstat = new Scanstatus(); ?>
                      <?=$sstat->get_status_select();?>
                   </div>
                  </div>
                </div>
                 <div class="col-md-12 grid-margin">
                <div class="row">
                    <div id='logresult' class="table-responsive" style='font-size:20px; font-weight:bold; padding:5px 15px; min-height: 500px;'></div>
                  </div>
                </div>
                </div>

                  <!-- Modal -->
                   <div class="modal fade" id="ClearLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle"><?=clerlog?></h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="index.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                              <!--<label for="clear_barcode">Введіть пароль</label>-->
                              <input type="password" class="form-control" id="clear_log_pass" name="clear_barcode" placeholder="Введіть пароль">
                            </div>
                            <button type="button" class="btn btn-danger mb-2" id="clear_log_btn">Очистка</button>
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

                <script>
                  $( document ).ready(function() {
                      $.ajax({
                        url: 'logresponse.php?event='+$('#scanlog').val()+'&status='+$('#status').val(),
                        cache: false,
                        global: false,
                        beforeSend: function() {
                          $('#loader').html("<img src='/img/loader3.gif' />");
                        },
                        success: function(xmldata){
                          $('#logresult').html(xmldata);
                          $('#loader').html("");
                       }
                     });


                      $('#clear_log_btn').click( function() {
                          if($('#scanlog').val() != -1){
                            //alert($('#clear_log_pass').val());
                            $.ajax({
                              url: 'clear_log.php?event='+$('#scanlog').val()+'&pass='+$('#clear_log_pass').val(),
                                  success: function(data){
                                      alert(data);
                                      window.location.reload();
                                  }
                              });
                          }

                      });


                });

                    $(document).keypress(function(e) {
                      if(e.which == 13) {
                          //var bar = $('#barcontrol').val();
                          //alert(bar+'***');

                          if($('#barcontrol').val() != ''){
                              $.ajax({
                                //type: 'POST',
                                url: 'barcode_history.php?barcode=' + $('#barcontrol').val()+'&event='+$('#scanlog').val(),
                                //data: 'barode=bar',
                            //dataType: 'json',
                                success: function(data){
                                  $('#logresult').html(data);
                                }
                              });

                               $.ajax({
                                url:'barcode/barcode.php',
                                method:"POST",
                                data:{code:$('#barcontrol').val(),type:'C128',label:''},
                                error:err=>{
                                  alert("Серевер не відповідає!");
                                },
                                success:function(resp){
                                  $('#display').html(resp)
                                 /* $('#bcode-card .card-footer').show('slideUp')*/
                                }
                              });

                              $('#barcontrol').val(null);
                          }
                    }
                  });
                </script>


        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

