<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$reqtype=3;
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

$DeleteQuery = "delete from mis_db.tbl_browsing_wap where date(datetime)='" . $prevdatedb . "' and page='getdata_147_ccgvisitorlogsTata_live'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());

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
$sql_waplog="INSERT INTO mis_db.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,page)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','".$afid."','getdata_147_ccgvisitorlogsTata_live')";
mysql_query($sql_waplog);
 }
   }
   mysql_close($dbConn212);
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
mysql_close($dbConn212);
echo "Invalid request";
exit;
}
exit;
?>