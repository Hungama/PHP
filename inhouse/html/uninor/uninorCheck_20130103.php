<?php
//$con = mysql_connect("database.master","weburl","weburl");
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
error_reporting(0);
$msisdn=trim($_REQUEST['msisdn']);
$curdate = date("Y-m-d");
$reqtype =trim($_GET['reqtype']);
$sId = '1410';

if($sId=='1410') {
	$tblSubTable = "uninor_redfm.tbl_jbox_subscription";
	$tblSubProc = "uninor_redfm.JBOX_SUB";
	$sCode = "55935";
	$planId=35;
	$mode="WAP";
}

$logPath = "/var/www/html/Uninor/logs/1410/log_".date("Y-m-d").".txt";

function checkmsisdn($msisdn,$flag)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
			else
			{
				if($flag==1)
				{
					echo "Failed";
				}
					exit;
			}
		}
	}
	elseif(strlen($msisdn)!=10)
	{
		if($flag==1)
		{
			echo "Failed";
		}
		exit;
	}
return $msisdn;
}

$flag=0;

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
?>   