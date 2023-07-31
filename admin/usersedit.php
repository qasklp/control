<?php

// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
// Статусы для eventplace 0 - не сканировался; 1 - в зале;

  include '../classes.php';
  session_start();
  if(!isset($_SESSION['user_id']))      // if there is no valid session
  {
    header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
  }


  $user = new User();
  $validation = new Validation();

  //echo $_GET['name']." - ".$_GET['login']." - ".$_GET['pass']." - ".$_GET['user_id'];


  if($user->edit_user_profile($_GET['user_id'], $validation->text_validation($_GET['name']), $validation->text_validation($_GET['login']), $validation->text_validation($_GET['pass'])) == 1) {
      if($_GET['user_id'] == $_SESSION['user_id']){
        $_SESSION['user_login'] = $_GET['login'];
      }
      echo 'true';
  }

 // echo $log->get_log_place($place);
  //echo "Response from script";
?>