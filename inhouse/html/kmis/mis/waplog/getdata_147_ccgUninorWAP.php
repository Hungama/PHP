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

$startfiletm = date("Y-m-d H:i:s");
$logPath = "logs/fileprocess_147_".date("Y-m-d").".txt";
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
$hitip='202.87.41.147';
$mode='WAP';
$service=$data[1];

$urldata = explode("&", $data[6]);
$planid=explode("=", $urldata[3]);
$dt = date("Y-m-d H:i:s",strtotime($data[7]));
if(empty($data[2]))
{
$zoneid=0;
}
else
{
$zoneid=$data[2];
}

if(empty($data[0]))
{
$msisdn=0;
}
else
{
$msisdn=$data[0];
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

 
 $zoneid_db=$zoneid;
 $datetime_db=$dt;
 $msisdn_db=$msisdn;
 $remoteaddress_db=$data[4];
 $useragent_db=$data[5];
 $chargingurlfired_db=$data[6];
 $response_db='Visitor-landing';
 $planid_db=$planid;
 $mode_db='WAP';
 $service_db=$data[1];
 $hitip_db=$hitip;

$serviceArray=array('OMU_NEW'=>'UninorMU','CMU_NEW'=>'UninorMU','U54646_NEW'=>'Uninor54646','USU_NEW'=>'UninorSU','UMY_NEW'=>'UninorMyMusic','UBR_NEW'=>'UninorDevo','UKIJI_NEW'=>'UninorContest','UMR_NEW'=>'RIAUninor','OMU'=>'UninorMU','CMU'=>'UninorMU','CMU60'=>'UninorMU','CMU30'=>'UninorMU','U54646'=>'Uninor54646','USU'=>'UninorSU','UMY'=>'UninorMyMusic','UBR'=>'UninorDevo','UKIJI'=>'UninorContest','UMR'=>'RIAUninor');


 $services=$data[1];
$servicesName= $serviceArray[$services];
 if(empty($servicesName)) 
 {
 $servicesName=$services;
 }

/*
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
*/
$sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$servicesName."','".$hitip_db."')";
mysql_query($sql_waplog);
//exit;
//echo $sql_waplog."<br>";	
 }
   }
   mysql_close($con);
   }
$baseurl='http://202.87.41.147/hungamawap/uninor/DoubleConsent/CCGVisitorRequest_';
if($reqtype==3)
{
$urltohit=$baseurl.$prevdate.'.txt';
//$urltohit=$baseurl;
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
$endfiletm = date("Y-m-d H:i:s");
$logData="file process end"."#".$endfiletm."\n\r";
error_log($logData,3,$logPath);
exit;
?>
