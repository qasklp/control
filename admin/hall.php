<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'access.php'; ?>
<?php

   // include '../classes.php';

  $hall = new Hall($event->get_active_event_id());
  //$user = new User();
   //echo $user->login('admin', 'A7788a');
   //echo $user->get_users_table();
   //echo $user->get_modal_for_mob();
?>
<style>
  .color{
    background-color: #299cf4;
    width: 20px;
    height: 20px;
    float: left;
    border-radius: 5px;

  }

  .color2{
    background-color: #888;
    width: 20px;
    height: 20px;
    float: left;
    border-radius: 5px;
  }

  .color3{
    background-color: #e01a52;
    width: 20px;
    height: 20px;
    float: left;
    border-radius: 5px;
  }

  .text{
    margin-left: 5px;
    color: black;
  }

</style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">

               <div style="margin:5px 20px;">
                  <div id='tooltip' display='none' style='position: absolute; display: none; z-index: 1000000; background-color:#ffee5a; border-radius:10px 10px; 0 0'></div>

                  <table style='border-color: white !important;'>
                    <tr>
                      <td class='text' width='70%' style = 'border:none;'><h3 style='float:left; margin: 10px 40px;'><?=$event->get_active_event_name()?></h3></td>
                      <td class='text' width='30%' style = 'border:none;'>
                        <div class="hall-statistics-list-item event-online-monitor taken">
                            <span class="color" ></span>
                            <span class="text"><?=inhall?></span>
                        </div>

                       <div class="hall-statistics-list-item event-online-monitor free" style='margin-top:10px;'>
                          <span class="color2"></span>
                          <span class="text"><?=notinhall?></span>
                        </div>

                        <?php if($event->get_addon_event($event->get_active_event_id()) == 1): ?>
                       <div class="hall-statistics-list-item event-online-monitor taken" style='margin-top:10px;'>
                          <span class="color3" ></span>
                          <span class="text"><?=invate?></span>
                       </div>
                      <?php endif; ?>

                      </td>
                    </tr>
                  </table>
              <div style="min-height: 600px;">
                <div id='hallmap'>

                </div>
              </div>

<script type="text/javascript">
  $( document ).ready(function() {
      $.ajax({
            url: 'hallmap.php?hall='+<?=$event->get_active_event_id()?>,
            cache: false,
            global: false,
            beforeSend: function() {
              $('#loader').html("<img src='/img/loader3.gif' />");
            },
            success: function(data) {
                $('#hallmap').html(data);
                $('#loader').hide();
            }
       });
  });


  function showTooltip(evt, text) {
      let tooltip = document.getElementById("tooltip");
      //alert($('#tooltip').html());
      $.ajax({
            url: 'placeresponse.php?place='+text,
            success: function(data) {
                tooltip.innerHTML = data;
                tooltip.style.display = "block";
                tooltip.style.left = evt.pageX - 240 + "px";
                tooltip.style.top = evt.pageY - 100 + "px";
          }
       });

  }

  function hideTooltip() {
    var tooltip = document.getElementById("tooltip");
    tooltip.style.display = "none";
  }
</script>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

