<?php

	//статусы лога 0-нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
	//статусы ответа для мобильного приложения
	//err: 1 - Подія не встановлена; 2 - Квиток відсутній у базі; 3-Повторний вхід; 4 - Квитка нема в залі;
	//succes: 1 - Вхід дозволено; 2-Вихід з залу
	//
	include 'classes.php';
	$event = new Event();
	$mobapk = new MobApp();
	$place = new Eventplace();
	$log = new Scanlog();
	$user = new User('ctrl','ctrl');
	$groupzone = new Groupzone();

	$active_event_id = 0;
	$active_event_name = '';
	$barcode = $_GET['ticket'];
	$exit = $_GET['exit'];
	$ctrl = $_GET['controller'];

	$active_event = $event -> get_active_event();
	if(is_array($active_event)){
		$active_event_name = $active_event['name'];
		$active_event_id = $active_event['id'];
	}else{
		$activ_event_name = $active_event;
	}

	if(isset($barcode)){

		if($barcode == ''){
			$log->insert_row($active_event_id, 0, $barcode, 0, $ctrl);
			echo $mobapk->get_response_error(2);
			exit;
		}

		$place->get_place($active_event_id, $barcode);
		//echo $activ_event_id."**".$barcode."***".$place->barcode;
		if($place->barcode == $barcode){
			if($place->status == 0){//вход в зал
				if($exit == 0){
					//Мероприятие с расширенной структурой
					if($event->get_addon_event($active_event_id) == 1){
						if($user->get_user_in_group($active_event_id, $ctrl, $place->zone_id) == 1 || $place->zone_id == '-1'){
							$log->insert_row($active_event_id, $place->id, $barcode, 1, $ctrl);
							$place->set_status(1, $place->id);
							echo $place->zone_name." ряд:".$place->row.": місце:".$place->col." - ".$mobapk->get_response_succes(1);
						}else{
							$log->insert_row($active_event_id, $place->id, $barcode, 4, $ctrl);
							echo $mobapk->get_response_error(5)." (".$place->zone_name.")";
						}
					}

					//Мероприятие обычное
					if($event->get_addon_event($active_event_id) == 0){
						$log->insert_row($active_event_id, $place->id, $barcode, 1, $ctrl);
						$place->set_status(1, $place->id);
						echo $place->zone_name." ряд:".$place->row.": місце:".$place->col." - ".$mobapk->get_response_succes(1);
					}

				}else{
					$log->insert_row($active_event_id, $place->id, $barcode, 3, $ctrl);
					echo $mobapk->get_response_error(4);
				}
			}

			if($place->status == 1){//повторный вход
				if($exit == 0){
					$log->insert_row($active_event_id, $place->id, $barcode, 2, $ctrl);
					echo $mobapk->get_response_error(3)." - ".$log->get_time($place->id);
				}else{
					$log->insert_row($active_event_id, $place->id, $barcode, 3, $ctrl);
					$place->set_status(0, $place->id);
					echo $place->zone_name." ряд:".$place->row.": місце:".$place->col." - ".$mobapk->get_response_succes(2);
				}
			}
		}
		else{
			$log->insert_row($active_event_id, 0, $barcode, 0, $ctrl);
			echo $mobapk->get_response_error(2);
		}
		exit;
	}



	if($_GET['event'] == $active_event_id){
		echo $user->login_mob($ctrl);
	}else{
		echo $mobapk->get_response_error(1);
	}

	//$event =  $_GET['event'];
	//$barcode =  $_GET['ticket'];

	//echo 'event - '.$event.'barcode - '.$barcode;
	//echo 'Error:Билет не найден.';
?>