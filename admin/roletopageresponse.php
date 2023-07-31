<?php

	include '../classes.php';
    //$user = new User('ctrl','ctrl');
    $role = new Role();

	//echo $event->get_active_event_id().' - '.$_GET['user'].' - '.$_GET['group'].' - '.$_GET['action'];
   echo $role->set_role_to_page($_GET['role'], $_GET['page'], $_GET['action']);
   //echo $user->set_user_to_group(55,23,33,false);