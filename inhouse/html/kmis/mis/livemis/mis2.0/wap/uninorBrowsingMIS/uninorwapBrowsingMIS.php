<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2014-12-03';
echo $view_date1;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan',
    'UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu',
    'KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livedump/wap/';
//include service name configuration 0000-00-00 00:00:00
//UninorMU - tbl_browsing_wap_mu_uninor
//UninorSU - tbl_browsing_wap_su_uninor
//Uninor54646 - tbl_browsing_wap_54646_uninor
//RIAUninor - tbl_browsing_wap_ria_uninor
//UninorMyMusic - tbl_browsing_wap_mod_uninor
//UninorDevo - tbl_browsing_wap_devo_uninor
$serviceArray=array('OMU_NEW'=>'UninorMU','CMU_NEW'=>'UninorMU','U54646_NEW'=>'Uninor54646','USU_NEW'=>'UninorSU','UMY_NEW'=>'UninorMyMusic','UBR_NEW'=>'UninorDevo','UKIJI_NEW'=>'UninorContest','UMR_NEW'=>'RIAUninor','OMU'=>'UninorMU','CMU'=>'UninorMU','CMU60'=>'UninorMU','CMU30'=>'UninorMU','U54646'=>'Uninor54646','USU'=>'UninorSU','UMY'=>'UninorMyMusic','UBR'=>'UninorDevo','UKIJI'=>'UninorContest','UMR'=>'RIAUninor');


//UninorMU process
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livedump/wap/processlog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for UninorwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$fileDumpfile = "UninorMUbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MU = $fileDumpPath . $fileDumpfile;
$browsingData='';
$get_MU_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('OMU_NEW','CMU_NEW','OMU','CMU','CMU60','CMU30')";

$query1 = mysql_query($get_MU_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_MU);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_MU);
        }

    $insertDump_MU = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MU . '" INTO TABLE misdata.tbl_browsing_wap_mu_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_MU, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
	
}


//Uninor54646 - tbl_browsing_wap_54646_uninor
$fileDumpfile = "Uninor54646browsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_uninor = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_54646_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$get_uninor_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('U54646_NEW','U54646')";

$query1 = mysql_query($get_uninor_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_uninor);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_uninor);
        }

    $insertDump_uninor = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_uninor . '" INTO TABLE misdata.tbl_browsing_wap_54646_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_uninor, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_54646_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}

//RIAUninor - tbl_browsing_wap_ria_uninor


$fileDumpfile = "RIAUninorbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_RIA= $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_ria_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
$get_RIA_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('UMR_NEW','UMR')";

$query1 = mysql_query($get_RIA_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_RIA);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_RIA);
        }

    $insertDump_RIA = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_RIA . '" INTO TABLE misdata.tbl_browsing_wap_ria_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_RIA, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_ria_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}


//UninorMyMusic - tbl_browsing_wap_mod_uninor

$fileDumpfile = "UninorMMbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_mm = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_mod_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$get_mm_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('UMY_NEW','UMY')";

$query1 = mysql_query($get_mm_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_mm);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_mm);
        }

    $insertDump_mm = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_mm . '" INTO TABLE misdata.tbl_browsing_wap_mod_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_mm, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_mod_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}

//UninorDevo - tbl_browsing_wap_devo_uninor


$fileDumpfile = "Uninor54646browsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_devo = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_devo_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$get_devo_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('UBR_NEW','UBR')";

$query1 = mysql_query($get_devo_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_devo);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_devo);
        }

    $insertDump_devo = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_devo . '" INTO TABLE misdata.tbl_browsing_wap_devo_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_devo, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_devo_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}


//UninorSU - tbl_browsing_wap_su_uninor

$fileDumpfile = "UninorSUbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_su = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_su_uninor where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$get_su_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('USU_NEW','USU')";

$query1 = mysql_query($get_su_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_su);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_su);
        }

    $insertDump_su = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_su . '" INTO TABLE misdata.tbl_browsing_wap_su_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_su, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_su_uninor where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}


$file_process_status = '***************Script end for UninorwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_MU);
unlink($fileDumpPath_uninor);
unlink($fileDumpPath_RIA);
unlink($fileDumpPath_mm);
unlink($fileDumpPath_devo);
unlink($fileDumpPath_su);
mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>