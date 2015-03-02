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
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/livedump/wap/';
//include service name configuration 0000-00-00 00:00:00
//For AircelLM:- tbl_browsing_wap_mu_aircel
//For AircelMC:- tbl_browsing_wap_mod_aircel

$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/aircel/livedump/wap/processlog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_browsing_wap_mod_aircel where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for aircelwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

$fileDumpfile = "aircelMCbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MOD = $fileDumpPath . $fileDumpfile;

$get_MOD_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_aircel nolock
where date(datetime)='" . $view_date1 . "' and service='AircelMC'";

$query1 = mysql_query($get_MOD_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_MOD);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_MOD);
        }

    $insertDump_MC = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MOD . '" INTO TABLE misdata.tbl_browsing_wap_mod_aircel FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_MC, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

$DeleteQuery = "delete from misdata.tbl_browsing_wap_mod_aircel where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
	
}
//MU

$fileDumpfile = "aircelMUbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MU = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_aircel where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$get_MOD_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_aircel nolock
where date(datetime)='" . $view_date1 . "' and service='AircelMU'";

$query1 = mysql_query($get_MOD_BrowsingData, $dbConn212) or die(mysql_error());
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

    $insertDump_MU = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MU . '" INTO TABLE misdata.tbl_browsing_wap_mu_aircel FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
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

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_aircel where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}

$file_process_status = '***************Script end for aircelwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_MOD);
unlink($fileDumpPath_MU);
mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>