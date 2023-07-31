<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>
<?php
  $user = new User();
  $guest = new Guests();
  $event = new Event();

?>
<style>

   @media print {
        @page {
            size: auto;
            margin: 0;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        html,
        body {
            width: 210mm;
            height: 290mm;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .print{
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        #sidebar{
          display: none;
        }
        .navbar{
          display: none !important;
        }

        .head_guest{
          display: none !important;
        }
        .footer{
          display: none !important;
        }
        .table-responsive{
            overflow-x: hidden;
            overflow-y: hidden;
        }
    }

  .prof_foto img{
      width: 200px;
      height:200px;
      border-radius: 100%;
      margin: 40px 0 20px 20px;
  }

  .prof{
    margin: 10px 0 10px 42px;
  }
  table td{
    font-size: 16px !important;
  }
</style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="head_guest">
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold" style='margin-bottom: 20px;'>Сканування гостей</h3><br>
                </div>
                </div>
                 <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                   <div style='float:left; margin:0 10px;'>
                     <input type="text" id='guest_scan' class="form-control" style="float:left; width: 350px; margin-top: -10px; font-size: 20px;">
                   </div>


                   <!--<div style='float:left; margin:0 10px;'>
                     <span style="font-weight:bold; float:left; padding:0 5px;">Організація</span>
                     <input type="text" id='name'>
                   </div>
                   <div>
                     <span style="font-weight:bold; float:left; padding:0 5px;">Штрихкод</span>
                     <input type="text" id='barcode'>
                   </div>-->
                  </div>
                </div><br/>
                </div>
                <div class="col-md-12 grid-margin" style='padding:0;'>
                <div class="row">
                    <div id='guestresult' class="table-responsive" style='font-size:20px; font-weight:bold; padding:5px 0; min-height: 500px;'>
                      <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                                <h1 style='text-align: center;'>Доступ у зону</h1><br/>
                                  <div id='acess_g_color' style='width: 100%; height: 300px; border-radius:10px; border: 3px solid black; background-color: grey;' >
                                    <div id='acess_g_text' style="text-align:center; font-family: Arial,sans-serif; font-weight:bold; font-size:60px; text-transform: uppercase;  margin:90px; color:white;"></div>
                                  <div>


                  <!--<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Фото
                          </th>
                          <th>
                            П.І.О
                          </th>
                          <th>
                            Реєстрація
                          </th>
                          <th>
                            Кількість плюсів
                          </th>
                          <th>
                            Вхід
                          </th>
                          <th>
                            Плюси зайшли
                          </th>
                          <th>
                            Прогрес входу плюсів
                          </th>
                          <th>
                            Зони доступу
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="py-1">
                            <img src='../img/users/20.png' alt='image'/>
                          </td>
                          <td style = ''>
                            <a hraf='#' data-toggle="modal" data-target="#AddInfoGuest1" style="cursor: pointer; text-decoration:underline;">Віктор Леонский</a>
                          </td>
                          <td>
                           <button type="button" class="btn btn-danger btn-icon-text">
                          <i class="ti-file btn-icon-prepend"></i>
                          Реєстрація
                        </button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-outline-secondary">-</button>
                          <button type="button" class="btn btn-outline-secondary">3</button>
                          <button type="button" class="btn btn-outline-secondary">+</button>
                        </div>
                          </td>
                          <td>
                           <button type="button" class="btn btn-social-icon btn-outline-youtube"><i class="mdi mdi-run icon-md"></i></button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-primary">
                            <i class="mdi mdi-account-plus"></i>
                          </button>
                          <button type="button" class="btn btn-primary">
                            3
                          </button>
                        </div>
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?='100'?>%" aria-valuenow="5" aria-valuemin="1" aria-valuemax="5"></div>
                            </div>
                          </td>
                          <td>All access</td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src='../img/users/user.png' alt='image'/>
                          </td>
                          <td style = ''>
                            Игорь Атаманчук
                          </td>
                          <td>
                           <button type="button" class="btn btn-info btn-icon-text">
                          Друк
                          <i class="ti-printer btn-icon-append"></i>
                        </button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-outline-secondary">-</button>
                          <button type="button" class="btn btn-outline-secondary">12</button>
                          <button type="button" class="btn btn-outline-secondary">+</button>
                        </div>
                          </td>
                          <td>
                           <button type="button" class="btn btn-social-icon btn-outline-youtube"><i class="mdi mdi-run icon-md"></i></button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-primary">
                            <i class="mdi mdi-account-plus"></i>
                          </button>
                          <button type="button" class="btn btn-primary">
                            3
                          </button>
                        </div>
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?='35'?>%" aria-valuenow="5" aria-valuemin="1" aria-valuemax="5"></div>
                            </div>
                          </td>
                          <td><input type="checkbox" user="10" id="61" name="group61" checked><label style="margin-left:5px;" for="61">Сцена</label><br><input type="checkbox" user="10" id="62" name="group62"><label style="margin-left:5px;" for="62">VIP</label><br><input type="checkbox" user="10" id="63" name="group63"><label style="margin-left:5px;" for="63">Backstage</label><br><input type="checkbox" user="10" id="64" name="group64" checked><label style="margin-left:5px;" for="64">Гримерка</label><br><input type="checkbox" user="10" id="78" name="group78"><label style="margin-left:5px;" for="78">Зал</label><br><input type="checkbox" user="10" id="79" name="group79"><label style="margin-left:5px;" for="79">Вхідна група</label><br></td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src='../img/users/user.png' alt='image'/>
                          </td>
                          <td style = ''>
                            Дмитрий Феликсов
                          </td>
                          <td>
                           <button type="button" class="btn btn-danger btn-icon-text">
                          <i class="ti-file btn-icon-prepend"></i>
                          Реєстрація
                        </button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-outline-secondary">-</button>
                          <button type="button" class="btn btn-outline-secondary">6</button>
                          <button type="button" class="btn btn-outline-secondary">+</button>
                        </div>
                          </td>
                          <td>
                           <button type="button" class="btn btn-social-icon btn-outline-youtube" disabled="disabled"><i class="mdi mdi-run icon-md"></i></button>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-primary" disabled="disabled">
                            <i class="mdi mdi-account-plus"></i>
                          </button>
                          <button type="button" class="btn btn-primary" disabled="disabled">
                            0
                          </button>
                        </div>
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: <?='0'?>%" aria-valuenow="5" aria-valuemin="1" aria-valuemax="5"></div>
                            </div>
                          </td>
                          <td><input type="checkbox" user="10" id="61" name="group61" checked><label style="margin-left:5px;" for="61">Сцена</label><br><input type="checkbox" user="10" id="62" name="group62"><label style="margin-left:5px;" for="62">VIP</label><br><input type="checkbox" user="10" id="63" name="group63"><label style="margin-left:5px;" for="63">Backstage</label><br><input type="checkbox" user="10" id="64" name="group64" checked><label style="margin-left:5px;" for="64">Гримерка</label><br><input type="checkbox" user="10" id="78" name="group78" checked><label style="margin-left:5px;" for="78">Зал</label><br><input type="checkbox" user="10" id="79" name="group79"><label style="margin-left:5px;" for="79">Вхідна група</label><br></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>-->
              </div>
            </div>

                    </div>
                  </div>

                </div>
                </div>



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
                   function printPage() {
                      window.print();
                      return false;
                    }

                  $( document ).ready(function() {
                      /*$.ajax({
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
                     });*/

                   $(":button").click(function() {

                        if( typeof $( this ).attr('guestid') !== 'undefined' ){

                            if(confirm("Реєструємо гостя?")){
                              //alert($( this ).attr('guestid'));
                              $.ajax({
                                   url: 'reg_guest.php?guestid=' + $( this ).attr('guestid'),
                                  success: function(data){
                                    alert(data);
                                    window.location.reload();
                                  }
                              });
                          }

                        }

                         if( typeof $( this ).attr('guest_print') !== 'undefined' ){
                            window.open('/admin/print_guest.php?id='+ $( this ).attr('guest_print'), '_blank');
                            //window.location.href = 'print_guest.php?id=' + $( this ).attr('guest_print');
                         }

                    });

                   $('#status').change( function() {
                      //alert($('#status').val());
                      $.ajax({
                        url: 'guests_stat.php?status=' + $('#status').val() + '&name='+$('#guest_name').val(),
                        cache: false,
                        global: false,
                        beforeSend: function() {
                          $('#loader').html("<img src='/img/loader3.gif' />");
                        },
                        success: function(data){
                            $('#guestresult').html(data);
                            $('#loader').html("");
                          /*$(xmldata).find('item').each(function(){
                              $('<li></li>').html( $(this).text() ).appendTo('.results');
                          });*/
                        }
                      });
                  });


                    /*$(":button").click( function() {

                      /*if( typeof $( this ).attr('guest') !== 'undefined' ){
                            alert($( this ).attr('guest'));
                        }

                      alert($('#plus_go').val()+' *** '+$('#guestId').val());*/

                          /*if(typeof $( this ).attr('guest') !== 'undefined'){
                            //alert($('#clear_log_pass').val());
                            $.ajax({
                              url: 'plus_go.php?plus='+$('#plus_go').val()+'&id='+$('#guestId').val(),
                                  success: function(data){
                                      alert(data);
                                      window.location.reload();
                                  }
                              });
                          }

                      });*/


                      $('#guest_reload').click( function() {
                          window.location.reload();
                      });


                      $('#guest_search').click( function() {
                          if($('#guest_name').val() != ''){
                            //alert($('#guest_name').val());

                            //$('#guestresult').html($('#guest_name').val());

                            $.ajax({
                              url: 'guests_search.php?status=' + $('#status').val() + '&name='+$('#guest_name').val(),
                                  success: function(data){
                                      $('#guestresult').html(data);

                                  }
                            });

                          }

                      });


                });

                    $(document).keypress(function(e) {
                      if(e.which == 13) {
                          //var bar = $('#barcontrol').val();
                          //alert($('#guest_scan').val());



                          if($('#guest_scan').val() != ''){
                              $.ajax({
                                url: 'guest_scan_response.php?barcode=' + $('#guest_scan').val(),
                                success: function(data){
                                  if(data != 0){
                                    $('#acess_g_color').css('backgroundColor', 'green');
                                    $('#acess_g_text').html(data);
                                  }else{
                                    $('#acess_g_color').css('backgroundColor', 'red');
                                    $('#acess_g_text').html('Заборонено');
                                  }

                                }
                              });

                              $('#guest_scan').val(null);
                          }
                    }
                  });
                </script>


        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

