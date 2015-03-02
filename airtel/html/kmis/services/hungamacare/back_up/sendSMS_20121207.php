<?php
date_default_timezone_set("Asia/Calcutta");

include("config/dbConnect.php");

$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, b.upload_for, m.msg_id, m.message FROM bulk_message_history b INNER JOIN tbl_message_data m ON m.msg_id = b.msg_id WHERE status = 0 ORDER BY batch_id LIMIT 1";
$fileData1 = mysql_query($smsFileQuery);
$fileData = mysql_fetch_array($fileData1);

$batch_id = $fileData['batch_id'];
$service_id = $fileData['service_id'];
$message = trim($fileData['message']);
$msg_id = $fileData['msg_id'];
$filename = $fileData['file_name'].".txt";
$filenameLck = $fileData['file_name']."_log.txt";
$uploadFor = $fileData['upload_for'];

$file_to_read="http://10.2.73.156/kmis/services/hungamacare/smsbulkuploads/".$service_id."/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

if($batch_id && $file_size) {
$lckFilePath="/var/www/html/kmis/services/hungamacare/smsbulkuploads/log/".$filenameLck;
$flag=0;
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	if(is_numeric($number)) {
		switch($service_id) {
			case 1502: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','HMMUSC',1,'546461','bulk'";
				break;
			case 15071:	//VH1 NightPack
			case 1507: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','601666',0,'55841','bulk'";
				break;
			case 1509: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','601666',0,'55001','bulk'";
				break;				
			case 1504: // GL Store@1		
			case 1511: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','HMLIFE',1,'55001','bulk'";
				break;
			case 1503: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','601666',0,'546461','bulk'";
				break;
			case 1513: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','HMLIFE',1,'55001','bulk'";
				break;
			case 1514: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','HMEDUT',2,'53222345','bulk'";
				break;
			case 1518: $sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."','HMMUSC',1,'5464612','bulk'";
				break;
		}
		//CALL master_db.SENDSMS('9891999169','huihuj*546*27%23jnfgjmf','HMLIFE',1,'55001','bulk');
		//CALL master_db.SENDSMS('9891999169','huihuj*546*27%23 jnfgjmf','601666',0,'55001','bulk');

		$sndMsgQuery .= ")";
		$logData = $number."#".$sndMsgQuery."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$lckFilePath);
		$sndMsg = mysql_query($sndMsgQuery);
	} else { $flag=1;}
}

if($flag) { 
	$updateQuery = "UPDATE bulk_message_history SET status = 2, process_time=NOW() WHERE batch_id = ".$batch_id;
} else {
	$updateQuery = "UPDATE bulk_message_history SET status = 1, process_time=NOW() WHERE batch_id = ".$batch_id;
}
$updateStatus = mysql_query($updateQuery);

echo "Send SMS";
} else {
echo "Numbers are not available!";
}
mysql_close($dbConn);

?>
