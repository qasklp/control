<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php require_once '../vendor/autoload.php'; ?>
<script src="js/canvasjs.min.js"></script>
<?php
   // include '../classes.php';
  if(!isset($_GET['id']) || $_GET['id'] == ''){
    echo "<div class='main-panel'><div class='content-wrapper'><div class='row'><div class='col-9 col-xl-8 mb-4 mb-xl-0'><div style='margin:50px; font-weight:600;'>Не вказан ID користувача</div></div></div></div>";
    include 'footer.php';
    exit;
  }


  $user_id = $_GET['id'];
  $user = new User();
  $log = new Scanlog();
  //echo $user->login('admin', 'A7788a');
  $name = $user->get_name_by_id($user_id);
  $login = $user->get_login_by_id($user_id);
  $role = $user->get_role_by_id($user_id);
  $last = $user->get_lastlogin_by_id($user_id);

  if( ($_SESSION['user_role'] != 'admin') && ($login != $_SESSION['user_login'])){
     echo "<div class='main-panel'><div class='content-wrapper'><div class='row'><div class='col-9 col-xl-8 mb-4 mb-xl-0'><div style='margin:50px; font-weight:600;'>Заборона на редагування профеля!</div></div></div></div>";
     include 'footer.php';
     exit;
  }

  if(isset($_FILES['UserPhoto'])){

      if(is_uploaded_file($_FILES['UserPhoto']['tmp_name'])){

          //название исходного файла без расширения
          $fileName = pathinfo($_FILES['UserPhoto']['name'], PATHINFO_FILENAME);

          //расширение
          $fileExtension = pathinfo($_FILES['UserPhoto']['name'], PATHINFO_EXTENSION);

          $img = $_FILES['UserPhoto']['tmp_name']; //путь к файлу из временной папки

          //Объект Intervention\Image\ImageManager для работы с изображениями
          $manager = new Intervention\Image\ImageManager(array('driver' => 'imagick'));

          if ($user->get_user_path_photo($user_id) != '') unlink($user->get_user_path_photo($user_id));

          $img_mini = $manager->make($img)->resize(100, 100,function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
          })->save('../img/users/'.$user_id.'.'.$fileExtension);

          if (file_exists('../img/users/'.$user_id.'.'.$fileExtension)){
              $user->add_photo($user_id, '../img/users/'.$user_id.'.'.$fileExtension);
          }
      }
  }

?>
<style>
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


                <h3 class="font-weight-bold" style='margin-bottom: 20px;'>Профіль користувача </h3>
                <br>
                 <div class="row">
                  <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                       <div class="card-body">
                        <div class="row">
                        <div class="col-md-4 mb-4 stretch-card transparent">
                         <div class='prof_foto'><?=$user->get_user_photo($user_id)?>
                          <?php if($role != 'ctrl'):?>
                             <button type="button" class="btn btn-warning btn-icon-text prof" id="new_foto" data-toggle="modal" data-target="#NewFotoModal">
                              <i class="ti-reload btn-icon-prepend"></i>
                               Нове фото
                             </button>
                          <?php endif; ?>
                        </div>
                       </div>
                       <div class="col-md-8 mb-4 stretch-card transparent">
                         <div class="table-responsive">
                          <br>
                           <table class="table table-striped">
                             <tbody>
                              <tr><td><span style="font-weight:600;">Name:</span></td><td><?=$name?></td></tr>
                                <tr><td><span style="font-weight:600;">Login:</span></td><td> <?=$login?></td></tr>
                                <tr><td><span style="font-weight:600;">Password:</span></td><td> *********</td></tr>
                                <tr><td><span style="font-weight:600;">Role:</span></td><td> <?=$role?></td></tr>
                                <tr><td><span style="font-weight:600;">Last login:</span> </td><td><?=$last?></td></tr>
                            <tbody>
                          </table>
                        </div>
                      </div>
                      </div>
                        <div style='float:right;'>
                          <button type="button" class="btn btn-success btn-icon-text" data-toggle="modal" data-target="#EditUserModal">
                            <i class="ti-alert mdi mdi-pen"></i>
                            Редагувати
                          </button>
                       </div>
                      </div>
                    </div>
                  </div>
                   <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                       <div class="card-body">
                          <!--<h3>Статистика сканування</h3>
                            <p class="card-description">
                              Add class <code>.table-striped</code>
                            </p>-->
                            <div id="chartContainer" style="height: 370px; width: 100%; margin:30px 0;"></div>
                      </div>
                    </div>
                  </div>



          </div>
          <div class="row">
          <?= $user->get_profile_stat_table($user_id) ?>
          </div>

            <!-- Modal -->
                  <div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Редагувати користувача</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="/admin/usersprofile.php?id=<?=$user_id?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="UserName">ФІО користувача</label>
                              <input type="text" class="form-control" id="UserName" name="UserName" placeholder="ФІО користувача" value="<?=$name?>">
                              <input type="hidden" class="form-control" id="UserId" name="UserId" value="<?=$user_id?>">
                            </div>
                            <div class="form-group">
                              <label for="UserLogin">Login</label>
                              <input type="text" class="form-control" id="UserLogin" name="UserLogin" placeholder="Login" value="<?=$login?>">
                            </div>
                            <div class="form-group">
                              <label for="UserPassword">Password</label>
                              <input type="password" class="form-control" id="UserPassword" name="UserPassword" placeholder="Password">
                            </div>
                               <button type="button" class="btn btn-primary mb-2" id='UserEdit'>Редагувати</button>
                              </div>

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

                  <!-- Modal -->
                  <!-- Modal Foto-->
                  <div class="modal fade" id="NewFotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle">Нове фото користувача</h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="/admin/usersprofile.php?id=<?=$user_id?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                              <label for="UserPhoto">Фото користувача</label>
                              <input type="file" name="UserPhoto" id="UserPhoto">
                            </div>

                                <button type="submit" class="btn btn-primary mb-2">Змінити</button>
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

               <script type="text/javascript">

                $(document).ready(function(){

                    /*$("#new_foto").on("click", function(){
                        alert('new_foto');
                    });*/

                    $("#UserEdit").on("click", function(){

                     // alert($("#UserName").val() + $("#UserLogin").val() + $("#UserPassword").val());

                      if($("#UserName").val() == ''){
                        alert("Ім'я користувача не введено!");
                        throw "stop";
                      }

                      if($("#UserLogin").val() == ''){
                        alert("Login користувача не введено!");
                        throw "stop";
                      }

                      if($("#UserPassword").val() == ''){
                        alert("Password користувача не введено!");
                        throw "stop";
                      }

                       //alert("You just clicked checkbox with the name " + this.name +' - '+ this.id +' - '+ $( this ).attr('user') + ' - ' +$( this ).prop( "checked" ));
                       //
                       //
                      $.ajax({

                        url: 'usersedit.php?name=' + $("#UserName").val()+'&login='+ $("#UserLogin").val() + '&pass=' + $("#UserPassword").val()+'&user_id='+ $("#UserId").val() ,
                        success: function(data){
                          //alert(data);

                          if(data){
                            alert('Профіль користувача змінено!');
                            window.location.reload();
                            //window.location.href = '/admin/logout.php';
                          }

                        }
                      });


                    });
                      //var mass = $("input:checkbox").attr('checked', 'checked');

                      /*for(var i=0; i<mass.length; i++){
                          console.log(mass[i]);
                      }*/

                 });

              </script>

              <script type="text/javascript">


   window.onload = function () {
      //$('#loader').html("<img src='/img/loader3.gif' />");
      $.ajax({
            url:'barcode/barcode.php',
            method:"POST",
            data:{code:'<?=$event->get_active_event_id()?>',type:'C128',label:''},
            /*beforeSend: function() {
                          $('#loader').html("<img src='/img/loader3.gif' />");
                        },*/
            error:err=>{
              console.log(err)
            },
            success:function(resp){
              $('#barcode_event').html(resp)
             // $('#bcode-card .card-footer').show('slideUp')
            }
          });


            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              theme: "light2",
              title: {
                text: "Загальна статистика логу"
              },
              data: [{
                type: "column",
                indexLabel: "{y}",
                showInLegend: false,
                dataPoints: [//нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
                  {y: <?=$log->get_log_status_count(0, $event->get_active_event_id(), $user_id);?>, label: "Немає в базі"},
                  {y: <?=$log->get_log_status_count(1, $event->get_active_event_id(), $user_id);?>, label: "Вхід до залу"},
                  {y: <?=$log->get_log_status_count(2, $event->get_active_event_id(), $user_id);?>, label: "Повторний вхід"},
                  {y: <?=$log->get_log_status_count(3, $event->get_active_event_id(), $user_id);?>, label: "Вихід із залу"},
                  {y: <?=$log->get_log_status_count(4, $event->get_active_event_id(), $user_id);?>, label: "Не той сектор"}
                ]
              }]
            });
            chart.render();

        }

    </script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>