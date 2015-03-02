<?php
error_reporting(0);
$text=$_REQUEST['text'];
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$servicename=trim($_REQUEST['servicename']);
$rcode =$_REQUEST['rcode'];
$curdate = date("Y-m-d");
$CCGID =$_REQUEST['CCGID'];

$remoteAdd=trim($_SERVER['REMOTE_ADDR']);

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#".$remoteAdd."#". $abc[1] . "\r\n" );
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
					$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $abc[1] . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/indicom/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $abc[1] . "\r\n" );
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
			$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/indicom/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $abc[1] . "\r\n" );
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
			case 'Bollywood_Merijaan_Hungama':
				$sc='566660';
				$s_id='1605';
				if($planid==31)
				{
					$dbname="indicom_starclub";
					$subscriptionTable="tbl_celebrity_evt_ticket";
					$subscriptionProcedure="JBOX_PURCHASE_CELEBRITY_TICKET";
					$lang='01';
				}
				if($planid==28)
				{
					$dbname="indicom_starclub";
					$subscriptionTable="tbl_jbox_subscription";
					$subscriptionProcedure="JBOX_SUB";
					$unSubscriptionProcedure="JBOX_UNSUB";
					$unSubscriptionTable="tbl_jbox_unsub";
					$lang='01';
				}
				break;
			case 'MTVLive_Hungama':
				$sc='546461';
				$s_id='1603';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_mtv_subscription";
				$subscriptionProcedure="MTV_SUB";
				$unSubscriptionProcedure="MTV_UNSUB";
				$unSubscriptionTable="tbl_mtv_unsub";
				$lang='HIN';
				break;
			case 'HungamaMedia_Hungama':
				$sc='546460';
				$s_id='1602';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				//$subscriptionProcedure="JBOX_SUB";
				$subscriptionProcedure="JBOX_SUB_WAP";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				break;
			case '':
				$servicename='EndlessMusic';
				$sc='59090';
				$s_id='1601';
				$dbname="indicom_radio";
				$subscriptionTable="tbl_radio_subscription";
				//$subscriptionProcedure="RADIO_SUB";
				$subscriptionProcedure="RADIO_SUB_WAP";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='99';
				break;
			case 'EndlessMusic':
				$sc='59090';
				$s_id='1601';
				$dbname="indicom_radio";
				$subscriptionTable="tbl_radio_subscription";
				//$subscriptionProcedure="RADIO_SUB";
				$subscriptionProcedure="RADIO_SUB_WAP";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='99';
				break;
			case 'indicom_9XM':
				$sc='54646996';
				$s_id='1602';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'indicom_Prem':
				$sc='5464667';
				$s_id='1609';
				$dbname="indicom_manchala";
				$subscriptionTable="tbl_prem_subscription";
				$subscriptionProcedure="PREM_SUB";
				$unSubscriptionProcedure="PREM_UNSUB";
				$unSubscriptionTable="tbl_prem_unsub";
				$lang='01';
				break;
			case 'indicom_Riya':
				$sc='5464668';
				$s_id='1609';
				$dbname="indicom_manchala";
				$subscriptionTable="tbl_riya_subscription";
				$subscriptionProcedure="RIYA_SUB";
				$chatSubTable="tbl_riya_celebchat_subscription";
				$chatProcedure="RIYA_CHAT_SUB";
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
				$lang='01';
				break;
			case 'indicom_9XT':
				$sc='54646997';
				$s_id='1602';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'indicom_Redfm':
				$sc='55935';
				$s_id='1610';
				$dbname="indicom_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'indicom_mylife':
				$sc='55001';
				$s_id='1611';
				$dbname="indicom_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				$subscriptionProcedure="RASOI_SUB";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
				$lang='01';
				break;
			case 'indicom_vh1':
				$sc='55841';
				$s_id='1607';
				$dbname="indicom_vh1";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'indicom_aav':
				$sc='5464639';
				$s_id='1602';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				break;
			case 'indicom_mnd':
				$sc='55001';
				$s_id='1613';
				$dbname="indicom_mnd";
				$subscriptionTable="tbl_character_subscription1";
				$subscriptionProcedure="MND_SUB";
				$unSubscriptionProcedure="MND_UNSUB";
				$unSubscriptionTable="tbl_character_unsub1";
				$lang='01';
				break;
			case 'indicom_bosskey':
				$sc='5464692';
				$s_id='1602';
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='01';
				$operator = "TATC";
				break;
		}
		$con = mysql_connect("database.master","weburl","weburl");
		
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}

		if($reqtype == 1)
		{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT varchar(20),in IN_SID int,in IN_PID
			mysql_select_db($dbname,$con);
			$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			if ($text==1)
				echo  $sub;
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			if($rows1[0] <=0)
			{
				if(($planid==31) && ($servicename= 'Bollywood_Merijaan_Hungama'))
				{
					$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount','1',$s_id,$planid,'$CCGID')";
				}
				else
				$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid,'$CCGID')";
				if ($text==1) echo  $call;
				$qry1=mysql_query($call) or die( mysql_error() );
				if(($planid==31) && ($servicename= 'Bollywood_Merijaan_Hungama'))
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and cele_showid='1'";
				else
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
				if ($text==1) echo  $select;
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
				$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/indicom/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of reqtype=1

		if($reqtype == 2)
		{
			if(($planid==31) && ($servicename= 'Bollywood_Merijaan_Hungama'))
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}

			mysql_select_db($dbname,$con);
			$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			$qry5=mysql_query($unsub,$con);
			$rows5 = mysql_fetch_row($qry5);
			if($rows5[0] >= 1)
			{
				$call="call ".$dbname.".".$unSubscriptionProcedure."($msisdn,'$mode')";
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
				$log_file_path="logs/indicom/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/indicom/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/indicom/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";

				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of request type=2
		if($reqtype == 3)
		{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;

			mysql_select_db($dbname,$con);
			
			$sub="select count(*) from ".$dbname.".".$chatSubTable." where ANI='$msisdn'";
			if($_GET['test']) echo  $sub;
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			if($rows1[0] <=0)
			{
				$call="call ".$dbname.".".$chatProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$CCGID')";
				if ($text==1) echo  $call;
				$qry1=mysql_query($call) or die( mysql_error() );
				if(($planid==31) && ($servicename= 'Bollywood_Merijaan_Hungama'))
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and cele_showid='1'";
				else
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
				if ($text==1) echo  $select;
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
				$log_file_path="logs/indicom/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/indicom/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/indicom/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" .$remoteAdd."#". $rcode . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of reqtype=3
	}

?>