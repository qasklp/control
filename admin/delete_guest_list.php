<?php

    session_start();
    if(!isset($_SESSION['user_id']))      // if there is no valid session
    {
        header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
    }

	include '../classes.php';
    $guest = new Guests();

    if($_GET['pass'] == $_SESSION['user_password']){
        if($guest -> delete_guest_list() == 1){
            echo "Список гостей видаленоЙ";
        }else{
            echo "Ошибка видалення заходу!";
        }
    }else{
        echo "Пароль невірний!!";
    }

    //echo $_GET['event'];
    //echo $event->Get_info()." - ".$_GET['event'];
?>