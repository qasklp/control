<?php

   include '../classes.php';

  $hall = new Hall($_GET['hall']);
  echo $hall->get_svg_hall_map();
  //$user = new User();
   //echo $user->login('admin', 'A7788a');
   //echo $user->get_users_table();
   //echo $user->get_modal_for_mob();
?>