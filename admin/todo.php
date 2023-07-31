<?php

	include '../classes.php';

    $todo = new ToDo();
    $event = new Event();
    $validation = new Validation();

    switch($_GET['action']){

        case 1:
            echo $todo->todo_add($event->get_active_event_id(), $validation->text_validation($_GET['text']));
            break;

        case 2:
            echo $todo->todo_del($_GET['id']);
            //echo 'del';
            break;

        case 3:
            $result = $todo->todo_chk($_GET['id'], $_GET['chk']);
            if($result != 1){
                echo 'Помилка при внесенні данних!';
            }
            break;

    }

    //echo $validation->get_double_barcodes($_GET['event'])."<br/>";
    //echo $validation->get_same_zone_col_row($_GET['event']);
    //echo "<span style='font-weight:bold;'>Місце проведення: </span>".$hall->name." (".$hall->addr.")";

?>