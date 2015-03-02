<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$cppid=$_REQUEST['cppid'];
$sc=$_REQUEST['sc'];
//$servicename=trim($_REQUEST['servicename']);
$curdate = date("Y-m-d");
	$log_file_path="logs/voicegetreqs/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $cppid . "#" . $sc . "#" . date('H:i:s') . "#".$remoteAdd. "\r\n" );
	fclose($file);
echo "SUCCESS";
exit;
?>   