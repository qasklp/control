<?php

	include '../classes.php';

    $event = new Event();
    $stat = new Stat();
    $hall = new Hall($event->get_active_event_id());
    $zone = new Zone();


    echo $hall->get_zones_table_by_id($_GET['hall']);

    /*$total = $stat->get_total($_GET['event']);

    echo "<span style='font-weight:bold;'>Місце проведення: </span>".$hall->name." (".$hall->addr.")<br/>";

    echo "<span style='font-weight:bold;'>Дата заходу: </span>".$event->get_event_date($_GET['event'])."<br/>";

    echo "<span style='font-weight:bold;'>Загальна кількість штрихкодів у базі: </span>".$total['total']."<br/>";

    $zones = $zone->get_zones_by_event($_GET['event']);

    for ($i=0;$i<count($zones);$i++){
         echo "<span style='font-weight:bold; margin-left:20px;'>Кількість у зоні '".$zone->zone_name($zones[$i]['zid'])."': </span>".$stat->get_zone_count($_GET['event'], $zones[$i]['zid'])."<br/>";
    }


    /*if($event->get_addon_event($_GET['event']) == 0){echo "<span style='font-weight:bold; '>Структура заходу:</span><span> Звичайна</span><br/>";}

    if($event->get_addon_event($_GET['event']) == 1){echo "<span style='font-weight:bold;'>Структура заходу:</span><span> Розширена</span><br/>";}*/



?>