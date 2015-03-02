<?php
//error_reporting(0);

$Msisdn=$_REQUEST['msisdn'];
$Price=$_REQUEST['price'];
$Status=$_REQUEST['Status'];
$curdate = date("Y-m-d");
if(strtolower($Status)=='success')
	$status1="MCoupon";
else
	$status1="MCoupon Failed";

$Res=$_REQUEST['Res'];

$log_file_path="logs/docomo/Recharge/AirtelRecharge_".$curdate.".txt";
$file=fopen($log_file_path,"a");
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".date('H:i:s')."\r\n" );
fclose($file);

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$insertFEsponse="insert into master_db.tbl_billing_success ";
$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'NA','NA','55001','CallBack','NA','AIRM','1511',0,'NA',now(),'".$Res."')";
$query = mysql_query($insertFEsponse,$dbConnAirtel) or die(mysql_error());

echo "Success";

?>   