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
		$sndMsgQuery = "CALL master_db.SENDSMS('".$number."','".$message."',";
		switch($service_id) {
			case 1502: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'54646','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'54646','bulk')";  	
				break;
			case 15071:	//VH1 NightPack
			case 1507: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'55841','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'55841','bulk')";  	
				break;
			case 1509: //Miss Riya
			case 1513: //My naughty diary		
			case 1504: //GL Store@1	
			case 1520: //Airtel Pallaturi Kathalu
			case 1511: if($uploadFor =='engagement') $sndMsgQuery .= "'HMLIFE',1,'55001','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'55001','bulk')"; 
				break; 
			case 1503: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'546461','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'546461','bulk')"; 					   
				break;
			case 1514: if($uploadFor =='engagement') $sndMsgQuery .= "'HMEDUT',2,'53222345','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'53222345','bulk')";					   
				break;
			case 1517: if($uploadFor =='engagement') $sndMsgQuery .= "'HMEDUT',4,'571811','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'571811','bulk')";					   
				break;
			case 1518: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'5464612','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'5464612','bulk')";
				break;
			case 15091: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'546469','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'546469','bulk')";
				break; //Miss Riya Toll Free on 54646169
			case 1501: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'54646169','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'54646169','bulk')";
				break;
			case 1515: if($uploadFor =='engagement') $sndMsgQuery .= "'HMDEVO',2,'51050','bulk')"; 
					   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'51050','bulk')"; //Airtel Devotional
				break;
		}
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

echo "Sent SMS";
} else {
echo "Numbers are not available!";
}
mysql_close($dbConn);

?>
