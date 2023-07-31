<?php

	include '../classes.php';
    $validation = new Validation();
    echo $validation->get_double_barcodes($_GET['event'],$_GET['limit'])."<br/>";
    echo $validation->get_same_zone_col_row($_GET['event'],$_GET['limit']);
    //echo "<span style='font-weight:bold;'>Місце проведення: </span>".$hall->name." (".$hall->addr.")";

?>