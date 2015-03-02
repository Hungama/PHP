<?php
include("dbDigiConnect.php");

$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, m.msg_id, m.message FROM bulk_message_history b INNER JOIN tbl_message_data m ON m.msg_id = b.msg_id WHERE status = 0 ORDER BY batch_id LIMIT 1";
$fileData1 = mysql_query($smsFileQuery, $dbConn);
$fileData = mysql_fetch_array($fileData1);
$batch_id = $fileData['batch_id'];
$service_id = $fileData['service_id'];
$message = trim($fileData['message']);
$msg_id = $fileData['msg_id'];
$filename = $fileData['file_name'].".txt";
$filenameLck = $fileData['file_name']."_log.txt";

$file_to_read="http://127.0.0.1/smsbulkuploads/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

if($batch_id && $file_size) {
$lckFilePath="/smsbulkuploads/log/".$filenameLck;

for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	$sndMsgQuery = "call master_db.SENDSMS_NEW(".$number.",'".$message."','2000','DIGI','1','SMSBULK',5)";
	
	//echo $sndMsgQuery;
	$sndMsg = mysql_query($sndMsgQuery, $dbConn);
	$fileLog = $number."#".$msg_id."#".date('Y-m-d H:i:s')."\n";
	error_log($fileLog,3,$lckFilePath);
	//fwrite($fp,$fileLog);
}
//fclose($fp);
$updateQuery = "UPDATE bulk_message_history SET status = 1 WHERE batch_id = ".$batch_id;
$updateStatus = mysql_query($updateQuery, $dbConn);
	echo "Send SMS";
} else {
	echo "Numbers are not available";
}
mysql_close($dbConn);

?>
