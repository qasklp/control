<footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between" style="margin-top:60px;">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022-2023. Tickets control system. All rights reserved.</span>
            <!--<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>-->
          </div>
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Design by <a href="https://www.facebook.com/leoworker" target="_blank">Victor Leonskiy</a></span>
          </div>
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
    <!-- Plugin js for this page -->
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>



  <script language="javascript" type="text/javascript">
              $('#active_event_set').click( function() {
                //alert($('#event').val());
                if($('#event').val() != -1){
                   $.ajax({
                      url: 'active_event_set.php?event='+$('#event').val(),
                      success: function(data) {
                        alert(data);
                        window.location.reload();
                    }
                  });
                }

              });

            $('#status').change( function() {
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
                    /*$(xmldata).find('item').each(function(){
                        $('<li></li>').html( $(this).text() ).appendTo('.results');
                    });*/
                  }
                });
            });

            $('#clear_barcode_btn').click( function() {
              if($('#event').val() != -1){
                // var text = "Видалити усі штрихкоди " + $('#event option:selected').text();
                 if($('#clear_barcode').val() != ''){
                    $.ajax({
                      //type: 'POST',
                      url: 'clear_barcodes.php?event='+$('#event').val()+'&pass='+$('#clear_barcode').val(),
                      //data: 'barode=bar',
                      //dataType: 'json',
                      success: function(data){
                          //alert(data);
                         if(data == 1){
                            alert('Штрихкоди видаленні із бази!');
                         }else{
                            alert(data);
                         }

                          window.location.reload();
                      }
                    });
                 }

                }
            });


            $('#all_out_btn').click( function(){
              //alert($('#event').val());
              if($('#event').val() != -1){
                //var text = "Видалити захід - '" + $('#event option:selected').text() + "'?";
                //alert($('#all_out2').val());
                if($('#all_out2').val() != ''){
                   //alert('Захід видалено!!!!');
                  $.ajax({
                  //type: 'POST',
                    url: 'all_out_barcodes.php?event=' + $('#event').val() + '&pass=' + $('#all_out2').val(),
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
              }
            });


            $('#del_event_btn').click( function(){
              if($('#event').val() != -1){
                //var text = "Видалити захід - '" + $('#event option:selected').text() + "'?";
                if($('#del_event').val() != ''){
                  // alert('Захід видалено!!!!');
                  $.ajax({
                  //type: 'POST',
                    url: 'delete_event.php?event=' + $('#event').val() + '&pass=' + $('#del_event').val(),
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
              }
            });

            $('#add_tickets_b').click( function() {
                //alert($('#add_tickets').val());
                if($('#add_tickets').val() != ''){
                   if($('#event').val() != -1){
                      var addtickets = $('#add_tickets').val();
                      var event = $('#event').val();
                      var zone = $('#zones').val();
                      alert(event + ' - '+ zone);
                      $.ajax({
                          cache: false,
                          global: false,
                          beforeSend: function() {
                           $('#loader').html("<img src='/img/loader3.gif' />");
                          },
                          type: 'POST',
                          data:{barcodes:addtickets.trim(), event:event, zone:zone},
                          url: 'add_barcodes.php',
                          //data: 'barode=bar',
                          //dataType: 'json',
                          success: function(data){
                              alert($('#event option:selected').text() + '. Додано штрихкодів у базу - ' + data);
                              window.location.reload();
                          }
                        });
                    }

                }
            });

            $('#add_event_btn').click( function(){
                if($('#EventName').val() == ''){
                  alert('Не введена назва заходу!');
                }else{
                  if($('#halls').val() == -1){
                      alert('Не вибране місце проведення!');
                  }else{
                       var str_event = $('input[name=Strevent]:checked', '#Add_event_form').val();
                       var import_bars = $('input[name=Importbars]:checked', '#Add_event_form').val();

                      $.ajax({
                        url: 'add_event.php?event=' + $('#EventName').val() + '&hall=' + $('#halls').val() + '&date=' + $('#event_date').val() + '&str_event=' + str_event + '&import_bars=' + import_bars,
                        success: function (date) {
                          alert(date);
                          window.location.reload();
                        }
                      });
                  }
                }

            });

            $('#update_log').click( function() {
                if($('#barcontrol').val() != ''){
                    $.ajax({
                      //type: 'POST',
                      url: 'barcode_history.php?barcode=' + $('#barcontrol').val()+'&event='+$('#scanlog').val(),
                      cache: false,
                      global: false,
                      beforeSend: function() {
                        $('#loader').html("<img src='/img/loader3.gif' />");
                      },
                      //data: 'barode=bar',
                      //dataType: 'json',
                      success: function(data){
                          $('#logresult').html(data);
                          $('#loader').html("");
                      }
                    });

                    $.ajax({
                        url:'barcode/barcode.php',
                        method:"POST",
                        data:{code:$('#barcontrol').val(),type:'C128',label:''},
                        error:err=>{
                          console.log(err);
                        },

                        success:function(resp){
                          $('#display').html(resp);
                                   /* $('#bcode-card .card-footer').show('slideUp')*/
                        }
                    });

                    $('#barcontrol').val(null);
                  }else{
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
                            alert('Лог оновленно!');
                          /*$(xmldata).find('item').each(function(){
                              $('<li></li>').html( $(this).text() ).appendTo('.results');
                          });*/
                        }
                      });
                  }

            });

            $('#scanlog').change( function(){

                $.ajax({
                  cache: false,
                  global: false,
                  beforeSend: function() {
                    $('#loader').html("<img src='/img/loader3.gif' />");
                  },
                  url: 'logresponse.php?event='+$('#scanlog').val()+'&status='+$('#status').val(),
                  success: function(xmldata){
                    $('#logresult').html(xmldata);
                    $('#loader').html("");
                  }
                });

            });

          $('#event').change(function() {
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



              $.ajax({
                  url: 'zones_ids.php?event=' + $('#event').val(),
                  success: function(check){
                      //alert(check);
                      $('#zone_ids').html(check);
                  }
              });

              $.ajax({
                  url: 'validation.php?event=' + $('#event').val()+'&limit=2',
                  success: function(check){
                      //alert(check);
                      $('#validation').html(check);
                  }
              });



          });



      </script>
  <!-- End custom js for this page-->
  <div class='loader-wrapper' id="loader" ></div>
</body>

</html>