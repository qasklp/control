<?php
    session_start();
	include '../classes.php';
    $guest = new Guests();
    if($guest->get_barcode_access($_GET['barcode'])){
        $guest->get_settings($guest->get_id_by_barcode($_GET['barcode']));
        $guest->insert_log_row($guest->id, 4, $guest->plus, $guest->barcode, $_SESSION['user_id']);
        echo $guest->name."</br>".$guest->organization;
    }else{
        $guest->insert_log_row(0, 5, 0, $_GET['barcode'], $_SESSION['user_id']);
        echo 0;
    }

?>