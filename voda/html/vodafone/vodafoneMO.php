<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];//SMS
$mode='SMS';
//reqtype>>ACT/CAN/DCT MU2
$reqtype=$_REQUEST['reqtype'];
$subchannel =$_REQUEST['subchannel'];
$subkeyword =$_REQUEST['subkeyword'];
$servicename=trim($_REQUEST['servicename']);
$curdate = date("Ymd");

$rcode =$_REQUEST['rcode'];
$lang =$_REQUEST['lang'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
  
$langArray = array('TEL'=>'08','HIN'=>'01','TAM'=>'07','KAN'=>'10','ENG'=>'02','MAI'=>'21','MAL'=>'09','NEP'=>'19','ASS'=>'17', 'GUJ'=>'12','RAJ'=>'18','BHO'=>'04','PUN'=>'03','ORI'=>'13','MAR'=>'11','CHH'=>'16','HAR'=>'05','BEN'=>'06','HIM'=>'15','KAS'=>'14','KUM'=>'20');

$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}
	
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
	if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
	}
	
	
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$con);
	$circleRow = mysql_fetch_row($circle1);

	$operator_circle_map=array('01'=>'APD','02'=>'ASM','03'=>'BIH','18'=>'PUB','10'=>'KAR','13'=>'MAH','21'=>'TNU','20'=>'WBL','05'=>'DEL','14'=>'MPD','04'=>'CHN','22'=>'UPE','06'=>'GUJ','08'=>'HPD','07'=>'HAY','09'=>'JNK','11'=>'KER','12'=>'KOL','15'=>'MUM','16'=>'NES','17'=>'ORI','19'=>'RAJ','23'=>'UPW','07'=>'HAR');
	
	$operator_circle_map = array_flip($operator_circle_map);
	
$cid=$operator_circle_map[$circleRow[0]];


			$log_file_path="/var/www/html/vodafone/mo/vodafone/allrequest_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $circleRow[0]."#".$cid."#".$mode . "#" . $reqtype . "#" . $subkeyword . "#" . $servicename."#LC:".$lang . "#" . date('H:i:s') . "#" . $remoteAdd . "\r\n" );
			fclose($file);
			
echo 'SUCCESS';	
mysql_close($con);
exit;		
/*

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);


if (!is_numeric("$planid"))
{
	echo $abc[1];
	$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
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
					$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
		case 'vodafone_54646':
			$sc='54646';
			$s_id='1302';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_MTV':
			$sc='546461';
			$s_id='1303';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_mtv_subscription";
			$subscriptionProcedure="MTV_SUB";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='HIN';
			break;
		case 'vodafone_AAV':
			$sc='5464611';
			$s_id='1302';
			$dbname="vodafone_hungama";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_vh1':
			$sc='55841';
			$s_id='1307';
			$dbname="vodafone_vh1";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		case 'vodafone_redfm':
			$sc='55935';
			$s_id='1310';
			$dbname="vodafone_redfm";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$unSubscriptionProcedure="jbox_unsub";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
			break;
		default: echo "Invalid Service name"; exit;
	}	
	$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}
	
	if($_REQUEST['lang']) { $lang=$_REQUEST['lang']; }
	
	if(!is_numeric($lang)) $langValue = $langArray[strtoupper($lang)];
	elseif(is_numeric($lang)) $langValue = $lang;
	else $langValue="01";

	if($reqtype == 1)
	{
		
		$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		mysql_select_db($dbname,$con);

		$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{
			$call="call ".$subscriptionProcedure."($msisdn,'$langValue','$mode','$sc','$amount',$s_id,$planid)";
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
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode = $abc[1];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 2)
		{
			if($_REQUEST['lang']) {
				$updateLang="UPDATE ".$dbname.".".$subscriptionTable." SET def_lang='".$langValue."' WHERE ANI='".$msisdn."'";
				mysql_query($updateLang);
			}

			echo $rcode = $abc[2];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang."#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
	}
	if($reqtype == 2)
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
		}else
		{
			$result=2;
		}
		if($result == 0)
		{
			echo $rcode = $abc[0];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang."#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode = $abc[1];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
		if($result == 2)
		{
			echo $rcode = $abc[2];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel."#L:".$langValue."#LC:".$lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
	}
}


*/

?>