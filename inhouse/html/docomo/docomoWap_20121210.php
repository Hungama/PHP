<?php
//error_reporting(0);
//$mode='net';
//echo "<pre>";print_r($_REQUEST);exit;

$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$mode=$_REQUEST['mode'];
$celebId = $_REQUEST['celebId'];
$seviceId=$_REQUEST['serviceid'];
$seviceId1=1009;

//echo "<pre>";print_r($_REQUEST);exit;
if($mode=='')
	$mode='net';
elseif($mode=='web')
	$mode='wap';

/*
if(strtolower($mode)=='net')
{
	$logDir='/var/www/html/docomo/logs/docomo/subscription/'.$seviceId1.'/Wap/';
	$logFile='subscription_'.date('Y-m-d').".txt";
	$logPath=$logDir.$logFile;
	
	$checkDnd="http://192.168.100.238:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=".$msisdn;
	$DndResponse=file_get_contents($checkDnd);
	if(strtoupper($DndResponse)!='ND')
	{
		echo "DND Listed" ;
		$subscriptionString=$checkDnd."#".date('h:i:s')."#".$DndResponse."\r\n";
		error_log($subscriptionString,3,$logPath);
		exit;
	}
}
*/


$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$logDir='/var/www/html/docomo/logs/docomo/subscription/'.$seviceId1.'/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;

$con = mysql_connect("192.168.100.224","weburl","weburl") or die('we are facing some temporarily problem please try later');

if($msisdn)
{
	
	if($reqtype=='RiyaWap')
	{
		$chargingUrl1="http://192.168.100.211/billing/Docomo/docomoCharging.php?msisdn=".$msisdn."&moh=WAP&rt=topup&scode=546462630&online=y";
		echo $response=file_get_contents($chargingUrl1);

		if(strlen($msisdn)==12) {
			$msisdn =  substr($msisdn, 2);
		} else $msisdn = $msisdn;

		$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
		$circle1=mysql_query($getCircle) or die( mysql_error() );
		while($row = mysql_fetch_array($circle1)) {
			$circle = $row['circle'];
		}
		if(!$circle) { $circle='UND'; }

		if($pos = strrpos(strtolower($response),"success")) {
			$insertQuery = "insert into mis_db.tbl_wapRequest_data (msisdn, mode, datetime,response,status,operator,circle,service) VALUES ('".$msisdn."' ,'WAP',NOW(),'".$response."','success','TATM','".$circle."','1009')";
		} else {
			$insertQuery = "insert into mis_db.tbl_wapRequest_data (msisdn, mode, datetime,response,status,operator,circle,service) VALUES ('".$msisdn."' ,'WAP',NOW(),'".$response."','failure','TATM','".$circle."','1009')";
		}
		mysql_query($insertQuery);
		exit;
	}

switch($planid)
	{
		case '39':
			$sc='5464626';
			$s_id='1009';
			$subscriptionTable="docomo_manchala.tbl_riya_subscription";
			$subscriptionProcedure="docomo_manchala.RIYA_SUB";
			$unSubscriptionProcedure="docomo_manchala.RIYA_UNSUB";
			$unSubscriptionTable="docomo_manchala.tbl_riya_unsub";
			$query="select count(*) from docomo_manchala.tbl_riya_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '3':
			$sc='590906';
			$s_id='1001';
			$subscriptionTable="docomo_radio.tbl_radio_subscription";
			$subscriptionProcedure="docomo_radio.RADIO_SUB";
			$unSubscriptionProcedure="docomo_radio.RADIO_UNSUB";
			$unSubscriptionTable="docomo_radio.tbl_radio_unsub";
			$query="select count(*) from docomo_radio.tbl_radio_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '2':
			$sc='590907';
			$s_id='1001';
			$subscriptionTable="docomo_radio.tbl_radio_subscription";
			$subscriptionProcedure="docomo_radio.RADIO_SUB";
			$unSubscriptionProcedure="docomo_radio.RADIO_UNSUB";
			$unSubscriptionTable="docomo_radio.tbl_radio_unsub";
			$query="select count(*) from docomo_radio.tbl_radio_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '8':
			$sc='54646';
			$s_id='1002';
			$subscriptionTable="docomo_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="docomo_hungama.JBOX_SUB";
			$unSubscriptionProcedure="docomo_hungama.JBOX_UNSUB";
			$unSubscriptionTable="docomo_hungama.tbl_jbox_unsub";
			$query="select count(*) from docomo_hungama.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '1':
			$sc='59090';
			$s_id='1001';
			$subscriptionTable="docomo_radio.tbl_radio_subscription";
			$subscriptionProcedure="docomo_radio.RADIO_SUB";
			$unSubscriptionProcedure="docomo_radio.RADIO_UNSUB";
			$unSubscriptionTable="docomo_radio.tbl_radio_unsub";
			$query="select count(*) from docomo_radio.tbl_radio_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '18':
			$sc='56666';
			$s_id='1005';
			$subscriptionTable="docomo_starclub.tbl_jbox_subscription";
			$subscriptionProcedure="docomo_starclub.JBOX_SUB";
			$unSubscriptionProcedure="docomo_starclub.JBOX_UNSUB";
			$unSubscriptionTable="docomo_starclub.tbl_jbox_unsub";
			$query="select count(*) from docomo_starclub.tbl_jbox_subscription where ani=".$msisdn;
			$lang='01';
		break;
		case '50':
			if($mode=='wap')
				$HitUrl="http://59.161.254.80/fanpage/WAPActivation.php?Mobileno=".$msisdn;
			else
				$HitUrl="http://59.161.254.80/fanpage/NETActivation.php?Mobileno=".$msisdn;
			//$response=file_get_contents($HitUrl);

			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$HitUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);

			if($response=='SUCCESS')
				$response="Success";
			else
				$response="Failure";
			echo $response;
			$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
			error_log($subscriptionString,3,$logPath);
			exit;
		break;
		case '19':							
			$HitUrl="http://192.168.100.212/docomo/docomo_follow_up.php?msisdn=".$msisdn."&mode=".$mode."&reqtype=1&planid=".$planid ."&subchannel=NET&rcode=100,101,102&celebid=".$celebId."&flag=0";
			//$response=file_get_contents($HitUrl);

			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$HitUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);

			if(trim($response)=='SUCCESS' || trim($response)=='100')
				$response="Success";
			elseif(trim($response)=='102')
				$response="Already subscribed";
			else
				$response="Failure";
			echo $response;
			$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
			error_log($subscriptionString,3,$logPath);
			exit;
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

?>   