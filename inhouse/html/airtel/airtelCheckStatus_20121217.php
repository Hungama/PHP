<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$msisdn = trim($_REQUEST['msisdn']);
$reqtype = trim($_REQUEST['reqtype']);
$mode = trim($_REQUEST['mode']);
$planId = trim($_REQUEST['plan_id']);
if(!$planId) 
	$planId='47';

$ServiceData = mysql_query("SELECT S_id FROM master_db.tbl_plan_bank WHERE Plan_id=".$planId); 
list($sId) = mysql_fetch_array($ServiceData);

if($sId == 1507) {
	$tblSubTable = "airtel_vh1.tbl_jbox_subscription";
	$tblSubProc = "airtel_vh1.JBOX_SUB";
	$sCode = "55841";
} 
elseif($sId == 1511) 
{
	if($planId == 30 || $planId == 48) 
	{
		$tblSubTable = "airtel_manchala.tbl_riya_subscription";
		$tblSubProc = "airtel_manchala.RIYA_SUB";
		$sCode = "5500169";
	} 
	elseif($planId == 29 || $planId == 46) 
	{
		$tblSubTable = "airtel_rasoi.tbl_rasoi_subscription";
		$tblSubProc = "airtel_rasoi.RASOI_SUB";
		$sCode = "55001";
	}
}
elseif($sId == 1513) 
{
	$tblSubTable = "airtel_mnd.tbl_character_subscription1";
	$tblSubProc = "airtel_mnd.MND_SUB";
	$sCode = "5500196";
}



$logPath="/var/www/html/airtel/log/log_".date("Y-m-d").".txt";

function checkmsisdn($msisdn,$abc)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
		}
	} else {
		echo "Invalid Parameter"; 
		exit;
	}
	return $msisdn;
}


if(is_numeric($msisdn)) {
	if($reqtype == 'CHECK') {
		$msisdn=checkmsisdn(trim($msisdn),$abc);
		$selectData = "select count(*) from ".$tblSubTable." where ani=".$msisdn;
		$result = mysql_query($selectData);
		list($count) = mysql_fetch_array($result);
		
		if($count)  
			echo $response="Subscribed";
		else 
			echo $response="New";
	
		$logData = $msisdn."#".$reqtype."#".$mode."#".$planId."#".$sId."#".$response."#".date('Y-m-d H:i:s')."\n";
		error_log($logData,3,$logPath);
	} else if($reqtype == 'SUB' && $mode!='' && $planId) {
		$msisdn=checkmsisdn(trim($msisdn),$abc);
		$selectData = "select count(*) from ".$tblSubTable." where ani=".$msisdn;
		$result = mysql_query($selectData);
		list($count) = mysql_fetch_array($result);
		if($count) {
			echo $response="Msisdn_Already_Subscribed";
			$logData = $msisdn."#".$reqtype."#".$mode."#".$planId."#".$sId."#".$response."#".date('Y-m-d H:i:s')."\n";
			error_log($logData,3,$logPath);
		} else { 
			$query = "select iAmount from master_db.tbl_plan_bank where Plan_id=".$planId;
			$data = mysql_query($query);
			list($amount) = mysql_fetch_array($data);
			$msisdn1=checkmsisdn(trim($msisdn),$abc);
			$call = "CALL ".$tblSubProc."('".$msisdn1."','01','".$mode."','".$sCode."','".$amount."','".$sId."','".$planId."')";
			mysql_query($call);
			$logData = $msisdn1."#".$call."#".date('Y-m-d H:i:s')."\n";
			error_log($logData,3,$logPath);
			echo "Success";
		}
	} else {
		$logData = $msisdn."#".$reqtype."#".$mode."#".$planId."#".$sId."#Invalid Parameter#".date('Y-m-d H:i:s')."\n";
		error_log($logData,3,$logPath);
		echo "Invalid Parameter";
	}
} else {
	$logData = $msisdn."#".$reqtype."#".$mode."#".$planId."#".$sId."#Invalid Parameter#".date('Y-m-d H:i:s')."\n";
	error_log($logData,3,$logPath);
	echo "Invalid Parameter";
}

mysql_close($dbAirtelConn);
?>