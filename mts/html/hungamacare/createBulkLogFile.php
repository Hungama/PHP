<?php
include("config/dbConnect.php");

$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,file_name FROM billing_intermediate_db.bulk_upload_history WHERE status=2 and upload_for IN ('active') and date(added_on)>='2012-11-23' order by added_on limit 1";

$bulkResult = mysql_query($bulkQuery,$dbConn);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$serviceId = $row['service_id'];
	$planId = $row['price_point'];
	$filename = $row['file_name'];

	$logPath="/var/www/html/hungamacare/bulkuploads/".$serviceId."/log/".$filename;

	$succQuery = "select msisdn,chrg_amount,MODE from master_db.tbl_billing_success nolock where subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."' ";
	$result1= mysql_query($succQuery,$dbConn);
	while($row = mysql_fetch_array($result1)) {
		$logData = $row['msisdn'].",".$row['chrg_amount'].",".$row['MODE'].",SUCCESS\n";
		error_log($logData,3,$logPath);
	}

	$failQuery = "select msisdn,res_text,MODE from master_db.tbl_billing_failure nolock where subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."' ";
	$result2= mysql_query($failQuery,$dbConn);
	while($row2 = mysql_fetch_array($result2)) {
		$logData = $row2['msisdn'].",".$row2['res_text'].",".$row2['MODE'].",FAIL\n";
		error_log($logData,3,$logPath);
	}
	
	$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET status=3 WHERE batch_id=".$batchId;	
	mysql_query($updateQuery,$dbConn);
}
echo "done";
mysql_close($dbConn);
?>
