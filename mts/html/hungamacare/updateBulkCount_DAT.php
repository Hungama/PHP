<?php
include("config/dbConnect.php");
//$bulkQuery = "select id,batch_id,added_on,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for,file_name from billing_intermediate_db.bulk_upload_history where upload_for='deactive' order by id DESC limit 1";
$bulkQuery = "select id,batch_id,added_on,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for,file_name from billing_intermediate_db.bulk_upload_history where batch_id='7109'";


$bulkResult = mysql_query($bulkQuery);
while($row = mysql_fetch_array($bulkResult)) {
 $batchId = $row['batch_id'];
 $serviceId = $row['service_id'];
	$planId = $row['price_point'];
	$totalCount = $row['total_file_count'];
$file_name = $row['file_name'];
//echo 'bulkuploads/'.$serviceId.'/'.$file_name;
$readlines = file('bulkuploads/'.$serviceId.'/'.$file_name);
$allani= array();
foreach ($readlines as $line_num => $mobno)
{
$mno=trim($mobno);
$allani[$line_num]=$mno;
}
$totalno=count($allani);
echo "<br>";

		switch($serviceId) {
							case '1101':
							$select_db='mts_radio.tbl_radio_subscription';
							break;
							case '1102':
							$select_db='mts_hungama.tbl_jbox_subscription';
							break;
							case '1103':
							$select_db='mts_mtv.tbl_mtv_subscription';
							break;
							case '1106':
							$select_db='mts_starclub.tbl_jbox_subscription';
							break;
							case '1110':
							$select_db='mts_redfm.tbl_jbox_subscription';
							break;
							case '1111':
							$select_db='dm_radio.tbl_digi_subscription';
							break;
							case '1113':
							$select_db='mts_mnd.tbl_character_subscription1';
							break;
							case '1116':
							$select_db='mts_voicealert.tbl_voice_subscription';
							break;
								}
							//$msisdn='7428807572';
$total_sc=0;						
$total_fc=0;	
						for($i=0;$i<$totalno;$i++)
							{
							$select_query="select count(*) from ";
							$select_query.=$select_db." where ANI='$allani[$i]' ";
							$querySubscription = mysql_query($select_query);
			$result=mysql_fetch_array($querySubscription);
if($result[0])
{
$total_sc++;
}
else
{
$total_fc++;
}
							}
	echo $file_name."******Totalno ".$totalno."****Total success count is ".$total_sc ."****And failed count is".$total_fc."<br>";

	$updateQuery = "UPDATE billing_intermediate_db.bulk_upload_history SET status=2, success_count='".$total_sc."', failure_count='".$total_fc."' WHERE batch_id=".$batchId;	
echo $updateQuery."<br>";
//mysql_query($updateQuery);
	/*
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
	mysql_query($updateQuery);*/
}

//echo "done";
mysql_close($dbConn);
?>