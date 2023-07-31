<?php

	include '../classes.php';
    $event = new Event();
    $guest = new Guests();
    $validation = new Validation();
    session_start();
    $guest->get_settings($_GET['id']);

    if($guest->plus_go($validation->text_validation($_GET['plus']), $guest->plus, $_GET['id']) == 1){
        $guest->insert_log_row($_GET['id'], 1, $_GET['plus'], $guest->barcode, $_SESSION['user_id']);
        echo "Зайшли по плюсах - ".$_GET['plus'];
    }else{
        echo $guest->plus_go($validation->text_validation($_GET['plus']), $guest->plus, $_GET['id']);
    }


?>