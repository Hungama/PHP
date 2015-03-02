<?php
error_reporting(1);
//include database connection file
include("db.php");
$dbname="uninor_jyotish";
$messageTable="tbl_jyotish_message";
$sendmessageProcedure="Jyotish_SendMessage";

$logPath = "logs/cron/".date('Y-m-d').".txt";
$message="Uninor Jyotish Aapke Dwaar mei call karne ke liye dhanyawaad. Jaaniye kaisa hoga aapka din. Toh apna bhavishya jaane ke liye, abhi dial  kare 5464627";
$checkANItoprocess=mysql_query("select ANI from uninor_jyotish.tbl_jyotish_subscription where STATUS=0 and SUB_TYPE='UI' order by SUB_DATE DESC limit 1000");
$notosendsms=mysql_num_rows($checkANItoprocess);

if($notosendsms==0)
{
$logData='No ANI to process'."\n\r";
echo $logData;
mysql_close($con);
exit;
}
else
{
while($row_file_info = mysql_fetch_array($checkANItoprocess))
{
$smstoANI=$row_file_info['ANI'];
$type='jyotish';
$circle='pan';

$sendSMS="call ".$dbname.".".$sendmessageProcedure." ('".$smstoANI."','".$type."','".$circle."')";	

if(!mysql_query($sendSMS))
{
echo "Failed";
//die(" Error: ".mysql_error());
$logData="#ANI#".$smstoANI."#message#".$message."#procedure#".$sendSMS."#response#Failed"."#".date('Y-m-d H:i:s')."\n\r";
error_log($logData,3,$logPath);
}
else
{
echo "Success";
$update_status_ANI = "UPDATE uninor_jyotish.tbl_jyotish_subscription set status='1' where ANI='".$smstoANI."'";
mysql_query($update_status_ANI);

$logData="#ANI#".$smstoANI."#message#".$message."#procedure#".$sendSMS."#response#Success"."#".date('Y-m-d H:i:s')."\n\r";
error_log($logData,3,$logPath);
}	

}
//end of while
mysql_close($con);
//close database connection
exit;
}
?>