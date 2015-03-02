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
if(empty($Res))
$Res=0;

$Service=strtolower($_REQUEST['Service']);
if($Service=='uninorsu')
{
$serviceid=1408;
$sc=524441;
}
else if($Service=='uninor54646')
{
$serviceid=1402;
$sc=54646;
}
else
{
$serviceid=1423;
$sc=52000;
}
//$log_file_path="logs/Uninor/Recharge/Recharge_".$curdate.".txt";
$log_file_path="logs/Recharge/Recharge_".$curdate.".txt";
$file=fopen($log_file_path,"a");
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".$serviceid."#".date('H:i:s')."\r\n" );
fclose($file);

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$insertFEsponse="insert into master_db.tbl_billing_success(billing_ID,msisdn,event_type,date_time,amount,status,aval_amount,chrg_amount,SC,MODE,circle,operator,service_id,subservice_id,plan_id,response_time,trans_ID) ";
$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'".$sc."','CallBack','NA','UNIM','".$serviceid."',0,'NA',now(),'".$Res."')";
//echo $insertFEsponse;
$query = mysql_query($insertFEsponse,$dbConn) or die(mysql_error());

echo "Success";
?>   