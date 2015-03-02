<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode="PROMO";
$planid=6;
$seviceId=1203;
$curdate = date("Y-m-d");
$currDateTime = date('Y-m-d H:i:s');
if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
$file=fopen($log_file_path,"a");
chmod($log_file_path,0777);

function checkmsisdn($msisdn,$abc,$seviceId)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 ) {
		if(strlen($msisdn)==12) {
			if(substr($msisdn,0,2)==91) {
				$msisdn = substr($msisdn, -10);
			} else {
				echo $abc[1];				
				fwrite($file,$msisdn."#".$mode."#1#".$planid."#".$mode."#".date('H:i:s')."#101\r\n" );
				exit;
			}
		}
	} elseif(strlen($msisdn)!=10) { 
		fwrite($file,$msisdn . "#" . $mode . "#1#" . $planid . "#" . $mode . "#" . date('H:i:s')."#101\r\n" );
		return 0;
	} elseif(!is_numeric($msisdn)) {
		fwrite($file,$msisdn . "#" . $mode . "#1#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#101\r\n" );
		return 0;
	}
	return $msisdn;
}

$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);

if ($msisdn == "") {
	echo "Please provide the complete parameter";
} else {
	$con = mysql_connect("database.master","weburl","weburl");
	if(!$con) {
		die('we are facing some temporarily problem please try later');
	}

	$sc='546461';
	$s_id='1203';
	$subscriptionTable="reliance_hungama.tbl_mtv_subscription";	
	$lang='01';

	$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
	$amt = mysql_query($amtquery);
	List($row1) = mysql_fetch_row($amt);
	$amount = $row1;

	$series = substr($msisdn,0,4);
	$cirquery="select circle from master_db.tbl_valid_series where series='".$series."'";
	$circle = mysql_query($cirquery);
	List($circleValue) = mysql_fetch_row($circle);
		
	$sub="select count(*) from ".$subscriptionTable." where ANI='$msisdn'";
	$qry1=mysql_query($sub);
	$rows1 = mysql_fetch_row($qry1);
	if($rows1[0] <=0) {
		$insertMTVrel = "INSERT INTO ".$subscriptionTable." (ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,circle,plan_id,USER_BAL,SUB_TYPE) VALUES ('".$msisdn."','".$currDateTime."','".$currDateTime."','".$lang."','5', '".$mode."','".$sc."','".$circleValue."','".$planid."','".$row1."', '".$mode."')";
		mysql_query($insertMTVrel);
		echo "SUCCESS";
		fwrite($file,$msisdn . "#" . $mode . "#1#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#100\r\n" );
	} else {	
		echo "Already Subscribed";
		fwrite($file,$msisdn . "#" . $mode . "#1#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#102\r\n" );
	}
}
fclose($file);
mysql_close($con);
?>   