<?php

    include '../classes.php';

    $guest = new Guests();
    $validation = new Validation();

    //echo $_GET['name'].' - '.$_GET['org'].' - '.$_GET['plus'].' - '.$_GET['comment'].' - '.$_GET['all_access'];

    // echo $_GET['name'];

    echo $guest->get_guests_table($validation->text_validation($_GET['name']), $_GET['status']);