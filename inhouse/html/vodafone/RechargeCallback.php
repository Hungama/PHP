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

$log_file_path="logs/Recharge/Recharge_".$curdate.".txt";

$file=fopen($log_file_path,"a");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
$insertFEsponse="insert into master_db.tbl_billing_success ";
$insertFEsponse .="values($Msisdn,$Msisdn,'".$status1."',now(),$Price,1,'NA',$Price,'NA','NA','55665','CallBack','NA','VODM','1301',0,'NA',now(),'".$Res."',0)";



if(mysql_query($insertFEsponse,$dbConnVoda))
{
echo "Success";
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".$insertFEsponse."#SUCCESS".date('H:i:s')."\r\n" );
}
else
{
echo "Failure";
$error= mysql_error();
fwrite($file,$Msisdn."#".$Price."#".$Status."#".$Res."#".$insertFEsponse."#Failure#".$error."#".date('H:i:s')."\r\n" );

}
fclose($file);
?>   