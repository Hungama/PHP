<?php
error_reporting(1);
$curdate = date("Y-m-d");
$curtime = date("H");
$logPath_retailer = "/var/www/html/airtel/logs/airtelRefererMsg/retailer_log_".date("Y-m-d_H:i:s").".txt";
$logPath_user = "/var/www/html/airtel/logs/airtelRefererMsg/user_log_".date("Y-m-d_H:i:s").".txt";
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
{
die('could not connect: ' . mysql_error());
}
$selectQuery=mysql_query("select id,ANI,friendANI,service_id,userCircle,status from master_db.tbl_refer_ussdData where date(endDate) >= date(now()) and status=0",$dbConn);
$num=mysql_num_rows($selectQuery);
if($num==0)
{
$logData='No record to process'."\n\r";
echo $logData;
//close database connection
mysql_close($dbConn);
exit;
}
else
{
while($result = mysql_fetch_array($selectQuery))
{	
$ani=$result['ANI'];
$friendANI=$result['friendANI'];
$id=$result['id'];
$service_id=$result['service_id'];
$userCircle=$result['userCircle'];
if($curtime>=20)
{
$type='RET';
}
else
{
$type='Promo';
}
//if($result['status']==0)

$message_user='Dear Customer, Aptech certified Spoken English course ki activation abhi tak pending hai. Service activate karne ke liye abhi reply kare 1 se at Rs.30/15days';

$sndMsgFrndQuery = "CALL master_db.SENDSMS('".$friendANI."','".$message_user."','HMEDUT',4,'5464613','".$type."')";
mysql_query($sndMsgFrndQuery,$dbConn);
$logData="id#".$id."#ani#".$friendANI."#service_id#".$service_id."#circle".$userCircle."#Query#".$sndMsgFrndQuery."#Time#".date("H:i:s")."\n\r";
error_log($logData,3,$logPath_user);
//update status here
$update_status = "UPDATE master_db.tbl_refer_ussdData set smssend=smssend+1 where id='".$id."'";
mysql_query($update_status,$dbConn);


}
echo 'Done';
mysql_close($dbConn);
}
//close database connection
exit;
?>