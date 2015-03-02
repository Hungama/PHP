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
$lang =$_REQUEST['lang'];
$curdate = date("Y-m-d");
$vcode = $_REQUEST['vcode'];
$aftId=$_REQUEST['aftid'];
$mm = $_REQUEST['MM'];
$songCode = $_REQUEST['Songcode'];


$remoteAdd=trim($_SERVER['REMOTE_ADDR']);

if($reqtype == 3 && $servicename=="vmi_riya") $servicename="docomo_Riya";

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return "\n"."Url:".$pageURL;
}

$url=curPageURL(); //$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

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
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#".$remoteAdd . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
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
					$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#".$remoteAdd . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#".$remoteAdd . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
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
			$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#".$remoteAdd . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#".$remoteAdd . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}

$msisdn=checkmsisdn(trim($msisdn),$abc);

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
				$s_id='1005';
				if($planid==20)
				{
					$dbname="docomo_starclub";
					$subscriptionTable="tbl_celebrity_evt_ticket";
					$subscriptionProcedure="JBOX_PURCHASE_CELEBRITY_TICKET";
					$lang='HIN';
				}
				if($planid==18)
				{
					$dbname="docomo_starclub";
					$subscriptionTable="tbl_jbox_subscription";
					$subscriptionProcedure="JBOX_SUB";
					$unSubscriptionProcedure="JBOX_UNSUB";
					$unSubscriptionTable="tbl_jbox_unsub";
					$lang='HIN';
				}
				$operator = "TATM";
				break;
			case 'MTVLive_Hungama':
				$sc='546461';
				$s_id='1003';
				if($aftId) 
					$mode=$mode."#".$aftId;
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_mtv_subscription";
				$subscriptionProcedure="MTV_SUB";
				$unSubscriptionProcedure="MTV_UNSUB";
				$unSubscriptionTable="tbl_mtv_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'HungamaMedia_Hungama':
				$sc='546460';
				$s_id='1002';
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$operator = "TATM";
				$lang='HIN';
				break;
			case 'SanjeevKapoor_rasoi':
				$sc='';
				$s_id='';
				$dbname="docomo_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				$subscriptionProcedure="RASOI_SUB";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case '':
				if($planid==40)
			{
				$servicename='EndlessMusic_VMI';
				$sc='59090';
				$s_id='1801';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				$subscriptionProcedure="RADIO_SUB";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='HIN';
				$operator = "VIRM";
			}
			else
			{
				$servicename='EndlessMusic';
				$sc='59090';
				$s_id='1001';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				$subscriptionProcedure="RADIO_SUB";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='HIN';
				$operator = "TATM";
			}
				break;
			case 'EndlessMusic':
				$servicename='EndlessMusic';
				$sc='59090';
				$s_id='1001';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				$subscriptionProcedure="RADIO_SUB";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'EndlessMusic_VMI':
				$servicename='EndlessMusic_VMI';
				$sc='59090';
				$s_id='1801';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				$subscriptionProcedure="RADIO_SUB";
				$unSubscriptionProcedure="RADIO_UNSUB";
				$unSubscriptionTable="tbl_radio_unsub";
				$lang='HIN';
				$operator = "VIRM";
				break;
			case 'EndlessMusicSMS':
				$servicename='EndlessMusicSMS';
				$sc='5909010';
				$s_id='1001';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_smspack_sub";
				$subscriptionProcedure="RADIO_SMS_SUB";
				$unSubscriptionProcedure="RADIO_SMS_UNSUB";
				$unSubscriptionTable="tbl_radio_smspack_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_9XM':
				$sc='54646996';
				$s_id='1002';
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_Riya': 
				$sc='5464626';
				$s_id='1009';
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_riya_subscription";
				$subscriptionProcedure="RIYA_SUB";
				$chatProcedure="RIYA_CHAT_SUB";
				$chatSubTable="tbl_riya_celebchat_subscription";				
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_Prem':
				$sc='5464627';
				$s_id='1009';
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_prem_subscription";
				$subscriptionProcedure="PREM_SUB";
				$unSubscriptionProcedure="PREM_UNSUB";
				$unSubscriptionTable="tbl_prem_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_9XT': //tashan..
				$sc='54646997';
				$s_id='1002';
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_REDFM': //tashan..
				$sc='55935';
				$s_id='1010';
				$dbname="docomo_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;			
			case 'docomo_mylife': 
				$sc='55001';
				$s_id='1011';
				$dbname="docomo_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				$subscriptionProcedure="RASOI_SUB";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;			
			case 'docomo_vh1': 
				$sc='55841';
				$s_id='1007';
				$dbname="docomo_vh1";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'docomo_aav': 
				$sc='5464639';
				$s_id='1002';
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "TATM";
				break;
			case 'vmi_REDFM': //tashan..
				$sc='55935';
				$s_id='1810';
				$dbname="virgin_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "VIRM";
				break;
			case 'vmi_mylife': 
				$sc='55001';
				$s_id='1811';
				$dbname="virgin_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				$subscriptionProcedure="RASOI_SUB";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
				$lang='HIN';
				$operator = "VIRM";
				break;
			case 'vmi_riya': 
				$sc='5464626';
				$s_id='1809';
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_riya_subscription";
				$subscriptionProcedure="RIYA_SUB";
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
				$lang='HIN';
				$operator = "VIRM";
				break;
			case 'vmi_vh1': 
				$sc='55841';
				$s_id='1807';
				$dbname="docomo_vh1";
				$subscriptionTable="tbl_jbox_subscription";
				$subscriptionProcedure="JBOX_SUB";
				$unSubscriptionProcedure="JBOX_UNSUB";
				$unSubscriptionTable="tbl_jbox_unsub";
				$lang='HIN';
				$operator = "VIRM";
				break;
		}	
		$con = mysql_connect("database.master","weburl","weburl");
		
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
		
		if($_REQUEST['lang']) $lang=$_REQUEST['lang'];
		else $lang='HIN';

		if($reqtype == 1)
		{
			$log_file_path1="logs/docomo/capture/".$servicename."/subscapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a");
			fwrite($file1,$msisdn . "#" . $mode ."#".$aftId."#".$reqtype."#".$planid."#".$lang."#".$s_id."#".$subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:". $songCode."#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
			fclose($file1);

			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			#IN_ANI VARCHAR(16),in IN_LANG varchar(5),in IN_MOD VARCHAR(10),in IN_DNIS varchar(30),in IN_AMNT int,in celeshowid int, in IN_SID int,in IN_PID int
			mysql_select_db($dbname,$con);
			if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
				$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and cele_showid='1'";
			else
				$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			//if($_GET['test']) echo $sub;
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			
			
			if(isset($_REQUEST['vcode'])) 
				{ 
					mysql_select_db('master_db',$con);
					$insertOBDQuery = "INSERT INTO master_db.tbl_crbt_activation (msisdn,request_time,vcode,status,operator,serviceId,planId,Response, ipAddr,MM,songcode) VALUES ('".$msisdn."',NOW(), '".$vcode."', 0, '".$operator."','".$s_id."','".$planid."','','".trim($_SERVER['REMOTE_ADDR'])."','".$mm."', '".$songCode."')";
					$myResult=mysql_query($insertOBDQuery) or die(mysql_error()) ;
				}
			if($rows1[0] <=0)
			{
				if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama')) 
					$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount','1',$s_id,$planid)";
				else 
					$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid)";

				$qry1=mysql_query($call) or die( mysql_error() );
				if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and cele_showid='1'";
				else
					$select="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";

				$qry2=mysql_query($select);
				$row1 = mysql_num_rows($qry2);

				$result=0;
				
				/*if($row1>=1) $result=0;
				else $result=1; */
			} else {
				$result=2;
			}

			if($result == 0)
			{
				/*if(isset($_REQUEST['vcode'])) { 
					$insertOBDQuery = "INSERT INTO master_db.tbl_crbt_activation (msisdn,request_time,vcode,status,operator,serviceId,planId,Response,ipAddr, MM,songcode) VALUES ('".$msisdn."',NOW(),'".$vcode."',0,'".$operator."','".$s_id."','".$planid."','', '".trim($_SERVER['REMOTE_ADDR'])."','".$mm."', '".$songCode."')";
					mysql_query($insertOBDQuery);
				}*/

				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn."#".$mode."#".$aftId."#".$reqtype."#".$planid."#".$lang."#".$subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode."#". $insertOBDQuery."#Conn:".$con."#". date('H:i:s')."#".$rcode."#".$url. "\r\n" );
				fclose($file); //.$insertOBDQuery."#"
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				if(isset($_REQUEST['vcode'])) { 
					$insertOBDQuery = "INSERT INTO master_db.tbl_crbt_activation (msisdn,request_time,vcode,status,operator,serviceId,planId,Response, ipAddr,MM,songcode) VALUES ('".$msisdn."',NOW(), '".$vcode."', 1, '".$operator."','".$s_id."','".$planid."','','".trim($_SERVER['REMOTE_ADDR'])."','".$mm."', '".$songCode."')";
					mysql_query($insertOBDQuery);
				}
				if(strlen($_REQUEST['lang'])<=3 && $_REQUEST['lang']) { 
					$lang=$_REQUEST['lang'];
					$updateLang="UPDATE ".$dbname.".".$subscriptionTable." SET def_lang='".$lang."' WHERE ANI='".$msisdn."'";
					mysql_query($updateLang);
				}
				$rcode = $abc[2];
				echo "Already Subscribed";
				$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode ."#".$insertOBDQuery. "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of reqtype 1

		if($reqtype == 2)
		{
			if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang . "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			$log_file_path1="logs/docomo/delcapture/".$servicename."/delcapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a+");
			fwrite($file1,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang."#".$subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
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
				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang . "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of reqtype 2

		if($reqtype == 3)
		{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			mysql_select_db($dbname,$con);

			$sub="select count(*) from ".$dbname.".".$chatSubTable." where ANI='$msisdn'"; if($_GET['test']) echo $sub;
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);			
			
			if($rows1[0] <=0)
			{
				$call="call ".$dbname.".".$chatProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid)";
				$qry1=mysql_query($call) or die( mysql_error() );
			
				if($_GET['test']) echo $call;
	
				$select="select count(*) from ".$dbname.".".$chatSubTable." where ANI='$msisdn'";
				$qry2=mysql_query($select);
				$row1 = mysql_num_rows($qry2);

				$result=0;
				
			} else {
				$result=2;
			}

			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/docomo/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				if($s_id == '1001') {
					fwrite($file,$msisdn."#".$mode."#".$aftId."#".$reqtype."#".$planid."#".$lang."#".$subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode."#". $insertOBDQuery."#Conn:".$con."#". date('H:i:s')."#".$rcode."#".$url. "\r\n" );
				} else {
					fwrite($file,$msisdn."#".$mode."#".$aftId."#".$reqtype."#".$planid."#".$lang."#".$subchannel."#".$remoteAdd."#Conn:".$con."#". date('H:i:s')."#".$rcode."#".$url. "\r\n" );
				}
				fclose($file); 
				mysql_close($con);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/docomo/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				if($s_id == '1001') {
					fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode . "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				} else {
					fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				}
				fclose($file);
				mysql_close($con);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/docomo/event/".$servicename."/event_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				if($s_id == '1001') {
					fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype ."#".$planid."#".$lang. "#" . $subchannel."#".$remoteAdd."#Vcode:".$vcode."#MM:".$mm."#songC:".$songCode ."#".$insertOBDQuery. "#" . date('H:i:s') . "#" . $rcode."#".$url . "\r\n" );
				} else {
					fwrite($file,$msisdn . "#" . $mode . "#" .$aftId."#". $reqtype."#".$planid."#".$lang."#". $subchannel."#".$remoteAdd."#". date('H:i:s')."#".$rcode."#".$url."\r\n" );
				}
				fclose($file);
				mysql_close($con);
				exit;
			}
		} // end of reqtype=3
	}
?>   