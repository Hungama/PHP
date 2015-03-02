<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
if($subchannel=='OBD_HUNG')
	$mode=$subchannel;
$servicename=trim($_REQUEST['servicename']);
$rcode =$_REQUEST['rcode'];
$curdate = date("Y-m-d");
//added for dynamic planid-amount format
$con = mysql_connect("database.master","weburl","weburl");
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
$planid=trim($_REQUEST['planid']);
		$planData = explode("-",$planid);
		if(count($planData)==2) {
			$planid = $planData[0];
			$getAmount = $planData[1];
		}
		
		if(!$getAmount) { 
		$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($getAmount) = mysql_fetch_row($amt);;
			}
mysql_close($con);
//end here

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);


if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1]."#".$remoteAdd. "\r\n" );
	fclose($file);
	exit;
}
function checkmsisdn($msisdn,$abc)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}else
			{
				echo $abc[1];
				$rcode=$abc[1];
				if($reqtype==1)
				{
					$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/uninor/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
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
			$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/uninor/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc);
/*if(($reqtype==1) || ($reqtype==2))
{*/
	if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
	{
		echo "Please provide the complete parameter";
	}
	else
	{
		switch($servicename)
		{
			case 'uninor_54646':
				$sc='54646';
				$s_id='1402';
				$dbname="uninor_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				if($planid == '35') $planid=10;
				break;
			case 'uninor_MPMC':
				$sc='5464622';
				$s_id='1418';
				$dbname="uninor_hungama";
				$subscriptionTable="tbl_comedy_subscription";
				$subscriptionProcedure="COMEDY_SUB";
				$unSubscriptionProcedure="COMEDY_UNSUB";
				$unSubscriptionTable="tbl_comedy_unsub";
				$lang='01';
				break;
			case 'uninor_MTV':
				$sc='546461';
				$s_id='1403';
				$dbname="uninor_hungama";
				$subscriptionTable="tbl_mtv_subscription";
				$subscriptionProcedure="MTV_SUB";
				$unSubscriptionProcedure="MTV_UNSUB";
				$unSubscriptionTable="tbl_mtv_unsub";
				$lang='HIN';
				break;
			case 'uninor_9XM':
				$sc='54646996';
				$s_id='1402';
				$dbname="uninor_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'uninor_RED':
				$sc='55935';
				$s_id='1410';
				$dbname="uninor_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'uninor_RIYA':
				$sc='5646428';
				$s_id='1409';
				$dbname="uninor_manchala";
				$subscriptionTable="tbl_riya_subscription";
				$subscriptionProcedure="RIYA_SUB";
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
				$lang='01';
				break;
			case 'uninor_aav':
				$sc='5464611';
				$s_id='1402';
				$dbname="uninor_hungama";
				$subscriptionTable="tbl_Artist_Aloud_subscription";
				$subscriptionProcedure="ARTIST_ALOUD_SUB";
				$unSubscriptionProcedure="ARTIST_ALOUD_UNSUB";
				$unSubscriptionTable="tbl_Artist_Aloud_unsub";
				$lang='01';
				break;
			case 'uninor_jyotish':
				$sc='66291373';
				$s_id='1416';
				$dbname="uninor_jyotish";
				$subscriptionTable="tbl_jyotish_subscription";
				$subscriptionProcedure="Jyotish_SUB";
				$unSubscriptionProcedure="Jyotish_UNSUB";
				$unSubscriptionTable="tbl_Jyotish_unsub";
				$lang='01';
				break;
			case 'uninor_sportsUnlimited':
				$sc='52255';
				$s_id='1408';
				$dbname="uninor_cricket";
				$subscriptionTable="tbl_cricket_subscription";
				$subscriptionProcedure="cricket_SUB";
				$unSubscriptionProcedure="cricket_UNSUB";
				$unSubscriptionTable="tbl_cricket_unsub";
				$lang='01';
				break;
			case 'uninor_kiji':
				$sc='52000';
				$s_id='1423';
				$dbname="uninor_summer_contest";
				$subscriptionTable="tbl_contest_subscription";
				$subscriptionProcedure="Contest_SUB";
				$unSubscriptionProcedure="Contest_UNSUB";
				$unSubscriptionTable="tbl_contest_unsub";
				$lang='01';
				break;
			default:
				echo "Invalid service."; exit;
		}
		
		$con = mysql_connect("database.master","weburl","weburl");
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}

		if(strlen($_REQUEST['lang'])<=3 && $_REQUEST['lang']) $lang=$_REQUEST['lang'];

		if($reqtype == 1)
		{
			
		//	$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			//List($row1) = mysql_fetch_row($amt);
			//$amount = $row1;
			$amount = $getAmount;
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID 
			mysql_select_db($dbname,$con);
			$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			if($rows1[0] <=0)
			{
				$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid)";
				$qry1=mysql_query($call) or die( mysql_error() );
				$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
				$qry2=mysql_query($select);
				$row1 = mysql_num_rows($qry2);
				if($row1>=1) {
					$result=0;
				} else {
					//$result=1;
					$result=0;
				}
			} else {
				$result=2;
			}
			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s')."#".$rcode."#". $remoteAdd."#".$call."\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s')."#".$rcode."#".$remoteAdd."#".$call."\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				if(strlen($_REQUEST['lang'])<=3 && $_REQUEST['lang']) {
					$lang=$_REQUEST['lang'];
					$updateLang="UPDATE ".$dbname.".".$subscriptionTable." SET def_lang='".$lang."' WHERE ANI='".$msisdn."'";
					mysql_query($updateLang);
				}

				$log_file_path="logs/uninor/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s')."#".$rcode."#".$remoteAdd."#".$call."\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
		if($reqtype == 2)
		{
			mysql_select_db($dbname,$con);
			$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			$qry5=mysql_query($unsub,$con);
			$rows5 = mysql_fetch_row($qry5);
			if($rows5[0] >= 1)
			{		
				$call="call ".$unSubscriptionProcedure."($msisdn,'$mode')";
				$qry1=mysql_query($call) or die( mysql_error());
				$unsub="select count(*) from ".$dbname.".".$unSubscriptionTable." where ANI='$msisdn'";
				$qry2=mysql_query($unsub);
				$row1 = mysql_fetch_row($qry2);
				if($row1[0]>=1)
				{
					$result=0;
				}else
				{
					$result=1;
				}
			}else
			{
				$result=2;
			}
			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/uninor/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') ."#".$rcode."#".$remoteAdd. "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;

			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
			    $log_file_path="logs/uninor/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#".$remoteAdd. "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/uninor/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#".$lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode. "#".$remoteAdd. "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
	}
?>   