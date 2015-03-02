<?php
error_reporting(1);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");

$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on FROM master_db.bulk_rbt_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and status in(1,2) order by batch_id DESC limit 30";
$bulkResult = mysql_query($bulkQuery,$dbConn_224);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$service_id = $row['service_id'];
	$added_on = $row['added_on'];
	$flag=1;
if($flag)
	{
$totalStatusQuery = "select 'Success' as type,count(*) as total from master_db.tbl_billing_success  where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Failure' as type, count(*) as total from master_db.tbl_billing_failure  where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Request' as type, count(*) as total from master_db.tbl_billing_reqs  where subservice_id='".$batchId."' 
and service_id='".$service_id."'";

	
	$statusResult = mysql_query($totalStatusQuery,$dbConn_224);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}

	if($status['Request'] == 0) {
		$updateQuery = "UPDATE master_db.bulk_rbt_history SET status=2, success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	} else {
		$updateQuery = "UPDATE master_db.bulk_rbt_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	}
	mysql_query($updateQuery,$dbConn_224);
	$type='';
	}
}

//update bulk count for event_active

$bulkQuery_eventactive = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on FROM master_db.bulk_upload_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and status in(1,2) and upload_for='event_active' order by batch_id DESC limit 30";
$bulkResult = mysql_query($bulkQuery_eventactive,$dbConn_224);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$service_id = $row['service_id'];
	$added_on = $row['added_on'];
	$flag=1;
if($flag)
	{
$totalStatusQuery = "select 'Success' as type,count(*) as total from master_db.tbl_billing_success  where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Failure' as type, count(*) as total from master_db.tbl_billing_failure  where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Request' as type, count(*) as total from master_db.tbl_billing_reqs  where subservice_id='".$batchId."' 
and service_id='".$service_id."'";

	
	$statusResult = mysql_query($totalStatusQuery,$dbConn_224);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}

	if($status['Request'] == 0) {
		$updateQuery = "UPDATE master_db.bulk_upload_history SET status=2, success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	} else {
		$updateQuery = "UPDATE master_db.bulk_upload_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	}
	mysql_query($updateQuery,$dbConn_224);
	$type='';
	}
}

echo "done";
mysql_close($dbConn_224);
?>