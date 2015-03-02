<?php
error_reporting(0);
$msisdn=$_GET['msisdn'];
$mode=$_REQUEST['mode'];
if(strtoupper($_REQUEST['mode']) == 'SCIVR') $mode="IVR";
elseif(strtoupper($_REQUEST['mode']) == 'SCWEB') $mode="WEB";

$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];

if(strtoupper($_REQUEST['subchannel']) == 'SCIVR') $subchannel="IVR";
elseif(strtoupper($_REQUEST['subchannel']) == 'SCWEB') $subchannel="WEB";

$seviceId=$_REQUEST['serviceid'];
$refundStatus=$_REQUEST['rstatus'];
$refundAmount=$_REQUEST['ramount'];
$seviceId=$_REQUEST['serviceid'];
$ac=$_REQUEST['ac'];
$param=$_REQUEST['param'];
$test=$_REQUEST['test'];
$online=$_REQUEST['online'];

$curdate = date("Y-m-d");
$StartTime = date("H:i:s");
$UCT=$_REQUEST['UCT']; // here UCT will be crbt_id

$log_file_path="logs/MTS/subscription/".$seviceId."/subscription_".$curdate.".txt";

$file=fopen($log_file_path,"a+");

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1];
	fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
	exit;
}
function checkmsisdn($msisdn,$abc,$seviceId)
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
				echo $abc[1];
				$rcode=$abc[1];
				if($reqtype==1)
				{
					fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/MTS/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
					fclose($file);
				}
				exit;
			}
		}
	}
	elseif(strlen($msisdn)!=10)
	{
		echo $abc[1];
		$rcode=$abc[1];
		if($reqtype==1)
		{
			fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/MTS/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);

if (($msisdn == "") || ($mode=="") || ($planid=="")) {
	echo "Please provide the complete parameter";
} else {
	$con = mysql_pconnect("10.130.14.106","billing","billing");
	if(!$con) {
		die('could not connect: ' . mysql_error());
	}
	switch($seviceId)
	{
		case '1103':
			$sc='546461';
			$s_id='1103';
			$DB='mts_mtv';
			$subscriptionTable="tbl_mtv_subscription";
			$subscriptionProcedure="MTV_SUB";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='01';
		break;
		case '1102':
			if($param=='9XM')
				$sc='54646996';
			elseif($param=='9XT')
				$sc='54646997';
			else
				$sc='54646';

			if($ac==1)
				$sc='546469';
			
			$s_id='1102';
			$DB='mts_hungama';
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="jbox_sub";
			$unSubscriptionProcedure="jbox_unsub";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
		break;
		case '1101':
			$sc='52222';
			$s_id='1101';
			$DB='mts_radio';
			$subscriptionTable="tbl_radio_subscription";
			$subscriptionProcedure="RADIO_SUB";
			$unSubscriptionProcedure="RADIO_UNSUB";
			$unSubscriptionTable="tbl_radio_unsub";
			$lang='01';
		break;
		case '1111':
			$sc='5432105';
			$s_id='1111';
			$DB='dm_radio';
			$subscriptionTable="tbl_digi_subscription";
			$subscriptionProcedure="DIGI_SUB";
			$unSubscriptionProcedure="DIGI_UNSUB";
			$unSubscriptionTable="tbl_digi_unsub";
			$lang='01';
		break;
		case '1110':
			$sc='55935';
			$s_id='1110';
			$DB='mts_redfm';
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
		break;
		case '1123':
			$sc='55333';
			$s_id='1123';
			$DB='Mts_summer_contest';
			$subscriptionTable="tbl_contest_subscription";
			$subscriptionProcedure="CONTEST_SUB";
			$unSubscriptionProcedure="CONTEST_UNSUB";
			$unSubscriptionTable="tbl_contest_unsub";
			$lang='01';
		break;
		case '1125':
			$sc='5464622';
			$s_id='1125';
			$DB='mts_JOKEPORTAL';
			$subscriptionTable="tbl_jokeportal_subscription";
			$subscriptionProcedure="JOKEPORTAL_SUB";
			$unSubscriptionProcedure="JOKEPORTAL_UNSUB";
			$unSubscriptionTable="tbl_jokeportal_unsub";
			$lang='01';
		break;
		case '1126':
			$sc='51111';
			$s_id='1126';
			$DB='mts_Regional';
			$subscriptionTable="tbl_regional_subscription";
			$subscriptionProcedure="REGIONAL_SUB";
			$unSubscriptionProcedure="REGIONAL_UNSUB";
			$unSubscriptionTable="tbl_regional_unsub";
			$lang='01';
		break;
		case '1106':
			if($planid==11 || $planid==12 || $planid==13 || $planid==19) {
				$sc='54321551';
				$s_id='1106';
				$DB='mts_starclub';
				$subscriptionTable="tbl_celebrity_evt_ticket";
				$subscriptionProcedure="JBOX_PURCHASE_CELEBRITY_TICKET";
				$lang='01';
			} else {
				$sc='5432155';
				$s_id='1106';
				$DB='mts_starclub';
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
			}
		break;
	}

	$log_file_path="logs/MTS/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	mysql_select_db($DB,$con);
	$unsub="select count(*) from ".$DB.".".$subscriptionTable." where ANI='$msisdn'";
	$qry5=mysql_query($unsub,$con);
	$rows5 = mysql_fetch_row($qry5);
	if($rows5[0] >= 1)
	{
		$unsubsQuery="call ".$DB.".".$unSubscriptionProcedure." ('$msisdn','$mode')";
		$qry1=mysql_query($unsubsQuery) or die( mysql_error() );
		$qry2=mysql_query("select count(*) from ".$DB.".".$unSubscriptionTable."  where ANI='$msisdn'");
		$row1 = mysql_fetch_row($qry2);
		if($row1[0]>=1)
			$result=0;
		else
			$result=1;
	}
	else
		$result=2;
	
	if($result == 0)
		echo $rcode = $abc[0];
	elseif($result == 1)
		echo $rcode = $abc[1];
	elseif($result == 2)
		echo $rcode = $abc[2];
	
	fwrite($file,$msisdn . "#" . $mode . "#2#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	fclose($file);

	mysql_close($con);
	/////////////////////////// End of Request to deactive the Msisdn///////////////////////////////////
}
?>