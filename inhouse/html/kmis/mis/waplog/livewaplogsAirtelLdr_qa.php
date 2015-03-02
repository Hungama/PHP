<?php
error_reporting(1);
include ("db_224.php");
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
$prevdate='20141213';
$prevdatedb='2014-12-13';

$DeleteQuery = "delete from mis_db.tbl_browsing_wap where date(datetime)='" . $prevdatedb . "' and service='WAPAirtelLDR' and  datatype='ccgresponse'";
//$deleteResult12 = mysql_query($DeleteQuery) or die(mysql_error());	

function enumValues($filename,$datatype) {
   $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
		print_r($data);
		exit;
//to handle last blank line
if($totalcount!=$i+1)
{

$hitip='117.239.178.108';
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
 
 $sessionid_db=$data[15];
 
 if($datatype=='ccgresponse')
 {
 $Publisher_Ref_Id=$data[13];
 $DGMResponse=$data[14];
 $DGMResponse = str_replace(array("\n", "\r","\r\n"), '', $DGMResponse);
 $DGMResponse = trim($DGMResponse);				
 $response_db=$data[6];
 $sessionid_db=$data[16];
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
 $service_name='WAPAirtelLDR';
 
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

					
 $sql_waplog="INSERT INTO mis_db.tbl_browsing_wap (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip,referer,affiliateid,datatype,circle,sessionid,Publisher_Ref_Id,DGMResponse,contentID)
VALUES ('".$zoneid_db."','".$datetime_db."','".$msisdn_db."','".$remoteaddress_db."','".mysql_real_escape_string($useragent_db)."','".trim($chargingurlfired_db)."','".$response_db."','".$planid_db."','".$mode_db."','".$service_name."','".$hitip_db."','".$referer_db."','".$afid."','".$datatype."','".$circle."','".$sessionid_db."','".$Publisher_Ref_Id."','".$DGMResponse."','')";

					
mysql_query($sql_waplog);
}
   }
   mysql_close($con);
}

$baseurl_browsing='http://117.239.178.108/hungamawap/airtel/CCG/logs/AllAirtelSendCCGVisitorResponseMIS_';
$urltohit_browsing=$baseurl_browsing.$prevdate.'.txt';
enumValues($urltohit_browsing,'browsing');
//echo $urltohit_browsing."<br>";
//sleep(10);
$baseurl_ccgresponse='http://117.239.178.108/hungamawap/airtel/CCG/logs/AllAirtelAfterCCGVisitorResponseMIS_';
$urltohit_ccgresponse=$baseurl_ccgresponse.$prevdate.'.txt';
enumValues($urltohit_ccgresponse,'ccgresponse');
echo $urltohit_ccgresponse."<br>";
echo "Done";
?>
