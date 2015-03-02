<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=trim($_REQUEST['msisdn']);
$chrgAmount=trim($_REQUEST['amount']);
$operator=strtolower(trim($_REQUEST['operator']));
$tId=trim($_REQUEST['tid']);
//$tId = date("HmyHis");
switch($operator)
{
	case 'aircel':
		$oid=16;
	break;
	case 'airtel':
		$oid=1;
	break;
	case 'loop':
		$oid=3;
	break;
	case 'bsnl':
		$oid=4;
	break;
	case 'vodafone':
		$oid=9;
	break;
	case 'idea':
		$oid=10;
	break;
	case 'mtnl':
		$oid=12;
	break;
	case 'mts':
		$oid=20;
	break;
	case 'reliance':
		$oid=14;
	break;
	case 'reliancecdma':
		$oid=15;
	break;
	case 'tataindicom':
		$oid=18;
	break;
	case 'tatadocomo':
		$oid=19;
	break;
	case 'uninor':
		$oid=21;
	break;
	case 'tatadocomovmi':
		$oid=24;
	break;
	
}
$logPath = "/var/www/html/Recharge/log/recharge_".date("Ymd").".txt";
if(is_numeric($msisdn) && (strlen($msisdn)==10 || strlen($msisdn)==12) && $chrgAmount!="" && $tId!="") {
	//$msisdn=int($msisdn);
	$query="insert into master_db.tbl_recharged(msisdn,amount,request_time,transactionId,status,operator_id) values (".$msisdn.",'".$chrgAmount."',now(),'".$tId."',0,$oid)";
	mysql_query($query);
	$logData=$msisdn."#".$chrgAmount."#".$tId."#".date("Y-m-d H:i:s")."#".$query."\n";
	echo "Success: ".$tId;
	error_log($logData,3,$logPath);
} else {
	echo "Error in Parameter.";
}

mysql_close($dbConn);

?>
