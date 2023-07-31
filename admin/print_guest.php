<?php

    include '../classes.php';
    $event = new Event();
    $role = new Role();
    $id = $_GET['id'];
    $guest = new Guests();
    $guest->get_settings($id);
    require 'barcode/vendor/autoload.php';
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
 ?>
 <style>
    .container div{
        font-size: 22px;
        font-weight: 600;
        /* font-family: sans-serif; */
        font-family: "Nunito", sans-serif;
    }

    .name{
        font-size: 28px !important;
    }

    @media print {
        @page {
            size: auto;
            margin: 10px;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        html,
        body {
            width: 210mm;
            height: 290mm;
            margin: 10px;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .btn{
          display: none !important;
        }

    }
 </style>
<div style="width: 100%;">
    <div class='container' style='width:380px; height:300px; background-origin: 5px; border:1px solid black; padding:10px; text-align: center;'>
        <div>
          <?=$event->get_active_event_name()?>
        </div>
        <div style='margin-top:20px;' class='name'>
            <?=$guest->name?>
        </div>
        <div style='margin-top:20px;'>
            <?=$guest->organization?>
        </div>
        <div style='margin-top:20px;'>
            <img style="border-radius: 0; width: 70%; height: 25%;" src="data:image/png;base64,<?=base64_encode($generator->getBarcode($guest->barcode,'C128'))?>"/>
        </div>
        <div>
            <?=$guest->barcode?>
        </div>
    </div>
</div>
<br/>
<button type="button" class="btn btn-info btn-icon-text" onclick="printPage()" style="width:400px; height:50px; cursor: pointer;">Друк<i class="ti-printer btn-icon-append"></i></button>

<script>
    function printPage() {
        window.print();
        return false;
    }
</script>