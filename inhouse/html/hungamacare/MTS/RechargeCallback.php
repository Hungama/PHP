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

$log_file_path="logs/MTS/Recharge/Recharge_".$curdate.".txt";
$file=fopen($log_file_path,"a");
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".date('H:i:s')."\r\n" );
fclose($file);

//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$con = mysql_connect("database.master_mts","ivr","ivr");
$sc='55333';
$serviceid='1123';
//$insertFEsponse="insert into master_db.tbl_billing_success ";
//$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'NA','NA','55333','CallBack','NA','mtsm','1123',0,'NA',now(),'".$Res."',0,0,0,0)";
$insertFEsponse="insert into master_db.tbl_billing_success(billing_ID,msisdn,event_type,date_time,amount,status,aval_amount,chrg_amount,SC,MODE,circle,operator,service_id,subservice_id,plan_id,response_time,trans_ID) ";
$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'".$sc."','CallBack','NA','AIRM','".$serviceid."',0,'NA',now(),'".$Res."')";
$query = mysql_query($insertFEsponse,$con) or die(mysql_error());

echo "Success";
?>   
