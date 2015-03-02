<?php
date_default_timezone_set("Asia/Calcutta");
include("config/dbConnect.php");
//$getBatchId="select batch_id from master_db.bulk_message_history nolock where status=0 and  schedule_date<=now() and date(schedule_date)=date(now()) ORDER BY batch_id LIMIT 10";
$getBatchId="select batch_id from master_db.bulk_message_history nolock where status=0 ORDER BY batch_id LIMIT 10";
$result_id=mysql_query($getBatchId,$dbConn);
$BatchList=array();
while(list($id)=mysql_fetch_array($result_id))
{
$BatchList[]=$id;
$batchidPicked="update master_db.bulk_message_history set status=1 where batch_id=".$id;
mysql_query($batchidPicked,$dbConn);
}
$totalcount=count($BatchList);

if($totalcount>=1)
{
$allIds = implode(",", $BatchList);
$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, b.upload_for, m.msg_id, m.message,b.scrubingStatus 
FROM bulk_message_history b INNER JOIN tbl_message_data m ON m.msg_id = b.msg_id WHERE b.batch_id in($allIds) ORDER BY b.batch_id";

//$smsFileQuery = "SELECT b.batch_id, b.service_id, b.file_name, b.upload_for, m.msg_id, m.message,b.scrubingStatus FROM bulk_message_history b INNER JOIN tbl_message_data m ON m.msg_id = b.msg_id WHERE status = 0 ORDER BY batch_id limit 2";
$fileData1 = mysql_query($smsFileQuery);

while($fileData = mysql_fetch_array($fileData1)) {
	$batch_id = $fileData['batch_id'];
	$service_id = $fileData['service_id'];
	$message = trim($fileData['message']);
	$msg_id = $fileData['msg_id'];
	$filename = $fileData['file_name'].".txt";
	$filenameLck = $fileData['file_name']."_log.txt";
	$uploadFor = $fileData['upload_for'];
	$msgFlag = $fileData['scrubingStatus'];
	$msgFlag='promo';

	$updateQuery_before = "UPDATE bulk_message_history SET status = 1, process_time=NOW() WHERE batch_id = ".$batch_id;
	$updateStatus_before = mysql_query($updateQuery_before); 


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
				case 1502: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'54646','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'54646','".$msgFlag."')";  	
					break;
				case 15071:	//VH1 NightPack
				case 1507: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'55841','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'55841','".$msgFlag."')";  	
					break;
				case 1509: //Miss Riya
				case 1513: //My naughty diary		
				case 1504: //GL Store@1	
				case 1520: //Airtel Pallaturi Kathalu
				case 15211: // Astro SMS Pack
				case 15212: // SexEducation SMS Pack
				case 15213: // Vastu SMS Pack
				case 1511: //Airtel GUD Life
							if($uploadFor =='engagement') $sndMsgQuery .= "'HMLIFE',1,'55001','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'55001','".$msgFlag."')"; 
					break; 
				case 1503: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'546461','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'546461','".$msgFlag."')"; 					   
					break;
				case 1514: if($uploadFor =='engagement') $sndMsgQuery .= "'HMEDUT',2,'53222345','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'53222345','".$msgFlag."')";					   
					break;
				case 1517: if($uploadFor =='engagement') $sndMsgQuery .= "'HMEDUT',4,'571811','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'571811','".$msgFlag."')";					   
					break;
				case 1518: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'5464612','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'5464612','".$msgFlag."')";
					break;
				case 15091: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'546469','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'546469','".$msgFlag."')";
					break; //Miss Riya Toll Free on 54646169
				case 1501: if($uploadFor =='engagement') $sndMsgQuery .= "'HMMUSC',1,'54646169','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'54646169','".$msgFlag."')";
					break;
				case 1515: if($uploadFor =='engagement') $sndMsgQuery .= "'HMDEVO',2,'51050','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'51050','".$msgFlag."')"; //Airtel Devotional
					break;
				case 1523: if($uploadFor =='engagement') $sndMsgQuery .= "'HMLIFE',2,'5500181','promo')"; 
						   elseif($uploadFor =='promotion') $sndMsgQuery .= "'601666',0,'5500181','".$msgFlag."')"; //Airtel Tintu Mon
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
}
}
else
{
echo "No Records Found";
}
mysql_close($dbConn);
?>