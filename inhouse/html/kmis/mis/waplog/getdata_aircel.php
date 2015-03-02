<?php
error_reporting(0);
include ("db.php");
$reqtype=$_REQUEST['type'];
$reqtype=1;
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$startfiletm = date("Y-m-d H:i:s");
$logPath = "logs/fileprocess_temp_".date("Y-m-d").".txt";
$logData="file process start"."#".$startfiletm."\n\r";
error_log($logData,3,$logPath);

function enumValues($filename,$type) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
   
   if($type==1)
{
$logPath = "logs/uninor/164531/dbfaileddata_".date("Y-m-d").".txt";
}
else if($type==2)
{
$logPath = "logs/airtel/154036/dbfaileddata_".date("Y-m-d").".txt";
}
else if($type==3)
{
$logPath = "logs/aircel/134685/dbfaileddata_".date("Y-m-d").".txt";
}
else if($type==4)
{
$logPath = "logs/docomo/130734/dbfaileddata_".date("Y-m-d").".txt";
}
   echo $logPath;
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
$urldata = explode("&", $data[5]);
if($type==1)
{
$hitip='202.87.41.147';
//$mode=explode("=", $urldata[4]);
//$planid=explode("=", $urldata[2]);
//$service=explode("=", $urldata[3]);
$mode=explode("=", $urldata[3]);
$planid=explode("=", $urldata[4]);
$service=explode("=", $urldata[5]);
}
else if($type==2 || $type==4)
{
$hitip='202.87.41.147';
$mode=explode("=", $urldata[4]);
$planid=explode("=", $urldata[2]);
$service=explode("=", $urldata[3]);
}
else if($type==3)
{
$hitip='202.87.41.147';
$mode=explode("=", $urldata[4]);
$planid=explode("=", $urldata[2]);
$service=explode("=", $urldata[3]);
}

$dt = date("Y-m-d H:i:s",strtotime($data[1]));
//$dt = $data[1];
if(empty($data[0]))
{
$zoneid=0;
}
else
{
$zoneid=$data[0];
}

if(empty($data[2]))
{
$msisdn=0;
}
else
{
$msisdn=$data[2];
}
if(empty($planid[1]))
{
$planid=0;
}
else
{
$planid=$planid[1];
}
 if (!is_numeric($zoneid)) 
 {
 $zoneid=0;
 }
if (!is_numeric($msisdn)) 
 {
 $msisdn=0;
 }
 if (!is_numeric($planid)) 
 {
 $planid=0;
 }
 
if(empty($data[7]))
{
 $referer='';
 }
 else
 {
 $referer=$data[7];
 }
 if($referer=='NA')
 {
 $referer='';
 }
 
 $serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609','TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601','RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010','TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801','TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603','MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003','AirtelGL'=>'1511','TataDoCoMoSongBook'=>'SB','RelianceMM'=>'MM','UninorSU'=>'1408','REDFMUninor'=>'1410','AircelMC'=>'2101');
 $services=$service[1];

					foreach ($serviceArray as $k => $v)
							{
								if($v==$services)
									{
										$service_name=$k;
									}
							}
							if(!empty($service_name))
								{
									$service_name=$service_name;
								}
							else
								{
									$service_name=$services;
									
								}
								if($service_name==1340)
									{
									$service_name='UninorMU';
									}
									
$zone_servie_map=array('134685'=>'AircelMC','130734'=>'TataDoCoMoSongBook','128635'=>'TataDoCoMoMX','128642'=>'TataDoCoMoMX','130686'=>'TataDoCoMoMX','127391'=>'RIATataDoCoMo','143509'=>'TataDoCoMoFMJ','131144'=>'RelianceCM','131158'=>'RelianceCM','131163'=>'RelianceCM','145530'=>'RelianceCM','154036'=>'AirtelGL','131745'=>'AirtelGL','156057'=>'VH1Airtel','144720'=>'VH1Airtel','154369'=>'RIAAirtel','161435'=>'AirtelPD','158443'=>'AirtelMND','165986'=>'AirtelSE','162644'=>'AirtelEU','165148'=>'AirtelDevo','164530'=>'UninorMU','164534'=>'UninorMU','166789'=>'UninorSU','168009'=>'Uninor-MU New Link','170688'=>'Uninor 30-Bhakti Ras','174736'=>'Aircel-Bhakti Ras');
if(empty($service_name))
{
$service_name=$zone_servie_map[$zoneid];
}
									
$sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer)
VALUES ('".$zoneid."','".$dt."','".$msisdn."','".$data[3]."','".mysql_real_escape_string($data[4])."','".$data[5]."','".strip_tags($data[6])."','".$planid."','".$mode[1]."','".$service_name."','".$hitip."','".$referer."')";
echo $sql_waplog."<br>";
/*
if(!mysql_query($sql_waplog))
{
echo "Error inserting data.";
$logData="#zoneid#".$zoneid."#datetime#".$dt."#msisdn#".$msisdn."#remoteaddress#".$data[3]."#useragent#".$data[4]."#chargingurlfired#".$data[5]."#response#".strip_tags($data[6]).'#planid#'.$planid.'#mode#'.$mode[1].'#service#'.$service_name.'#hitip#'.$hitip.'#referer#'.$referer."\n";
error_log($logData,3,$logPath);
}
*/
}
   }
   mysql_close($con);
   }
 //handle zoneid
$baseurl_1='http://202.87.41.147/hungamawap/uninor/164531/subsLog/';
$baseurl_2='http://202.87.41.147/hungamawap/airtel/154036/visitorLogVoice/';
$baseurl_3='http://202.87.41.147/hungamawap/aircel/134685/subsLog/';
$baseurl_4='http://202.87.41.194/hungamawap/docomo/130734/logs/';
//yyyymmdd
// $urltohit_1='http://202.87.41.147/hungamawap/uninor/164531/subsLog/20130506_log1.log';
//  $urltohit_2='http://202.87.41.147/hungamawap/airtel/154036/visitorLogVoice/20130508_log1.log';
	//$urltohit_3='http://202.87.41.147/hungamawap/aircel/134685/subsLog/20130509_log1.log';
	$urltohit_4='http://202.87.41.194/hungamawap/docomo/130734/logs/20130509_log1.log';

$urltohit_1=$baseurl_1.$prevdate.'_log1.log';
//enumValues($urltohit_1,1);

$urltohit_2=$baseurl_2.$prevdate.'_log1.log';
//enumValues($urltohit_2,2);

$urltohit_3=$baseurl_3.$prevdate.'_log1.log';
//enumValues($urltohit_3,3);

//$urltohit_4=$baseurl_4.$prevdate.'_log1.log';
enumValues($urltohit_4,4);
echo 'done';
mysql_close($con);
exit;

$endfiletm = date("Y-m-d H:i:s");
$logData="file process end"."#".$endfiletm."\n\r";
error_log($logData,3,$logPath);
exit;
?>