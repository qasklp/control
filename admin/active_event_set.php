<?php

	include '../classes.php';
    $event = new Event();
    echo $event->set_active_event($_GET['event']);
    //echo $event->Get_info()." - ".$_GET['event'];
?>