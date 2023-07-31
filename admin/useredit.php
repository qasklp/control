<?php

// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
// Статусы для eventplace 0 - не сканировался; 1 - в зале;

  include '../classes.php';
  $user = new User();
  echo $_GET['name']." - ".$_GET['login']." - ".$_GET['pass'];
 // echo $log->get_log_place($place);
  //echo "Response from script";
?>