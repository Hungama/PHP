<?php
error_reporting(0);

$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$response=$_REQUEST['response'];
$mode='WAP';

$logPath = "/var/www/html/airtel/logs/airtelEU/log_".date("Y-m-d").".txt";

$query=mysql_query("SELECT s_id,iamount from master_db.tbl_plan_bank where plan_id=".$planid);
list($serviceId,$amount) = mysql_fetch_array($query);


$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
$circle1=mysql_query($getCircle) or die( mysql_error() );
while($row = mysql_fetch_array($circle1)) {
	$circle = $row['circle'];
}
if(!$circle) { $circle='UND'; }

if($serviceId && (strlen($msisdn)==10 || strlen($msisdn)==12) && $planid) {
	if(strtoupper($response) == 'SUCCESS') {
		$querySUB = "insert into airtel_radio.tbl_radio_subscription(ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle) values('".$msisdn."',now(),now(),'01',0,'WAP','546469',0,null,'".$planid."','".$circle."');";
		mysql_query($querySUB);
		$billingQuery = "insert into master_db.tbl_billing_success values ('0','".$msisdn."','SUB',NOW(),'".$amount."',1,'30','".$amount."','','01','546469','WAP','".$circle."','AIRM','".$serviceId."','0','".$planid."',NOW() ,'')";
		mysql_query($billingQuery);
	} elseif(strtoupper($response) == 'FAILURE') {
		$failureQuery = "insert into master_db.tbl_billing_failure values ('0', '".$msisdn."', 'SUB', NOW(), '".$amount."', '1', '".$amount."', '".$amount."','','01','546469','WAP','".$circle."','AIRM','".$serviceId."','','".$planid."',NOW(),'')";
		mysql_query($failureQuery);
	}

}

mysql_close($dbConn); 
?>   