<?php

// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона 
// Статусы для eventplace 0 - не сканировался; 1 - в зале;
	session_start();
  	//session_regenerate_id();
  	if(!isset($_SESSION['user_id']))      // if there is no valid session
  	{
    	header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
  	}

	include 'classes.php';
	$log = new Scanlog();
	$place = new Eventplace();
	$user = new User();
	$event = new Event();

	$user_id = $_GET['user_id'];
	$code =  $_GET['code'];
	$active_event_id =  $_GET['event'];
	$exit =  $_GET['exit'];

	//echo $user->id." - ".$code." - ".$active_event_id." - ".$exit."<br/>";
	//echo '[{"status":1}]';

	//$place->get_place($active_event_id, $code);

	//echo '[{"status":1, "zone":"Столы", "zone_id":76, "row":22,"col":12,"price":125,"time":"2022-10-04 17:55:17","barcode":"322228721534","inv":0,"img":"", "fan":0}]';
	//echo "ISSET - ".isset($place->id)."<br/>";



	if ($place->get_place($active_event_id, $code)){ //get_json(0) - нет в базе, get_json(1) - вход, get_json(2) - повторный, get_json(3) - вышел, get_json(4) - не та зона входа, get_json(5) - нет в зале
		if($place->status == 0){//вход в зал
			if($exit == 0){
				//echo $event->get_addon_event($active_event_id);
				//Мероприятие с расширенной структурой
				if($event->get_addon_event($active_event_id) == 1){
					//echo $active_event_id." - ".$code;
					//echo $place->get_group_zone($active_event_id, $code)."<br/>";
					//echo $user->get_user_in_group ($active_event_id, $user, $place->get_group_zone($active_event_id, $code));
					if($user->get_user_in_group($active_event_id, $user_id, $place->zone_id) || $place->zone_id == '-1'){
						$log->insert_row($active_event_id, $place->id, $code, 1, $user_id);
						$place->set_status(1, $place->id);
						echo $place->get_json(1, $user_id);
					}else{
						$log->insert_row($active_event_id, $place->id, $code, 4, $user_id);
						echo $place->get_json(4, $user_id);
					}
				}

				//Мероприятие обычное
				if($event->get_addon_event($active_event_id) == 0){
					$log->insert_row($active_event_id, $place->id, $code, 1, $user_id);
					$place->set_status(1, $place->id);
					echo $place->get_json(1, $user_id);
				}
			}else{
				$log->insert_row($active_event_id, $place->id, $code, 3, $user_id);
				echo $place->get_json(5, $user_id);
			}
		}

		if($place->status == 1){//повторный вход
			if($exit == 0){
				$log->insert_row($active_event_id, $place->id, $code, 2, $user_id);
				echo $place->get_json(2, $user_id);
			}else{
				$log->insert_row($active_event_id, $place->id, $code, 3, $user_id);
				$place->set_status(0, $place->id);
				echo $place->get_json(3, $user_id);
			}
		}
	}else{
		$log->insert_row($active_event_id, 0, $code, 0, $user_id);
		echo $place->get_json(0, $user_id);
	}

?>