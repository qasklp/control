<?php

	include '../classes.php';
    $user = new User('ctrl','ctrl');
    $event = new Event();

	//echo $event->get_active_event_id().' - '.$_GET['user'].' - '.$_GET['group'].' - '.$_GET['action'];
   echo $user->set_user_to_group($event->get_active_event_id(), $_GET['user'], $_GET['group'], $_GET['action']);
   //echo $user->set_user_to_group(55,23,33,false);