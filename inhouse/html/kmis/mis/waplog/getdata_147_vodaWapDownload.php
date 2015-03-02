<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

$reqtype=$_REQUEST['type'];
$reqtype=3;
if (isset($_REQUEST['date'])) {
    $prevdate = $_REQUEST['date'];
} else {
    $prevdate = date("Ymd", time() - 60 * 60 * 24);
}

function enumValues($filename,$type,$dbConnVoda) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
$hitip='202.87.41.147';
$mode='WAP';
 $zoneid_db=$data[0];
 $datetime_db=$data[1];
 $msisdn_db=$data[2];
 $remoteaddress_db=$data[3];
 $useragent_db=$data[4];
 $model_db=$data[5];
 $service_db=$data[7];
 $contentid_db=$data[9];
 $pin_db=$data[10];
 
$sql_waplog="INSERT INTO master_db.dailyReportVodafoneWapDownload (report_date,msisdn,circle,mode,service_id,Remote_add,full_user_agent,model,ip,contentid,pin)
VALUES ('".$datetime_db."','".$msisdn_db."','".$circle."','".$mode."','".$service_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($model_db)."','".$hitip."','".$contentid_db."','".$pin_db."')";

mysql_query($sql_waplog,$dbConnVoda);
//exit;
 }
   }
   mysql_close($dbConnVoda);
   }

$baseurl='http://202.87.41.147/hungamawap/uninor/DoubleConsent/AllVodaSongDownloadRequestMIS_';
//$baseurl='http://202.87.41.147/hungamawap/uninor/DoubleConsent/AllVodaSongDownloadRequestMIS_20140827.txt';
if($reqtype==3)
{
$urltohit=$baseurl.$prevdate.'.txt';
//$urltohit=$baseurl;
enumValues($urltohit,3,$dbConnVoda);
echo $urltohit."<br>";
echo "Done";
}
else
{
mysql_close($dbConnVoda);
echo "Invalid request";
exit;
}
exit;
?>