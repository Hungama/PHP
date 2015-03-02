<?php
include("config/dbConnect.php");
//$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM billing_intermediate_db.bulk_upload_history WHERE date(added_on)>='2012-11-01' and status=1 and upload_for IN ('active','renewal','event_active')";
$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count FROM billing_intermediate_db.bulk_upload_history nolock WHERE date(added_on)>='2012-11-01' and status in(1,2) and upload_for IN ('active','renewal','event_active','event_unsub','act_tnb') order by batch_id desc limit 50";
$bulkResult = mysql_query($bulkQuery,$dbConn);
//echo mysql_num_rows($bulkResult);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$serviceId = $row['service_id'];
	$planId = $row['price_point'];
	$totalCount = $row['total_file_count'];

	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success nolock WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure nolock WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'
	UNION 
	SELECT 'Request' as type, count(*) as total FROM master_db.tbl_billing_reqs nolock WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'";
//echo $totalStatusQuery;
	$statusResult = mysql_query($totalStatusQuery,$dbConn);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}

	if($status['Request'] == 0) {
		$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET status=2, success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	} else {
		$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	}
//	echo $updateQuery;
	//echo "<br>";
	mysql_query($updateQuery,$dbConn);
}

echo "done";
mysql_close($dbConn);
?>
