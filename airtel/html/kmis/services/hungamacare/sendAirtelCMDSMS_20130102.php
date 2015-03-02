<?php
date_default_timezone_set("Asia/Calcutta");

include("config/dbConnect.php");

$logPath = "/var/www/html/kmis/services/hungamacare/log/CMDMSG/cmdmsg_log_".date("Ymd").".txt";

$day = date('D');

$msgQuery = "select message,id from airtel_hungama.tbl_cmd_message where setfor in ('".$day."') and date(datetime)='".date('Y-m-d')."'";
$msgResult = mysql_query($msgQuery);
while($row = mysql_fetch_array($msgResult)) {
	$message = $row['message'];
	$msgId = $row['id'];
}

$aniQuery = "SELECT ANI FROM airtel_hungama.tbl_comedyportal_subscription WHERE status=1";
$aniDataResult = mysql_query($aniQuery);

while($aniData = mysql_fetch_array($aniDataResult))
{
	$msisdn = trim($aniData['ANI']);
	if(is_numeric($msisdn)) {
		$call = "CALL master_db.SENDSMS('".$msisdn."','".$message."','5464612',1,'HMMUSC','active')";
		mysql_query($call);
		$logData = $msisdn."#".$call."#".date("Y-m-d H:i:s")."\n";
	} else {
		$logData = $msisdn."#Invalid Number#".date("Y-m-d H:i:s")."\n";
	}
	error_log($logData,3,$logPath);
}

$nextDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+8,date("Y")));
$nextDay = date("D",mktime(0,0,0,date("m"),date("d")+8,date("Y")));

$updateMsgQuery = "update airtel_hungama.tbl_cmd_message set setfor='".$nextDay."', datetime='".$nextDate."' where id='".$msgId."'";
mysql_query($updateMsgQuery);

echo "Done";

mysql_close($dbConn);

?>
