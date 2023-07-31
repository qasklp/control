<?php

	include '..\db_connection.php';
	require_once('PHPExcel.php');
	//$phpexcel = new PHPExcel();
	include '../classes.php';
	//$code =  $_POST['code'];
	$event_id =  $_GET['event'];
	$eventname = '';
	$event = new Event();
	$place = new Eventplace();
	$zone = new Zone();
	$eventname = $event->get_forlog_event_name($event_id);
	$unsold_tbl = $place->get_unsold_tickets($event_id);

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/*echo "<pre>";
var_dump($scan_tbl);
echo "</pre>";*/


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


// Add some data
echo date('H:i:s') , " Add some data" , EOL;
/*$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');*/



//$str = mb_convert_encoding($scan_titles[1]['title'], 'UTF-8','Windows-1251');

// Miscellaneous glyphs, UTF-8
//
//

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Зона')
			->setCellValue('B1', 'Ряд')
			->setCellValue('C1', 'Місце')
			->setCellValue('D1', 'Ціна')
			->setCellValue('E1', 'Штрихкод');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);

			/*->setCellValue($scan_titles[9]['cell'].'1', $scan_titles[9]['title'])
            ->setCellValue($scan_titles[10]['cell'].'1', $scan_titles[10]['title'])
            ->setCellValue($scan_titles[11]['cell'].'1', $scan_titles[11]['title'])
            ->setCellValue($scan_titles[12]['cell'].'1', $scan_titles[12]['title']);*/

$count = 2;
for($i=0; $i<count($unsold_tbl); $i++){
	//echo $zone->is_fan(intval($scan_tbl[$i]['zone_id']))."**<br/>";
	//echo $scan_tbl[$i]['zone_id']."<br/>";
	if($zone->is_fan(intval($unsold_tbl[$i]['zone_id'])) == 1){
		$unsold_tbl[$i]['row'] = "";
		$unsold_tbl[$i]['col'] = "";
	}

	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$count, $unsold_tbl[$i]['name'])
			->setCellValue('B'.$count, $unsold_tbl[$i]['row'])
			->setCellValue('C'.$count, $unsold_tbl[$i]['col'])
			->setCellValue('D'.$count, $unsold_tbl[$i]['price'])
			->setCellValueExplicit('E'.$count, $unsold_tbl[$i]['barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
			$count++;
	//echo $scan_tbl[$i]['id']." - ".$scan_tbl[$i]['barcode']."<br/>";
}




// Rename worksheet
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Unscan tickets');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
//echo "******".__FILE__;
// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);


$path = "C:\OpenServer\domains\control\admin\\reports\\".$eventname."_unscan.php";

echo $eventname;

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;



echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel5 file
echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', $path));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;

	
	/*
	$mysqli = new mysqli($servername, $username, $password, $dbname);
	if ($mysqli->connect_errno) {
		echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$sql = "SELECT s.id as 'id', s.barcode as 'barcode', s.user as 'user', s.time as 'time', s.status as 'status', z.sector as 'zone', e.row as 'row', e.col as 'col', e.price as 'price' FROM scanlog s LEFT JOIN eventplace e ON s.eventplace = e.id LEFT JOIN zone z ON e.zone = z.id WHERE s.event = {$event}";
	//echo $sql;
	if($result = $mysqli->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    //echo "<p>Получено объектов: $rowsCount</p>";
    $text = "Id	Штрихкод	Користувач	Час	Статус	Зона	Ряд	Місце	Ціна\n";
    
	foreach($result as $row2){// Статусы для scanlog 0 - нет в базе; 1 - вход в зал; 2 - повторный вход; 3-выход из зала; 4 - не та зона 
      // echo "<tr style='background-color: #fff;'><td>".$row2['id']."</td><td>".$row2['barcode']."</td><td>".$row2['user']."</td><td>".$row2['time']."</td><td>";
	   switch($row2['status']){
			case 0:
			$text .= $row2['id']."	".$row2['barcode']."	Скан1	".$row2['time']."	Нема в базі	".$row2['zone']."	".$row2['row']."	".$row2['col']."	".$row2['price']."\n";
			break;
			
			case 1:
			$text .= $row2['id']."	".$row2['barcode']."	Скан1	".$row2['time']."	Вхід в зал	".$row2['zone']."	".$row2['row']."	".$row2['col']."	".$row2['price']."\n";
			
			break;
			
			case 2:
			$text .= $row2['id']."	".$row2['barcode']."	Скан1	".$row2['time']."	Повторний вхід	".$row2['zone']."	".$row2['row']."	".$row2['col']."	".$row2['price']."\n";
		
			break;
		  
			case 3:
			$text .= $row2['id']."	".$row2['barcode']."	Скан1	".$row2['time']."	Вихід із зали	".$row2['zone']."	".$row2['row']."	".$row2['col']."	".$row2['price']."\n";
		
			break;
		  
			
			case 4:
			$text .= $row2['id']."	".$row2['barcode']."	Скан1	".$row2['time']."	Не та зона	".$row2['zone']."	".$row2['row']."	".$row2['col']."	".$row2['price']."\n";
			
			break;
			
	   }
	   
	   //echo "</td><td>".$row2['zone']."</td><td>".$row2['row']."</td><td>".$row2['col']."</td><td>".$row2['price']."</td></tr>";
	   //$code2 = $row2["barcode"];
	}
		//echo $code2;
		/*echo "<pre>";
		var_dump($row2);
		echo "</pre>";*/
	//if($code == $code2 && $event == $row2["event"]){
			
		//	$zone = $row2["sector"];
		//$row = $row2["row"];
		///$col = $row2["col"];
		//	$flag = true;
	 // }
	//echo '[{"zone":'.$zone.',"row":'.$row.',"col":'.$col.'}]';
    //}

	/*
    $result->free();
} else{
    echo "Ошибка: " . $mysqli->error;
}
*/
	

/*
$sql2 = "SELECT * FROM event e WHERE e.id = {$event}";
//echo $sql;
	if($result2 = $mysqli->query($sql2)){
		
		 foreach($result2 as $row2){
			//echo $row2;
			$eventname = $row2['forlog'];
		 }
		 //$result->free();
	}else{
		echo "Ошибка: " . $mysqli->error;
	}
$mysqli->close();	

$fp = fopen(htmlspecialchars($eventname).".csv", "w");//поэтому используем режим 'w'

	// записываем данные в открытый файл
	fwrite($fp, $text);

	//не забываем закрыть файл, это ВАЖНО
	fclose($fp);

//if ($flag){
//	echo '[{"zone":"'.$zone.'","row":'.$row.',"col":'.$col.'}]';
//}else{
//	echo "1";
//}

/*	
switch ($_REQUEST['action']) {
    case 'sample1':
        echo 'Пример 1 - передача завершилась успешно';
        break;
    case 'sample2':
        echo 'Пример 2 - передача завершилась успешно. Параметры: code = ' . $code.' - '. $code2;
        break;
    case 'sample3':
        echo "$('.results').html('Пример 3 - Выполнение JavaScript');";
        break;
    case 'sample4':
        header ('Content-Type: application/xml; charset=UTF-8');

        echo <<<XML
<?xml version='1.0' standalone='yes'?>
<items>
<item>Пункт 1</item>
<item>Пункт 2</item>
<item>Пункт 3</item>
<item>Пункт 4</item>
<item>Пункт 5</item>
</items>
XML;
        break;
    case 'sample5':
        $aRes = array('name' => 'Andrew', 'nickname' => 'Aramis');

        require_once('Services_JSON.php');
        $oJson = new Services_JSON();
        echo $oJson->encode($aRes);
        break;
}
*/
?>