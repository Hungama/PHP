<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$keyword=$_REQUEST['keyword'];
$keyword=strtoupper($keyword);
$reqtype=$_REQUEST['param'];
$curdate = date("Y-m-d");
$rcode="SUCCESS,FAILURE,FAILURE";
$abc=explode(',',$rcode);
if (($msisdn == "") || ($keyword=="") || ($reqtype==""))
{
	echo "Please provide the complete parameter";
}
else
{
	switch($keyword)
	{
		case 'START RIYA':
			$sc='5464626';
			$s_id='1009';
			$dbname="docomo_manchala";
			$subscriptionTable="tbl_riya_subscription";
			$subscriptionProcedure="RIYA_SUB";
			$unSubscriptionProcedure="RIYA_UNSUB";
			$unSubscriptionTable="tbl_riya_unsub";
			$lang='01';
			$planid='39';
			$serviceID='1009Riya';
			$mode='155223';
			$reqtype='SUB';
		break;
		case 'STOP RIYA':
			$sc='5464626';
			$s_id='1009';
			$dbname="docomo_manchala";
			$subscriptionTable="tbl_riya_subscription";
			$subscriptionProcedure="RIYA_SUB";
			$unSubscriptionProcedure="RIYA_UNSUB";
			$unSubscriptionTable="tbl_riya_unsub";
			$lang='01';
			$planid='39';
			$serviceID='1009Riya';
			$mode='155223';
			$reqtype='UNSUB';
		break;
		case 'START RED':
			$sc='55935';
			$s_id='1010';
			$dbname="docomo_redfm";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			$planid='38';
			$serviceID='1010RED';
			$mode='155223';
			$reqtype='SUB';
		break;
		case 'STOP RED':
			$sc='55935';
			$s_id='1010';
			$dbname="docomo_manchala";
			$subscriptionTable="tbl_riya_subscription";
			$subscriptionProcedure="RIYA_SUB";
			$unSubscriptionProcedure="RIYA_UNSUB";
			$unSubscriptionTable="tbl_riya_unsub";
			$lang='01';
			$planid='38';
			$serviceID='1010RED';
			$mode='155223';
			$reqtype='UNSUB';
		break;
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
					if($reqtype=='SUB')
					{
						$log_file_path="logs/docomo/subscription/".$serviceID."/subscription_".$curdate.".txt";
						$file=fopen($log_file_path,"a");
						fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "REASON------>Wrong MSISDN \r\n" );
						fclose($file);
					}
					if($reqtype=='UNSUB')
					{
						$log_file_path="logs/docomo/unsubscription/".$serviceID."/unsubscription_".$curdate.".txt";
						$file=fopen($log_file_path,"a");
						fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "REASON------>Wrong MSISDN \r\n" );
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
			if($reqtype=='SUB')
			{
				$log_file_path="logs/docomo/subscription/".$serviceID."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "REASON------>Wrong MSISDN \r\n" );
				fclose($file);
			}
			if($reqtype=='UNSUB')
			{
				$log_file_path="logs/docomo/unsubscription/".$serviceID."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "REASON------>Wrong MSISDN \r\n" );
				fclose($file);
			}
			exit;
		}
		return $msisdn;
	}
	$msisdn=checkmsisdn(trim($msisdn),$abc);

	
		$con = mysql_connect("database.master","weburl","weburl");

		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}

		if($reqtype =='SUB')
		{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT int,in celeshowid int, in IN_SID int,in IN_PID int
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
				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/subscription/".$serviceID."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/subscription/".$serviceID."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/subscription/".$serviceID."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
		if($reqtype == 'UNSUB')
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
			}
			else
			{
				$result=2;
			}
			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/unsubscription/".$serviceID."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/unsubscription/".$serviceID."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/unsubscription/".$serviceID."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		}
	}
?>