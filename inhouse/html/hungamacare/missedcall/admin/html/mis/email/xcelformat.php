<?php

error_reporting(0);
require_once("db.php");
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = new PHPExcel();
include('excel-header.php');
//DYNAMIC CONTENT//


/* header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=my_excel_report.xls");
header("Pragma: no-cache");
header("Expires: 0");
flush(); */
//and  IsmItr='0'
/* $sql_query=mysql_query("select * from Hungama_Tatasky.tbl_dailymisMitrExcelReport  where  date='2014-11-25' ",$con); */
$sql_query=mysql_query("select Date,Circle,CapsuleName,TotalMissedCallsReceived,TotalOBDsMade,TotalOBDsSuccessfull,
TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel 
from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where date(date)>='2014-11-10' order by date desc",$con); 
$counter = 4;
while($mydata=mysql_fetch_array($sql_query))
{
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter, $mydata['Date']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter, $mydata['Circle']);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter, $mydata['CapsuleName']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter, $mydata['TotalMissedCallsReceived']);
/* if($mydata['IsMitr']=='0')
{ */

$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter, $mydata['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$counter, $mydata['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$counter, $mydata['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$counter, $mydata['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$counter, $mydata['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$counter, $mydata['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$counter, $mydata['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$counter, $mydata['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$counter, $mydata['Tamil']);
/* }
else if($mydata['IsMitr']!='0')
{ */

$sql_query_data=mysql_query("select TotalOBDsMade,TotalOBDsSuccessfull,
TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,
IsMitr,NotSel from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where date(date)>='2014-11-10'
 and IsMitr=1  and Date='".$mydata['Date']."' and Circle= '".$mydata['Circle']."' order by date desc",$con);
$num_rows=mysql_num_rows($sql_query_data);
$data_rows=mysql_fetch_array($sql_query_data);
if($num_rows>0)
{
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$counter, $data_rows['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$counter, $data_rows['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$counter, $data_rows['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$counter, $data_rows['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$counter, $data_rows['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$counter, $data_rows['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$counter, $data_rows['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$counter, $data_rows['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$counter, $data_rows['Tamil']);
}


/* } */

$counter++;
}  


if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set('UTC');
	} else {
			putenv("TZ=UTC");
	}
	$exportTime = date("Y-m-d_His", time()); 
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
	$file = 'ExportExcel'.$exportTime. '.xlsx';
	
	//$objWriter->save('php://output');
	//$objWriter->save('results.xlsx'); 
	$objWriter -> save(str_replace('.php', '.xlsx', '/var/www/html/hungamacare/missedcall/admin/html/mis/mitr-excel/' . $file)); 
	
	
	

?>