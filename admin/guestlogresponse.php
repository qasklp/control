<?php

	include '../classes.php';
    $guest = new Guests();
    echo $guest->get_guestlog_table($_GET['status']);

?>