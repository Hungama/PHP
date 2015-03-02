<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
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
	$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
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
					$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/docomo/unsubscription/unsubscription_".$curdate.".txt";
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
			$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/docomo/unsubscription/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		exit;
	}
return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc);

if(($reqtype==1) || ($reqtype==2))
{
	if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
	{
		echo "Please provide the complete parameter";
	}
	else
	{
		$con = mysql_pconnect("119.82.69.210","weburl","weburl");
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
		if($reqtype == 1)
		{
			$amt = mysql_query("select iAmount,iValidty from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1['iAmount'];
			$lang='99';
			$sc='59090';
			$s_id='1001';
			$b='1';
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID 
			mysql_select_db("docomo_radio",$con);
			$qry=mysql_query("select count(*) from tbl_radio_subscription where ANI='$msisdn'");
			$rows = mysql_num_rows( $qry );
			if($rows <= 0)
			{
				$qry1=mysql_query("call RADIO_SUB($msisdn,'$lang','$mode','$sc','$amount','$s_id','$planid')") or die( mysql_error() );
				#$qry2=mysql_query("select @result");
				#$rows = mysql_num_rows( $qry2 );
				$qry2=mysql_query("select count(*) from tbl_radio_subscription where ANI='$msisdn'");
				$row1 = mysql_fetch_rows($qry2);
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
				$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 1)
			{
				$rcode = $abc[1];
				$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 2)
			{
				$rcode = $abc[2];
				$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
		}
		if($reqtype == 2)
		{
			mysql_select_db("docomo_radio",$con);
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID 
			mysql_select_db("docomo_radio",$con);
			$qry=mysql_query("select count(*) into @test from tbl_radio_subscription where ANI='$msisdn'");
			$rows = mysql_num_rows( $qry );
			if($rows >= 0)
			{		
				$qry1=mysql_query("call RADIO_UNSUB($msisdn,'$mode')") or die( mysql_error() );
				#$qry2=mysql_query("select @result");
				#$rows = mysql_num_rows( $qry2 );
				$qry2=mysql_query("select count(*) into @cnt from tbl_radio_unsub where ANI='$msisdn'");
				$row1 = mysql_fetch_rows($qry2);
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
				$log_file_path="logs/docomo/unsubscription/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 1)
			{
				$rcode = $abc[1];
				$log_file_path="logs/docomo/unsubscription/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
			if($result == 2)
			{
				$rcode = $abc[2];
				$log_file_path="logs/docomo/unsubscription/unsubscription_".$curdate.".txt";
				
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
			}
		}
	}
}else
	{
		echo $abc[1];
		$log_file_path="logs/docomo/subscription/subscription_".$curdate.".txt";
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