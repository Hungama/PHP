<?php
date_default_timezone_set("Asia/Calcutta");

include("config/dbConnect.php");

$logPath = "/var/www/html/kmis/services/hungamacare/log/CMDMSG/cmdmsg_log_".date("Ymd").".txt";

$aniQuery = "SELECT ANI FROM airtel_hungama.tbl_comedyportal_subscription WHERE status=1";
$aniDataResult = mysql_query($aniQuery);

$message = "Thank you for using Airtel Mana Pata Mana Comedy! Dial 5464612(TOLLFREE) and listen Comedy, Janapada Geethalu, Peradi Song and many more. Dial now 5464612";

while($aniData = mysql_fetch_array($aniDataResult))
{
	$msisdn = trim($aniData['ANI']);
	if(is_numeric($msisdn)) {
		$call = "CALL master_db.SENDSMS_NEW('".$msisdn."','".$message."','HMMUSC',1,'5464612')";
		mysql_query($call);
		$logData = $msisdn."#".$call."#".date("Y-m-d H:i:s")."\n";
	} else {
		$logData = $msisdn."#Invalid Number#".date("Y-m-d H:i:s")."\n";
	}
	error_log($logData,3,$logPath);
}

echo "Done";

mysql_close($dbConn);

?>
