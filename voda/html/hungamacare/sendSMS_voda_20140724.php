<?php
include("dbConnect.php");
$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, m.msg_id, m.message FROM master_db.bulk_message_history b INNER JOIN master_db.tbl_message_data m ON m.msg_id = b.msg_id WHERE status = 0 ORDER BY batch_id LIMIT 1";
$fileData1 = mysql_query($smsFileQuery);
$fileData = mysql_fetch_array($fileData1);
$batch_id = $fileData['batch_id'];
$service_id = $fileData['service_id'];
$message = trim($fileData['message']);
$msg_id = $fileData['msg_id'];
$filename = $fileData['file_name'].".txt";
$filenameLck = $fileData['file_name']."_log.txt";


$file_to_read="http://10.43.248.137/hungamacare/smsbulkuploads/".$service_id."/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);
$lckFilePath = "/var/www/html/hungamacare/smsbulkuploads/log/".$filenameLck;
if($batch_id && $file_size) {
/*$numberQuery = "SELECT u.msg_id, u.msisdn, m.message FROM bulk_msgupload_data u RIGHT JOIN tbl_message_data m ON m.msg_id = u.msg_id WHERE u.batch_id = ".$batch_id;
$numberData = mysql_query($numberQuery);
while($row = mysql_fetch_array($numberData)) {*/
/*
`SENDSMS`(IN IN_ANI VARCHAR(12), IN IN_MSG VARCHAR(1000),IN IN_DNIS varchar(20),IN_TYPE VARCHAR(20),IN IN_FLAG int)

# IN_FLAG -> 1 54646, 2 REDFM,3 VH1

*/
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	//$sndMsgQuery = "CALL master_db.SENDSMS_NEW(".$number.",'".$message."','54646','1')";
	$sndMsgQuery = "CALL master_db.SENDSMS(".$number.",'".$message."','54646','sms-promo','1')";
	$sndMsg = mysql_query($sndMsgQuery);

	$fileLog = $number."#".$msg_id."#".$sndMsgQuery."#".date('Y-m-d H:i:s')."\n";
	error_log($fileLog,3,$lckFilePath);
	//fwrite($fp,$fileLog);
}

$updateQuery = "UPDATE bulk_message_history SET status = 1 WHERE batch_id = ".$batch_id;
$updateStatus = mysql_query($updateQuery);
	echo "Send SMS";
} else {
	echo "Numbers are not available";
}

mysql_close($dbConn);


?>
