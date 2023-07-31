<?php
    session_start();
    if(!isset($_SESSION['user_id']))      // if there is no valid session
    {
        header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
    }

	include '../classes.php';

    if($_GET['pass'] == $_SESSION['user_password']){
        $event = new Event();
        echo $event->clear_barcodes($_GET['event']);
    }else{
        echo "Пароль невірний!!";
    }

    //echo $_GET['pass']." - ".$_GET['event'];
?>