<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
//$reqtype=$_REQUEST['type'];
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

$DeleteQuery = "delete from mis_db.tbl_browsing_wap where date(datetime)='" . $prevdatedb . "' and page='getdata_147_ccgResponseAirtelWAP_live'";
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

$hitip='202.87.41.147';
$mode='WAP';
 $zoneid_db=$data[0];
 $datetime_db=$data[1];
 $msisdn_db=$data[2];
 $remoteaddress_db=$data[3];
 $useragent_db=$data[4];
 $chargingurlfired_db=$data[5];
 $response_db=$data[6];
/* if(empty($response_db))
 {
 $response_db='Double consent';
 }
 else
 {
 $response_db='SUCCESS';
 }*/
 $planid_db=$data[7];
 $mode_db=$data[8];
 $service_name=$data[9];
 $hitip_db=$data[10];
 //$referer_db=urlencode($data[11]);
 $referer_db='';

 $mode_db='WAP';
 
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
$serviceArray=array('1509074'=>'AirtelMND','1508786'=>'AirtelEU','1508709'=>'AirtelEU','1509109'=>'AirtelGL','1508450'=>'Airtel54646','1509125'=>'AirtelDevo','1508630'=>'AirtelDevo','1515680'=>'AirtelGL','1515679'=>'AirtelGL','1515678'=>'AirtelGL','1515677'=>'AirtelGL','1515676'=>'AirtelGL','1515675'=>'AirtelGL','1515684'=>'AirtelGL','1515683'=>'AirtelGL','1515682'=>'AirtelGL','1515681'=>'AirtelGL','1515674'=>'AirtelGL');
 $service_name=$serviceArray[$service_name];
 $sql_waplog="INSERT INTO mis_db.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,page)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','getdata_147_ccgResponseAirtelWAP_live')";
if($service_name!='')
{
mysql_query($sql_waplog);
//echo $sql_waplog."<br>";	
}
else
{
echo mysql_error();
}
//exit;
 }
   }
   mysql_close($dbConn212);
   }

$baseurl='http://202.87.41.147/hungamawap/airtel/dconsent/AllAirtelAfterCCGVisitorResponseMIS_';
//http://202.87.41.147/hungamawap/airtel/dconsent/AllAirtelAfterCCGVisitorResponseMIS_20140724.txt
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