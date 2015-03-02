<?php
include("dbConnect.php");

$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, m.msg_id, m.message FROM bulk_message_history b INNER JOIN tbl_message_data m ON m.msg_id = b.msg_id WHERE status = 0 ORDER BY batch_id LIMIT 1";
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
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	$sndMsgQuery = "CALL master_db.SENDSMS(".$number.",'".$message."','54646')";
	$sndMsg = mysql_query($sndMsgQuery);

	$fileLog = $number."#".$msg_id."#".date('Y-m-d H:i:s')."\n";
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
