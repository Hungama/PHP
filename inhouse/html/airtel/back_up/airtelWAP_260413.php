<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
error_reporting(1);

$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$response=$_REQUEST['response'];
$mode='WAP';

$logPath = "/var/www/html/airtel/log/airtelWAP/log_".date("Y-m-d").".txt";

if($msisdn) { 
	$query=mysql_query("SELECT s_id,iamount from master_db.tbl_plan_bank where plan_id=".$planid);
	list($serviceId,$amount) = mysql_fetch_array($query);

	//echo $serviceId.",".$amount;

	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

	if($serviceId && (strlen($msisdn)==10 || strlen($msisdn)==12) && $planid) {
		if(strtoupper($response) == 'SUCCESS') 
			{
			
			
			$countData = mysql_query("SELECT COUNT(1) FROM airtel_radio.tbl_radio_subscription WHERE ANI=".$msisdn);
			list($allSub) = mysql_fetch_array($countData);
			if($allSub) {
				echo "Already Subscribed";
				$logData="#msisdn#".$msisdn."#planid#".$planid."#response#".$response."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#Already Subscribed#" .date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
			} else {
				$querySUB = "insert into airtel_radio.tbl_radio_subscription (ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle) values('".$msisdn."',now(), adddate(now(),1),'01',1, 'WAP','546469', 0,null,'".$planid."','".$circle."');";
				mysql_query($querySUB);
				$billingQuery = "insert into master_db.tbl_billing_success values ('0','".$msisdn."','SUB',NOW(),'".$amount."',1,'30','".$amount."','NA','01','546469','WAP','".$circle."','AIRM','".$serviceId."','0','".$planid."',NOW() ,'')";
				mysql_query($billingQuery);
				echo "Subscribed";
				
				$msgQuery = mysql_query("select airtel_radio.getMESSAGE('".$msisdn."','EU_SUB') as msg");
				list($message) = mysql_fetch_array($msgQuery);

				$sndMsg = "call master_db.SENDSMS('".trim($msisdn)."','".$message."','HMMUSC',3,'54646','sub');";
				mysql_query($sndMsg);

				$logData="#msisdn#".$msisdn."#planid#".$planid."#response#".$response."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#" .$amount."#Subscribed#".$message."#".$sndMsg."#".date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);		}
		} else{
				$failureQuery = "insert into master_db.tbl_billing_failure values ('0', '".$msisdn."', 'SUB', NOW(), '".$amount."', '1', '".$amount."', '".$amount."','','01','546469','WAP','".$circle."','AIRM','".$serviceId."','','".$planid."',NOW(),'')";
				mysql_query($failureQuery);
				echo "Failure";
				$logData="#msisdn#".$msisdn."#planid#".$planid."#response#".$response."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount. "#Failure#" .date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
		}
	} else {
		$logData=$msisdn."#".$planid."#".$response."#Invalid Parameter#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);	
	}
} else {
	$logData="MDN NOT FOUND#planid:".$planid."#response:".$response."#Invalid Parameter#" .date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
mysql_close($dbConn); 
?>   