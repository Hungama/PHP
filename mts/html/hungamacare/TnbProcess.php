<?php
error_reporting(0);
ob_start();
session_start();
include("config/dbConnect.php");

$query = "SELECT batch_Id,file_name, tnbMode, tnbDays, planId, service_id FROM master_db.bulk_tnb_history  WHERE status=0 LIMIT 1";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$serviceId = $row['service_id'];
	$filename = $row['file_name'];
	$tnbMode = $row['tnbMode'];
	$tnbDays = $row['tnbDays'];
	$planId = $row['planId'];
	$batchId = $row['batch_Id'];
	$newMode = $row['tnbMode']."-".$row['tnbDays'];
}

$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planId;
$qryAmount = mysql_query($selAmount);
list($getAmount) = mysql_fetch_array($qryAmount);

switch($serviceId) {
	case '1101' : $subProcedure = "mts_radio.RADIO_SUB";
				  $dnis='52222';
			break;
	case '1111' : $subProcedure = "dm_radio.DIGI_SUB";
				  $dnis='5432105';	
			break;
	case '1116' : $subProcedure = "mts_voicealert.VOICE_SUB";
				  $dnis='54444';
			break;
}

$logPath = "/var/www/html/hungamacare/tnbUpload/".$serviceId."/log/".$filename."_log_".date("Y-m-d").".txt";

$file_to_read="http://10.130.14.107/hungamacare/tnbUpload/".$serviceId."/".$filename.".txt";
$file_data=file($file_to_read);
$file_size=sizeof($file_data);

for($i=0; $i<$file_size; $i++) {
	$number = trim($file_data[$i]);
	$qry = "CALL ".$subProcedure."('".$number."','01','".$newMode."','".$dnis."','".$getAmount."',".$serviceId.",'".$planId."')";
	mysql_query($qry);
	$logData=$number."#".$qry."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}

mysql_query("UPDATE master_db.bulk_tnb_history SET status=1 WHERE batch_id=".$batchId);

mysql_close($dbConn);
echo "Done";
?>