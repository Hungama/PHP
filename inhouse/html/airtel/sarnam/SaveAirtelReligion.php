<?php
error_reporting(0);
$langid=$_REQUEST['langId'];
$msisdn=$_REQUEST['msisdn'];
$act=$_REQUEST['act'];
$userAgent=$_REQUEST['userAgent'];

$logdate=date("Ymd");
$logPath="/var/www/html/airtel/sarnam/wapvistitorlog/".$logdate."_visitorlog.log";


include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
switch($langid)
{
	case '1':
		$langN='hindu';
	break;
	case '2':
		$langN='muslim';
	break;	
	case '3':
		$langN='sikhism';
	break;	
	case '4':
		$langN='christianity';
	break;
	case '5':
		$langN='buddhism';
	break;
	case '6':
		$langN='jainism';
	break;
}
if(!$dbConnAirtel)
	die('could not connect due to connectivity failure: '.mysql_error());

if($act=='up')
{
	//$updateReligion="update airtel_devo.tbl_religion_profile set lastreligion_cat='".$langN."' where ani=".$msisdn;
	$updateReligion="REPLACE INTO airtel_devo.tbl_religion_profile (ani,lastreligion_cat,lang) VALUES ($msisdn,'".$langN."',01)";

	$QueryMNDWhl = mysql_query($updateReligion,$dbConnAirtel);
	mysql_close($dbConnAirtel);
	echo "Success";
}
if($act=='get')
{
	$getReligionQuery="select lastreligion_cat from airtel_devo.tbl_religion_profile where ani=".$msisdn;
	$getResult = mysql_query($getReligionQuery,$dbConnAirtel);
	$getRecord=mysql_fetch_array($getResult);
	echo $getRecord[0];
	mysql_close($dbConnAirtel);
}
if($act=='visitor')
{
	$logString=date('d-m-Y h:i:s')."|".$msisdn."|".$userAgent."\r\n";
	error_log($logString,3,$logPath);
	echo "Success";
	mysql_close($dbConnAirtel);
}






?>   