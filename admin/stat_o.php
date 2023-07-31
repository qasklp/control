<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<?php //include 'access.php'; ?>
<?php
  $log = new Scanlog();
  $stat = new Stat();
  $user = new User();
  $hall = new Hall($event->get_active_event_id());
  $stat->get_total($event->get_active_event_id());

?>
<script src="js/canvasjs.min.js"></script>
<style>
  .center{
    text-align: center;
    margin: 10px auto;
  }

  .right{
    text-align: center;
    margin: 10px auto;
  }
</style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold" style='margin-bottom: 20px;'> <?=$event->get_active_event_name();?> (ID - <?=$event->get_active_event_id()?>)<button style='margin:7px 0 0 20px; ' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="ti-file btn-icon-prepend"></i> Детальна інформація</button></h3>

                <!-- Modal -->
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="exampleModalCenterTitle"><?= $event->get_active_event_name() ?></h3>
                        </div>
                        <div class="modal-body">
                          <h4 class="modal-title" id="exampleModalCenterTitle"><span style="font-weight:bold;">ID події</span></h4>
                          <h4 class="modal-title" id="barcode_event"></h4>
                          <h4><span style="font-weight:bold;">Дата заходу:</span> <?= $event->get_event_date($event->get_active_event_id())?></h4>
                          <h4><span style="font-weight:bold;">Місце проведення:</span> <?= $hall->name?></h4>
                          <h4><span style="font-weight:bold;">Адреса:</span> <?= $hall->addr?></h4>
                          <h4 class="modal-title" id="exampleModalCenterTitle">IP - <?=$_SERVER['SERVER_ADDR']?></h4>
                          <h4><?=$stat->get_event_duration($event->get_active_event_id())?></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!--<div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                  <br/><br/>

                  <h3>Загальна статистика</h3><br/>
                  <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex flex-wrap mb-8">
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Всього штрихкодів у БД</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?=$stat->total['total']?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Увійшли на захід</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?=$stat->total['inhall']?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Не на заході</p>
                              <h3 class="text-primary fs-30 font-weight-medium center"><?=$stat->total['total']-$stat->total['inhall']?></h3>
                            </div>
                            <div class="center" >
                              <p class="card-title" style='text-transform:none;'>Заповненість заходу</p>
                              <?php if($stat->total['total'] != 0):?>
                                <h3 class="text-primary fs-30 font-weight-medium center"><?=round(($stat->total['inhall']*100)/$stat->total['total'],0)?>%</h3>
                              <?php else:?>
                                  <h3 class="text-primary fs-30 font-weight-medium center">0</h3>

                              <?php endif;?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h3>Кількість у зонах</h3>
                  <div class="row">
                     <div class="col-md-12 stretch-card grid-margin">
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="font-size:22px;">Зона</th>
                                <th style="font-size:22px; text-align: center;">Всього місць у зоні</th>
                                <th style="font-size:22px; text-align: center;">Не увійшли у зону</th>
                                <th style="font-size:22px; text-align: center;">Заповненість зони</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                for($i=0; $i < count($stat->get_inzone_count($event->get_active_event_id())); $i++){
                                  echo "<tr><td style='font-size:24px;' >".$stat->inzone[$i]['zonename']."</td>
                                  <td style='font-size:22px;' class='center'><span class='font-weight-bold mr-4 center'>".$stat->get_zone_count($event->get_active_event_id(), $stat->inzone[$i]['zone_id'])."</span></td>
                                  <td style='font-size:22px;' class='center'><span class='font-weight-bold mr-4 center'>".($stat->get_zone_count($event->get_active_event_id(), $stat->inzone[$i]['zone_id'])-$stat->inzone[$i]['inzone'])."</span></td>
                                  <td style='font-size:22px;' class='right'><span class='font-weight-bold mr-4'>".$stat->inzone[$i]['inzone']."</span>(".round(($stat->inzone[$i]['inzone']*100)/$stat->get_zone_count($event->get_active_event_id(), $stat->inzone[$i]['zone_id']), 0)." %)</td>
                                  </tr>";
                                }
                              ?>
                            </tbody>
                          </table>
                          </div>
                        </div>
                  </div>

                  <h3>Кількість по цені</h3>

                  <div class="row">
                     <div class="col-md-12 stretch-card grid-margin">
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="font-size:22px;">Зона</th>
                                <th style="font-size:22px; text-align: center;">Ціна</th>
                                <th style="font-size:22px; text-align: center;">Увійшли</th>
                                <th style="font-size:22px; text-align: center;">Не увійшли</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                for($i=0; $i < count($stat->get_by_price_inzone($event->get_active_event_id())); $i++){
                                  echo "<tr>
                                  <td style='font-size:24px;' >Фанзона</td>

                                  <td style='font-size:22px;' class='center'><span class='font-weight-bold mr-4 center'>";

                                  if($stat->byprice[$i]['price'] != 0){
                                    echo $stat->byprice[$i]['price'];
                                  }else{
                                    echo 'Запрошення';
                                  }

                                  echo"</span></td>

                                  <td style='font-size:22px;' class='center'><span class='font-weight-bold mr-4 center'>".$stat->byprice[$i]['count']."</span></td>
                                  <td style='font-size:22px;' class='center'><span class='font-weight-bold mr-4 center'>".$stat->get_by_price_notinzone($stat->byprice[$i]['price'], $event->get_active_event_id())."</span></td>

                                  </tr>";
                                }
                              ?>
                            </tbody>
                          </table>
                          </div>
                        </div>
                  </div>


                  <!--<div class="table-responsive">
                    <table class="table">
                      <thead>
                      <tr>
                          <th width='25%' style="font-size: 18px;">Кількість штрихкодів у БД</th>
                          <th width='25%' style="font-size: 18px;">Увійшли на захід</th>

                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td style='color:black; font-size: 16px;'><?=$stat->total['total']?></td>
                          <td style='color:black; font-size: 16px;'><?=$stat->total['inhall']?></td>

                        </tr>
                      </tbody>
                    </table>
                </div>
                <br />
                <h3>Кількість у зонах</h3>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr>
                      <?php
                        //echo count($stat->get_inzone_count($active_event_id));

                        for($i=0; $i < count($stat->get_inzone_count($active_event_id)); $i++){
                          echo "<th>".$stat->inzone[$i]['zonename']."</th>";
                        }
                      ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <?php
                        for($i=0; $i < count($stat->get_inzone_count($active_event_id)); $i++){
                          echo "<td style='color:black;'>".$stat->inzone[$i]['inzone']."</td>";
                        }
                      ?>
                    </tr>
                    </tbody>
                  </table>-->

<br>

<div id="chartContainer" style="height: 370px; width: 100%; margin:30px 0;"></div>
<div id="chartContainer3" style="height: 370px; width: 100%; margin:30px 0;"></div>

<div id="chartContainer2" style="height: 370px; width: 100%; margin:30px 0;"></div>
<div id="chartContainer4" style="height: 370px; width: 100%; margin:30px 0;"></div>
<!--<div id="chartContainer5" style="height: 370px; width: 100;"></div>-->
<script type="text/javascript">


   window.onload = function () {
      $.ajax({
            url:'barcode/barcode.php',
            method:"POST",
            data:{code:'<?=$event->get_active_event_id()?>',type:'C128',label:''},
            error:err=>{
              console.log(err)
            },
            success:function(resp){
              $('#barcode_event').html(resp)
             // $('#bcode-card .card-footer').show('slideUp')
            }
          });

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2",

  title:{
    text: "Статистика входу",
    horizontalAlign: "center"
  },
  data: [{
    type: "doughnut",
    startAngle: 60,
    //innerRadius: 60,
    indexLabelFontSize: 17,
    indexLabel: "{label} - {y} (#percent%)",
    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
    dataPoints: [
      { y: <?=$stat->total['inhall']?>, label: "У залі", color:"#4f81bc" },
      { y: <?=$stat->total['total'] - $stat->total['inhall']?>, label: "Не увійшли", color:"#c0504e" },
    ]
  }]
});
chart.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Статистика логу"
  },
  data: [{
    type: "column",
    indexLabel: "{y}",
    showInLegend: false,
    dataPoints: [//нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
      {y: <?=$log->get_log_status_count(0, $event->get_active_event_id());?>, label: "Немає в базі"},
      {y: <?=$log->get_log_status_count(1, $event->get_active_event_id());?>, label: "Вхід до залу"},
      {y: <?=$log->get_log_status_count(2, $event->get_active_event_id());?>, label: "Повторний вхід"},
      {y: <?=$log->get_log_status_count(3, $event->get_active_event_id());?>, label: "Вихід із залу"},
      {y: <?=$log->get_log_status_count(4, $event->get_active_event_id());?>, label: "Не той сектор"}
    ]
  }]
});
chart2.render();

/*var chart3 = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  title: {
    text: "Статистика входу по годинах"
  },
  data: [{
    type: "column",
    indexLabel: "{y}",
    showInLegend: false,
    dataPoints: [//нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
      <?php

        foreach($stat->get_count_by_hour($event->get_active_event_id()) as $k=>$v){
          $l = $k+1;
          $lab = $k.':00 - '.$l.':00';
      ?>
      {y: <?=$v?>, label: '<?=$lab?>'},
      <?php } ?>
    ]
  }]
});
chart3.render();*/

var chart3 = new CanvasJS.Chart("chartContainer3", {
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Статистика входу (інтервал 5 хв.)"
  },
  data: [{
    type: "column",
    indexLabel: "{y}",
    indexLabelFontSize: 12,
    showInLegend: false,
    dataPoints: [//нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона
      <?php
       // foreach($scan->get_dates_scan($event->get_active_event_id()) as $date){
           foreach($stat->get_count_by_min($event->get_active_event_id()) as $val){
            foreach($val as $k=>$v){
              if($v != 0){
      ?>
      {y: <?=$v?>, label: '<?=$k?>'},
      <?php }}}?>
    ]
  }]
});
chart3.render();


var chart4 = new CanvasJS.Chart("chartContainer4", {
  animationEnabled: true,
  theme: "light2",
  title:{
    text:"Кількість по сканувальникам"
  },
  axisX:{
    interval: 1
  },
  axisY2:{
    interlacedColor: "rgba(1,77,101,.2)",
    gridColor: "rgba(1,77,101,.1)",
    title: "Number of Companies"
  },
  data: [{
    type: "bar",
    name: "controlers",
    indexLabel: "{y}",
    dataPoints: [
      <?php
        foreach($stat->get_count_by_users($event->get_active_event_id()) as $k=>$v){
      ?>
      {y: <?=$v?>, label: '<?=$user->get_login_by_id($k)?>'},
      <?php } ?>
    ]
  }]
});
chart4.render();

}

var chart = new CanvasJS.Chart("chartContainer5", {
  title: {
    text: "Temperature of Each Boiler"
  },
  axisY: {
    title: "Відскановано квитків",
    //includeZero: true,
    //suffix: " °C"
  },
  data: [{
    type: "column",
    //yValueFormatString: "#,### °C",
    indexLabel: "{y}",
    dataPoints: [
      {y: <?=$log->get_log_status_count(1, $event->get_active_event_id());?>, label: "Вхід до залу"},

    ]
  }]
});

function updateChart() {
  //alert('updateChart');
  var boilerColor, deltaY, yVal;
  var dps = chart.options.data[0].dataPoints;
  for (var i = 0; i < dps.length; i++) {
    $.ajax({
        url: 'telemetria.php',
          success: function(data){
            //alert(data);
            //dps[i] = {label: 'контр'+<?=rand(5, 15);?>, y: data};

                      /*$(xmldata).find('item').each(function(){
                          $('<li></li>').html( $(this).text() ).appendTo('.results');
                      });*/
            }
      });
  }
  //for (var i = 0; i < dps.length; i++) {
    //alert(dps[i].y);
    //deltaY = Math.round(2 + Math.random() *(-2-2));
    //yVal = deltaY + dps[i].y > 0 ? dps[i].y + deltaY : 0;
    //boilerColor = yVal > 200 ? "#FF2500" : yVal >= 170 ? "#FF6000" : yVal < 170 ? "#6B8E23 " : null;

     // dps[0] = {y: <?=$log->get_log_status_count(1, $event->get_active_event_id());?>, label: "Вхід до залу"},
    //alert(dps[0].y);
    //dps[i] = {label: dps[i].label, y: <?= $v?>};
  //}
  chart.options.data[0].dataPoints = dps;
  chart.render();
};
updateChart();

setInterval(function() {updateChart()}, 500);


</script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

