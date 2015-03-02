<?php
error_reporting(0);
//echo "<pre>";print_r($_REQUEST);exit;
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$servicename=trim($_REQUEST['servicename']);
$rcode =$_REQUEST['rcode'];
$curdate = date("Y-m-d");
$vcode = $_REQUEST['vcode'];
$aftId=$_REQUEST['aftid'];
$mm = $_REQUEST['MM'];
$songCode = $_REQUEST['Songcode'];

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1]." | PlanId Not Found";
	$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
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
					$log_file_path="logs/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
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
			$log_file_path="logs/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
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
		switch($servicename)
		{
			case 'loop54646': 
				$sc='54646';
				$s_id='20027';
				$dbname="loop_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
		}	
		$con = mysql_connect("database.master","weburl","weburl");
		
		if(!$con)
			die('could not connect1: ' . mysql_error());
		
		if($reqtype == 1)
		{
			$log_file_path1="logs/".$servicename."/subscapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a");
			fwrite($file1,$msisdn . "#" . $mode ."#".$aftId."#". $reqtype . "#" . $planid . "#" .$s_id."#". $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode."#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file1);
			
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
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

				$result=0;
			} else {
				$result=2;
			}

			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn."#".$mode."#".$aftId."#".$reqtype."#".$planid."#".$subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode."#". $insertOBDQuery."#Conn:".$con."#". date('H:i:s')."#".$rcode. "\r\n" );
				fclose($file); //.$insertOBDQuery."#"
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype . "#" . $planid . "#" . $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				$rcode = $abc[2];
				echo "Already Subscribed";
				$log_file_path="logs/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype . "#" . $planid . "#" . $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode ."#".$insertOBDQuery. "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
		if($reqtype == 2)
		{
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
				echo $rcode = $abc[0];
				$log_file_path="logs/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype . "#" . $planid . "#" . $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype . "#" . $planid . "#" . $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype . "#" . $planid . "#" . $subchannel."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
	}
?>   