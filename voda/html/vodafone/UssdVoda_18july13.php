<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode='USSD';
$reqtype=1;
$planid=$_REQUEST['planid'];
$servicename=trim($_REQUEST['servicename']);
$curdate = date("Y-m-d");
$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}

if(!isset($rcode))
{
	$rcode="SUCCESS,FAILURE,ALREADY-SUBSCRIBED";
}
$abc=explode(',',$rcode);
$ani_circle=array('917875682525'=>'13','919620368822'=>'10','919672992251'=>'19','918587800776'=>'05','919839977197'=>'22','919539521159'=>'11','918357820942'=>'14','919930128651'=>'15','919988260940'=>'18','918334831463'=>'12','918297407993'=>'01','918587800665'=>'05','917838666172'=>'05','918860777745'=>'05','919962004412'=>'04','919672992251'=>'19');


//if($mode=='USSD' && ($msisdn=='918860777745' || $msisdn=='918587800665' || $msisdn=='917838666172'|| $msisdn=='919962004412'|| $msisdn=='917875682525'|| $msisdn=='919620368822'|| $msisdn=='919672992251'|| $msisdn=='918587800776'|| $msisdn=='919839977197'|| $msisdn=='919539521159'|| $msisdn=='918357820942'|| $msisdn=='919930128651'|| $msisdn=='919988260940'|| $msisdn=='918334831463' || $msisdn=='918297407993' || $msisdn=='919672992251'))
if($mode=='USSD')
{
$logDir="/var/www/html/vodafone/logs/dc/";
$curdate = date("Ymd");
$logPath2 = $logDir."ccg_".$curdate.".txt";

if(strlen($msisdn)==10)
	{
		$msisdn='91'.$msisdn;
	}
	else
	{
		$msisdn=$msisdn;
	}
	$validseries=substr($msisdn, 2, 4);
	//$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$getCircle = "select circle from master_db.tbl_valid_series where series =$validseries";
	$circle1=mysql_query($getCircle,$con) or die( mysql_error() );
	$circleRow = mysql_fetch_row($circle1);
	
	
	//echo $circleRow[0];
	
	$operator_circle_map=array('01'=>'APD','02'=>'ASM','03'=>'BIH','18'=>'PUB','10'=>'KAR','13'=>'MAH','20'=>'TNU','23'=>'WBL','05'=>'DEL','14'=>'MPD','04'=>'CHN','21'=>'UPE','06'=>'GUJ','08'=>'HPD','07'=>'HAY','09'=>'JNK','11'=>'KER','12'=>'KOL','15'=>'MUM','16'=>'NES','17'=>'ORI','19'=>'RAJ','12'=>'UPW','07'=>'HAR');
	
	$operator_circle_map = array_flip($operator_circle_map);
	
//$cid=$ani_circle[$msisdn];
if($msisdn=='918587800665')
$cid=$ani_circle[$msisdn];
else
$cid=$operator_circle_map[$circleRow[0]];

$transId=date('YmdHis');
$reqsId=date('YmdHis')."12";


if($servicename=='vodafone_54646')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_ENTRMNTPORTAL&Class=ENTRMNTPORTAL&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*13&From=VENDOR&param1=NA&param2=NA&param3NA";
}
else if($servicename=='vodafone_redfm')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_REDFM&Class=REDFM&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*11&From=VENDOR&param1=NA&param2=NA&param3NA";
}
else if($servicename=='vodafone_vh1')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_VH1MUSIC&Class=VH1_MUSIC&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*12&From=VENDOR&param1=NA&param2=NA&param3NA";
}

$logurl="#url#".$url."#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
echo "Press OK to continue.";
session_unset();
session_destroy();
$logurl="#Seesion-Closed#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
sleep(2);
$logurl="#CGUSSD Request-Start#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
$status = file_get_contents($url);
$logresponse="#Response#".$status."#".date("Y-m-d H:i:s")."\n";
error_log($logresponse,3,$logPath2);
$logurl="#CGUSSD Request-End#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
//end here
//header("Location:". $url);
exit;
}
/********************end here**********************/

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
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
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
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
	}	
	

	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle,$con) or die( mysql_error() );
	$circleRow = mysql_fetch_row($circle1);
		
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
			if(strtoupper($circleRow[0])=='GUJ' && $servicename=='vodafone_54646')
				echo $rcode1 = "We had received your request, will update you shortly by SMS";
			else
				echo $rcode1 = $abc[0];
			
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode1 = $abc[1];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 2)
		{
			echo $rcode1 = $abc[2];
			$log_file_path="logs/vodafone/subscription/".$servicename."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
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
			echo $rcode1= $abc[0];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;

		}
		if($result == 1)
		{
			echo $rcode1 = $abc[1];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
		if($result == 2)
		{
			echo $rcode1 = $abc[2];
			$log_file_path="logs/vodafone/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode1 . "\r\n" );
			fclose($file);
			mysql_close($con);
			exit;
		}
	}
}




?>   
