<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'partial.php'; ?>
<?php include 'sidebar.php'; ?>
<style>
  .table td img{
    width: 50px;
    height: 100%;
  }
</style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-9 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold" style='margin-bottom: 20px;'><?=reports?> <?=$event->get_active_event_name();?> (ID - <?=$event->get_active_event_id()?>)</h3>
                  <br/><br/>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="font-size:18px;"><?=reportname?></th>
                          <th style="font-size:18px;"><?=reportload?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style='font-weight:400 !important; font-size:16px;'><?=totalreport?></td>
                          <td><div style="margin:20px 0; cursor:pointer; font-size:22px;" id='save_word'><img src="/img/word_ico.jpg" alt="word" style="border-radius:0; margin-left: 20px;"></div></td>
                        </tr>
                         <tr>
                          <td style='font-weight:400 !important; font-size:16px;'><?=barbasestat?></td>
                          <td>

                            <div style="margin:20px 0; cursor:pointer; font-size:22px; float: left;" id='save_base'><img src="/img/ecxel_ico.jpg" alt="base_csv" style="border-radius:0; margin-left: 20px;"></div>
                            <div style="margin:20px 0; cursor:pointer; font-size:22px;" id='save_base_csv2'><a href='savebase_csv.php?r=1' target="_blank">
                              <img src="/img/csv_ico.png" alt="base_csv" style="border-radius:0; margin-left: 20px;"></a></div>
                          </td>
                        </tr>
                        <tr>
                          <td style='font-weight:400 !important; font-size:16px;'><?=enterlog?></td>
                          <td>
                            <div style="margin:20px 0; cursor:pointer; font-size:22px; float: left;" id='save_excel'><img src="/img/ecxel_ico.jpg" alt="" style="border-radius:0; margin-left: 20px;"></div>
                            <div style="margin:20px 0; cursor:pointer; font-size:22px;" id='save_base_csv2'><a href='savebase_csv.php?r=2' target="_blank">
                              <img src="/img/csv_ico.png" alt="base_csv" style="border-radius:0; margin-left: 20px;"></a></div>
                          </td>
                        </tr>
                        <tr>
                          <td style='font-weight:400 !important; font-size:16px;'><?=notonevent?></td>
                          <td>
                            <div style="margin:20px 0; cursor:pointer; font-size:22px; float: left;" id='save_unsold'><img src="/img/ecxel_ico.jpg" alt="" style="border-radius:0; margin-left: 20px;"></div>
                            <div style="margin:20px 0; cursor:pointer; font-size:22px;" id='save_base_csv2'><a href='savebase_csv.php?r=3' target="_blank">
                              <img src="/img/csv_ico.png" alt="base_csv" style="border-radius:0; margin-left: 20px;"></a></div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
              </div>


                <!--<div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>-->

               <script type="text/javascript">
                $( document ).ready(function() {

                    $('#save_base').click( function() {
                      //alert('save_base');
                          $.ajax({
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              url: 'savebase.php?event=' + <?=$event->get_active_event_id()?>,
                              success: function(data) {
                                alert('<?=basesave?>');
                                $('#loader').html("");
                            }
                          });

                      });

                  $('#save_base_csv').click( function() {
                      //alert('save_base_csv');

                         $.ajax({
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              url: 'savebase_csv.php?event=' + <?=$event->get_active_event_id()?>,
                              success: function(data) {
                                alert('<?=basesavecsv?>');
                                $('#loader').html("");
                            }
                          });

                      });

                    $('#save_excel').click( function() {
                          $.ajax({
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              url: 'savelog.php?event=' + <?=$event->get_active_event_id()?>,
                              success: function(data) {
                                alert('<?=logsave?>');
                                $('#loader').html("");
                            }
                          });

                      });

                    $('#save_unsold').click( function() {

                          $.ajax({
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              url: 'saveunsold.php?event='+ <?=$event->get_active_event_id()?>,
                              success: function(data) {
                                alert('<?=nonscanbr?>');
                                $('#loader').html("");
                            }
                          });

                      });

                    $('#save_word').click( function() {
                        //alert('<?=$active_event_id?>');
                          $.ajax({
                              cache: false,
                              global: false,
                              beforeSend: function() {
                                $('#loader').html("<img src='/img/loader3.gif' />");
                              },
                              url: 'stat_to_word.php?event='+<?=$event->get_active_event_id()?>,
                              success: function(data) {
                                alert('<?=statall?>'+data);
                                $('#loader').html("");
                            }
                          });

                      });
                });
                </script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
<?php include 'footer.php'; ?>

