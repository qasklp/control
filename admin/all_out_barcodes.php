<?php

    session_start();
    if(!isset($_SESSION['user_id']))      // if there is no valid session
    {
        header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
    }

	include '../classes.php';
    $event = new Event();

    if($_GET['pass'] == $_SESSION['user_password']){

        if($event->set_out_all_barcodes($_GET['event']) == 1){
            echo "Всі штрихкоди заходу не в залі!";
        }else{
            echo "Ошибка зміни статусов штрихкодів!";
        }
    }else{
        echo "Пароль невірний!!";
    }

    //echo $_GET['event'];
    //echo $event->Get_info()." - ".$_GET['event'];
?>