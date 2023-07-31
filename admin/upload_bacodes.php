<?php

	include '../classes.php';
    $event = new Event();
    $hall == new Hall($event->get_active_event_id());
    $validation = new Validation();

   if($event->is_addon_event($_POST['event'])== 1){
        echo $event->import_barcods_from_csv($_POST['event'], true);
    }else{
        echo $event->import_barcods_from_csv($_POST['event'], false);
    }



?>