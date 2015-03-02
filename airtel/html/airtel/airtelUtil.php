<?php
error_reporting(0);
$msisdn=$_GET['msisdn'];
$param=$_GET['param'];
$reqtype=$_GET['reqtype'];
$curdate = date("Y-m-d");
$mode='UTIL';
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
				if($reqtype=='SUB' || $reqtype==1)
				{
					$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype=='UNSUB' || $reqtype==2)
				{
					$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
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
		if($reqtype=='SUB' || $reqtype==1)
		{
			$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype=='UNSUB' || $reqtype==2)
		{
			$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$seviceId);

if (($msisdn == "") || ($reqtype=="") || ($param==""))
{
	echo "Please provide the complete parameter";
}
else
{
	include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	//$con = mysql_connect("10.2.73.156","billing","billing");
	if(!$dbConn)
	{
		die('could not connect1: ' . mysql_error());
	}

	switch($param) {
		case '546461':
			$s_id='1503';
			$planid=27;
			$db="airtel_hungama";
			$subscriptionTable="tbl_mtv_subscription";
			$subscriptionProcedure="MTV_SUB";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='01';
			$serviceName='Hungama MTV DJ DIAL';
			break;
		case '54646':
			$s_id='1502';
			$db="airtel_hungama";			
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			$planid=26;
			$serviceName='Entertainment Portal (Hungama HM)';
			break;
		case '5464612':
			$s_id='1502';
			$db="airtel_hungama";			
			$subscriptionTable="tbl_comedyportal_subscription";
			$subscriptionProcedure="COMEDY_SUB";
			$unSubscriptionProcedure="COMEDY_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			$planid=50;
			$serviceName='Airtel Comedy';
			break;
		case '55841':
		case '55841V1':
			$sc='55841';
			$s_id='1507';
			
			if($param=='55841') $planid=28;
			elseif($param=='55841V1') $planid=47; 

			$db="airtel_vh1";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			$serviceName='Vh1 Radio GAGA Hungama';
			break;
		case '55001':
		case '55001G1':
		case '5500101':
			$s_id='1511';
			if($param == '55001') { 
				$sc='55001';
				$planid=29;
				$serviceName='Good Life Hungama';
			} elseif($param == '55001G1') { 
				$sc='55001';
				$planid=46;
				$serviceName='Good Life Hungama';
			} elseif($param == '5500101') {
				$sc='5500101';				
				$planid=34;
				$serviceName='Store@1';
			}			
			$db="airtel_rasoi";
			$subscriptionTable="tbl_rasoi_subscription";
			$subscriptionProcedure="RASOI_SUB";
			$unSubscriptionProcedure="RASOI_UNSUB";
			$unSubscriptionTable="tbl_rasoi_unsub";
			$lang='01';			
			break;
		case '5500169':
		case '5500169R1':
			$sc='5500169';
			$s_id='1511';
			if($param=='5500169') $planid=30;
			elseif($param=='5500169R1') $planid=48;
			$db="airtel_manchala";
			$subscriptionTable="tbl_riya_subscription";
			$subscriptionProcedure="RIYA_SUB";
			$unSubscriptionProcedure="RIYA_UNSUB";
			$unSubscriptionTable="tbl_riya_unsub";
			$lang='01';
			$serviceName='Miss Riya Hungama';
			break;
		case '53222345':
			$sc='53222345';
			$s_id='1514';
			$planid=40;
			$db="airtel_EDU";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			$serviceName='Personality Development (Hungama IVR)';			
			break;
		case '5464611':
		case '51050':
			$sc='51050';
			$s_id='1515';
			$planid=45;
			$db="airtel_devo";
			$subscriptionTable="tbl_devo_subscription";
			$subscriptionProcedure="DEVO_SUB";
			$unSubscriptionProcedure="devo_unsub";
			$unSubscriptionTable="tbl_devo_unsub";
			$lang='01';
			$serviceName='Airtel Devotional';			
			break;
		case '5500196':
			$sc='5500196';
			$s_id='1513';
			$planid=51;
			$db="airtel_mnd";
			$subscriptionTable="tbl_character_subscription1";
			$subscriptionProcedure="MND_SUB";
			$unSubscriptionProcedure="MND_UNSUB";
			$unSubscriptionTable="tbl_character_unsub1";
			$lang='01';
			$serviceName='Airtel My Naughty Diary';			
			break;
		case '5584112':
			$sc='5584112';
			$s_id='1507';
			$planid=33;
			$db="airtel_vh1";
			$subscriptionTable="tbl_vh1nightpack_subscription";
			$subscriptionProcedure="NIGHTPACK_SUB";
			$unSubscriptionProcedure="NIGHTPACK_UNSUB";
			$unSubscriptionTable="tbl_vh1nightpack_unsub";
			$lang='01';
			$serviceName='Airtel VH1 NightPack';			
			break;
		case '571811':
			$sc='571811';
			$s_id='1517';
			$planid=56;
			$db="airtel_SPKENG";
			$subscriptionTable="tbl_spkeng_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_spkeng_unsub";
			$lang='01';
			$serviceName='Airtel Spoken English';			
			break;
		case '546469':
			$sc='546469';
			$s_id='1501';
			$planid=20;
			$db="airtel_radio";
			$subscriptionTable="tbl_radio_subscription";
			$subscriptionProcedure="RADIO_SUB";
			$unSubscriptionProcedure="RADIO_UNSUB";
			$unSubscriptionTable="tbl_radio_unsub";
			$lang='01';
			$serviceName='Airtel Entertainment Unlimited';			
			break;
		case '5464613':
			$sc='5464613';
			$s_id='1520';
			$planid=59;
			$db="airtel_hungama";
			$subscriptionTable="tbl_pk_subscription";
			$subscriptionProcedure="PK_SUB";
			$unSubscriptionProcedure="PK_UNSUB";
			$unSubscriptionTable="tbl_pk_unsub";
			$lang='01';
			$serviceName='Airtel Palleturi Kathalu';			
			break;
		case '5464614':
			$sc='5464614';
			$s_id='1522';
			$planid=63;
			$db="airtel_hungama";
			$subscriptionTable="tbl_arm_subscription";
			$subscriptionProcedure="ARM_SUB";
			$unSubscriptionProcedure="ARM_UNSUB";
			$unSubscriptionTable="tbl_arm_unsub";
			$lang='01';
			$serviceName='Airtel Regional';			
			break;
	}

	if($reqtype == 'SUB' || $reqtype==1)
	{
		header("Content-type: text/xml");
		echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$s_id";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{
			$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$lang."','CC','".$sc."','".$amount."',".$s_id.",".$planid.")";
			$qry1=mysql_query($qry) or die( mysql_error() );
			$query2="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
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
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>SUB</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			echo $rcode = $abc[0];
			$log_file_path="logs/airtel/subscription/".$param."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#SUB\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
		if($result==1)
		{
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>ERROR</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			echo $rcode = $abc[1];
			$log_file_path="logs/airtel/subscription/".$param."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#ERROR\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
		if($result==2)
		{
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>ERROR</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			echo $rcode = $abc[2];
			$log_file_path="logs/airtel/subscription/".$param."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#ALREADY SUB\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
	}
	if($reqtype=='UNSUB' || $reqtype==2)
	{
		header("Content-type: text/xml");
		echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
		//This if condition for block & unblock unsubscription 5/14/2012
		/*$day = date("D");
		if($day == "Mon" || $day == "Wed" || $day == "Fri") { 
			if($param==55001 || $param==55841)
			{
				echo "<ROOT>\n";
				echo "</ROOT>\n";
				$log_file_path="logs/airtel/unsubscription/".$param."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#UNSUB_PENDING\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
		}*/

		$unsub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry5=mysql_query($unsub,$dbConn);
		$rows5 = mysql_fetch_row($qry5);
		if($rows5[0] >= 1)
		{		
			$unsubsQuery="call ".$db.".".$unSubscriptionProcedure." ('$msisdn','UTIL')";
			$qry1=mysql_query($unsubsQuery) or die( mysql_error() );
			$qry2=mysql_query("select count(*) from ".$db.".".$unSubscriptionTable."  where ANI='$msisdn'");
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
			
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>UNSUB</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			$log_file_path="logs/airtel/unsubscription/".$param."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#UNSUB\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
		if($result == 1)
		{
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>ERROR</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			$log_file_path="logs/airtel/unsubscription/".$param."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#ERROR\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
		if($result == 2)
		{
			echo "<ROOT>\n";
			echo "<SERVICE>\n";
			echo "<SVCID>".$param."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>ERROR</STATUS>\n";
			echo "</SERVICE>\n";
			echo "</ROOT>\n";
			echo $rcode = $abc[2];
			$log_file_path="logs/airtel/unsubscription/".$param."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#UTIL#" . $reqtype . "#" . date('H:i:s') . "#ALREADY UNSUB\r\n" );
			fclose($file);
			mysql_close($dbConn);
			exit;
		}
	}
}
?>   