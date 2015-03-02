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
else if($type==3)
{
$hitip='202.87.41.147';
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
 
 $serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609',
 'TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601',
 'RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010',
 'TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801',
 'TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603',
 'MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003','Airtel Good Life'=>'1511','TataDoCoMoSongBook'=>'SB','RelianceMM'=>'MM');
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
echo $sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip)
VALUES ('".$zoneid."','".$dt."','".$msisdn."','".$data[3]."','".mysql_real_escape_string($data[4])."','".$data[5]."','".strip_tags($data[6])."','".$planid."','".$mode[1]."','".$service_name."','".$hitip."')";
echo "<br>";
/*
if(!mysql_query($sql_waplog))
{
echo "Error inserting data.";
}
*/	
 }
   }
   mysql_close($con);
   }
//$baseurl_1='http://202.87.41.147/hungamawap/uninor/164531/subsLog/';
$baseurl_1='http://202.87.41.147/hungamawap/uninor/164531/subsLog/20130131_log1.log';
if($reqtype==1)
{
//$urltohit_1=$baseurl_1.$prevdate;
$urltohit_1=$baseurl_1;
enumValues($urltohit_1,4);
}
else
{
mysql_close($con);
echo "Invalid request";
exit;
}
$endfiletm = date("Y-m-d H:i:s");
$logData="file process end"."#".$endfiletm."\n\r";
error_log($logData,3,$logPath);
?>