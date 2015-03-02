<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$servicename='MTVLive_Hungama';
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
	$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
					$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="/var/www/html/docomo/logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
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
			$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="/var/www/html/docomo/logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
		$sc='546461';
		$s_id='1003';
		$dbname="docomo_hungama";
		$subscriptionTable="tbl_mtv_subscription";
		$subscriptionProcedure="MTV_SUB";
		$unSubscriptionProcedure="MTV_UNSUB";
		$unSubscriptionTable="tbl_mtv_unsub";
		$lang='HIN';
		$con = mysql_connect("database.master","weburl","weburl");
		
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}

		if($reqtype == 1)
		{
			$log_file_path1="/var/www/html/docomo/logs/docomo/capture/".$servicename."/subscapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a");
			fwrite($file1,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" .$s_id."#". $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file1);
			/*echo "100";
			exit;*/

			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID 
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
				$rcode = $abc[0];
				$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 1)
			{
				$rcode = $abc[1];
				$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 2)
			{
				$rcode = $abc[2];
				$log_file_path="/var/www/html/docomo/logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
		}
		if($reqtype == 2)
		{
			$log_file_path1="/var/www/html/docomo/logs/docomo/delcapture/".$servicename."/delcapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a+");
			fwrite($file1,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file1);
			/*echo "100";
			exit;*/
			
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
			}
			else
			{
				$result=2;
			}
			if($result == 0)
			{
				$rcode = $abc[0];
				$log_file_path="/var/www/html/docomo/logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 1)
			{
				$rcode = $abc[1];
				$log_file_path="/var/www/html/docomo/logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 2)
			{
				$rcode = $abc[2];
				$log_file_path="/var/www/html/docomo/logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
		}
	}
/*}else
{
	echo $abc[1];
	$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	fclose($file);
	exit;
}*/
switch($rcode)
{
	case $abc[0]:
		echo "$abc[0]";
		break;
	case $abc[1]:
		echo "$abc[1]";
		break;
	case $abc[2]:
		echo "$abc[2]";
		break;
	default:
		echo $rcode;
	break;
}
mysql_close($con);
?>   