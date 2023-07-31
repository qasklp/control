<?php

	include '../classes.php';

    $guests = new Guests();
    echo $guests->import_guest_from_csv();
?>