<?php
error_reporting(1);
include ("db_224.php");
$reqtype=$_REQUEST['type'];
$reqtype=3;
if (isset($_REQUEST['date'])) {
    $prevdate = $_REQUEST['date'];
} else {
    $prevdate = date("Ymd", time() - 60 * 60 * 24);
}
$prevdate='20141028';
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
$afid=trim($data[12]);
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
$serviceArray=array('1508709'=>'AirtelEU','1509074'=>'AirtelMND','1508786'=>'AirtelEU','1509109'=>'AirtelGL','1508450'=>'Airtel54646','1508630'=>'AirtelDevo');
$planIDArray=array('1508709'=>'AirtelEU','1509074'=>'AirtelMND','1508786'=>'AirtelEU','1509109'=>'AirtelGL','1508450'=>'Airtel54646','1508630'=>'AirtelDevo');
 $service_name=$serviceArray[$service_name];
 
 //get circle
$msisdnval_count_val = strlen($msisdn_db);
if ($msisdnval_count_val == 12) {
    $msisdnval2 = substr($msisdn_db, 2);
} else {
    $msisdnval2 = $msisdn_db;
}
$msisdnval_count_val2 = strlen($msisdnval2);
if($msisdnval_count_val2==10)
{
$getCircle = "select master_db.getCircle(".trim($msisdnval2).") as circle";
$circle1=mysql_query($getCircle);
list($circle)=mysql_fetch_array($circle1);
}
					if(!$circle)
					{ 
					$circle='UND';
					}

					
 $sql_waplog="INSERT INTO mis_db.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,datatype,circle)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','".$afid."','browsing','".$circle."')";

					
mysql_query($sql_waplog);
//echo $sql_waplog."<br>";	
//exit;
/*if($service_name!='')
{
mysql_query($sql_waplog);
//echo $sql_waplog."<br>";	
}*/
//exit;
 }
   }
   mysql_close($con);
}

$baseurl='http://117.239.178.108/hungamawap/airtel/CCG/logs/AllAirtelSendCCGVisitorResponseMIS_';
//http://117.239.178.108/hungamawap/airtel/CCG/logs/AllAirtelSendCCGVisitorResponseMIS_20140722.txt
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