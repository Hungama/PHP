<?php
#include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
//$header1=getallheaders();exit;
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
	$tblUnSubProc = "airtel_vh1.JBOX_UNSUB";
	$sCode = "55841";
} elseif($sId == 1511) {
	if($planId == 30 || $planId == 48) 
	{
		$tblSubTable = "airtel_manchala.tbl_riya_subscription";
		$tblSubProc = "airtel_manchala.RIYA_SUB";
		$tblUnSubProc = "airtel_manchala.RIYA_UNSUB";
		$sCode = "5500169";
	} 
	elseif($planId == 29 || $planId == 46) 
	{
		$tblSubTable = "airtel_rasoi.tbl_rasoi_subscription";
		$tblSubProc = "airtel_rasoi.RASOI_SUB";
		$tblUnSubProc = "airtel_rasoi.RASOI_UNSUB";
		$sCode = "55001";
	}
} elseif($sId == 1513) {
	$tblSubTable = "airtel_mnd.tbl_character_subscription1";
	$tblSubProc = "airtel_mnd.MND_SUB";
	$tblUnSubProc = "airtel_mnd.MND_UNSUB";
	$sCode = "5500196";
} elseif($sId == 1515)  {
	$tblSubTable = "airtel_devo.tbl_devo_subscription";
	$tblSubProc = "airtel_devo.DEVO_SUB";
	$tblUnSubProc = "airtel_devo.devo_unsub";
	$sCode = "51050";
} elseif($sId == 1514)  {
	$tblSubTable = "airtel_EDU.tbl_jbox_subscription";
	$tblSubProc = "airtel_EDU.JBOX_SUB";
	$tblUnSubProc = "airtel_EDU.JBOX_UNSUB";
	$sCode = "53222345";
} elseif($sId == 1501)  {
	$tblSubTable = "airtel_radio.tbl_radio_subscription";
	$tblSubProc = "airtel_radio.RADIO_SUB";
	$tblUnSubProc = "airtel_radio.RADIO_UNSUB";
	$sCode = "546469";
}
elseif($sId == 1517)  {
	$tblSubTable = "airtel_SPKENG.tbl_spkeng_subscription";
	$tblSubProc = "airtel_SPKENG.JBOX_SUB";
	$tblUnSubProc = "airtel_SPKENG.JBOX_UNSUB";
	$sCode = "571811";
}



$logPath="/var/www/html/airtel/log/airtelSub/".$sId."/log_".date("Y-m-d").".txt";

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
			if($msisdn!='9910998340')
			{
				mysql_query($call);
			}
			
			$logData = $msisdn1."#".$call."#".date('Y-m-d H:i:s')."\n";
			error_log($logData,3,$logPath);
			echo "Success";
		}
	}
	else if($reqtype == 'UNSUB' && $mode!='' && $planId) 
	{
		$unsubcall = "CALL ".$tblUnSubProc."('".$msisdn1."','".$mode."')";
		mysql_query($unsubcall);
		echo "Success";
	}
	else {
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