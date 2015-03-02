<?php
error_reporting(1);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$type=strtolower($_REQUEST['last']);
// make mis_db the current db
$db_selected = mysql_select_db('mis_db', $dbConn212);
if (!$db_selected) {
    die ('Can\'t use mis_db : ' . mysql_error());
}
if (date('H') == '00' || $type=='y')
{
$type='y';
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}

$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$prevdate='20150205';
//$prevdatedb='2015-02-05';
echo $prevdate;
$waplogFile="AllUninorVisitorRequestMISNew_".$prevdate.'.txt';
/*
$baseurl_browsing='http://117.239.178.108/hungamawap/uninor/DoubleConsent/logs/';
$urltohit_browsing=$baseurl_browsing.$waplogFile;
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livedump/".$waplogFile;
unlink($fileDumpPath);

if ( copy($urltohit_browsing, $fileDumpPath) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);
*/
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/others/".$waplogFile;
if (file_exists($fileDumpPath)) {

$DeleteQuery = "delete from mis_db.tbl_browsing_wap_uninor where date(datetime)='" . $prevdatedb . "'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	


 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" (zoneid,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,circle,datetime)
 SET referer=urldecode(referer)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
 unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
 }


//Added for Uninor LDR WAP Logs Start here
 $baseurl_browsing='';
 $waplogFile='';
 $urltohit_browsing='';
 $fileDumpPath='';
 $waplogFile="logs_".$prevdate.'.txt';
/*
$baseurl_browsing='http://117.239.178.108/hungamawap/uninorldr/logs/wap/';
$urltohit_browsing=$baseurl_browsing.$waplogFile;
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livedump/".$waplogFile;
unlink($fileDumpPath);

if ( copy($urltohit_browsing, $fileDumpPath) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);
*/
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/ldr/".$waplogFile;
if (file_exists($fileDumpPath)) {
$DeleteQuery = "delete from mis_db.tbl_browsing_wap_uninor where date(datetime)='" . $prevdatedb . "' and service='WAPUninorLDR'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(zoneid,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,circle,sessionid,handset1,datetime,datatype)
 SET referer=urldecode(referer)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data(WAPUninorLDR)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPUninorLDR) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
 }
 //Added for Uninor LDR WAP Logs end here
 
 //Added for Uninor KIJI WAP Logs Start here
 $baseurl_browsing='';
 $waplogFile='';
 $urltohit_browsing='';
 $fileDumpPath='';
 
$waplogFile="logs_".$prevdate.'.txt';
 /*
$baseurl_browsing='http://117.239.178.108/hungamawap/uninorcontest/logs/wap/';
$urltohit_browsing=$baseurl_browsing.$waplogFile;
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorBrowsingMIS/livedump/".$waplogFile;
unlink($fileDumpPath);

if ( copy($urltohit_browsing, $fileDumpPath) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);
*/
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/contest/".$waplogFile;
if (file_exists($fileDumpPath)) {
$DeleteQuery = "delete from mis_db.tbl_browsing_wap_uninor where date(datetime)='" . $prevdatedb . "' and service='WAPUninorContest'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(zoneid,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,circle,sessionid,handset1,datetime,datatype)
 SET referer=urldecode(referer)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Browsing Data(WAPUninorContest)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPUninorContest) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
 }
 //Added for Uninor KIJI WAP Logs end here
 unlink($fileDumpPath);
mysql_close($dbConn212);
echo "Done";
?>
