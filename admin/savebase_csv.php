<?php

include '../classes.php';
$event = new Event();
$zone = new Zone();
$scan = new Scanlog();
$place = new Eventplace();

$event_id = $event->get_active_event_id();
$scan_titles = $scan->get_scanlog_titles_for_excel();

if($_GET['r'] == 1){
  $scan_tbl = $scan->get_barcodesbase_for_excel($event_id);
  $eventname = $event->get_forlog_event_name($event_id)."_base.csv";
}

if($_GET['r'] == 2){
  $scan_tbl = $scan->get_log_for_excel($event_id);
  $eventname = $event->get_forlog_event_name($event_id)."_log.csv";
}

if($_GET['r'] == 3){
  $scan_tbl = $place->get_unsold_tickets($event_id);
  $eventname = $event->get_forlog_event_name($event_id)."_unscan.csv";
}

header("Content-type: text/csv");
header('charset=utf-8');
header("Content-Disposition: attachment; filename=".$eventname);
header("Pragma: no-cache");
header("Expires: 0");


/*echo '<pre>';
var_dump($scan_titles);
echo '</pre>';*/


/*$array = array(
  array(1, 'Продукт 1', 2000, 'Ссылка на продукт 1', 1),
  array(2, 'Продукт 2', 3000, 'Ссылка на продукт 2', 0),
  array(3, 'Продукт 3', 4000, 'Ссылка на продукт 3', 1),
  array(4, 'Продукт 4', 5000, 'Ссылка на продукт 4', 1),
  array(5, 'Продукт 5', 10000, 'Ссылка на продукт 5', 0)
);*/

$out = fopen('php://output', 'w');

//mb_convert_encoding(fputcsv($out, array('id','Название','Цена','Ссылка','Статус'), ";"), "UTF-8", "WINDOWS-1251");


if($_GET['r'] == 1){

  fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $scan_titles[5]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[6]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[7]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[8]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[1]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[4]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[3]['title'])), ";");

  foreach($scan_tbl as $item)
  {
    //echo $item["zone"]." ".'<br/>';

    fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $item["zone"]), iconv('UTF-8', 'WINDOWS-1251', $item['row']), iconv('UTF-8', 'WINDOWS-1251', $item['col']), iconv('UTF-8', 'WINDOWS-1251', $item['price']), iconv('UTF-8', 'WINDOWS-1251', $item['barcode']), iconv('UTF-8', 'WINDOWS-1251', $item['status']), iconv('UTF-8', 'WINDOWS-1251', $item['time'])), ";");
    //mb_convert_encoding(fputcsv($out, array($item[0],$item[1],$item[2],$item[3],$item[4]), ";"), "UTF-8", "WINDOWS-1251");
  }
}

if($_GET['r'] == 2){

  fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $scan_titles[0]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[1]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[2]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[3]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[4]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[5]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[6]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[7]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[8]['title'])), ";");

  foreach($scan_tbl as $item)
  {
    //echo $item["zone"]." ".'<br/>';

    fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $item["id"]), iconv('UTF-8', 'WINDOWS-1251', $item['barcode']), iconv('UTF-8', 'WINDOWS-1251', $item['ctrl']), iconv('UTF-8', 'WINDOWS-1251', $item['time']), iconv('UTF-8', 'WINDOWS-1251', $item['status']), iconv('UTF-8', 'WINDOWS-1251', $item['zone']), iconv('UTF-8', 'WINDOWS-1251', $item['row']), iconv('UTF-8', 'WINDOWS-1251', $item['col']), iconv('UTF-8', 'WINDOWS-1251', $item['price'])), ";");
    //mb_convert_encoding(fputcsv($out, array($item[0],$item[1],$item[2],$item[3],$item[4]), ";"), "UTF-8", "WINDOWS-1251");
  }
}

if($_GET['r'] == 3){

  fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $scan_titles[5]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[6]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[7]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[8]['title']), iconv('UTF-8', 'WINDOWS-1251', $scan_titles[1]['title'])), ";");

  foreach($scan_tbl as $item)
  {
    //echo $item["zone"]." ".'<br/>';

    fputcsv($out, array(iconv('UTF-8', 'WINDOWS-1251', $item["name"]), iconv('UTF-8', 'WINDOWS-1251', $item['row']), iconv('UTF-8', 'WINDOWS-1251', $item['col']), iconv('UTF-8', 'WINDOWS-1251', $item['price']), iconv('UTF-8', 'WINDOWS-1251', $item['barcode'])), ";");
    //mb_convert_encoding(fputcsv($out, array($item[0],$item[1],$item[2],$item[3],$item[4]), ";"), "UTF-8", "WINDOWS-1251");
  }
}


fclose($out);