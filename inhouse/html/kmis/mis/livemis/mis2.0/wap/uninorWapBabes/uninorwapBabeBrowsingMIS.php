<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2014-12-03';
echo $view_date1;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorWapBabes/livedump/wap/';
//include service name configuration 0000-00-00 00:00:00
//UninorBabe Api - tbl_browsing_wap_3puninor_babes

//UninorBabes process
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorWapBabes/livedump/wap/processbrowsinglog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_browsing_wap_3puninor_babes where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for UninorwapBabesBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$fileDumpfile = "UninorBabesbrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_MU = $fileDumpPath . $fileDumpfile;
$browsingData='';
$get_MU_BrowsingData = "select msisdn,circle,datetime,affiliateid,zoneid,chargingurlfired,referer,remoteaddress,useragent from mis_db.tbl_browsing_wap_uninor nolock
where date(datetime)='" . $view_date1 . "' and service in('3PWAPUninorBabe')";

$query1 = mysql_query($get_MU_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_MU);
    while (list($msisdn,$circle,$datetime,$affiliateid,$zoneid,$chargingurlfired,$referer,$remoteaddress,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $remoteaddress. "|" . $useragent. "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_MU);
        }

    $insertDump_MU = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_MU . '" INTO TABLE misdata.tbl_browsing_wap_3puninor_babes FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,affiliate,zoneid,url,http_referer,ip,device_browser)';
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

$DeleteQuery = "delete from misdata.tbl_browsing_wap_3puninor_babes where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
	
}


$file_process_status = '***************Script end for UninorwapBabeBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_MU);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>