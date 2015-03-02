<?php
error_reporting(1);
//Missed Call data for tiscon & mcd
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2015-01-01';
echo $view_date1;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan',
    'UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu',
    'KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$fileDumpPath = '/var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/livedump/';
$processlog = "/var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/livedump/processlog_".date('Ymd').".txt";

$file_process_status = '***************Script start for missed call mcd******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
$DeleteQuery = "delete from misdata.tbl_missedcall_enterprise_mcdowell where date(datetime)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
error_log($file_process_status, 3, $processlog);
$fileDumpfile = "MissedCallMCDMISdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MCD = $fileDumpPath . $fileDumpfile;
$missedCallData='';
$get_MCD_MissedCallData = "select ani,circle,date_time from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp nolock 
where date(date_time)='" . $view_date1 . "' and ANI!=''";

$query1 = mysql_query($get_MCD_MissedCallData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_MCD);
    while (list($msisdn,$circle,$datetime) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $missedCallData = $msisdn . "|" . $circle . "|". $datetime. "|" ."\r\n";
      error_log($missedCallData, 3, $fileDumpPath_MCD);
        }

    $insertDump_recharge = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MCD . '" INTO TABLE misdata.tbl_missedcall_enterprise_mcdowell FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,datetime)';
    if(mysql_query($insertDump_recharge, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Recharge Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Recharge Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	echo $file_process_status;
    error_log($file_process_status, 3, $processlog);
	
}
$file_process_status = '***************Script end for Recharge-dedication data******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath_MCD);

$fileDumpfile='';
$file_process_status = '***************Script start for missed call Tiscon******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
$DeleteQuery = "delete from misdata.tbl_missedcall_enterprise_tiscon where date(datetime)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
error_log($file_process_status, 3, $processlog);
$fileDumpfile = "MissedCallTisconMISdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_Tiscon = $fileDumpPath . $fileDumpfile;
$missedCallData='';
$get_Tiscon_MissedCallData = "select ani,circle,date_time from Hungama_Tatasky.tbl_tata_pushobd nolock where date(date_time)='" . $view_date1 . "' and ANI!='' ";

$query2 = mysql_query($get_Tiscon_MissedCallData, $dbConn212) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath_Tiscon);
    while (list($msisdn,$circle,$datetime) = mysql_fetch_array($query2)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $missedCallData = $msisdn . "|" . $circle . "|". $datetime. "|" ."\r\n";
      error_log($missedCallData, 3, $fileDumpPath_Tiscon);
        }

    $insertDump_tiscon = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_Tiscon . '" INTO TABLE misdata.tbl_missedcall_enterprise_tiscon FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" (msisdn,circle,datetime)';
    if(mysql_query($insertDump_tiscon, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute tiscon missed call Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error tiscon missed call Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	echo $file_process_status;
    error_log($file_process_status, 3, $processlog);
	
}
$file_process_status = '***************Script end for tiscon missed call******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath_Tiscon);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>