<?php
include("config/dbConnect.php");
$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,file_name,channel,amount 
FROM billing_intermediate_db.bulk_upload_history nolock WHERE date(added_on)='".$view_date."' and status=2 
and upload_for='event_unsub' order by batch_id DESC";

/*$bulkQuery = "SELECT batch_id,service_id,price_point,total_file_count,file_name,channel,amount 
FROM billing_intermediate_db.bulk_upload_history nolock WHERE date(added_on)='".$view_date."' 
and upload_for='event_unsub' and batch_id in(21116,21117,21118,21119,21120) order by batch_id DESC";
*/
$bulkResult = mysql_query($bulkQuery,$dbConn);
$CheckStatusProcedure="Mts_tmp.BULK_STATUS";
while($row = mysql_fetch_array($bulkResult)) {
	$batchId = $row['batch_id'];
	$serviceId = $row['service_id'];
	$planId = $row['price_point'];
	$totalCount = $row['total_file_count'];
	$file_name = $row['file_name'];
	$channel = $row['channel'];
	$amount = $row['amount'];
	$file_to_read="http://10.130.14.107/hungamacare/bulkuploads/".$serviceId."/".$file_name;
		$file_data=file($file_to_read);
		$file_size=sizeof($file_data);
		for($i=0;$i<$file_size;$i++)
		{
	$msisdn=trim($file_data[$i]);
	$call = "call " . $CheckStatusProcedure . "('$msisdn',$serviceId,$planId,'$channel','$amount','$batchId')";
	mysql_query($call,$dbConn);
	}
sleep(3);
}
echo "done";
mysql_close($dbConn);
?>
