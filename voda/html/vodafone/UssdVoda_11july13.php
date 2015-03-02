<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode='USSD';
$reqtype=1;
$planid=$_REQUEST['planid'];
$servicename=trim($_REQUEST['servicename']);
$curdate = date("Y-m-d");

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,ALREADY-SUBSCRIBED";
}
$abc=explode(',',$rcode);

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
					$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc);
if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
{
	echo "Please provide the complete parameter";
}
else
{
	switch($servicename)
	{
		case 'vodafone_54646':
			$sc='54646';
			$s_id='1302';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_MTV':
			$sc='546461';
			$s_id='1303';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_mtv_subscription";
			$subscriptionProcedure="MTV_SUB";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='HIN';
			break;
		case 'vodafone_AAV':
			$sc='5464611';
			$s_id='1302';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_vh1':
			$sc='55841';
			$s_id='1307';
			$dbname="vodafone_vh1";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_redfm':
			$sc='55935';
			$s_id='1310';
			$dbname="vodafone_redfm";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="jbox_unsub";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
	}	
	$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}

	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$con) or die( mysql_error() );
	$circleRow = mysql_fetch_row($circle1);
		
	if($reqtype == 1)
	{
		
		$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		mysql_select_db($dbname,$con);

		$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{
			$call="call ".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid)";
			$qry1=mysql_query($call) or die( mysql_error() );
			$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($select);
			$row1 = mysql_num_rows($qry2);
			if($row1>=1)
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
			if(strtoupper($circleRow[0])=='GUJ' && $servicename=='vodafone_54646')
				echo $rcode1 = "We had received your request, will update you shortly by SMS";
			else
				echo $rcode1 = $abc[0];
			
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode1 = $abc[1];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 2)
		{
			echo $rcode1 = $abc[2];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
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
			echo $rcode1= $abc[0];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode1 = $abc[1];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
		if($result == 2)
		{
			echo $rcode1 = $abc[2];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
	}
}




?>   
