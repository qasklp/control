<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>
<?php
  $guest = new Guests();
?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <div id='hall' style='font-size: 16px; margin:10px 0;'>
                      <?=$guest->get_guestlog_status_select();?>
                   </div>
                  </div>
                </div>
                 <div class="col-md-12 grid-margin">
                <div class="row">
                    <div id='guestlog' class="table-responsive" style='font-size:20px; font-weight:bold; min-height: 500px;'>
                        <div class="col-lg-12 stretch-card">

                    <?=$guest->get_guestlog_table()?>


                    </div>
                  </div>
                </div>
                </div>

                  <!-- Modal -->
                   <div class="modal fade" id="ClearLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Очистити лог заходу?</h3>
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


                      $('#guest_status').change( function() {
                          //alert($('#guest_status').val());

                          $.ajax({
                              url: 'guestlogresponse.php?status='+$('#guest_status').val(),
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              success: function(data){
                                $('#guestlog').html(data);
                                $('#loader').html("");
                             }
                           });

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

