<?php
date_default_timezone_set("Asia/Calcutta");

include("config/dbConnect.php");

$fileQuery = "select batch_id,file_name,status,total_file_count,service_id from master_db.bulk_remove_history where status=0 ORDER BY batch_id LIMIT 1";
$fileData1 = mysql_query($fileQuery);
$fileData = mysql_fetch_array($fileData1);

$batch_id = $fileData['batch_id'];
$service_id = $fileData['service_id'];
$filename = $fileData['file_name'];
$filenameLck = $fileData['file_name'];

$file_to_read="http://10.2.73.156/kmis/services/hungamacare/bulkRuploads/".$service_id."/".$filename;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

if($batch_id && $file_size) {
$lckFilePath="/var/www/html/kmis/services/hungamacare/bulkRuploads/".$service_id."/log/".$filenameLck;
$flag=0;
for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	if(is_numeric($number)) {
		$totalMDN[] = $number;			
	} 
}

$planQuery = "SELECT plan_id,S_id FROM tbl_plan_bank WHERE sname='".$service_id."'";
$result = mysql_query($planQuery);
while($row = mysql_fetch_array($result)) {
	$planData[] = $row['plan_id'];
	$s_id = $row['S_id'];
}

$condition = "plan_id IN ('".implode("','",$planData)."') and service_id='".$s_id."'";

$deleteQuery = "DELETE FROM master_db.tbl_billing_failure WHERE msisdn IN ('".implode("','",$totalMDN)."') and ".$condition;
mysql_query($deleteQuery);

$logData=$deleteQuery." # ".date('Y-m-d H:i:s')."\n";
error_log($logData,3,$lckFilePath);

for($i=0;$i<count($totalMDN);$i++) {
	$ani = trim($totalMDN[$i]);
	$callProcedure = "CALL airtel_manchala.RIYA_UNSUB_PENDING('".$ani."','CC')";
	mysql_query($callProcedure);

	$logData=$callProcedure." # ".date('Y-m-d H:i:s')."\n";
	error_log($logData,3,$lckFilePath);
}

$updateQuery = "UPDATE master_db.bulk_remove_history SET status = 1, process_time=NOW() WHERE batch_id = ".$batch_id;
$updateStatus = mysql_query($updateQuery);


echo "Failure Data Remove";
} else {
echo "Files are not available!";
}
mysql_close($dbConn);

?>
