<?php
error_reporting(1);
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2014-11-30';
echo $view_date1;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan',
    'UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu',
    'KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$fileDumpPath = '/var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/livedump/';

//recharge processlog
$processlog = "/var/www/html/hungamacare/missedcall/admin/html/mis/MCD_dedication_RechargeData/livedump/processlog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_recharge_enterprise_mcdowell where date(added)='" . $view_date1 . "'";

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for Dedication-Recharge mcd******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);



$fileDumpfile = "RechargeMCDMISdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MCD = $fileDumpPath . $fileDumpfile;
$browsingData='';
$get_MCD_BrowsingData = "select ANI as msisdna,EntryDate as added,RechargeDate as bill_added,status,response,party,operator,circle,Campgid as campaignid,SecondANI as msisdnb
from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)='" . $view_date1 . "'";

$query1 = mysql_query($get_MCD_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_MCD);
    while (list($msisdna,$added,$bill_added,$status,$response,$party,$operator,$circle,$campaignid,$msisdnb) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdna . "|" . $added . "|". $bill_added . "|" . $status . "|" . $response . "|" . $party . "|" . $operator. "|" . $circle. "|" . $campaignid. "|" . $msisdnb. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_MCD);
        }

    $insertDump_recharge = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MCD . '" INTO TABLE misdata.tbl_recharge_enterprise_mcdowell FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdna,added,bill_added,status,response,party,operator,circle,campaignid,msisdnb)';
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


//dedication process log

$fileDumpfile = "DedicationMCDMISdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_Dedication = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery1 = "delete from misdata.tbl_dedication_enterprise_mcdowell where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery1, $LivdbConn) or die(mysql_error());


$get_DEDI_BrowsingData = "select ANI as msisdn,BPARTYANI as msisdnb,circle as circleb,trim(Momessage), date_time as date 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate where date(date_time)='" . $view_date1 . "'";

$query1 = mysql_query($get_DEDI_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_Dedication);
    while (list($msisdn,$msisdnb,$circleb,$mommessage,$date) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circleb)] == '')
			$circleb='Others';
			else
			$circleb=$circle_info[strtoupper($circleb)];
			$mommessage = str_replace(array("\n", "\r","\r\n"), '', $mommessage);
		
	  $browsingData = $msisdn . "|" . $msisdnb . "|" . $circleb . "|" . $mommessage . "|" . $date . "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_Dedication);
        }

    $insertDump_dedication = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_Dedication . '" INTO TABLE misdata.tbl_dedication_enterprise_mcdowell FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,msisdnb,circleb,mommessage,date)';
    if(mysql_query($insertDump_dedication, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for dedicate Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error dedicate Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

echo $file_process_status;
}

$file_process_status = '***************Script end for Recharge-dedication data******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_MCD);
unlink($fileDumpPath_Dedication);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>
