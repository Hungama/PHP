<?php
error_reporting(0);
$Msisdn=$_REQUEST['msisdn'];
$Price=$_REQUEST['price'];
$Status=$_REQUEST['Status'];
$curdate = date("Y-m-d");
if(strtolower($Status)=='success')
	$status1="Recharged";
else
	$status1="Recharge Failed";

$Res=$_REQUEST['Res'];

$log_file_path="logs/Recharge/Recharge_".$curdate.".txt";

$file=fopen($log_file_path,"a");
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".date('H:i:s')."\r\n" );
fclose($file);
/*******
will code here to notify altrust team...
*****/
echo "Success";
?>   