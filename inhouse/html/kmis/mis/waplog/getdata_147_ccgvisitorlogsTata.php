<?php
error_reporting(1);
include ("db.php");
$reqtype=$_REQUEST['type'];
$reqtype=3;
if (isset($_REQUEST['date'])) {
    $prevdate = $_REQUEST['date'];
} else {
    $prevdate = date("Ymd", time() - 60 * 60 * 24);
}
//$prevdate='20141130';
function enumValues($filename,$type) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
//print_r($data);
$hitip='202.87.41.194';
$mode='WAP';
 $zoneid_db=$data[0];
 $datetime_db=$data[1];
 $msisdn_db=$data[2];
 $remoteaddress_db=$data[3];
 $useragent_db=$data[4];
 $chargingurlfired_db=$data[5];
 $response_db=$data[6];
 if(empty($response_db))
 {
 $response_db='Double consent';
 }
 else
 {
 $response_db='SUCCESS';
 }
 $planid_db=$data[7];
 $mode_db=$data[8];
 $service_name=$data[9];
 $hitip_db=$data[10];
 $referer_db=$data[11];

 $mode_db='WAP';
 $service_db=$data[1];
 
$afid=trim($data[13]);
if(empty($afid)) 
 {
 $afid=0;
 }
 
 $hitip_db=$hitip;
 if (!is_numeric($zoneid_db)) 
 {
 $zoneid_db=0;
 }
if (!is_numeric($msisdn_db)) 
 {
 $msisdn_db=0;
 }
						
if (!is_numeric($planid_db)) 
 {
 $planid_db=0;
 }
 //$dtm=explode(" ",$datetime_db);
 //$datetime_db='14-10-16 '.$dtm[1];
$sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','".$afid."')";

//if($service_name=='TataDoCoMocrbt')
//{
mysql_query($sql_waplog);
//echo $sql_waplog."<br>";	
//}
//exit;
 }
   }
   mysql_close($con);
   }

$baseurl='http://202.87.41.194/hungamawap/docomo/doubCons/logs/AllTataVisitorRequestMIS_';
//http://202.87.41.194/hungamawap/docomo/doubCons/logs/AllTataVisitorRequestMIS_20140721.txt
if($reqtype==3)
{
$urltohit=$baseurl.$prevdate.'.txt';
enumValues($urltohit,3);
echo $urltohit."<br>";
echo "Done";
}
else
{
mysql_close($con);
echo "Invalid request";
exit;
}
exit;
?>
