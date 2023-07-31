<?php

	include '../classes.php';
	$log = new Scanlog();
    $stat = new Stat();
	$event = new Event();
	//$code =  $_POST['code'];
	$event_id =  $_GET['event'];
	$event_name = $event->get_forlog_event_name($event_id);
	$hall = new Hall($event_id);
	$stat = new Stat();
	$stat->get_total($event_id);
	require_once '../vendor/autoload.php';
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	use PhpOffice\PhpWord\Shared\Converter;

$section = $phpWord->addSection();


// Adding Text element with font customized using explicitly created font style object...
$fontStyle = new \PhpOffice\PhpWord\Style\Font();
$fontStyle->setBold(true);
$fontStyle->setName('Tahoma');
$fontStyle->setSize(14);
$myTextElement = $section->addText($event_name." (ID - ".$event_id.")");
$myTextElement->setFontStyle($fontStyle);

$fontStyle2 = new \PhpOffice\PhpWord\Style\Font();
$fontStyle2->setBold(false);
$fontStyle2->setName('Tahoma');
$fontStyle2->setSize(12);


$myTextElement = $section->addText("IP адрес: ". $_SERVER['REMOTE_ADDR']);
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText("Дата заходу: ". $event->get_event_date($event_id));
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText("Місце проведення: ". $hall->name);
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText("Адреса: ". $hall->addr);
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText("Початок сканування: ".$event->get_min_time($event_id));
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText("Закінчення сканування: ".$event->get_max_time($event_id));
$myTextElement->setFontStyle($fontStyle2);
$myTextElement = $section->addText($stat->get_event_duration($event_id));
$myTextElement->setFontStyle($fontStyle2);

$tableStyle = array(
    'borderColor' => '006699',
    'borderSize'  => 6,
    'cellMargin'  => 50
);

//$fontStyle2 = new \PhpOffice\PhpWord\Style\Font();

$myTextElement = $section->addTitle('Загальна статистика', 2);


$fancyTableStyleName = 'Fancy Table';
$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
$fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
$fancyTableCellStyle = array('valign' => 'center');
$fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
$fancyTableFontStyle = array('bold' => true);
$phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
$table = $section->addTable($fancyTableStyleName);

$table = $section->addTable();

$table->addRow();
$table->addCell(3750)->addText("Загальна кількість штрихкодів");
$table->addCell(3750)->addText("Увійшли на захід");
$table->addRow();
$table->addCell(3750)->addText($stat->total['total']);
$table->addCell(3750)->addText($stat->total['inhall']);

/*for ($r = 1; $r <= $rows; $r++) {
    $table->addRow();
    for ($c = 1; $c <= $cols; $c++) {
        $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
    }
}*/


$section->addText('Кількість у зонах', $header);
$table = $section->addTable();

$table->addRow();
	for($i=0; $i < count($stat->get_inzone_count($event_id)); $i++){
		$table->addCell(3750)->addText($stat->inzone[$i]['zonename']);
	}

$table->addRow();
	for($i=0; $i < count($stat->get_inzone_count($event_id)); $i++){
			$table->addCell(3750)->addText($stat->inzone[$i]['inzone']);
	}
/*
$section->addTitle('2D charts', 1);
$section = $phpWord->addSection(array('colsNum' => 2, 'breakType' => 'continuous'));

$chartTypes = array('pie', 'doughnut', 'bar', 'column', 'line', 'area', 'scatter', 'radar', 'stacked_bar', 'percent_stacked_bar', 'stacked_column', 'percent_stacked_column');
$twoSeries = array('bar', 'column', 'line', 'area', 'scatter', 'radar', 'stacked_bar', 'percent_stacked_bar', 'stacked_column', 'percent_stacked_column');
$threeSeries = array('bar', 'line');
$categories = array('Нема в базі', 'Вхід у зал', 'Повторний вхід', 'Вихід із залу', 'Не той сектор');
$series1 = array($log->get_log_status_count(0, $event_id), $log->get_log_status_count(1, $event_id), $log->get_log_status_count(2, $event_id), $log->get_log_status_count(3, $event_id), $log->get_log_status_count(5, $event_id));
//$series2 = array(3, 1, 7, 2, 6);
//$series3 = array(8, 3, 2, 5, 4);
$showGridLines = false;
$showAxisLabels = false;
$showLegend = true;
$legendPosition = 't';
// r = right, l = left, t = top, b = bottom, tr = top right

foreach ($chartTypes as $chartType) {
    $section->addTitle(ucfirst($chartType), 2);
    $chart = $section->addChart($chartType, $categories, $series1);
    $chart->getStyle()->setWidth(Converter::inchToEmu(2.5))->setHeight(Converter::inchToEmu(2));
    $chart->getStyle()->setShowGridX($showGridLines);
    $chart->getStyle()->setShowGridY($showGridLines);
    $chart->getStyle()->setShowAxisLabels($showAxisLabels);
    $chart->getStyle()->setShowLegend($showLegend);
    $chart->getStyle()->setLegendPosition($legendPosition);
    /*if (in_array($chartType, $twoSeries)) {
        $chart->addSeries($categories, $series2);
    }
    if (in_array($chartType, $threeSeries)) {
        $chart->addSeries($categories, $series3);
    }*/
    /*
    $section->addTextBreak();
}*/
/*
$section = $phpWord->addSection(array('breakType' => 'continuous'));
$section->addTitle('3D charts', 1);
$section = $phpWord->addSection(array('colsNum' => 2, 'breakType' => 'continuous'));

$chartTypes = array('pie', 'bar', 'column', 'line', 'area');
$multiSeries = array('bar', 'column', 'line', 'area');
$style = array(
    'width'          => Converter::cmToEmu(5),
    'height'         => Converter::cmToEmu(4),
    '3d'             => true,
    'showAxisLabels' => $showAxisLabels,
    'showGridX'      => $showGridLines,
    'showGridY'      => $showGridLines,
);
foreach ($chartTypes as $chartType) {
    $section->addTitle(ucfirst($chartType), 2);
    $chart = $section->addChart($chartType, $categories, $series1, $style);
    /*if (in_array($chartType, $multiSeries)) {
        $chart->addSeries($categories, $series2);
        $chart->addSeries($categories, $series3);
    }*/
    /*
    $section->addTextBreak();
}*/

/*$table->addCell(3750)->addText("Загальна кількість штрихкодів");
$table->addCell(3750)->addText("Зайшли на захід");
$table->addRow();
$table->addCell(3750)->addText($stat->total['total']);
$table->addCell(3750)->addText($stat->total['inhall']);*/

$path = 'C:\OpenServer\domains\control\admin\reports\\'.$event_name.'_statistics.docx';

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($path);
//echo "WORD SUCCESS!!!";

?>