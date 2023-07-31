

<style>
    .label{
        color:  white;
    }
</style>

<script>

function showTooltip(evt, text) {
      let tooltip = document.getElementById("tooltip");
      //alert($('#tooltip').html());
      $.ajax({
            url: 'placeresponse.php?place='+text,
            success: function(data) {
                tooltip.innerHTML = data;
                tooltip.style.display = "block";
                tooltip.style.left = evt.pageX + 10 + "px";
                tooltip.style.top = evt.pageY + 10 + "px";
          }
     });

}

function hideTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "none";
}
</script>

<?php
    include '../classes.php';
    require_once '../vendor/autoload.php';
    $scan = new Scanlog();
    $user = new User('ctrl1','c11');
    $user->login('ctrl1','c11');
    $place = new Eventplace();
    $event = new Event();
    $groupzone = new Groupzone();
    $stat = new Stat();
    $sstat = new Scanstatus();
    $zone = new Zone();
    $saler = new Saler();
    $role = new Role();
    $hall = new Hall(46);
    $guest = new Guests();


   //$price = $stat->get_by_price_inzone($event->get_active_event_id());
   //

   echo Settings::GetLang()."*******";

   /*echo "<pre>";
   var_dump($stat->get_by_price_inzone($event->get_active_event_id()));
   echo "</pre>";
   echo $stat->get_by_price_notinzone(699, $event->get_active_event_id());*/


    /*if($guest->get_barcode_access('3201000251271')){
        echo 'TRUE';
    }else{
        echo 'FALSE';
    }*/

    //echo $guest->get_status_name_by_id(1);
    //echo $guest->insert_log_row(22, 1, 11, 0);
    //echo $guest->id.' - '.$guest->organization.' - '.$guest->plus.' - '.$guest->comment.' - '.$guest->is_reg.' - '.$guest->all_access.' - '.$guest->barcode;


    //echo $zone->insert_zone('FAN2', 24, true);

    //echo $_SERVER['PHP_SELF'].'<br/>';

    /*if($role->get_role_to_page(1,2)){
        echo "Можно пускать!!";
    }else{
        echo "Нельзя пускать!!";
    }*/

    //echo $stat->get_event_duration(120);

    //$todo = new Todo();
    //echo $todo->todo_del(3);
    //echo $todo->todo_list($event->get_active_event_id());

/*
  $scan_tbl = $scan->get_barcodesbase_for_excel(99);
  echo '<pre>';
  var_dump($scan_tbl);
  echo '</pre>';


  // echo $stat -> get_inzone_count_by_user(19, -1);
   /* use Intervention\Image\ImageManagerStatic as Image;
    Image::configure(['driver' => 'gd']);
    echo $image = Image::make('http://192.168.0.4/img/lenta.jpg')->resize(300, 200);

    echo "<img src='".$image."' />";

    //echo $user->add_user('Вася Пупкин','pupkin','12345','visitor')."*****";

   /*echo '<pre>';
   var_dump($stat->get_count_by_min(50));
   echo '</pre>';*/

    //echo $event->delete_event(82);

    //echo $zone->get_lenta(62);

    /*$mass = $place->get_place_status_array(4);

    $m = explode("#", $mass[10][3][26]);
    echo $m[0]." - ".$m[1]."<br/>";

    echo "<pre>";
    var_dump($mass);
    echo "</pre>";

/*
    if($place->get_place_status(52, 76, 22, 6)){
        echo "U ZALY";
    }else{
        echo "NE U ZALY";
    }
    //echo $event -> get_zones_ids_names(5);
    /*for($i=1; $i<5; $i++){
        $place->get_place_status(5, 40, 1, $i);
        echo $place->id." ".$place->row." ".$place->col." ".$place->status." ".$place->barcode."<br/>";
    }*/

    //echo $zone->zone_place_count(20, 4, 1);

    /*for($i=1; $i<5; $i++){
        echo $place->get_place_status(5, 40, 1, $i)."<br/>";
    }*/

    //echo $zone->get_zones_ids(5);

   /* echo "<div style='position: inherit; margin-bottom:100px;'>".$hall->name." - ".$hall->addr."<div id='tooltip' display='none' style='position: absolute; display: none; z-index: 1000000; background-color:blue;'></div><br/>";
    echo $hall->get_svg_hall_map(46);
    echo "</div>";*/


    /*echo "<pre>";
    //echo $saler->get_saler_name(10);
    var_dump($place->get_unsold_tickets(45));
    //echo $sstat->get_status_name(1);
    echo "</pre>";

   /*echo $zone->is_fan(62)."<br/>";
   echo $zone->zone_hall_id(65)."<br/>";
   echo $zone->zone_name(62)."<br/>";
   //echo $sstat->get_status_select();

    //echo $user->set_user_to_group(46, 21, 2, false);

    //echo $titles[][];
   /* echo '<pre>';
    var_dump($titles);
    echo '</pre>';

    /*$place = new Eventplace();
    $place->get_place(45, '351501712024');
    echo $place->get_is_inv(45, '351501712024');*/

include 'footer.php'; ?>