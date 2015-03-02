<?php
error_reporting(0);
$text=$_REQUEST['text'];
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$celebid=$_REQUEST['celebId'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$servicename=trim($_REQUEST['servicename']);
$rcode =$_REQUEST['rcode'];
$curdate = date("Y-m-d");
if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
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
					$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/docomo/unsubscription/follow_up/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
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
			$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/docomo/unsubscription/follow_up/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
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
		$sc='566660';
		$s_id='1005';
		$dbname="follow_up";
		$subscriptionTable="tbl_subscription";
		$subscriptionProcedure="FOLLOWUP_SUB";
		$unSubscriptionProcedure="FOLLOWUP_UNSUB";
		$unSubscriptionTable="tbl_unsubscription";
		$lang='01';
			
		$con = mysql_connect("119.82.69.210","weburl","weburl");
		
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
		if($reqtype == 1)
		{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			mysql_select_db($dbname,$con);
			$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and Ani_Celeb='$celebid' and Service_Id='$s_id'";
			if ($text==1)
				echo  $sub;
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			if($rows1[0] <=0)
			{
				$call="call ".$subscriptionProcedure."('$celebid',$msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid)";
				$qry1=mysql_query($call) or die( mysql_error() );
				$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and Ani_Celeb='$celebid' and Service_Id='$s_id'";
				$qry2=mysql_query($select);
				$row1 = mysql_num_rows($qry2);
				if($row1>=1)
				{
					$result=0;
				}else
				{
					$result=1;
				}
			}
			else
			{
				$result=2;
			}
			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/subscription/follow_up/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $celebid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
	}

?>   