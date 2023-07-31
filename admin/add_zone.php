<?php

	include '../classes.php';
    $zone = new Zone();

    //$hall = new Hall($event->get_active_event_id());

    $validation = new Validation();

   //echo $_GET['name'].' - '.$_GET['hall'].' - '. $_GET['is_fan'];

    if($zone->insert_zone($validation->text_validation($_GET['name']), $_GET['hall'], $_GET['is_fan']) == 1){
        echo 'Зона: '.$_GET['name'].' створенна!';
    }else{
        echo 'Помилка при створенні зони!';
    }


   /* echo" <div class='row'><div class='col-md-12 grid-margin' style='width:100%; flex: 0 100%;' id='event_info'>";
    if($_POST['EventName'] != ''){*/


                      /*echo $_POST['EventName']."<br/>";
                      echo date('Y-m-d H:i:s', strtotime($_POST['EventDate']))."<br/>";
                      echo $_POST['halls']."<br/>";
                      echo $_POST['Strevent']."<br/>";
                      echo $_POST['Importbars']."<br/>";
                      echo "</div></div><br/><br/>";*/

        /*if($event->add_event($validation->text_validation($_POST['EventName']), date('Y-m-d H:i:s', strtotime($_POST['EventDate'])), $_POST['halls'], $_POST['Strevent'], $_POST['Importbars']) == 1){

            echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Захід створенно</div>";

            echo $event->success_add_event_table($validation->text_validation($_POST['EventName']), date('d.m.Y H:i', strtotime($_POST['EventDate'])), $hall->get_hall_name_by_id($_POST['halls']), $_POST['Importbars']);
            }
    }else{
                       echo "<div id='flash' class='text-light bg-dark pl-1' style='padding: 10px; background-color:#FF4747 !important; font-weight: bold;'>Не введена назва заходу</div>";
                    }
                    echo "</div></div>";*/


?>