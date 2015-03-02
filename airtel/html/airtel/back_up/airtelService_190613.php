<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$mode='USSD';
$reqtype=$_REQUEST['reqtype'];
if(!isset($reqtype)) 
	$reqtype=0;
$planid=$_REQUEST['planid'];
$friendMDN=$_REQUEST['fmdn'];
$serviceId=$_REQUEST['serviceid'];
$test=$_REQUEST['test'];
$curdate = date("Y-m-d");

$logPath = "/var/www/html/airtel/logs/airtelService/".$serviceId."/log_".date("Y-m-d").".txt";
$allLogPath = "/var/www/html/airtel/logs/airtelService/".$serviceId."/AllLogs_".date("Y-m-d").".txt";

/*****************************check msisdn start*****************/
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
	die('could not connect: ' . mysql_error());

function checkmsisdnonly($msisdn)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
		}		
	} else {
		$msisdn='';
	}
	return $msisdn;
}
$msisdn=checkmsisdnonly(trim($msisdn));

$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
$circle1=mysql_query($getCircle) or die( mysql_error() );
while($row = mysql_fetch_array($circle1)) {
	$circle = $row['circle'];
}


if(!$circle) { $circle='UND'; }

/******************************end here**************************/

//---------------- end here ------------------------------
if($serviceId==1523)
{
	include("/var/www/html/airtel/airtelService_tint.php");
	exit;
}
switch($serviceId)
{
	case '1517':
		$sc='571811';			
		$s_id='1517';
		$db="airtel_SPKENG";
		$subscriptionTable="tbl_spkeng_subscription";
		$subscriptionProcedure="JBOX_SUB";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_spkeng_unsub";
		$lang='01';	
		$actSucc = "Your request to Start SPOKEN ENGLISH service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to SPOKEN ENGLISH service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to SPOKEN ENGLISH service.";
		$deactSucc = "Your request to Stop SPOKEN ENGLISH service has been submitted successfully. Thank you for using SPOKEN ENGLISH service.";
		$deactFail = "Sorry! Your request to Stop SPOKEN ENGLISH service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from SPOKEN ENGLISH service.	";
	break;
	case '1518':
		$sc='5464612';			
		$s_id='1518';
		$db="airtel_hungama";
		$subscriptionTable="tbl_comedyportal_subscription";
		$subscriptionProcedure="COMEDY_SUB";
		$unSubscriptionProcedure="COMEDY_UNSUB";
		$unSubscriptionTable="tbl_comedyportal_unsub";
		$lang='01';	
		$actSucc = "Your request to Start MANA PAATA MANA COMEDY service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to MANA PAATA MANA COMEDY service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to MANA PAATA MANA COMEDY service.";
		$deactSucc = "Your request to Stop MANA PAATA MANA COMEDY service has been submitted successfully. Thank you for using MANA PAATA MANA COMEDY service.";
		$deactFail = "Sorry! Your request to Stop MANA PAATA MANA COMEDY service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from MANA PAATA MANA COMEDY service.";
		$ussdLogPath = "/var/www/html/airtel/ussdlogs/MPMC_log_".date("Y-m-d").".txt";	
		
		if($serviceId == '1518') {
			$selData = "SELECT count(*) FROM master_db.tbl_ussd_activation WHERE circle='".$circle."' and service_id='".$serviceId."' and sysdate() between starttime and endtime and status=1 and type='direct'"; 
			$result1 = mysql_query($selData);
			$check = mysql_fetch_row($result1);
			//echo $check[0];
			if($check[0]>0) {
				$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
				$qry1=mysql_query($sub);
				$cont = mysql_fetch_row($qry1);	
				if($cont[0]<=0 && $reqtype==0) {
					$planid='50';
					$reqtype=1;
				}
			}
		}
	break;
	case '1515':
		$sc='51050';			
		$s_id='1515';
		$db="airtel_devo";
		$subscriptionTable="tbl_devo_subscription";
		/*if($msisdn==9971530333 || $msisdn==9910998340 || $msisdn==8527000779) {
			$subscriptionProcedure="DEVO_USSD_SUB"; //exit;
        } else */
		$subscriptionProcedure="DEVO_SUB";

		$unSubscriptionProcedure="DEVO_UNSUB";
		$unSubscriptionTable="tbl_devo_unsub";
		$lang='01';	
		$actSucc = "Your request to Start SARNAM service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to SARNAM service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to SARNAM service.";
		$deactSucc = "Your request to Stop SARNAM service has been submitted successfully. Thank you for using SARNAM service.";
		$deactFail = "Sorry! Your request to Stop SARNAM service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from SARNAM service.	";
			
		$response1 = 'Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs. '."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Unsubscribe";
		/*if($circle == "UPW") {			
			$response1 = 'Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs. '."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Refer A Friend";
		} else {
			$response1 = 'Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs. '."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Unsubscribe";
		}*/

		if($serviceId == '1515') {
			$selData = "SELECT count(*) FROM master_db.tbl_ussd_activation WHERE circle='".$circle."' and service_id='".$serviceId."' and sysdate() between starttime and endtime and status=1 and type='direct'"; 
			$result1 = mysql_query($selData);
			$check = mysql_fetch_row($result1);
			//echo $check[0];
			if($check[0]>0) {
				$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
				$qry1=mysql_query($sub);
				$cont = mysql_fetch_row($qry1);	
				if($cont[0]<=0 && $reqtype==0) {
					$planid='41';
					$reqtype=1;
				}
			}
		}

		switch($circle) {
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
	case '1514':
		$sc='53222345';			
		$s_id='1514';
		$db="airtel_EDU";
		$subscriptionTable="tbl_jbox_subscription";
		$subscriptionProcedure="JBOX_SUB";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
	
			switch($circle) {
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
		
		$actSucc = "Your request to Start Personality Development service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to Personality Development service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to Personality Development service.";
		$deactSucc = "Your request to Stop Personality Development service has been submitted successfully. Thank you for using Personality Development service.";
		$deactFail = "Sorry! Your request to Stop Personality Development service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from Personality Development service.";		
	break;
	case '1511':
		$sc='55001';			
		$s_id='1511';
		$db="airtel_rasoi";
		$subscriptionTable="tbl_rasoi_subscription";
		$subscriptionProcedure="RASOI_SUB";
		$unSubscriptionProcedure="RASOI_UNSUB";
		$unSubscriptionTable="tbl_rasoi_unsub";	
		
	/*	$actSucc = "Thanks for subscribing to LIFESTYLE! Get daily exciting tips on Relationships, love, dating & fashion. To listen, just dial 55001(Toll free).";
		$actFail = "Sorry! Your subscription to LIFESTYLE service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to LIFESTYLE service.";
		$deactSucc = "Your request to Stop LIFESTYLE service has been submitted successfully. Thank you for using LIFESTYLE service.";
		$deactFail = "Sorry! Your request to Stop LIFESTYLE service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from LIFESTYLE service.";		
		*/
		$actSucc = "Thanks for subscribing to Lifestyle Dressing Room! Get daily exciting tips on Relationships,fashion &more. To listen,just dial 55001(Toll free).";
		$actFail = "Sorry! Your subscription to Lifestyle Dressing Room service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to Lifestyle Dressing Room service.";
		$deactSucc = "Your request to Stop Lifestyle Dressing Room service has been submitted successfully. Thank you for using Lifestyle Dressing Room service.";
		$deactFail = "Sorry! Your request to Stop Lifestyle Dressing Room service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from Lifestyle Dressing Room service.";
		
	
		/*$actSucc = "Thanks for subscribing to Good Life! Get to learn authentic dishes . To listen, just dial 55001(Toll free)";
		$actFail = "Sorry! Your subscription to Good Life service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to Good Life.";
		$deactSucc = "To restart the service dial 5XXXX or *321*001#.";
		$deactFail = "Sorry! Your request to Stop Good Life service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from Good Life service.";
		*/
	break;
	case '1501':
		$sc='546469';
		$s_id='1501';
		$db="airtel_radio";
		$subscriptionTable="tbl_radio_subscription";
		$subscriptionProcedure="RADIO_SUB";
		$unSubscriptionProcedure="RADIO_UNSUB";
		$unSubscriptionTable="tbl_radio_unsub";
		$lang='01';		
		$actSucc = "Your request to start Entertainment Unlimited service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to Entertainment Unlimited service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribe to the service.";
		$deactSucc = "You request has been received to stop Entertainment unlimited from your mobile phone. Dial 546469 to subscribe again.";
		$deactFail = "Sorry! Your request to Stop Entertainment unlimited service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are not subscribe to the service. Dial 546469 to subscribe now.";
	break;
}

//------------- Refer logic ------------------


if($msisdn=='9999245707' && $serviceId==1501)
{
$referUrl = "/var/www/html/airtel/referFriendEU.php"; 
include_once($referUrl);
exit;
}
$chkRFlag = 0;
$referdUser = mysql_query("SELECT count(1) FROM master_db.tbl_refer_ussdData where friendANI='".$msisdn."' and endDate>=".date('Y-m-d')." and service_id=".$serviceId." and referFrom='Friend'");
list($chkRFlag) = mysql_fetch_array($referdUser);
if($serviceId == 1) 
$serviceArray = array(1514,1517);
else 
$serviceArray = array($serviceId);


$referCount =0;
$retData=0;

if($serviceId==1 || $serviceId==1514 || $serviceId==1517) {
	$q="SELECT count(1) FROM master_db.tbl_refer_ussdMDN where service_id IN (".implode(",",$serviceArray).") and ANI='".$msisdn."'";
	$referData = mysql_query($q);
	list($referCount) = mysql_fetch_array($referData);
	$retData=1;
} else {
	if($circle == "UPW" && ($serviceId == 1515)) { 
		$referCount=1;

	}
}
$referUrl = "/var/www/html/airtel/referFriend.php"; 
if($msisdn==9910040744)
	$referUrl = "/var/www/html/airtel/referFriend_2.php"; 
//if($msisdn==9910040744 || $msisdn==8130291637)
    if($msisdn==8130291637)
	$referUrl = "/var/www/html/airtel/referFriend_3.php"; 

$frndMDN = $reqtype;
if($referCount && ($serviceId == 1517 || $serviceId == 1515 || $serviceId == 1514 || strlen($reqtype)==10 || strlen($reqtype)==12) && $reqtype!=1) {			
	include_once($referUrl);
	exit;
}

//----------- Refer logic end here ------------
 
function ValidateParameter($serviceId,$msisdn)
{
	if($msisdn=="" || !is_numeric($msisdn) || (!is_numeric($serviceId)))
		return false;
	else
		return true;
}

$validateResponse=ValidateParameter($serviceId,$msisdn);

if(!$validateResponse) {
	echo $response="Please provide the complete parameter";
	$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#"."Response:".$response."#".date("Y-m-d H:i:s")."\n\r";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
} else {
	if($planid) { 
		$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planid;
		$qryAmount = mysql_query($selAmount);
		list($amount) = mysql_fetch_array($qryAmount);
	}

	if($reqtype == 0) {
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
			case '1517': $response='Welcome to Spoken English. Subscribe @Rs5/day and get 10 free min (plus extra 20free mins on activation). Reply '."\n". '1 to Subscribe'."\n".'2 to Unsubscribe'."\n"."Select option";  
				header("Menu code:".$response);
			break;
			case '1515': $response='Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs. '."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Unsubscribe";  
				header("Menu code:".$response);
			break;
			case '1514': $response='Enjoy Personality Development @Rs 15/7days for free 30mins. Listen and enjoy learning. Reply'."\n".'1 to subscribe'. "\n".'2 to unsubscribe'."\n"."Select option";  
				header("Menu code:".$response);
			break;
			case '1518': $response='Enjoy Mana Paata Mana Comedy at Rs.30/30days. Listen comedy clips and laugh'."\n".'Reply '."\n".'1 to Subscribe '."\n".'2 to Unsubscribe ';  
				header("Menu code:".$response);				
			break;
			case '1511': //$response='Welcome to LIFESTYLE! Your daily dose of love, dating, relationship & fashion tips, Charges Rs.30/month. Please press'."\n".'1 to Subscribe '."\n".'2 to Unsubscribe '."\n"."Reply";    
			$response='Welcome to Lifestyle Dressing Room!Your daily dose of love,relationship,fashion tips. Please press'."\n".'1 to Subscribe '."\n".'2 to unsubscribe'."\n".'@Rs.30/month'."\n"."Reply";
			//$response='Hello, Welcome to Good Life. Subscribe & learn Indian/International recipe @Rs.30/30 days. Reply '."\n".'1 to Subscribe '."\n".'2 to unsubscribe'."\n";
				header("Menu code:".$response);								
			break;
			case '1501': 
				//$response='Welcome to Airtel Entertainment Unlimited. Listen unlimited music, Audio cinema, and Bollywood gossips. Download HT and ringtone'."\n".'Press 1 to subscribe'."\n".'Press 2 to unsubscribe'."\n".'Reply';
				
				$response='Entertainment Unlimited at Rs.30/15days.Listen Unlimited Music,Audio Cinema,Bollywood Gossip,download HT'."\n".'Press 1 to subscribe'."\n".'Press 2 to unsub'."\n".'Reply';
				header("Menu code:".$response);				
			break;
		}
		
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		if($serviceId == '1518' || $serviceId == '1515') {
			$ussdLogData=$msisdn."#Main Menu#".$serviceId."#".$circle."#".date("Y-m-d H:i:s")."\n";;
			error_log($ussdLogData,3,$ussdLogPath);
		}
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}

	if(($reqtype=='1' || $reqtype=='2') && !$planid) {
		$query = "SELECT Plan_id,iAmount,iValidty FROM master_db.tbl_plan_bank WHERE S_id=".$serviceId;		
		$result1 = mysql_query($query);
		$i=0;
		$resData = "";
		while($row= mysql_fetch_array($result1)) {
			$i++;
			$resData .= "$i for Rs.".$row['iAmount']."/".$row['iValidty']." days Service"."\n";			
		}
		
		if($reqtype=='1') $data = "For subscribe";
		elseif($reqtype=='2') {  $data = "For unsubscribe"; $resData="1 to Unsubscribe"; }
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');
		switch($serviceId) 
		{
			case '1517': if($reqtype=='1') $response = "Welcome to Spoken English. "."\n"."Reply"."\n"."1 For Subscribe";
						 elseif($reqtype=='2') $response = "Welcome to Spoken English. "."\n"."Reply"."\n"."2 For Unsubscribe"; 						 
				header('Menu code:'.$response);
			break;	
			case '1515': $response='Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs.'."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Unsubscribe";  
				header('Menu code:'.$response);
			break;	
			case '1518': if($i==1) { 
							$response = "Invalid Plan Id. Please try again!!";
						 } else { 
							$response='Welcome to Mana Pata Mana Comedy. '.$data."\n".'Reply '."\n".$resData; 
						 }									
				header('Menu code:'.$response);
			break;	
			case '1511': 
			//$response='Welcome to LIFESTYLE! Your daily dose of love, dating, relationship & fashion tips, Charges Rs.30/month. Please press'."\n".'1 to Subscribe '."\n".'2 to Unsubscribe '."\n"."Reply";    
			$response='Welcome to Lifestyle Dressing Room!Your daily dose of love,relationship,fashion tips. Please press'."\n".'1 to Subscribe '."\n".'2 to unsubscribe'."\n".'@Rs.30/month'."\n"."Reply";
			//$response='Hello, Welcome to Good Life. Subscribe & learn Indian/International recipe @Rs.30/30 days. Reply '."\n".'1 to Subscribe '."\n".'2 to unsubscribe'."\n";			
				header("Menu code:".$response);				
			break;
			case '1501': $response='Welcome to Airtel Entertainment Unlimited. Listen unlimited music, Audio cinema, and Bollywood gossips. Download HT and ringtone'."\n".'Press 1 to subscribe'."\n".'Press 2 to unsubscribe'."\n".'Reply';  
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}

	if($reqtype=='1' && $planid) { 
		if($chkRFlag && ($service_id='1515' || $service_id='1513')) 
			$mode="REF";
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);	
		if($rows1[0]<=0) {
			$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";			
			$qry1=mysql_query($qry) or die( mysql_error() );					

			$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($sub);
			$rows2 = mysql_fetch_row($qry2);
			if($rows2[0]>0) $response = $actSucc;
			else $response = $actFail;
		} else {		
			$response = $actAlr;
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);
		echo $response;
		$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		if($serviceId == '1518' || $serviceId == '1515') {
			$logPath1="/var/www/html/airtel/logs/airtelService/".$serviceId."/subLogs_".date("Y-m-d").".txt";
			$logData1=$msisdn."#".$response."#".$circle."#".date("Y-m-d H:i:s")."\n";;
			error_log($logData1,3,$logPath1);
			$ussdLogData=$msisdn."#Activation#".$serviceId."#".$circle."#".date("Y-m-d H:i:s")."\n";
			error_log($ussdLogData,3,$ussdLogPath);
		}
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}

	if(($reqtype=='2') && $planid) 
	{	
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);	
		
		if($rows1[0]>0) { 
			$unsubsQuery="call ".$db.".".$unSubscriptionProcedure." ('$msisdn','$mode')";
			$unsubsQuery1=mysql_query($unsubsQuery) or die( mysql_error() );
			
			$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry3=mysql_query($sub);
			$rows3 = mysql_fetch_row($qry3);	
			if($rows3[0] <= 0) $response = $deactSucc;
			else $response = $deactFail;
		} else {
			$response = $deactAlr;
		}
		header('Freeflow: FB');

		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);

		echo $response;
		$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$unsubsQuery."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		if($serviceId == '1518' || $serviceId == '1515') {
			$ussdLogData=$msisdn."#Deactivation#".$serviceId."#".$circle."#".date("Y-m-d H:i:s")."\n";
			error_log($ussdLogData,3,$ussdLogPath);
		}
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}	
	mysql_close($dbConn);
} 
?>   