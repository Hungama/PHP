<?php
include_once '/var/www/html/kmis/services/hungamacare/config/dbConnect.php';
$msisdn=$_GET['msisdn'];
$serviceid=$_GET['ServiceId'];

if($serviceid==1202)
	$Query1 = "call reliance_hungama.JBOX_UNSUB('$msisdn', 'CC')";
if($serviceid==1208)
	$Query1 = "call reliance_cricket.CRICKET_UNSUB('$msisdn', 'CC')";
if($serviceid==1203)
	$Query1 = "call reliance_hungama.MTV_UNSUB('$msisdn', 'CC')";

$queryresult12=mysql_query($Query1);
?>

