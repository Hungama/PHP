<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);
$sessionid=trim($_REQUEST['sessionid']);
$contentid=trim($_REQUEST['contentid']);
$UA=$_REQUEST['UA'];
$currentpage=$_REQUEST['currentpage'];
$afid=$_REQUEST['afid'];
$type='BROWSINGAPI';

if (is_numeric($msisdn)) {
if (strlen($msisdn) == 12)
$msisdn = substr($msisdn, -10);
}

//$logPath = "logs/browsingAPI_" . date("Ymd") . ".txt";
//$logData = $type."#".$msisdn ."#".$sessionid."#".$contentid."#".$currentpage."#".$UA."#".$afid."#".date('Y-m-d H:i:s') . "\n";
//error_log($logData, 3, $logPath);

$logdate = date("Ymd");
$refererName=$_SERVER['HTTP_REFERER'];
$afid=$_REQUEST['afid'];


$msisdnval_count_val = strlen($msisdn);
$chkFoUnknown=strtolower($msisdn);
$circle='UND';
if($chkFoUnknown!='unknown')
{
		
	if ($msisdnval_count_val == 12) {
		$msisdnval2 = substr($msisdn, 2);
	} else {
		$msisdnval2 = $msisdn;
	}
$msisdnval_count_val2 = strlen($msisdnval2);
	if($msisdnval_count_val2==10)
	{	
		$getCircle = "http://10.48.54.11/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
		$circle = file_get_contents($getCircle);
	}
	else
	{
		$circle='UND';
	}
}
//$logPath_MIS="/var/www/html/hungamawap/airtel/CCG/logs/AllAirtelVisitorRequestMIS_".$logdate.".txt";
//$logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $UA . "|" . $currentpage . "|BROWSINGAPI|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .$refererName."|".$afid."|".$circle."|".date('Y-m-d H:i:s')."|".$sessionid."|".$contentid."|"."\r\n";
//error_log($logString_MIS218_Airtel, 3, $logPath_MIS);

$logPath_MIS218_Airtel="/var/www/html/hungamawap/airtel/CCG/logs/AllAirtelVisitorRequestMISNew_".$logdate.".txt";
$logString_MIS218_Airtel = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $UA . "|" . $currentpage . "|BROWSINGAPI|" .$planid."|WAP|WAPAirtelLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$Publisher_Ref_Id."|".$DGMResponse."|".$sessionid."|".$contentid."|".date('Y-m-d H:i:s')."|CGNOK|"."\r\n";
error_log($logString_MIS218_Airtel, 3, $logPath_MIS218_Airtel);
echo "SUCCESS";
?>
