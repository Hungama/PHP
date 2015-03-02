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
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/voda/livedump/wap/';

//include service name configuration 0000-00-00 00:00:00
//VodafoneMU - tbl_browsing_wap_mu_vodafone
//Vodafone54646 - tbl_browsing_wap_54646_vodafone

//VodafoneMU process
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/voda/livedump/wap/processlog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_vodafone where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for VodawapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);



$fileDumpfile = "VodafoneMUbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MU = $fileDumpPath . $fileDumpfile;
$browsingData='';
$get_MU_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_voda nolock
where date(datetime)='" . $view_date1 . "' and service='VodafoneMU'";

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

    $insertDump_MU = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MU . '" INTO TABLE misdata.tbl_browsing_wap_mu_vodafone FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
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

$DeleteQuery = "delete from misdata.tbl_browsing_wap_mu_vodafone where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
	
}


//Vodafone54646 - tbl_browsing_wap_54646_vodafone

$fileDumpfile = "Vodafone54646browsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_Voda = $fileDumpPath . $fileDumpfile;
$browsingData='';
$DeleteQuery = "delete from misdata.tbl_browsing_wap_54646_vodafone where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$get_Voda_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_voda nolock
where date(datetime)='" . $view_date1 . "' and service='Vodafone54646'";

$query1 = mysql_query($get_Voda_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_Voda);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_Voda);
        }

    $insertDump_voda = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_Voda . '" INTO TABLE misdata.tbl_browsing_wap_54646_vodafone FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    if(mysql_query($insertDump_Voda, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);

	$DeleteQuery = "delete from misdata.tbl_browsing_wap_54646_vodafone where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}



$file_process_status = '***************Script end for VodawapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_MU);
unlink($fileDumpPath_Voda);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>