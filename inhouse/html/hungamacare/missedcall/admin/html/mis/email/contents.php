<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include ("/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/emailalert/func.php");
#$PrevDate='2014-11-26';
#$filedate='20141126';
//date condition start here
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

require_once("/var/www/html/hungamacare/missedcall/admin/html/mis/email/db.php");
require_once '/var/www/html/hungamacare/missedcall/admin/html/mis/email/PHPExcel.php';
require_once '/var/www/html/hungamacare/missedcall/admin/html/mis/email/PHPExcel/IOFactory.php';
$objPHPExcel = new PHPExcel();
include('/var/www/html/hungamacare/missedcall/admin/html/mis/email/excel-header.php');
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
	$objWriter -> save(str_replace('.php', '.xlsx', '' . $filepath)); 

/*    Put excel file end here*/

		$path = $filepath;
		
		$files_to_zip = array($path);
            $newZip = 'Allusertisconreport_' . $filedate . '.zip';
			unlink($newZip);

           create_zip($files_to_zip, $newZip);
            sleep(2);

$ctime=date("d,D M H A");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
			
$message .= 'Please find attached the report for MITR and Non-MITR members for '.$PrevDate."<br><br>";

$message .= 'Regards,'."<br>";
$message .= 'Team MIS- Hungama'."<br>";
$message .="<br>";
$message .= 'Please do not reply to this email as ms.mis@hungama.com is an un-attended mailbox.';
$message .="</body></html>";
$htmlfilename='tisconReportData_'.$filedate.'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>