<?php
//error_reporting(0);


$msisdn=$_GET['msisdn'];
$mode=$_GET['mode'];
$reqtype=$_GET['reqtype'];
$planid=$_GET['planid'];
$subchannel =$_GET['subchannel'];
$rcode =$_GET['rcode'];


if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);
if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
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
			}
			else
			{
				echo $abc[1];
				$rcode=$abc[1];
				if($reqtype==1)
				{
					$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/reliance/unsubscription/unsubscription_".$curdate.".txt";
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
			$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/reliance/unsubscription/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		exit;
	}
return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc);




$curdate = date("Y-m-d");
if(($reqtype==1) || ($reqtype==2))
{
if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
{
	echo "Please provide the complete parameter";
}
else
{
	$con = mysql_pconnect("database.master","weburl","weburl");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}
	if($reqtype == 1)
	{
		$amt = mysql_query("select iAmount,iValidty from master_db.tbl_plan_bank where Plan_id='$planid'" );
		List($amount,$Validty) = mysql_fetch_row($amt);
		$amount = $amount;
		$lang='01';
		$sc='54646';
		$s_id='1202';
		$b='1';
		#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID 
		mysql_select_db("reliance_hungama",$con);
		$sub="select count(*) from reliance_hungama.tbl_jbox_subscription where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		
		#echo "athar".$rows1[0]."haider";
		if($rows1[0] <=0)
		{
			$qry="call JBOX_SUB($msisdn,'$lang','$mode','$sc','$amount','$s_id','$planid')";
			$qry1=mysql_query($qry) or die( mysql_error() );
			#$qry2=mysql_query("select @result");
			#$rows = mysql_num_rows( $qry2 );
			$qry2=mysql_query("select count(*) from reliance_hungama.tbl_jbox_subscription where ANI='$msisdn'");
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
			$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($result == 1)
		{
			$rcode = $abc[1];
			$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($result == 2)
		{
			$rcode = $abc[2];
			$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
			
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
	}
	if($reqtype == 2)
	{
		mysql_select_db("reliance_hungama",$con);
		$unsub="select count(*) from reliance_hungama.tbl_jbox_subscription where ANI='$msisdn'";
		$qry5=mysql_query($unsub,$con);
		$rows5 = mysql_fetch_row($qry5);
		#echo "harpreet".$rows5[0]."singh";
		if($rows5[0] >= 1)
		{		
			$qry1=mysql_query("call JBOX_UNSUB($msisdn,'$mode')") or die( mysql_error() );
			#$qry2=mysql_query("select @result");
			#$rows = mysql_num_rows( $qry2 );
			$qry2=mysql_query("select count(*) from reliance_hungama.tbl_jbox_unsub where ANI='$msisdn'");
			$row1 = mysql_fetch_row($qry2);
			#echo "harpreet1".$row1[0]."singh1";
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
			$rcode = $abc[0];
			$log_file_path="logs/reliance/unsubscription/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($result == 1)
		{
			$rcode = $abc[1];
			$log_file_path="logs/reliance/unsubscription/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($result == 2)
		{
			$rcode = $abc[2];
			$log_file_path="logs/reliance/unsubscription/unsubscription_".$curdate.".txt";
			
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
	}
}
}else
	{
		echo $abc[1];
		$log_file_path="logs/reliance/subscription/subscription_".$curdate.".txt";
		$file=fopen($log_file_path,"a");
		fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
		fclose($file);
		exit;
	}
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

?>   