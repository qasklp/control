<?php

	include '../classes.php';
    $event = new Event();
    $activ_event_id = 0;
    $activ_event_name = '';
    $activ_event = $event -> get_active_event();
    if(is_array($activ_event)){
        $activ_event_name = $activ_event['name'];
        $activ_event_id = $_GET['event'];
    }else{
        $activ_event_name = $activ_event;
    }

    if($activ_event_id != 0){
        echo $event->get_log_barcode($activ_event_id, $_GET['barcode']);
    }

?>