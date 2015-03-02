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
$prevdate='20150213';
$prevdatedb='2015-02-13';
echo $prevdate;
$waplogFile="AllTataVisitorRequestMIS_".$prevdate.'.txt';
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/tata/ldr/".$waplogFile;
if (file_exists($fileDumpPath)) {

$DeleteQuery = "delete from mis_db.tbl_browsing_wap_tata where date(datetime)='" . $prevdatedb . "'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	


 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_tata FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" (datetime,zoneid,affiliateid,msisdn,circle,remoteaddress,chargingurlfired,response,useragent,mode,service,hitip,referer,sessionid)
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

 unlink($fileDumpPath);
mysql_close($dbConn212);
echo "Done";
?>
