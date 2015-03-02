<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2014-12-03';
echo $view_date1;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan',
    'UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/idea/livedump/wap/';


//include service name configuration 0000-00-00 00:00:00
//For RIATataDocomo - tbl_browsing_wap_vh1_idea


// RIATataDoCoMo process

$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/idea/livedump/wap/processlog_".date('Ymd').".txt";
$DeleteQuery = "delete from misdata.tbl_browsing_wap_vh1_idea where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for IdeawapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//vh1 process

$fileDumpfile = "IdeabrowsingdumpFile_" . date('ymd') . '.txt';
$fileDumpPath_RIA = $fileDumpPath . $fileDumpfile;
$browsingData='';
$get_RIA_BrowsingData = "select msisdn,circle,datetime,remoteaddress,affiliateid,zoneid,chargingurlfired,referer,useragent from mis_db.tbl_browsing_wap_idea nolock
where date(datetime)='" . $view_date1 . "' and service='VH1'";

$query1 = mysql_query($get_RIA_BrowsingData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_RIA);
    while (list($msisdn,$circle,$datetime,$remoteaddress,$affiliateid,$zoneid,$chargingurlfired,$referer,$useragent) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
	  $browsingData = $msisdn . "|" . $circle . "|" . $datetime . "|" . $remoteaddress . "|" . $affiliateid . "|" . $zoneid . "|" . $chargingurlfired. "|" . $referer. "|" . $useragent . "|" ."\r\n";
      error_log($browsingData, 3, $fileDumpPath_RIA);
        }

    $insertDump_RIA = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_RIA . '" INTO TABLE misdata.tbl_browsing_wap_vh1_idea FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,date,ip,affiliate,zoneid,url,http_referer,device_browser)';
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

$DeleteQuery = "delete from misdata.tbl_browsing_wap_vh1_idea where date='0000-00-00 00:00:00'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
	
}

$file_process_status = '***************Script end for IdeawapBrowsingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($fileDumpPath_RIA);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>