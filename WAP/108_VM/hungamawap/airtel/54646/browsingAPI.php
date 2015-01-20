<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);
$sessionid=trim($_REQUEST['sessionid']);
$contentid=trim($_REQUEST['contentid']);
$UA=$_REQUEST['UA'];
$currentpage=$_REQUEST['currentpage'];

$type='BROWSINGAPI';
$logPath = "logs/browsingAPI_" . date("Ymd") . ".txt";
$logData = $type."#".$msisdn ."#".$sessionid."#".$contentid."#".$currentpage."#".$UA."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
echo "SUCCESS";
?>