<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>

<?php if($_SESSION['user_role'] != 'admin'){
        echo "<h3 style='margin:30px auto; font-weight:bold; text-align:center;'>Перегляд сторінки заборонено!</h3>";
        exit;
      }
?>


<?php require_once '../vendor/autoload.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
           <?php
                if(isset($_POST['userId'])){
                  $user = new User();
                  $validation = new Validation();
                  echo "<div class='row'><div class='col-md-12 grid-margin' style='width:100%; flex: 0 100%;' id='event_info'>";
                    if($_POST['user_password'] == $_SESSION['user_password']){
                        if($user->del_user($validation->text_validation($_POST['userId'])) == 1){
                          echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Користувача видалено</div><br/>";
                        }

                    }else{
                      echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Пароль невірний!</div><br/>";
                      //$user -> del_user($validation->text_validation($_POST['userId']);
                    }

                  echo "</div></div>";
                }

                if(isset($_POST['UserName'])){

                  $user = new User();
                  $validation = new Validation();
                  $flag = true;

                  echo" <div class='row'><div class='col-md-12 grid-margin' style='width:100%; flex: 0 100%;' id='event_info'>";

                  if($_POST['UserName'] == ''){
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>ФІО користувача не введено</div><br/>";
                      $flag = false;
                  }

                  if($_POST['UserLogin'] == ''){
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Login користувача не введено</div><br/>";
                      $flag = false;
                  }

                  if($_POST['UserPassword'] == ''){
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Password користувача не введено</div><br/>";
                      $flag = false;
                  }

                  if($_POST['user_role'] == ''){
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Role користувача не вибрана</div><br/>";
                      $flag = false;
                  }

                  if($flag){
                    $name = $validation->text_validation($_POST['UserName']);
                    $login = $validation->text_validation($_POST['UserLogin']);
                    $pass =  $validation->text_validation($_POST['UserPassword']);

                    if($user->add_user($name, $login, $pass, $_POST['user_role']) == 1){
                          $user->login($login, $pass);
                          echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Користувача створенно</div>";

                          //echo $_POST['UserName']." - ".$_POST['UserLogin']." - ".$_POST['UserPassword']." - ".$_POST['user_role'];
                            if(isset($_FILES['UserPhoto'])){

                               if(is_uploaded_file($_FILES['UserPhoto']['tmp_name'])){

                                /*echo "<pre>";
                                var_dump($_FILES['UserPhoto']['name']);
                                echo "</pre>";*/

                                  //название исходного файла без расширения
                                  $fileName = pathinfo($_FILES['UserPhoto']['name'], PATHINFO_FILENAME);
                                  //расширение
                                  $fileExtension = pathinfo($_FILES['UserPhoto']['name'], PATHINFO_EXTENSION);

                                  $img = $_FILES['UserPhoto']['tmp_name']; //путь к файлу из временной папки

                                 //Объект Intervention\Image\ImageManager для работы с изображениями
                                  $manager = new Intervention\Image\ImageManager(array('driver' => 'imagick'));

                                 $img_mini = $manager->make($img)->resize(100, 100,function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                })->save('../img/users/'.$user->id.'.'.$fileExtension);

                                if (file_exists('../img/users/'.$user->id.'.'.$fileExtension)){
                                    $user->add_photo($user->id, '../img/users/'.$user->id.'.'.$fileExtension);
                                }
                              }
                           }

                          echo $user->success_add_user_table($user->id, $user->name, $user->login, $user->role);
                      }

                    //echo $_POST['UserName']." - ".$_POST['UserLogin']." - ".$_POST['UserPassword']." - ".$_POST['user_role'];
                  }


                  echo "</div></div>";
                    //if($_POST['UserName'] != ''){


                      /*echo $_POST['EventName']."<br/>";
                      echo date('Y-m-d H:i:s', strtotime($_POST['EventDate']))."<br/>";
                      echo $_POST['halls']."<br/>";
                      echo $_POST['Strevent']."<br/>";
                      echo $_POST['Importbars']."<br/>";
                      echo "</div></div><br/><br/>";*/

                }
            ?>
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0" style='padding-right: 0;'>
                <h3 class="font-weight-bold" style='margin-bottom: 20px; float: left;'><?=rolemanage?></h3><button type="button" class="btn btn-info btn-ti-star" id='add_event' data-toggle="modal" data-target="#AddUserModal" style="margin:-10px 0 10px 10px;">
                      <i class="mdi mdi-plus-circle" style='vertical-align: middle;'></i>
                      <?=roleadd?>
                  </button>
                  <div style='margin-top: 30px;'></div>
                <?php

                 // include '../classes.php';


                 $user = new User();
                 $role = new Role();
                 //echo $user->login('admin', 'A7788a');
                 echo $role->get_rolers_table();
                 //echo $user->get_modal_for_mob();
                 //echo $user->get_modal_del_user();
              ?>
              </div>
            </div>

            <!-- Modal -->
                  <div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle"><?=roleadd?></h3>
                        </div>
                        <div class="modal-body">
                          <form class="forms-sample" action="/admin/users.php" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="UserName">ФІО користувача</label>
                              <input type="text" class="form-control" id="UserName" name="UserName" placeholder="ФІО користувача">
                            </div>
                            <div class="form-group">
                              <label for="UserLogin">Login</label>
                              <input type="text" class="form-control" id="UserLogin" name="UserLogin" placeholder="Login">
                            </div>
                            <div class="form-group">
                              <label for="UserPassword">Password</label>
                              <input type="password" class="form-control" id="UserPassword" name="UserPassword" placeholder="Password">
                            </div>
                            <div class="form-group">
                              <label for="UserPhoto">Фото користувача</label>
                              <input type="file" name="UserPhoto" id="UserPhoto">
                            </div>
                            <div class="form-group">
                              <label for="user_role" style="margin-top:10px;">Роль користувача</label>
                               <select name="user_role" id="user_role" class="js-example-basic-single w-100" style="float:left; width:50%;" tabindex="0" aria-hidden="false">
                                  <option value="">Вибрати роль</option>
                                  <option value="admin">Admin</option>
                                  <option value="visitor">Visitor</option>
                                  <option value="ctrl">Controler</option>
                                </select>
                              </div>
                                <button type="submit" class="btn btn-primary mb-2">Додати</button>
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
                    $(":checkbox").on("click", function(){

                       //alert("You just clicked checkbox with the name " + this.name +' - '+ this.id +' - '+ $( this ).attr('role') + ' - ' +$( this ).prop( "checked" ));
                      $.ajax({

                        url: 'roletopageresponse.php?role=' + $( this ).attr('role')+'&page='+ this.id + '&action=' + $( this ).prop( "checked" ),
                        success: function(data){
                          if(data == 1)
                            alert('Дані внесені у базу!');
                        }
                      });


                    });
                      //var mass = $("input:checkbox").attr('checked', 'checked');

                      /*for(var i=0; i<mass.length; i++){
                          console.log(mass[i]);
                      }*/

                 });

              </script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

