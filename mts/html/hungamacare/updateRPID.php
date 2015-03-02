<?php
include("config/dbConnect.php");
$bulkQuery = "SELECT ANI,plan_id,RPID FROM dm_radio.tbl_digi_subscription nolock WHERE status=1 and RPID=0 order by sub_date asc";
$bulkResult = mysql_query($bulkQuery,$dbConn);
$num=mysql_num_rows($bulkResult);
if($num>=1)
{
while($row = mysql_fetch_array($bulkResult)) {
	$ani = $row['ANI'];
	$planId = $row['plan_id'];
	
	$succQuery = "select msisdn,RPID from master_db.tbl_billing_success nolock where msisdn='".$ani."' and service_id=1111 and plan_id='".$planId."' order by response_time desc limit 1";
	$result1= mysql_query($succQuery,$dbConn);
	$num=mysql_num_rows($result1);
	if($num)
	{
		list($msisdn,$RPID) = mysql_fetch_array($result1); 
	}
	else
	{
		$succQuery = "select msisdn,RPID from master_db.tbl_billing_success_backup nolock where msisdn='".$ani."' and service_id=1111 and plan_id='".$planId."' order by response_time desc limit 1";
		$result1= mysql_query($succQuery,$dbConn);
		$num=mysql_num_rows($result1);
		if($num)
		{
		list($msisdn,$RPID) = mysql_fetch_array($result1); 
		}
	}
	//echo $msisdn."#".$RPID."<br>";
		$updateQuery = "UPDATE dm_radio.tbl_digi_subscription SET RPID='".$RPID."' WHERE ANI=".$msisdn;	
		mysql_query($updateQuery,$dbConn);
}
echo "done";
}
else
{
echo "No BatchId Found";
}
mysql_close($dbConn);
?>