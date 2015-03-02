<?php
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
error_reporting(1);
$reqsdate=$_REQUEST['Date'];
$service=$_REQUEST['Service'];
include ("/var/www/html/kmis/mis/livemis/mis2.0/airtel/serviceNameconfig.php");
$service_array = array('WAPAirtelLDR');
//$reqsdate='2014-10-28';
//$service='WAPAirtelLDR';

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$LivdbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";
$dateFormatQuery = mysql_query($getDateFormatQuery,$LivdbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

$fileDumpfile = $service.'_'.date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;


$get_data_query = "select date,type,sum(value) as TotalCount,sum(revenue) as TotalRev from misdata.livemis 
where service='".$service."' and date(date)='".$reqsdate."' and date<'".$DateFormat[0]."' group by type,hour(date) order by date,type asc";

$query1 = mysql_query($get_data_query, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileDumpPath1");
    unlink($fileDumpPath1);
    while (list($date, $type, $TotalCount, $TotalRev) = mysql_fetch_array($query1)) {
			echo $logdata = $date . "," . $type ."," . $TotalCount . "," . $TotalRev . "\r\n";
            //error_log($logdata, 3, $fileDumpPath1);
        }
header("Pragma: no-cache");
header("Expires: 0");

}
else
{
echo 'Data not available or invalid service name';
}
mysql_close($LivdbConn);
?>