<?php
error_reporting(0);
include ("dbConnect.php");
//$dbConnVoda = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123');
$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on FROM vodafone_hungama.bulk_upload_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and status in(1) and upload_for IN ('active') order by batch_id ASC";
$dbConnVoda=$dbConn;
$bulkResult = mysql_query($bulkQuery,$dbConnVoda);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$added_on = $row['added_on'];
	//$serviceId = $row['service_id'];
	//$planId = $row['price_point'];
	
/*	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'
	UNION 
	SELECT 'Request' as type, count(*) as total FROM master_db.tbl_billing_reqs WHERE subservice_id='".$batchId."' and service_id='".$serviceId."' and plan_id='".$planId."'";
	*/
	
	
echo $totalStatusQuery = "select 'Success' as type,count(*) as total from master_db.bulk_upload_status a,master_db.tbl_billing_success b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id and a.plan_id=b.plan_id and b.event_type='SUB' and a.msisdn=b.msisdn
union
select 'Failure' as type, count(*) as total from master_db.bulk_upload_status a,master_db.tbl_billing_failure b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id and a.plan_id=b.plan_id and b.event_type='SUB' and a.msisdn=b.msisdn
union
select 'Request' as type, count(*) as total from master_db.bulk_upload_status a,master_db.tbl_billing_reqs b  where  a.batch_id='".$batchId."' 
and b.service_id=a.service_id and a.plan_id=b.plan_id and b.event_type='SUB' and a.msisdn=b.msisdn";
	

	
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
