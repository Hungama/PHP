<?php
error_reporting(0);
include("db.php");
$reqtype=$_REQUEST['type'];
//$reqtype=1;
//$reqtype=2;
$reqtype=3;
$prevdate = date("Ymd", time() - 60 * 60 * 24);
function enumValues($filename,$type) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
$urldata = explode("&", $data[5]);
if($type==1)
{
$hitip='125.21.241.108';
$mode=explode("=", $urldata[1]);
$planid=explode("=", $urldata[2]);
$service=explode("=", $urldata[4]);
}
else if($type==2)
{
$hitip='202.87.41.194';
$mode=explode("=", $urldata[4]);
$planid=explode("=", $urldata[2]);
$service=explode("=", $urldata[3]);
}
else
{
$hitip='202.87.41.147';
$mode=explode("=", $urldata[4]);
$planid=explode("=", $urldata[2]);
$service=explode("=", $urldata[3]);
}
//|29-11-2012 16:33:18
$dt = date("Y-m-d H:i:s",strtotime($data[1]));
//$dt = $data[1];

$sql_waplog="INSERT INTO misdata.tbl_browsing_wap2 (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip)
VALUES ('".$data[0]."','".$dt."','".$data[2]."','".$data[3]."','".mysql_real_escape_string($data[4])."','".$data[5]."','".strip_tags($data[6])."','".$planid[1]."','".$mode[1]."','".$service[1]."','".$hitip."')";
/*
$logPath = "logs/wap_log".".txt";
$logData=$fGetContents."#".$hitip."\n\r";
error_log($logData,3,$logPath);
*/

if(!mysql_query($sql_waplog))
{
mysql_error();
}
	
 }
   }
   }
$baseurl_1='http://125.21.241.108/common/getLogs.php?date=';
//$baseurl_1='http://125.21.241.108/common/getLogs.php?date=20121202';
$baseurl_2='http://202.87.41.194/common/getLogs.php?date=';
//$baseurl_2='http://202.87.41.194/common/getLogs.php?date=20121130';
//$baseurl_3='http://202.87.41.147/common/getLogs.php?date=20121204';
$baseurl_3='http://202.87.41.147/common/getLogs.php?date=';

if($reqtype==1)
{
$urltohit_1=$baseurl_1.$prevdate;
//$urltohit_1=$baseurl_1;
enumValues($urltohit_1,1);
}
else if($reqtype==2)
{
$urltohit_2=$baseurl_2.$prevdate;
//$urltohit_2=$baseurl_2;
enumValues($urltohit_2,2);
}
else if($reqtype==3)
{
//$urltohit_3=$baseurl_3.$prevdate;
$urltohit_3=$baseurl_3;
enumValues($urltohit_3,3);
}
else
{
echo "Invalid request";
}

mysql_close($con);
?>
