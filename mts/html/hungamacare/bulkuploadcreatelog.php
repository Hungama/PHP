<?php
error_reporting(1);
include("config/dbConnect.php");
$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fetchHistoryfromTable="SELECT batch_id,service_id,total_file_count,file_name,amount,channel FROM billing_intermediate_db.bulk_upload_history 
WHERE status=2 and upload_for IN ('event_unsub') and date(added_on)='".$view_date."'";
/*
$fetchHistoryfromTable="SELECT batch_id,service_id,total_file_count,file_name,amount,channel FROM billing_intermediate_db.bulk_upload_history nolock
WHERE status in(2,3) and upload_for IN ('event_unsub') and date(added_on)='".$view_date."'";
*/
$executeQueryGethistory=mysql_query($fetchHistoryfromTable,$dbConn);
while($rows=mysql_fetch_array($executeQueryGethistory))
{
echo $batchId."<br>";
	$batchId = $rows['batch_id'];
	$serviceId = $rows['service_id'];
	$amount = $rows['amount'];
	$file_name = $rows['file_name'];
	$mode=$rows['channel'];
	
	$dirPath="/var/www/html/hungamacare/bulkuploads/".$serviceId."/log/";
	unlink($dirPath);
	$queryGetData="select msisdn,amount,mode,status from Mts_tmp.tbl_bulkupload_status nolock where batch_id='".$batchId."'";
	$executeQueryGetData=mysql_query($queryGetData,$dbConn);
	$isData=mysql_num_rows($executeQueryGetData);

if($isData>0)
	{
		$filePath=$dirPath.$rows['file_name'];
		while($rows1=mysql_fetch_array($executeQueryGetData))
		{
		 $LogString=$rows1[0].','.$rows1[1].','.$rows1[2].','.$rows1[3]."\n";
		error_log($LogString,3,$filePath);
		}
	$updayeHistory="update billing_intermediate_db.bulk_upload_history set status=3 where batch_id='".$batchId."'";
	$executeQueryUpdateHistory=mysql_query($updayeHistory,$dbConn);

	}
	
sleep(2);
}
$deleteData="delete from Mts_tmp.tbl_bulkupload_status WHERE date(added_on) < DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
//$executeDeleteQuery=mysql_query($deleteData,$dbConn);

mysql_close($dbConn);
echo "done";
?>
