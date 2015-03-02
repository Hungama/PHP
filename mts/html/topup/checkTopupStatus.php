<?php
$msisdn =$_REQUEST['msisdn'];
$mode = "OBD-MS";
$operator = "MTSM";

$test=trim($_REQUEST['test']);

function checkmsisdn($msisdn,$flag) {
	if(strlen($msisdn)==12 || strlen($msisdn)==10 ) {
		if(strlen($msisdn)==12) {
			if(substr($msisdn,0,2)==91) {
				$msisdn = substr($msisdn, -10);
			}
			else {
				if($flag==1) {
					echo "Failed";
				}
				exit;
			}
		}
	}
	elseif(strlen($msisdn)!=10) {
		if($flag==1) {
			echo "Failed";
		}
		exit;
	}
	return $msisdn;
}

$msisdn=checkmsisdn($msisdn,1);

$billingquery = "SELECT count(*) FROM master_db.tbl_billing_success nolock WHERE msisdn = '".$msisdn."' AND mode = '".$mode."' AND operator = '".$operator."'";
$result = mysql_query($billingquery);
list($count)=mysql_fetch_array($result);

if(!$count)
	echo "The number entered ".$msisdn." is currently not subscribed";
else
	echo "The number entered ".$msisdn." is currently subscribed";

mysql_close($dbConnInhouseM); 
?>