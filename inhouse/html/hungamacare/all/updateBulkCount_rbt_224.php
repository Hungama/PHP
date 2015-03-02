<?php
error_reporting(0);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on FROM master_db.bulk_rbt_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 2 DAY))) and status in(1) order by batch_id ASC";
$bulkResult = mysql_query($bulkQuery,$dbConn_224);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$added_on = $row['added_on'];
	//$serviceId = $row['service_id'];
	//$planId = $row['price_point'];
	
    $totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success WHERE subservice_id='".$batchId."'
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure WHERE subservice_id='".$batchId."'
	UNION 
	SELECT 'Request' as type, count(*) as total FROM master_db.tbl_billing_reqs WHERE subservice_id='".$batchId."' ";
	
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
	echo $updateQuery;
	echo "<br>";
	mysql_query($updateQuery,$dbConn_224);
	$type='';
}

echo "done";
mysql_close($dbConn_224);
?>