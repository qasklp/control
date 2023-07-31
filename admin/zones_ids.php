<?php

	include '../classes.php';
    $event = new Event();
    echo $event->get_zones_ids_names($_GET['event']);
    //echo '[{"event":'.$_GET['event'].',"addon":"'.$addon.'"}]';
?>