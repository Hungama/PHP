<?php
error_reporting(1);
include ("db.php");
$reqtype=$_REQUEST['type'];
$reqtype=1;

$startfiletm = date("Y-m-d H:i:s");
$logPath = "logs/fileprocess_temp_".date("Y-m-d").".txt";
$logData="file process start"."#".$startfiletm."\n\r";
error_log($logData,3,$logPath);

function enumValues($filename,$type) {

 $fGetContents = file_get_contents($filename);
   if($type==1)
{
$hitip='202.87.41.144';
}
$json = json_decode($fGetContents, true);
   echo '<pre>';
foreach($json as $item) {
   if(empty($item[1]))
{
$zoneid=0;
}
else
{
$zoneid=$item[1];
}	
if(empty($item[3]))
{
$msisdn=0;
}
else
{
$msisdn=$item[3];
}
 if (!is_numeric($zoneid)) 
 {
 $zoneid=0;
 }
if (!is_numeric($msisdn)) 
 {
 $msisdn=0;
 }
 $planid=0;
 $zoneid_response_array=array('130734'=>'Visitor','128635'=>'Visitor','128642'=>'Visitor','130686'=>'Visitor','127391'=>'Visitor','143509'=>'Double Confirmation','167979'=>'Double Confirmation','129456'=>'Double Confirmation','134685'=>'Visitor');
$dt = date("Y-m-d H:i:s",strtotime($item[0]));

$zone_servie_map=array('134685'=>'AircelMC','130734'=>'TataDoCoMoSongBook','128635'=>'TataDoCoMoMX','128642'=>'TataDoCoMoMX','130686'=>'TataDoCoMoMX','127391'=>'RIATataDoCoMo','143509'=>'TataDoCoMoFMJ','131144'=>'RelianceCM','131158'=>'RelianceCM','131163'=>'RelianceCM','145530'=>'RelianceCM','154036'=>'AirtelGL','131745'=>'AirtelGL','156057'=>'VH1Airtel','144720'=>'VH1Airtel','154369'=>'RIAAirtel','161435'=>'AirtelPD','158443'=>'AirtelMND','165986'=>'AirtelSE','162644'=>'AirtelEU','165148'=>'AirtelDevo','164530'=>'UninorMU','164534'=>'UninorMU','166789'=>'UninorSU','168009'=>'Uninor-MU New Link','170688'=>'Uninor 30-Bhakti Ras','174736'=>'Aircel-Bhakti Ras');
$service_name=$zone_servie_map[$zoneid];

//	echo 'Circle: ' . $item[2] . '<br />';
$sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip)
VALUES ('".$zoneid."','".$dt."','".$msisdn."','','".mysql_real_escape_string($item[4])."','','".$zoneid_response_array[$zoneid]."','".$planid."','','".$service_name."','".$hitip."')";
	if(!mysql_query($sql_waplog))
{
echo "Error inserting data.";
//die(" Error: ".mysql_error());
}
	
	}
	  
//function end here
}
  
 $prevdate = date("d/m/Y", time() - 60 * 60 * 24);
  
 //  http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=TATAGSM&zoneid=130734&date=23/02/2013
$baseurl_1='http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=TATAGSM&zoneid=';

$baseurl_2='http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=AIRCEL&zoneid=';

$zoneidarray=array('130734','128635','128642','130686','127391','143509','167979','129456','134685');
//$zoneidarray=array('134685');
foreach($zoneidarray as $zoneid) {
if($zoneid=='134685')
{
echo $urltohit_1=$baseurl_2.$zoneid.'&date='.$prevdate;
//echo $urltohit_1='http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=AIRCEL&zoneid=134685&date=24/04/2013';
}
else
{
$urltohit_1=$baseurl_1.$zoneid.'&date='.$prevdate;
}
enumValues($urltohit_1,1);

}
echo "File processed successfully.";
mysql_close($con);
$endfiletm = date("Y-m-d H:i:s");
$logData="file process end"."#".$endfiletm."\n\r";
error_log($logData,3,$logPath);
exit;
?>
