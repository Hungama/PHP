<?php
error_reporting(1);
include ("db_224.php");
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
#$prevdate='20141028';
#$prevdatedb='2014-10-28';
$baseurl_browsing='http://117.239.178.108/hungamawap/airtel/CCG/logs/';
$waplogFile="AllAirtelSendCCGVisitorResponseMIS_".$prevdate.'.txt';
$urltohit_browsing=$baseurl_browsing.$waplogFile;

$fileDumpPath="/var/www/html/kmis/mis/waplog/logs/".$waplogFile;
//copy fil from server
$file = 'http://202.87.41.147/hungamawap/aircel/wap_sub/AllAircelVisitorRequestMISNew_20141203.txt';
$newfile ='logs/'.$waplogFile;
unlink($fileDumpPath);

if ( copy($file, $newfile) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);
if (file_exists($fileDumpPath)) {

$DeleteQuery = "delete from mis_db.tbl_browsing_wap_aircel where date(datetime)='" . $prevdatedb . "' and service in('AircelMC','AircelMU')";
$deleteResult12 = mysql_query($DeleteQuery) or die(mysql_error());	


  $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE mis_db.tbl_browsing_wap_aircel FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(zoneid,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,circle,datetime)';
    if(mysql_query($insertDump))
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
mysql_close($con);
echo "Done";
?>