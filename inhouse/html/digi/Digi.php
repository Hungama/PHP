<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$rcode =$_REQUEST['rcode'];
$seviceId=$_REQUEST['serviceid'];
$ac=$_REQUEST['ac'];
$param=$_REQUEST['param'];
$curdate = date("Y-m-d");
$price = $_REQUEST['price'];
if(!isset($rcode))
{
	$rcode="100,101,102";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1];
		$log_file_path="logs/digi/error/error_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	chmod($log_file_path,0777);
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "Reason---> Wrong planid \r\n" );
	fclose($file);
	exit;
}

/*function checkmsisdn($msisdn,$abc,$seviceId)
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
	elseif(!is_numeric($msisdn))
	{
		echo $abc[1];
		$log_file_path="logs/reliance/subscription/".$seviceId."/subscription_".$curdate.".txt";
		$file=fopen($log_file_path,"a");
		chmod($log_file_path,0777);
		fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
		fclose($file);
		exit;
	}

	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);
*/

if (!is_numeric($msisdn))
{
	echo $abc[1];
	$log_file_path="logs/digi/error/error_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	chmod($log_file_path,0777);
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "Reason---> Wrong msisdn \r\n" );
	fclose($file);
	exit;
}

if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
{
	echo "Please provide the complete parameter";
}
else
{
	$con = mysql_connect("172.16.56.42","billing","billing");
	if(!$con)
	{
		die('we are facing some temporarily problem please try later');
	}
	switch($seviceId)
	{
		case '1701':
		switch($planid)
		{
			case '1':
			case '4':
				$service_name='digi';
				$sc='131224';
				$s_id='1701';
				$subscriptionTable="dm_radio.tbl_digi_subscription";
				$subscriptionProcedure="dm_radio.DIGI_SUB";
				$unSubscriptionProcedure="dm_radio.DIGI_UNSUB";
				$unSubscriptionTable="dm_radio.tbl_digi_unsub";
				$lang='01';
			break;
			case '2':
			case '5':
				$service_name='digi_bengali';
				$sc='131221';
				$s_id='1701';
				$subscriptionTable="dm_radio_bengali.tbl_digi_subscription";
				$subscriptionProcedure="dm_radio_bengali.DIGI_SUB";
				$unSubscriptionProcedure="dm_radio_bengali.DIGI_UNSUB";
				$unSubscriptionTable="dm_radio_bengali.tbl_digi_unsub";
				$lang='06';
			break;
			case '3':
			case '6':
				$service_name='digi_nepali';
				$sc='131222';
				$s_id='1701';
				$subscriptionTable="dm_radio_nepali.tbl_digi_subscription";
				$subscriptionProcedure="dm_radio_nepali.DIGI_SUB";
				$unSubscriptionProcedure="dm_radio_nepali.DIGI_UNSUB";
				$unSubscriptionTable="dm_radio_nepali.tbl_digi_unsub";
				$lang='20';
			break;
		}
	}

	if($reqtype == 1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		if($price == 3)
			$amount = 3;
		elseif($price == 1)
			$amount = 1;
		$sub="select count(*) from ".$subscriptionTable." where ANI='$msisdn'";

		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{
			 $qry="call ". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
			 $qry1=mysql_query($qry);
			 $query2="select count(*) from ".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($query2);
			 $result2=mysql_fetch_row($qry2);
			 if($_REQUEST['test']) echo $result2[0]." ".$query2." ".$qry;
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
			$log_file_path="logs/digi/subscription/".$seviceId."_".$service_name."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			chmod($log_file_path,0777);
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}

			if($result==1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/digi/subscription/".$seviceId."_".$service_name."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result==2)
			{

				echo $rcode = $abc[2];
				$log_file_path="logs/digi/subscription/".$seviceId."_".$service_name."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
		if($reqtype == 2)
		{

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
				$log_file_path="logs/digi/unsubscription/".$seviceId."_".$service_name."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/digi/unsubscription/".$seviceId."_".$service_name."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/digi/unsubscription/".$seviceId."_".$service_name."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				chmod($log_file_path,0777);
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
}
?>