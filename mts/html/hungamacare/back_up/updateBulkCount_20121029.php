<?php
include("config/dbConnect.php");

//echo $bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM billing_intermediate_db.bulk_upload_history WHERE added_on between DATE_SUB(now(), INTERVAL 6 HOUR) and now() and status=1 and upload_for IN ('active','renewal') ";

$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM billing_intermediate_db.bulk_upload_history WHERE date(added_on)>='2012-10-18' and status=1 and upload_for IN ('active','renewal') limit 10";

$bulkResult = mysql_query($bulkQuery);
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

	$statusResult = mysql_query($totalStatusQuery);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}

	if($status['Request'] == 0) {
		$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET status=2, success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	} else {
		$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	}
	//echo "<br>".$updateQuery;
	mysql_query($updateQuery);
}

echo "done";
mysql_close($dbConn);
?>
