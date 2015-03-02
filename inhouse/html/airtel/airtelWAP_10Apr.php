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
	switch($serviceId)
	{
		case '1501':
			$db = "airtel_radio";
		       $sub = "tbl_radio_subscription";
			$srt_code = 546469;
			$cli = 'HMMUSC';
			$m_code = '54646';
			$msgQuery = mysql_query("select airtel_radio.getMESSAGE('".$msisdn."','EU_SUB') as msg");
				list($message) = mysql_fetch_array($msgQuery);

		break;
		case '1513':
			$db = "airtel_mnd";
		    	$sub = "tbl_character_subscription1";
			$srt_code = 5500196;
			$cli = 'HMLIFE';
			$m_code = '55001';
			$msgQuery = mysql_query("select airtel_mnd.getMESSAGE('".$msisdn."','SUB') as msg");
			list($message) = mysql_fetch_array($msgQuery);

		break;
    }
	//echo $db."-".$sub ;
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

	if($serviceId && (strlen($msisdn)==10 || strlen($msisdn)==12) && $planid) {
		if(strtoupper($response) == 'SUCCESS') 
			{
			
			$getQuery1="SELECT COUNT(1) FROM $db".'.'."$sub WHERE ANI=".$msisdn;
			$countData = mysql_query($getQuery1);
			list($allSub) = mysql_fetch_array($countData);
			if($allSub) {
				echo "Already Subscribed";
				$logData="#msisdn#".$msisdn."#planid#".$planid."#response#".$response."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#".$amount."#Already Subscribed#" .date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);
			} else {
				//$querySUB = "insert into airtel_radio.tbl_radio_subscription
                 		$querySUB = "insert into ". $db.".".$sub."
				(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle) values('".$msisdn."',now(), adddate(now(),1),'01',1, 'WAP',$srt_code, 0,null,'".$planid."','".$circle."');";
				mysql_query($querySUB);

				$billingQuery = "insert into master_db.tbl_billing_success values ('0','".$msisdn."','SUB',NOW(),'".$amount."',1,'30','".$amount."','NA','01','".$srt_code."','WAP','".$circle."','AIRM','".$serviceId."','0','".$planid."',NOW() ,'')";
				mysql_query($billingQuery);
				echo "Subscribed";
				
				
				$sndMsg = "call master_db.SENDSMS('".trim($msisdn)."','".$message."','".$cli."',3,'".$m_code."','sub');";
				mysql_query($sndMsg);

				$logData="#msisdn#".$msisdn."#planid#".$planid."#response#".$response."#mode#".$mode."#circle#".$circle."#serviceId#".$serviceId."#amount#" .$amount."#Subscribed#".$message."#".$sndMsg."#".date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logPath);		}
		} else{
				$failureQuery = "insert into master_db.tbl_billing_failure values ('0', '".$msisdn."', 'SUB', NOW(), '".$amount."', '1', '".$amount."', '".$amount."','','01','".$srt_code."','WAP','".$circle."','AIRM','".$serviceId."','','".$planid."',NOW(),'')";
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