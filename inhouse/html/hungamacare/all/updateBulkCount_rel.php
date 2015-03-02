<?php
error_reporting(1);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on,upload_for FROM master_db.bulk_upload_history WHERE date(added_on) in (date(now()),date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and status in(1,2) and upload_for IN ('active','topup','event') and batch_id!='27584' order by batch_id DESC limit 30";
//$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,date(added_on) as added_on,upload_for FROM master_db.bulk_upload_history WHERE upload_for IN ('active','topup','event') and batch_id in('34963','34964','34965') order by batch_id DESC";
$bulkResult = mysql_query($bulkQuery,$dbConn_224);
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$added_on = $row['added_on'];
	$service_id=$row['service_id'];
	$upload_for = $row['upload_for'];
	if($upload_for=='active')
	{
	$event_type='SUB';
	}
	else if($upload_for=='event' || $upload_for=='topup')
	{
	$event_type='EVENT';
	$sqlwhere="and date(b.date_time)='".$added_on."'";
	}	
	else
	{
	$event_type='TOPUP';
	}
	
	//check for bulk_upload_data_base & bulk_upload_data table for this batch_id
$check_data_base=mysql_query("select count(*) from master_db.bulk_upload_data_base where batch_id='".$batchId."'",$dbConn_224);
$bulk_upload_data_base=mysql_fetch_array($check_data_base);
$check_data=mysql_query("select count(*) from master_db.bulk_upload_data where batch_id='".$batchId."'",$dbConn_224);
$bulk_upload_data=mysql_fetch_array($check_data);
$flag=0;
	if($bulk_upload_data_base[0]!=0)
	{
	$stable='master_db.bulk_upload_data_base';
	$flag=1;
	}
	else if($bulk_upload_data[0]!=0)
	{
	$stable='master_db.bulk_upload_data';
	$flag=1;
	}
	else
	{
	echo 'No data';
//	mysql_close($dbConn_224);
	//exit;
	}
	if($upload_for=='event')
	$flag=1;
	
	if($flag)
	{
	
	if($upload_for=='event')
	{
	$totalStatusQuery = "select 'Success' as type,count(*) as total from master_db.tbl_billing_success   where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Failure' as type, count(*) as total from master_db.tbl_billing_failure  where subservice_id='".$batchId."' 
and service_id='".$service_id."'
union
select 'Request' as type, count(*) as total from master_db.tbl_billing_reqs where  subservice_id='".$batchId."' 
and service_id='".$service_id."'";
	}
	else
	{
$totalStatusQuery = "select 'Success' as type,count(*) as total from $stable a,master_db.tbl_billing_success b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and b.event_type='".$event_type."' and a.msisdn=b.msisdn $sqlwhere
union
select 'Failure' as type, count(*) as total from $stable a,master_db.tbl_billing_failure b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and b.event_type='".$event_type."' and a.msisdn=b.msisdn $sqlwhere
union
select 'Request' as type, count(*) as total from $stable a,master_db.tbl_billing_reqs b  where  a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and b.event_type='".$event_type."' and a.msisdn=b.msisdn $sqlwhere ";
}
/*$totalStatusQuery = "select 'Success' as type,count(*) as total from $stable a,master_db.tbl_billing_success b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and a.msisdn=b.msisdn
union
select 'Failure' as type, count(*) as total from $stable a,master_db.tbl_billing_failure b  where a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and a.msisdn=b.msisdn
union
select 'Request' as type, count(*) as total from $stable a,master_db.tbl_billing_reqs b  where  a.batch_id='".$batchId."' 
and b.service_id=a.service_id  and a.msisdn=b.msisdn";
*/
	
//echo $totalStatusQuery;
//echo "<br>";
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
	
//	$updateQuery = "UPDATE master_db.bulk_upload_history SET success_count='".$status['Success']."', failure_count='".$status['Failure']."', InRequest='".$status['Request']."'  WHERE batch_id=".$batchId;	
	//echo $updateQuery;
	mysql_query($updateQuery,$dbConn_224);
	$type='';
	}
}

echo "done";
mysql_close($dbConn_224);
?>
