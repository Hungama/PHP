<?php
error_reporting(0);
include ("dbConnect.php");
//$dbConnVoda = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123');
//$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM airtel_hungama.bulk_upload_history WHERE added_on>='2013-01-02 14:00:00' and status=1 and upload_for IN ('active') order by batch_id ASC";
//$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM airtel_hungama.bulk_upload_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and status in(1,2,3) and upload_for IN ('active') order by batch_id ASC";

$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM vodafone_hungama.bulk_upload_history WHERE status in(1,2,3) and upload_for IN ('active') order by batch_id ASC";

$dbConnVoda=$dbConn;

$bulkResult = mysql_query($bulkQuery,$dbConnVoda);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$serviceId = $row['service_id'];
	$planId = $row['price_point'];
	$totalCount = $row['total_file_count'];

	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'
	UNION 
	SELECT 'Request' as type, count(*) as total FROM master_db.tbl_billing_reqs WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'";
	
	$statusResult = mysql_query($totalStatusQuery,$dbConnVoda);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}

	if($status['Request'] == 0) {
		$updateQuery = "UPDATE vodafone_hungama.bulk_upload_history SET status=2, success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	} else {
		$updateQuery = "UPDATE vodafone_hungama.bulk_upload_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	}
	
	mysql_query($updateQuery,$dbConnVoda);
	$type='';
}

echo "done";
mysql_close($dbConnVoda);
?>
