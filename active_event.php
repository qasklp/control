<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'content.php'; ?>

<style>
    .label{
        color:  white;
    }
</style>

<script>

    $('#tooltip').click( function() {
        alert('*******');
    });

function showTooltip(evt, text) {
  let tooltip = document.getElementById("tooltip");
  tooltip.innerHTML = text;
  tooltip.style.display = "block";
  tooltip.style.left = evt.pageX + 10 + "px";
  tooltip.style.top = evt.pageY + 10 + "px";
}

function hideTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "none";
}
</script>

<?php
    $scan = new Scanlog();
    $user = new User('ctrl1','c11');
    $user -> login('ctrl1','c11');
    $place = new Eventplace();
    $event = new Event();
    $groupzone = new Groupzone();
    $stat = new Stat();
    $sstat = new Scanstatus();
    $zone = new Zone();
    $saler = new Saler();
    $hall = new Hall(46);



    echo "<div style='position: inherit; margin-bottom:100px;'>".$hall->name." - ".$hall->addr."<div id='tooltip' display='none' style='position: absolute; display: none; z-index: 1000000;'></div><br/>";
    echo $hall->get_svg_hall_map(46);
    echo "</div>";


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