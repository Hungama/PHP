<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$view_date1='2014-12-03';
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/wap/';
//include service name configuration
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/wap/processlogBrowsingData_".date('Ymd').".txt";
include ("/var/www/html/kmis/mis/livemis/mis2.0/airtel/serviceNameconfig.php");
$DeleteQuery = "delete from misdata.tbl_browsing_wap_ldr_airtel where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for airtelwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);

$fileDumpfile = "browsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_ldr_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap nolock
where date(datetime)='" . $view_date1 . "' and service='WAPAirtelLDR' and datatype='browsing'";

$query1 = mysql_query($get_ldr_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath1);
        }

    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.tbl_browsing_wap_ldr_airtel FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
    //mysql_query($insertDump7, $LivdbConn);
	
	if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
//    error_log($file_process_status, 3, $processlog);
	
}


$file_process_status = '***************Script end for airtelwapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath1);
mysql_close($dbConnAirtel);
mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>
