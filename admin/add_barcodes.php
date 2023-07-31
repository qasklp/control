<?php

	include '../classes.php';
    $eventplace = new Eventplace();

    extract($_POST);

    //$barcodes =  $barcodes'];
   // $barcodes = explode('/n', $barcodes);
    $rows_array = preg_split('/[\n\r]+/', $barcodes);

    $add_tickets =  $eventplace -> add_tickets($rows_array, $zone, $event);
    echo $add_tickets;


?>