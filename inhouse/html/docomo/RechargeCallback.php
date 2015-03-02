<?php
//error_reporting(0);

$Msisdn=$_REQUEST['msisdn'];
$Price=$_REQUEST['price'];
$Status=$_REQUEST['Status'];
$curdate = date("Y-m-d");
if(strtolower($Status)=='success')
	$status1="Recharged";
else
	$status1="Recharge Failed";

$Res=$_REQUEST['Res'];

$log_file_path="logs/docomo/Recharge/Recharge_".$curdate.".txt";
$file=fopen($log_file_path,"a");
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".date('H:i:s')."\r\n" );
fclose($file);

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$insertFEsponse="insert into master_db.tbl_billing_success ";
$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'NA','NA','59090','CallBack','NA','TATM','1001',0,'NA',now(),'".$Res."',0,0,0)";
$query = mysql_query($insertFEsponse,$dbConn) or die(mysql_error());

echo "Success";

?>   