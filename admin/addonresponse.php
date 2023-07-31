<?php

	include '../classes.php';
    $event = new Event();
    echo $event->get_addon_event($_GET['event']);
    //echo '[{"event":'.$_GET['event'].',"addon":"'.$addon.'"}]';
?>