<?php
require_once("db.php");
$filedate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
include ("func.php");
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = new PHPExcel();
include('excel-header.php');
$year=date("Y");
$day=date("d");
if($day!='01')
{
$cond="month(date)=month(now()) and year(date)=year(now()) ";
}
else
{
$cond="month(date)=month(now())-1 and year(date)=year(now()) ";
}

/****Put excel file start here****/
$sql_query=mysql_query("select Date,Circle,CapsuleName,TotalMissedCallsReceived,TotalOBDsMade,TotalOBDsSuccessfull,TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,TotalNewUsers from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where $cond and IsMitr=0 order by date desc",$con);
$counter = 4;
while($mydata=mysql_fetch_array($sql_query))
{

$objPHPExcel->getActiveSheet()->SetCellValue('A'.$counter, $mydata['Date']);
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter, $mydata['Circle']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter, $mydata['CapsuleName']);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter, $mydata['TotalMissedCallsReceived']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter, $mydata['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter, $mydata['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$counter, $mydata['TotalNewUsers']);
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$counter, $mydata['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$counter, $mydata['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$counter, $mydata['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$counter, $mydata['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$counter, $mydata['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$counter, $mydata['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$counter, $mydata['Tamil']);
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$counter, $mydata['NotSel']);
//mitr code
$sql_query_data=mysql_query("select TotalOBDsMade,TotalOBDsSuccessfull,TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,TotalNewUsers from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where date(date)='".$mydata['Date']."' and IsMitr=1  and Circle= '".$mydata['Circle']."'",$con);
$num_rows=mysql_num_rows($sql_query_data);
$data_rows=mysql_fetch_array($sql_query_data);
if($num_rows>0)
{
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$counter, $data_rows['TotalOBDsMade']);
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$counter, $data_rows['TotalOBDsSuccessfull']);
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$counter, $data_rows['TotalNewUsers']);
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$counter, $data_rows['TotalUniqueOBDs']);
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$counter, $data_rows['TotalMinutesConsumed']);
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$counter, $data_rows['AverageDuration_OBD']);
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$counter, $data_rows['PeakCallingHour']);
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$counter, $data_rows['Hindi']);
$objPHPExcel->getActiveSheet()->SetCellValue('X'.$counter, $data_rows['Bengali']);
$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$counter, $data_rows['Tamil']);
$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$counter, $data_rows['NotSel']);
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
	
$filepath = 'Allusertisconreport_' . $filedate . '.xlsx'; 

//$objWriter -> save(str_replace('.php', '.xlsx', '' . $filepath));
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filepath.'');
header('Cache-Control: max-age=0'); 
$objWriter->save('php://output');

/*    Put excel file end here*/

/* $path = $filepath;

$files_to_zip = array($path);
$newZip = 'Allusertisconreport_' . $filedate . '.zip';
unlink($newZip);
create_zip($files_to_zip, $newZip);
sleep(2);
# send the file to the browser as a download */

mysql_close($con);
?>