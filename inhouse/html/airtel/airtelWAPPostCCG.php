<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$amnt=intval($_REQUEST['amnt']);
$response=$_REQUEST['response'];
$trxid=$_REQUEST['trxid'];
$contentid=$_REQUEST['contentid'];
$deviceUA=$_REQUEST['UA'];
$serviceid=$_REQUEST['serviceid'];
$AFFID=$_REQUEST['AFFID'];

if($AFFID=='null' || $AFFID=='')
$AFFID = 0; 

if(isset($_REQUEST['serviceid'])) { 
	$serviceid=$_REQUEST['serviceid'];
} else {
	$serviceid=1527;
}

$mode='WAP';
$logPath = "/var/www/html/airtel/log/airtelWAP/logPostCCG_".date("Y-m-d").".txt";
 
switch($serviceid)
	{
	case '1528':
			$db = "airtel_devo";
			$sub = "Airtel_DEVO_WAP_billing";
			$srt_code = 55001;
			$cli = 'HMLIFE';
			$m_code = '55001';
		break;
	case '1527':
			$db = "airtel_rasoi";
			$sub = "Airtel_LDR_WAP_billing";
			$srt_code = 55001;
			$cli = 'HMLIFE';
			$m_code = '55001';
		break;
	default:
			$db = "airtel_rasoi";
			$sub = "Airtel_LDR_WAP_billing";
			$srt_code = 55001;
			$cli = 'HMLIFE';
			$m_code = '55001';
		break;
   }
//(IN_MSISDN VARCHAR(16),IN IN_EVENTTYPE VARCHAR(15),IN IN_CRGAMNT VARCHAR(100),IN IN_PREPOST VARCHAR(20),IN IN_ISID INT,    IN IN_PID INT,IN IN_MOD VARCHAR(20),IN IN_VALIDITY INT,IN IN_DOWNLOAD INT,IN IN_DATE_TIME DATETIME,IN IN_TRANSID VARCHAR(50))
	
$querySUB = "CALL $db.$sub('".$msisdn."','SUB',";
$querySUB .= "'".$amnt."','','".$serviceid."','','WAP','','',now(),'')";			

	if(mysql_query($querySUB,$dbConn212))
	{
	$res='SUCCESS';
	$error='OK';
	}
	else
	{
	$res='FAILURE';
	$error=mysql_error();
	}
	//echo $res;
	$logData=$msisdn."#".$planid."#".$res."#".$error."#WAP"."#".$serviceid."#".$amnt."#" .$querySUB."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);			
mysql_close($dbConn212); 
?>