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

function enumValues($filename,$type) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		
//to handle last blank line
if($totalcount!=$i+1)
{
$hitip='202.87.41.194';
$mode='WAP';
$dt = date("Y-m-d H:i:s",strtotime($data[1]));
$urldata = explode("&", $data[6]);
$ServiceName=explode("=", $urldata[1]);

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
 $remoteaddress_db=$data[3];
 $useragent_db=$data[4];
 $chargingurlfired_db=$data[6];
 $response_db='Double consent';

 $mode_db='WAP';
 $service_db=$data[1];
 $hitip_db=$hitip;

$serviceArray=array('GSMENDLESS45'=>'TataDoCoMoMX','GSMENDLESSMONTHLY60'=>'TataDoCoMoMX','GSMENDLESSWEEKLY14'=>'TataDoCoMoMX','GSMENDLESSDAILY2'=>'TataDoCoMoMX','GSMMISSRIYA30'=>'RIATataDoCoMo','GSMHMP30'=>'TataDoCoMo54646','GSMPKP'=>'TataDoCoMoMND','GSMPKP50'=>'TataDoCoMoMND');
$planIDArray=array('GSMENDLESS45'=>'46','GSMENDLESSWEEKLY14'=>'2','GSMENDLESSDAILY2'=>'1','GSMMISSRIYA30'=>'99','GSMHMP30'=>'8','GSMPKP'=>'106','GSMPKP50'=>'164','GSMENDLESSMONTHLY60'=>'');

 $services=$ServiceName[1];

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

							
								
$planid_db=$planIDArray[$service_name];
if (!is_numeric($planid_db)) 
 {
 $planid_db=0;
 }
 
$sql_waplog="INSERT INTO misdata.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$serviceArray[$service_name]."','".$hitip_db."')";
//mysql_query($sql_waplog);

echo $sql_waplog."<br>";	
//exit;
 }
   }
   mysql_close($con);
   }

$baseurl='http://202.87.41.194/hungamawap/docomo/doubCons/logs/';
if($reqtype==3)
{
$urltohit=$baseurl.$prevdate.'_log1.log';
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