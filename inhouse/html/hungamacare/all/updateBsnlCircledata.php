<?php
error_reporting(1);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
$date=$_REQUEST['date'];
//$date='2014-09-02';
echo "Start at".date('Y-m-d H:i:s');
$bulkQuery = "SELECT distinct msisdn from mis_db.tbl_bsnl_54646_calllog where date(call_date)='".$date."'";
$bulkResult = mysql_query($bulkQuery,$dbConn_224);
while($row = mysql_fetch_array($bulkResult)) {
	$msisdn = $row['msisdn'];	
	$getCircle = "select master_db.getCircleBSNL(".trim($msisdn).") as circle";
	$circle=mysql_query($getCircle,$dbConn_224);
	$circleRow = mysql_fetch_row($circle);
	$cid=strtolower($circleRow[0]);
	if($cid=='')
	$cid='oth';
	
	echo $updateQuery = "UPDATE mis_db.tbl_bsnl_54646_calllog SET circle='".$cid."'  WHERE msisdn=".$msisdn;
	mysql_query($updateQuery,$dbConn_224);
	}
echo "End at".date('Y-m-d H:i:s');
echo "done";
mysql_close($dbConn_224);
?>
