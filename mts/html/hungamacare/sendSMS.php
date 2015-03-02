<?php 
include ("config/dbConnect.php");

$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, m.msg_id, m.message FROM master_db.bulk_message_history b INNER JOIN master_db.tbl_message_data m ON m.msg_id = b.msg_id WHERE b.status = 0 ORDER BY b.batch_id LIMIT 1";
$fileData1 = mysql_query($smsFileQuery,$dbConn);
$fileData = mysql_fetch_array($fileData1);
$batch_id = $fileData['batch_id'];
$service_id = $fileData['service_id'];
$message = trim($fileData['message']);
$msg_id = $fileData['msg_id'];
$filename = $fileData['file_name'].".txt";
$filenameLck = $fileData['file_name']."_log.txt";

$file_to_read="http://10.130.14.107/hungamacare/smsbulkuploads/".$service_id."/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

$lckFilePath="/var/www/html/hungamacare/smsbulkuploads/log/".$filenameLck;

if($batch_id && $file_size) {
	/*$numberQuery = "SELECT u.msg_id, u.msisdn, m.message FROM master_db.bulk_msgupload_data u RIGHT JOIN master_db.tbl_message_data m ON m.msg_id = u.msg_id WHERE u.batch_id = ".$batch_id;
	$numberData = mysql_query($numberQuery);
	while($row = mysql_fetch_array($numberData)) { */
	
	/*parameters  MSG_TYPE and IN_FLAG, please send  the  name of event for which SMS is triggered; for eg: if  Hangup SMS is pushed then type should be ‘hangup’, for subscription send ‘sub’ for renewal send ‘renew‘ etc. Second Parameter IN_FLAG remains same as 0 for all events.
	call SENDSMS_BULK_DND('8459394649','this is a test sms','55935','sub','0')
	*/
	for($i=0; $i<$file_size; $i++) {
		$number = trim($file_data[$i]);

		$sndMsgQuery = "CALL master_db.SENDSMS_BULK_DND(";
		switch($service_id) {
			case 1101: $sndMsgQuery .= "'".$number."','".$message."','52222','sms-promo','0'";
			break;
			case 1102: $sndMsgQuery .= "'".$number."','".$message."','54646','sms-promo','0'";
			break;
			case 1103: $sndMsgQuery .= "'".$number."','".$message."','546461','sms-promo','0'";
			break;
			case 1105: $sndMsgQuery .= "'".$number."','".$message."','5432155','sms-promo','0'";
			break;
			case 1106: $sndMsgQuery .= "'".$number."','".$message."','5432155','sms-promo','0'";
			break;
			case 1111: $sndMsgQuery .= "'".$number."','".$message."','5432105','sms-promo','0'";
			break;
			case 1110: $sndMsgQuery .= "'".$number."','".$message."','55935','sms-promo','0'";
			break;
			case 1116: $sndMsgQuery .= "'".$number."','".$message."','54444','sms-promo','0'";
			break;
			case 1113: $sndMsgQuery .= "'".$number."','".$message."','54646196','sms-promo','0'";
			break;
			case 1124: $sndMsgQuery .= "'".$number."','".$message."','522223','sms-promo','0'";
			break;
			case 1125: $sndMsgQuery .= "'".$number."','".$message."','5464622','sms-promo','0'";
			break;
			case 1123: $sndMsgQuery .= "'".$number."','".$message."','55333','sms-promo','0'";
			break;
			case 1126: $sndMsgQuery .= "'".$number."','".$message."','51111','sms-promo','0'";
			break;
		}
		$sndMsgQuery .= ")";
		//$sndMsg = mysql_query($sndMsgQuery,$dbConn);
		if(mysql_query($sndMsgQuery, $dbConn))
		$res="SUCCESS";
		else
		$res= mysql_error();
				
		$fileLog = $number."#".$msg_id."#".$sndMsgQuery."#".$res."#".date('Y-m-d H:i:s')."\n";
		error_log($fileLog,3,$lckFilePath);
	}
	$updateQuery = "UPDATE master_db.bulk_message_history SET status = 1 WHERE batch_id = ".$batch_id;
	$updateStatus = mysql_query($updateQuery,$dbConn);
	echo "Send SMS";
} else { 
	echo "Numbers not available.";
}
mysql_close($dbConn);
//echo "Send SMS";

?>
