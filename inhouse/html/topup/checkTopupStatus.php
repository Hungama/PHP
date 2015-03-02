<?php
$msisdn =$_REQUEST['msisdn']; 
$mode = "OBD-MS"; 
//$op = trim($_REQUEST['operator']);
$operator = strtoupper($_REQUEST['operator']);
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

switch($operator) {
	case 'RELC': $fullOpName = "Reliance";
		break;
	case 'TATC': $fullOpName = "Tata Indicom";
		break;
	case 'TATM': $fullOpName = "Docomo";
		break;
	case 'UNIM': $fullOpName = "Uninor";
		break;
}

$msisdn=checkmsisdn($msisdn,1);
$con = mysql_connect("database.master","weburl","weburl");
if(!$con) {
	die('We are facing some temporarily Problem , please try later : ');
}

$billingquery = "SELECT count(*) FROM master_db.tbl_billing_success nolock WHERE msisdn = '".$msisdn."' AND operator = '".$operator."' AND mode = '".$mode."'";
$result = mysql_query($billingquery); 
list($count)=mysql_fetch_array($result);

if(!$count)
	echo "The number entered ".$msisdn." is currently not subscribed for ".$fullOpName." operator";
else
	echo "The number entered ".$msisdn." is currently subscribed for ".$fullOpName." operator";

mysql_close($con);
?>