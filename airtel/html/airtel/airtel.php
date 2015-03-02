<?php
error_reporting(0);
$msisdn=trim($_REQUEST['msisdn']);
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$subchannel =$_REQUEST['subchannel'];
$rcode =$_REQUEST['rcode'];
$seviceId=$_REQUEST['serviceid'];
$test=$_REQUEST['test'];
$ac=$_REQUEST['ac'];
$dnis = $_REQUEST['dnis'];
$lang = $_REQUEST['lang'];
$religion = $_REQUEST['rel'];
$curdate = date("Y-m-d");

if(isset($_REQUEST['flag'])) {
	$flag=$_REQUEST['flag'];
} else {
	$flag=1;
}


$langArray = array('TEL'=>'08','HIN'=>'01','TAM'=>'07','KAN'=>'10','ENG'=>'02','MAI'=>'21','MAL'=>'09','NEP'=>'19','ASS'=>'17', 'GUJ'=>'12','RAJ'=>'18','BHO'=>'04','PUN'=>'03','ORI'=>'13','MAR'=>'11','CHH'=>'16','HAR'=>'05','BEN'=>'06','HIM'=>'15','KAS'=>'14','KUM'=>'20');

if(!isset($rcode))
{
	if($mode=='USSD' || $mode=='ussd')
	{
		if ($seviceId=='1507')
		{
			if($reqtype=='1')
				$rcode="Your request to Start Vh1 Radio GAGA service has been submitted successfully.,Sorry!Your subscription to Vh1 Radio GAGA could not be processed due to some technical problem. Please try again later.,You are already subscribed to Vh1 Radio GAGA service. Dial 55841 (Tollfree) to enjoy International music.";
			if($reqtype=='2')
				$rcode="Your request to Stop Vh1 Radio GAGA service has been submitted successfully. Thank you for using Vh1 Radio GAGA service.,Sorry!Your request to Stop Vh1 Radio GAGA could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from Vh1 Radio GAGA service.";
		}
		elseif($seviceId=='1502')
		{
			if($reqtype=='1')
				$rcode="Your request to Start Entertainment Zone service has been submitted successfully.,Sorry! Your subscription to Entertainment Zone service could not be processed due to some technical problem. Please try again later.,You are already subscribed to Entertainment Zone service.";
			if($reqtype=='2')
				$rcode="Your request to Stop Entertainment Zone service has been submitted successfully. Thank you for using Entertainment Zone service.,Sorry! Your request to Stop Entertainment Zone service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from Entertainment Zone service.";
		}
		elseif($seviceId=='1511')
		{
			if($reqtype=='1')
				$rcode="Your request to Start GOOD LIFE service has been submitted successfully.,Sorry!Your subscription to GOOD LIFE could not be processed due to some technical problem. Please try again later.,You are already subscribed to GOOD LIFE service. Dial 55001 @ 2p/sec to listen and enjoy the service.";
			if($reqtype=='2')
				$rcode="Your request to Stop GOOD LIFE service has been submitted successfully. Thank you.,Sorry!Your request to Stop GOOD LIFE could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from GOOD LIFE service.";
		}
		elseif($seviceId=='1503')
		{
			if($reqtype=='1')
				$rcode="Your request to Start MTV DJ DIAL service has been submitted successfully.,Sorry! Your subscription to MTV DJ DIAL service could not be processed due to some technical problem. Please try again later.,You are already subscribed to MTV DJ DIAL service.";
			if($reqtype=='2')
				$rcode="Your request to Stop MTV DJ DIAL service has been submitted successfully. Thank you for using MTV DJ DIAL service.,Sorry! Your request to Stop MTV DJ DIAL service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from MTV DJ DIAL service.";
		}
		elseif($seviceId=='1514')
		{
			
			if($reqtype=='1')
				$rcode="Your request to Start Personality Development service has been submitted successfully.,Sorry! Your subscription to Personality Development service could not be processed due to some technical problem. Please try again later.,You are already subscribed to Personality Development service. ";
			if($reqtype=='2')
				$rcode="Your request to Stop Personality Development service has been submitted successfully. Thank you for using Personality Development service.,Sorry! Your request to Stop Personality Development service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from Personality Development service.";
		}
		elseif($seviceId=='1515')
		{
			if($reqtype=='1')
				$rcode="Your request to Start SARNAM service has been submitted successfully.,Sorry! Your subscription to SARNAM service could not be processed due to some technical problem. Please try again later.,You are already subscribed to SARNAM service. ";
			if($reqtype=='2')
				$rcode="Your request to Stop SARNAM service has been submitted successfully. Thank you for using SARNAM service.,Sorry! Your request to Stop SARNAM service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from SARNAM service.";
		}
		elseif($seviceId=='1517')
		{
			if($reqtype=='1')
				$rcode="Your request to Start SPOKEN ENGLISH service has been submitted successfully.,Sorry! Your subscription to SPOKEN ENGLISH service could not be processed due to some technical problem. Please try again later.,You are already subscribed to SPOKEN ENGLISH service.";
				//$rcode="Welcome to Spoken English. Subscribe @Rs5/day and get 10 free min. Reply"."\n"."1 to Subscribe"."\n"."2 to Unsubscribe"."\n"."Select option,Sorry! Your subscription to SPOKEN ENGLISH service could not be processed due to some technical problem. Please try again later.,You are already subscribed to SPOKEN ENGLISH service.";
			if($reqtype=='2')
				$rcode="Your request to Stop SPOKEN ENGLISH service has been submitted successfully. Thank you for using SPOKEN ENGLISH service.,Sorry! Your request to Stop SPOKEN ENGLISH service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from SPOKEN ENGLISH service.";
		}
		elseif($seviceId=='1501')
		{
			if($reqtype=='1')
				$rcode="Your request to Start Entertainment Unlimited service has been submitted successfully.,Sorry! Your subscription to Entertainment Unlimited service could not be processed due to some technical problem. Please try again later.,You are already subscribed to Entertainment Unlimited service.";
			if($reqtype=='2')
				$rcode="Your request to Stop Entertainment Unlimited service has been submitted successfully. Thank you for using Entertainment Unlimited service.,Sorry! Your request to Stop Entertainment Unlimited service could not be processed due to some technical problem. Please try again later.,You are already unsubscribed from Entertainment Unlimited service.";
		}
	}
	else
		$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

if (!is_numeric("$planid") && $reqtype==1)
{
	echo $abc[1];
	$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
	fclose($file);
	exit;
}
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
				if($reqtype==1)
				{
					$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				if($reqtype==2)
				{
					$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
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
			$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);

if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid=="" && $reqtype==1))
{
	echo "Please provide the complete parameter";
	if($reqtype==1)
		{
			$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
		if($reqtype==2)
		{
			$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
}
else
{
	include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	if(!$dbConn)
	{
		die('could not connect: ' . mysql_error());
	}
	//get circle here

$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle"; 
$circle1=mysql_query($getCircle) or die( mysql_error() );
while($row = mysql_fetch_array($circle1)) {
	$circle = $row['circle'];
}
if(!$circle) { $circle='UND'; }
	switch($seviceId)
	{
		case '1503':
			$sc='546461';
			$s_id='1503';
			$db="airtel_hungama";
			$subscriptionTable="tbl_mtv_subscription";
			//$subscriptionProcedure="MTV_SUB";
			$subscriptionProcedure="MTV_SUBBULK";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='01';
		break;
		case '1502':
			$s_id='1502';
			$db="airtel_hungama";
			$subscriptionTable="tbl_jbox_subscription";
			//$subscriptionProcedure="JBOX_SUB";
			$subscriptionProcedure="JBOX_SUBBULK";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
			if($ac==1) {
				$sc='546469';
			} elseif($ac==2) { 
				$sc='5464612';		
				$s_id='1518';
				$subscriptionTable="tbl_comedyportal_subscription";
				//$subscriptionProcedure="COMEDY_SUB";
				$subscriptionProcedure="COMEDY_SUBBULK";
				$unSubscriptionProcedure="COMEDY_UNSUB";
				$unSubscriptionTable="tbl_comedyportal_unsub";
			} else {
				$sc='54646';		
			}
		break;		
		case '1507':
			$sc='55841';
			$s_id='1507';
			$db="airtel_vh1";
			$subscriptionTable="tbl_jbox_subscription";
			//$subscriptionProcedure="JBOX_SUB";
			$subscriptionProcedure="JBOX_SUBBULK";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
		break;
		case '1511':			
			$s_id='1511';
			if($planid == 30 || $planid == 48){
				if($dnis==1) $sc='54646169';
				else $sc='5500169';
				$db="airtel_manchala";
				$subscriptionTable="tbl_riya_subscription";
				//$subscriptionProcedure="RIYA_SUB";
				$subscriptionProcedure="RIYA_SUBBULK";
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
			} elseif($planid == 29 || $planid == 46) {
				$sc='55001';
				$db="airtel_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				//$subscriptionProcedure="RASOI_SUB";
				$subscriptionProcedure="RASOI_SUBBULK";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
			} elseif($planid == 34) {
				$sc='5500101';
				$db="airtel_rasoi";
				$subscriptionTable="tbl_storeatone_subscription";
				//$subscriptionProcedure="STOREATONE_SUB";
				$subscriptionProcedure="STOREATONE_SUBBULK";
				$unSubscriptionProcedure="STOREATONE_UNSUB";
				$unSubscriptionTable="tbl_storeatone_unsub";
			}
			$lang='01';
		break;
		case '1514':
			$sc='53222345';
			$s_id='1514';
			$db="airtel_EDU";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUBBULK_USSD";
			//$subscriptionProcedure="JBOX_SUBBULK";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			//$lang='01';			
			switch($circle)
			{
				case 'KAR':
				$lang='10';
				break;
				case 'APD':
				$lang='08';
				break;
				default:
				$lang='01';
				break;
			}	
		break;
		case '1513':
			$sc='5500196';
			$s_id='1513';
			$db="airtel_mnd";
			$subscriptionTable="tbl_character_subscription1";
			//$subscriptionProcedure="MND_SUB";
			$subscriptionProcedure="MND_SUBBULK";
			$unSubscriptionProcedure="MND_UNSUB";
			$unSubscriptionTable="tbl_character_unsub1";
			$lang='01';			
		break;
		case '1515':
			$sc='51050';
			$s_id='1515';
			$db="airtel_devo";
			$subscriptionTable="tbl_devo_subscription";
			//$subscriptionProcedure="DEVO_SUB";
			$subscriptionProcedure="DEVO_SUBBULK";
			$unSubscriptionProcedure="devo_unsub";
			$unSubscriptionTable="tbl_devo_unsub";
			$lang='01';			
		break;
		case '1518':
			$sc='5464612';			
			$s_id='1518';
			$db="airtel_hungama";
			$subscriptionTable="tbl_comedyportal_subscription";
			//$subscriptionProcedure="COMEDY_SUB";
			$subscriptionProcedure="COMEDY_SUBBULK";
			$unSubscriptionProcedure="COMEDY_UNSUB";
			$unSubscriptionTable="tbl_comedyportal_unsub";
			$lang='01';
		break;
		case '1517':
			$sc='571811';			
			$s_id='1517';
			$db="airtel_SPKENG";
			$subscriptionTable="tbl_spkeng_subscription";
			//$subscriptionProcedure="JBOX_SUB";
			$subscriptionProcedure="JBOX_SUB_BULK";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_spkeng_unsub";
			$lang='01';
		break;
		case '1501':
			$sc='546469';			
			$s_id='1501';
			$db="airtel_radio";
			$subscriptionTable="tbl_radio_subscription";
			//$subscriptionProcedure="RADIO_SUB";
			$subscriptionProcedure="RADIO_SUBBULK";
			$unSubscriptionProcedure="RADIO_UNSUB";
			$unSubscriptionTable="tbl_radio_unsub";
			$lang='01';
		break;
		case '1520':
			$sc='5464613';			
			$s_id='1520';
			$db="airtel_hungama";
			$subscriptionTable="tbl_pk_subscription";
			//$subscriptionProcedure="PK_SUB";
			$subscriptionProcedure="PK_SUBBULK";
			$unSubscriptionProcedure="PK_UNSUB";
			$unSubscriptionTable="tbl_pk_unsub";
			$lang='01';
		break;
		case '1521':
			$sc='5464613';			
			$s_id='1521';
			$db="airtel_smspack";
			if($planid == 62) { 
				$subscriptionTable="TBL_ASTRO_SUBSCRIPTION";
				$subscriptionProcedure="ASTRO_SUB_BULK";
				$unSubscriptionProcedure="ASTRO_UNSUB";
				$unSubscriptionTable="TBL_ASTRO_SUBSCRIPTION_LOG";
			}  elseif($planid == 61) {
				$subscriptionTable="TBL_SEXEDU_SUBSCRIPTION";
				$subscriptionProcedure="SEXEDU_SUB_BULK";
				$unSubscriptionProcedure="SEXEDU_UNSUB";
				$unSubscriptionTable="TBL_SEXEDU_SUBSCRIPTION_LOG";
			} elseif($planid == 60) {
				$subscriptionTable="TBL_VASTU_SUBSCRIPTION";
				$subscriptionProcedure="VASTU_SUB_BULK";
				$unSubscriptionProcedure="VASTU_UNSUB";
				$unSubscriptionTable="TBL_VASTU_SUBSCRIPTION_LOG";
			}
			$lang='01';
		break;
		case '1522':
			$sc='5464614';			
			$s_id='1522';
			$db="airtel_hungama";
			$subscriptionTable="tbl_arm_subscription";
			//$subscriptionProcedure="ARM_SUB";
			$subscriptionProcedure="ARM_SUBBULK";
			$unSubscriptionProcedure="ARM_UNSUB";
			$unSubscriptionTable="tbl_arm_unsub";
			$lang='01';
		break;
		case '1523':
			$sc='5500181';			
			$s_id='1523';
			$db="airtel_TINTUMON";
			$subscriptionTable="tbl_TINTUMON_subscription";
			//$subscriptionProcedure="ARM_SUB";
			$subscriptionProcedure="TINTUMON_SUB";
			$unSubscriptionProcedure="TINTUMON_UNSUB";
			$unSubscriptionTable="tbl_TINTUMON_unsub";
			$lang='01';
		break;
	}	
	
	function getReligion($religion) {
		$query = mysql_query("SELECT religion FROM airtel_devo.tbl_religion_detail WHERE religion like '%".$religion."%'");
		list($religionValue) = mysql_fetch_array($query);
		return $religionValue;
	}	

	if($_REQUEST['lang']) $lang=$_REQUEST['lang'];
	$langValue = $langArray[strtoupper($lang)];
	if(!$langValue) $langValue="01";

	if($reqtype == 1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
	
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;

		if($mode == 'USSD' && $s_id=='1515') {
			$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
			$circle1=mysql_query($getCircle) or die( mysql_error() );
			while($row = mysql_fetch_array($circle1)) {
				$circle = $row['circle'];
			}
			if(!$circle) { $circle='UND'; }

			$query1 = "SELECT planId,amount,religion FROM airtel_devo.tbl_religionPlan_detail WHERE circle='".$circle."'";
			$result11=mysql_query($query1);
			while($rowData = mysql_fetch_array($result11)) {
				$NewPlanId = $rowData['planId'];
				$NewAmount = $rowData['amount'];
				$NewReligion = $rowData['religion'];
				
				if(is_numeric($NewPlanId)) {
					$planid = $NewPlanId;
					$amount = $NewAmount;
				}

				if($NewReligion != 'null') {
					$religionflag=1;
					$religion = $NewReligion;
				} else {
					$religionflag=0;
				}
			}
		}
		
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{	
		if($s_id==1523)
		$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$langValue."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		else
		$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$langValue."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.",'0')";

			$qry1=mysql_query($qry) or die( mysql_error() );
			
			if($mode == 'USSD' && $s_id=='1515' && $religionflag) {
				mysql_query("DELETE FROM airtel_devo.tbl_religion_profile WHERE ANI='".$msisdn."'");
				$insertReligion = "INSERT INTO airtel_devo.tbl_religion_profile (ANI, lastreligion_cat, lang) VALUES ('".$msisdn."', '".strtolower($religion)."', '".$lang."')";
				mysql_query($insertReligion);
			}

			if($_REQUEST['rel'] && $s_id=='1515') {
				$religion = $_REQUEST['rel'];
				$countData = mysql_query("SELECT count(*) FROM airtel_devo.tbl_religion_profile WHERE ANI='".$msisdn."'");
				list($countRel) = mysql_fetch_array($countData);
				$religionValue = getReligion($religion);
				$lang = $_REQUEST['lang'];
				$langValue = $langArray[strtoupper($lang)];
				if(!$langValue) $langValue="01";
				if($countRel) {									
					$updateReligion = "UPDATE airtel_devo.tbl_religion_profile SET lastreligion_cat='".strtolower($religionValue)."',lang='".$langValue."' WHERE ANI='".$msisdn."'";
					mysql_query($updateReligion);
					if($_REQUEST['test']) echo $updateReligion;
				} else {
					$insertReligion = "INSERT INTO airtel_devo.tbl_religion_profile (ANI, lastreligion_cat, lang) VALUES ('".$msisdn."', '".strtolower($religionValue)."', '".$langValue."')";
					mysql_query($insertReligion);
					if($_REQUEST['test']) echo $insertReligion;
				}
			}

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
				echo $rcode = $abc[0];
				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
				
			if($result==1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
			if($result==2)
			{
				echo $rcode = $abc[2];
				
				if(strlen($_REQUEST['lang'])<=3 && $_REQUEST['lang']) { 
					$lang = $_REQUEST['lang'];
					$langValue = $langArray[strtoupper($lang)];
					$updateLang="UPDATE ".$dbname.".".$subscriptionTable." SET def_lang='".$langValue."' WHERE ANI='".$msisdn."'";
					mysql_query($updateLang);
				}
				
				if($_REQUEST['rel'] && $s_id=='1515') {
					$religion = $_REQUEST['rel'];
					$countData = mysql_query("SELECT count(*) FROM airtel_devo.tbl_religion_profile WHERE ANI='".$msisdn."'");
					list($countRel) = mysql_fetch_array($countData);
					//echo "hello".$countRel;
					$religionValue = getReligion($religion);
					$lang = $_REQUEST['lang'];
					$langValue = $langArray[strtoupper($lang)];
					if(!$langValue) $langValue="01";
					if($countRel) {									
						$updateReligion = "UPDATE airtel_devo.tbl_religion_profile SET lastreligion_cat='".strtolower($religionValue)."',lang='".$langValue."' WHERE ANI='".$msisdn."'";
						mysql_query($updateReligion);
						if($_REQUEST['test']) echo $updateReligion;
					} else {
						$insertReligion = "INSERT INTO airtel_devo.tbl_religion_profile (ANI, lastreligion_cat, lang) VALUES ('".$msisdn."', '".strtolower($religionValue)."', '".$langValue."')";
						mysql_query($insertReligion);
						if($_REQUEST['test']) echo $insertReligion;
					}
				}

				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
		}

		if($reqtype == 2)
		{
			$unsub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry5=mysql_query($unsub);
			$rows5 = mysql_fetch_row($qry5);
			if($rows5[0] >= 1)
			{
				/*if($s_id=='1513') {
					$ch="ch".$flag;
					$unsubsQuery="call ".$db.".".$unSubscriptionProcedure." ('$msisdn','$mode','".$ch."')";
				} else {*/
					$unsubsQuery="call ".$db.".".$unSubscriptionProcedure." ('$msisdn','$mode')";	
				//}
				
				$qry1=mysql_query($unsubsQuery); // or die( mysql_error() );
				$qry2=mysql_query("select count(*) from ".$db.".".$unSubscriptionTable."  where ANI='$msisdn'");
				$row1 = mysql_fetch_row($qry2);
				if($row1[0]>=1)
				{
					$result=0;
				}else
				{
					$result=1;
				}
			} else {
				$result=2;
			}
			if($result == 0)
			{
				echo $rcode = $abc[0];
				$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
			if($result == 1)
			{
				echo $rcode = $abc[1];
				$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
			if($result == 2)
			{
				echo $rcode = $abc[2];
				$log_file_path="logs/airtel/unsubscription/".$seviceId."/unsubscription_".$curdate.".txt";
				
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
		}
}
?>   