<?php

	include '../classes.php';
    $event = new Event();
    echo $event->get_log_table($_GET['event'],$_GET['status'],'');

?>