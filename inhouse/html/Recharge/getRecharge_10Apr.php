<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=trim($_REQUEST['msisdn']);
$chrgAmount=trim($_REQUEST['amount']);
$tId=trim($_REQUEST['tid']);
//$tId = date("HmyHis");
$logPath = "/var/www/html/Recharge/log/recharge_".date("Ymd").".txt";
if(is_numeric($msisdn) && (strlen($msisdn)==10 || strlen($msisdn)==12) && $chrgAmount!="" && $tId!="") {
	$query="insert into master_db.tbl_recharged(msisdn,amount,request_time,transactionId,status) values (".$msisdn.",'".$chrgAmount."',now(),'".$tId."',0)";
	mysql_query($query);
	$logData=$msisdn."#".$chrgAmount."#".$tId."#".date("Y-m-d H:i:s")."#".$query."\n";
	echo "Success: ".$tId;
	error_log($logData,3,$logPath);
} else {
	echo "Error in Parameter.";
}

mysql_close($dbConn);

?>