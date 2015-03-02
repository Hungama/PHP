<?php
error_reporting(0);
$msisdn=$_GET['msisdn'];
$mode=$_GET['mode'];
$reqtype=$_GET['reqtype'];
$planid=$_GET['planid'];
$subchannel =$_GET['subchannel'];
$rcode =$_GET['rcode'];
$seviceId=$_GET['serviceid'];
$ac=$_GET['ac'];
$curdate = date("Y-m-d");
if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	chmod($log_file_path,0777);
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	fclose($file);
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
			}else
			{
				echo $abc[1];
				$rcode=$abc[1];
				if($reqtype==1)
				{
					$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					chmod($log_file_path,0777);
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/reliance/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					chmod($log_file_path,0777);
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
			$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			chmod($log_file_path,0777);
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/reliance/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			chmod($log_file_path,0777);
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);

if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
{
	echo "Please provide the complete parameter";
}
else
{
	$con = mysql_connect("119.82.69.210","weburl","weburl");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}
	echo $seviceId.'athar';
	switch($seviceId)
	{
		case '1203':
			$sc='546461';
			$s_id='1203';
			$subscriptionTable="reliance_hungama.tbl_mtv_subscription";
			$subscriptionProcedure="reliance_hungama.MTV_SUB";
			$unSubscriptionProcedure="reliance_hungama.MTV_UNSUB";
			$unSubscriptionTable="reliance_hungama.tbl_mtv_unsub";
			$lang='01';
			break;
		case '1202':
			if($ac==1)
				$sc='546469';
			else
				$sc='54646';
			$s_id='1202';
			$subscriptionTable="reliance_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="reliance_hungama.JBOX_SUB";
			$unSubscriptionProcedure="reliance_hungama.JBOX_UNSUB";
			$unSubscriptionTable="reliance_hungama.tbl_jbox_unsub";
			$lang='01';
			break;
		case '1208':
			if($ac==1)
				$sc='546469';
			else
				$sc='546462';
			$s_id='1208';
			$subscriptionTable="reliance_cricket.tbl_cricket_subscription";
			$subscriptionProcedure="reliance_cricket.CRICKET_SUB";
			$unSubscriptionProcedure="reliance_cricket.CRICKET_UNSUB";
			$unSubscriptionTable="reliance_cricket.tbl_cricket_unsub";
			$lang='01';
			break;

	}	
	if($reqtype == 1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$sub="select count(*) from $subscriptionTable where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{
			$qry="call ". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
			$qry1=mysql_query($qry) or die( mysql_error() );
			$query2="select count(*) from ".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($query2);
			$result2=mysql_fetch_row($qry2);
			if($result2[0]>=1)
				$result=0;
			else
				$result=1;
		}
		else
			$result=2;
		if($result==0)
		{
			echo $rcode = $abc[0];
			$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
			
			if($result==1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
			if($result==2)
			{

				echo $rcode = $abc[2];
				$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
		}
		if($reqtype == 2)
		{
			//mysql_select_db("reliance_cricket",$con);
			$unsub="select count(*) from ".$subscriptionTable." where ANI='$msisdn'";
			$qry5=mysql_query($unsub,$con);
			$rows5 = mysql_fetch_row($qry5);
			if($rows5[0] >= 1)
			{		
				$unsubsQuery="call ".$unSubscriptionProcedure." ('$msisdn','$mode')";
				$qry1=mysql_query($unsubsQuery) or die( mysql_error() );
				$qry2=mysql_query("select count(*) from ".$unSubscriptionTable."  where ANI='$msisdn'");
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
				$log_file_path="logs/reliance/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/reliance/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/reliance/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				exit;
			}
		}
}
?>   