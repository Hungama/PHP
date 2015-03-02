<?php
$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$mode=$_REQUEST['mode'];
$wallName=$_REQUEST['wallName'];
if($mode=='')
	$mode='net';
$seviceId=$_REQUEST['serviceid'];
$reqtype=$_REQUEST['reqtype'];
$isTopup=$_REQUEST['isTopup'];
$seviceId1=1409;
$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);

$logDir='/var/www/html/Uninor/logs/uninor/subscription/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;
if($msisdn)
{

	if($reqtype=='Download')
	{
		$billlingPath210="http://192.168.100.210/billing/uninor_billing/UninorWap.php?msisdn=".$msisdn;
		echo $billlingResponse=file_get_contents($billlingPath210);
		$logString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$seviceId ."#".$billlingPath210."#". date('H:i:s')."#". $billlingResponse. "\r\n" ;		
		error_log($logString,3,$logPath);
		exit;
	}
	if($reqtype=='bhaktiras')
	{
		
		$billlingPath210="http://192.168.100.216/uninor/UninorWap.php?msisdn=".$msisdn."&mode=".$mode."&isTopup=".$isTopup;
		$billlingResponse=file_get_contents($billlingPath210);
		$logString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$seviceId ."#".$billlingPath210."#". date('H:i:s')."#". $billlingResponse. "\r\n" ;		
		error_log($logString,3,$logPath);
		if(strtoupper($billlingResponse)=='SUCCESS' && $isTopup==1 )
		{
			$link3 = "http://202.87.41.147/waphung/content_download/155015/".$wallName;
			header("location:$link3");
		}
		exit;
	}
	if($reqtype=='UninorMuWap')
	{
		$billlingPath210="http://192.168.100.216/uninor/UninorWap.php?msisdn=".$msisdn."&mode=".$mode."&service=UninorMuWap";
		echo $billlingResponse=file_get_contents($billlingPath210);
		$logString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$seviceId ."#".$billlingPath210."#". date('H:i:s')."#". $billlingResponse. "\r\n" ;		
		error_log($logString,3,$logPath);
		exit;
	}
	if($reqtype=='UninorMuWap2')
	{
		$billlingPath210="http://192.168.100.216/uninor/UninorWap.php?msisdn=".$msisdn."&mode=".$mode."&service=UninorMuWap2&plan_id=13401&sub_id=1340";
		echo $billlingResponse=file_get_contents($billlingPath210);
		$logString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$seviceId ."#".$billlingPath210."#". date('H:i:s')."#". $billlingResponse. "\r\n" ;		
		error_log($logString,3,$logPath);
		exit;
	}
$con = mysql_connect("192.168.100.224","weburl","weburl") or die('we are facing some temporarily problem please try later');
switch($planid)
	{
		case '35':
			$sc='55935';
			$s_id='1410';
			$subscriptionTable="uninor_redfm.tbl_jbox_subscription";
			$subscriptionProcedure="uninor_redfm.JBOX_SUB";
			$unSubscriptionProcedure="uninor_redfm.JBOX_UNSUB";
			$unSubscriptionTable="uninor_redfm.tbl_jbox_unsub";
			$query="select count(*) from uninor_redfm.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '10':
			$sc='54646';
			$s_id='1402';
			$subscriptionTable="uninor_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="uninor_hungama.JBOX_SUB";
			$unSubscriptionProcedure="uninor_hungama.JBOX_UNSUB";
			$unSubscriptionTable="uninor_hungama.tbl_jbox_unsub";
			$query="select count(*) from uninor_hungama.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '47':
			$sc='5464626';
			$s_id='1409';
			$subscriptionTable="uninor_manchala.tbl_riya_subscription";
			$subscriptionProcedure="uninor_manchala.RIYA_SUB";
			$unSubscriptionProcedure="uninor_manchala.RIYA_UNSUB";
			$unSubscriptionTable="uninor_manchala.tbl_riya_unsub";
			$query="select count(*) from uninor_manchala.tbl_riya_subscription where ani=".$msisdn;
			$lang='01';
		break;
	}	
	$execute=mysql_query($query);
	$row=mysql_fetch_row($execute);
	if($msisdn && $row[0]=='0' && $reqtype==1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id=".$planid." and S_id=$s_id";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$actionQry="call ". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		$qry1=mysql_query($actionQry) or die( mysql_error());
		echo $response="Success";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	elseif($row[0]>0)
	{
		echo $response="Already Subscribed";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	else
	{
		echo $response="Failure";
		$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
	}
	error_log($subscriptionString,3,$logPath);
	mysql_close($con);
}
else
	echo "Msisdn not found";

?>   