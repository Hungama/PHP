<?php
date_default_timezone_set("Asia/Calcutta");

include("config/dbConnect.php");

$logPath = "/var/www/html/kmis/services/hungamacare/log/Pending/allAirtelPen_log_".date("Ymd").".txt";

$day = date('D');

$message="Full talktime, paiye Rs200 ka full talktime Rs200 aur Rs150 ka full talktime Rs150 ke recharge se apne airtel mobile par. Khaas offer ke liye call 12131";

$aniQuery = "SELECT ANI FROM airtel_SPKENG.tbl_spkeng_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_EDU.tbl_jbox_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_devo.tbl_devo_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_hungama.tbl_mtv_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_hungama.tbl_jbox_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_mnd.tbl_character_subscription1 WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_radio.tbl_radio_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT ANI FROM airtel_rasoi.tbl_rasoi_subscription WHERE status=11 and circle IN ('UPW')
UNION
SELECT '9654998981' AS ANI";

//$aniQuery = "SELECT '8447013444' AS ANI";

$aniDataResult = mysql_query($aniQuery);

while($aniData = mysql_fetch_array($aniDataResult))
{
	$msisdn = trim($aniData['ANI']);
	if(is_numeric($msisdn)) {
		$call = "CALL master_db.SENDSMS('".$msisdn."','".$message."','601666',0,'54646','bulk')";
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
