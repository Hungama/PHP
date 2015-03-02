<?php

error_reporting(0);
require_once("db.php");
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = new PHPExcel();
include('excel-header.php');
//DYNAMIC CONTENT//


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=my_excel_report.xls");
header("Pragma: no-cache");
header("Expires: 0");
flush();
//and  IsmItr='0'
$sql_query=mysql_query("select * from Hungama_Tatasky.tbl_dailymisMitrExcelReport  where  date='2014-11-25' ",$con);
$counter = 4;
while($mydata=mysql_fetch_array($sql_query))
{
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter, $mydata['Date']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter, $mydata['Circle']);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter, $mydata['CapsuleName']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter, $mydata['TotalMissedCallsReceived']);
if($mydata['IsMitr']=='0')
{

$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter, $mydata['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$counter, $mydata['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$counter, $mydata['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$counter, $mydata['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$counter, $mydata['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$counter, $mydata['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$counter, $mydata['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$counter, $mydata['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$counter, $mydata['Tamil']);
}
else if($mydata['IsMitr']!='0')
{
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$counter, $mydata['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$counter, $mydata['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$counter, $mydata['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$counter, $mydata['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$counter, $mydata['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$counter, $mydata['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$counter, $mydata['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$counter, $mydata['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$counter, $mydata['Tamil']);


}

$counter++;
}  


if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set('UTC');
	} else {
			putenv("TZ=UTC");
	}
	$exportTime = date("Y-m-d_His", time()); 
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
	//$file = 'ExportExcel'.$exportTime. '.xlsx';
	
	$objWriter->save('php://output');
	//$objWriter->save('results.xlsx'); 
	//$objWriter -> save(str_replace('.php', '.xlsx', 'C:\wamp/www/excel-test/' . $file)); 
	
	
	

?>