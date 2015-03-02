<?php
include("dbConnect.php");
//$smsFileProcessQuery = "SELECT batch_id FROM master_db.bulk_message_history WHERE status=0 and date(scheduleDate)<=date(now()) ORDER BY batch_id ASC LIMIT 10";
$smsFileProcessQuery = "SELECT batch_id FROM master_db.bulk_message_history WHERE status=0 and scheduleDate<=now() and date(scheduleDate)=date(now()) ORDER BY batch_id ASC LIMIT 10";

$fileProcessData1 = mysql_query($smsFileProcessQuery);
$processSmsArray = array();
$j = 0;
while ($row = mysql_fetch_array($fileProcessData1)) {
    $processSmsArray[$j] = $row['batch_id'];
    $updateSmsQry = "update master_db.bulk_message_history set status=3 where batch_id='" . $row['batch_id'] . "'";
    $updateResult = mysql_query($updateSmsQry);
    $j++;
}

$totalcount = count($processSmsArray);

if ($totalcount >= 1) {
    $allIds = implode(",", $processSmsArray);	
$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, m.msg_id, m.message FROM master_db.bulk_message_history b INNER JOIN master_db.tbl_message_data m ON m.msg_id = b.msg_id WHERE batch_id in($allIds)";
$fileData1 = mysql_query($smsFileQuery);
$isfileindb = mysql_num_rows($fileData1);
if ($isfileindb >= 1) {

while ($fileData = mysql_fetch_array($fileData1)) {
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
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	$sndMsgQuery = "CALL master_db.SENDSMS_BULK('".$number."','" . $message . "',";
                    switch ($service_id) {
                        case '1302':
						case '1307':
						case '1310':
								$smscli='54646';
								$sndMsgQuery .= "'$smscli','sms-promo','1')";
							break;
						case '1301':
								$smscli='55665';
								$sndMsgQuery .= "'$smscli','sms-promo','1')";
                            break;
                    }
	
	$sndMsg = mysql_query($sndMsgQuery);

	$fileLog = $number."#".$msg_id."#".$sndMsgQuery."#".date('Y-m-d H:i:s')."\n";
	error_log($fileLog,3,$lckFilePath);
}

$updateQuery = "UPDATE bulk_message_history SET status = 1 WHERE batch_id = ".$batch_id;
$updateStatus = mysql_query($updateQuery);
	echo "Send SMS";
} else {
	echo "Numbers are not available";
}

}
}
}
else {
    echo "Files are not available";
}
mysql_close($dbConn);
?>