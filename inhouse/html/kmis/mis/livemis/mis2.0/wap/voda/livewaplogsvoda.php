<?php
error_reporting(1);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$type=strtolower($_REQUEST['last']);
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
//$prevdate='20141203';
//$prevdatedb='2014-12-03';
echo $prevdate;
$baseurl_browsing='http://202.87.41.147/hungamawap/uninor/DoubleConsent/';
$waplogFile="AllVodaVisitorRequestMISNew_".$prevdate.'.txt';
$urltohit_browsing=$baseurl_browsing.$waplogFile;

$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/voda/livedump/".$waplogFile;
unlink($fileDumpPath);
//copy from server
if ( copy($urltohit_browsing, $fileDumpPath) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);
if (file_exists($fileDumpPath)) {

$DeleteQuery = "delete from mis_db.tbl_browsing_wap_voda where date(datetime)='" . $prevdatedb . "' and service in('VodafoneMU','Vodafone54646')";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	


  $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_voda FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(zoneid,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,circle,datetime)';
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
mysql_close($dbConn212);
echo "Done";
?>
