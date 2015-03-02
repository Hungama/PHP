<?php
error_reporting(0);

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
	die('could not connect: ' . mysql_error());

$msisdn=$_REQUEST['msisdn'];
$mode='USSD';
$reqtype=$_REQUEST['reqtype'];
if($reqtype=='*177*995#' || !isset($reqtype)) $reqtype=0;

$planid=$_REQUEST['planid'];
$serviceId=$_REQUEST['serviceid'];
$test=$_REQUEST['test'];
$curdate = date("Y-m-d");

if($reqtype=='1' || $reqtype=='2')
	$isreq=false;
else
	$isreq=true;

$logPath = "/var/www/html/airtel/logs/airtelFlayer/".$serviceId."/flayer_log_".date("Y-m-d").".txt";
$logPath1 = "/var/www/html/airtel/logs/airtelFlayer/".$serviceId."/Airtel_Log_".date("Y-m-d").".txt";


if($reqtype==0 && $serviceId==1507) { 
	$planid=47; 
} elseif($reqtype==1 && $serviceId==1507) {
	$planid=47; $reqtype=1;
} elseif($reqtype==2 && $serviceId==1507) {
	$planid=28; $reqtype=1;
} elseif($reqtype==3 && $serviceId==1507) {
	$planid=47; $reqtype=2;
}

/*****************************check msisdn start*****************/

function checkmsisdnonly($msisdn) 
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 ) {
		if(strlen($msisdn)==12) { 
			if(substr($msisdn,0,2)==91) {
				$msisdn = substr($msisdn, -10);
			}
		}		
	} else {
		$msisdn='';
	}
	return $msisdn;
}
$msisdn=checkmsisdnonly(trim($msisdn));

/*if($msisdn == '9910040744' || $msisdn == '919910040744') 
{ $chkFlag =1;}*/

/******************************end here**************************/

$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
$circle1=mysql_query($getCircle) or die( mysql_error() );
while($row = mysql_fetch_array($circle1)) {
	$circle = $row['circle'];
}
if(!$circle) { $circle='UND'; }

if($msisdn=='8527000779' || $msisdn=='918527000779' || $msisdn=='+918527000779') $circle="KAR";

//----------------- Chk whitelist MND number for direct activation ---------------  
if($serviceId == '1513' || $serviceId == '1503')
$QueryMNDWhl = mysql_query("SELECT count(1) FROM airtel_mnd.tbl_ussdMND_whitelist WHERE ANI='".$msisdn."' and serviceId='".$serviceId."'");
list($mndWhlCount) = mysql_fetch_array($QueryMNDWhl);

if($mndWhlCount && $circle!='KAR' && $serviceId == '1513') $reqtype=1;
elseif($mndWhlCount && $serviceId == '1503') $reqtype=1;

//-------------------------- Code end here ---------------------------------------


//------------- Refer logic ------------------
$chkRFlag = 0;
$referdUser = mysql_query("SELECT count(1) FROM master_db.tbl_refer_ussdData where friendANI='".$msisdn."' and endDate>=".date('Y-m-d')." and service_id=".$serviceId);
list($chkRFlag) = mysql_fetch_array($referdUser);

$serviceArray = array($serviceId);

$referUrl = "/var/www/html/airtel/referFriend.php"; 
$retData=0;
//echo $referUrl; die;
if($serviceId==1513) {
	$q="SELECT count(1) FROM master_db.tbl_refer_ussdMDN where service_id IN (".implode(",",$serviceArray).") and ANI='".$msisdn."'";
	$referData = mysql_query($q);
	list($referCount) = mysql_fetch_array($referData);
	if($referCount) $retData=1;
} else {
	if($circle == "UPW" && ($serviceId == 1513)) { 
		$referCount=1;

	}
}
//echo "Ret: ".$retData; 
$frndMDN=$reqtype;
if(($circle == 'UPW' && $serviceId == 1513 && ($reqtype!=1 && $reqtype!=5)) || ($serviceId == 1513 && $retData==1)) {
	//echo "hello"; die;
	include_once($referUrl);
	exit;
}


//----------- Refer logic end here ------------

switch($serviceId)
{
	case '1503':		
		if($circle=="KAR") {
			$response1="Welcome to Manoranjana Pack. Listen to hit songs & Comedy. Subscribe @Rs.30/month and browse free 200 min. Reply"."\n"."1 to subscribe"."\n"."2 to unsubscribe"."\n"."Select Option";
			$serviceName="Manoranjana Pack";
			$sc='5464614';
			$s_id='1522';
			$db="airtel_hungama";
			$subscriptionTable="tbl_arm_subscription";
			$subscriptionProcedure="ARM_SUB";
			$unSubscriptionProcedure="ARM_UNSUB";
			$unSubscriptionTable="tbl_arm_unsub";
			$planid=63;
			$lang='10';
		} elseif($circle=="TNU" || $circle=="CHN") {
			$response1="Welcome to Crazy Kondattam. Listen to the favorite comedies . Subscriber @Rs 30/month and browse free 200 min. Reply"."\n"."1 to subscribe"."\n"."2 to unsubscribe"."\n"."Select Option";
			$serviceName="Crazy Kondattam";
			$sc='5464614';
			$s_id='1522';
			$db="airtel_hungama";
			$subscriptionTable="tbl_arm_subscription";
			$subscriptionProcedure="ARM_SUB";
			$unSubscriptionProcedure="ARM_UNSUB";
			$unSubscriptionTable="tbl_arm_unsub";
			$planid=64;
			$lang='01';
		} else {
			$response1="Welcome to MTV DJ DIAL.Listen to the favorite comedies.Subscriber @Rs 30/month and browse free 30 min.Reply"."\n"."1 to subscribe"."\n"."2 to unsubscribe";
			$serviceName="MTV Dj Dial";
			$sc='546461';
			$s_id='1503';
			$db="airtel_hungama";
			$subscriptionTable="tbl_mtv_subscription";
			$subscriptionProcedure="MTV_SUB";
			$unSubscriptionProcedure="MTV_UNSUB";
			$unSubscriptionTable="tbl_mtv_unsub";
			$lang='01';
		}
		/*$actSucc = "Your request to Start ".$serviceName." service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to ".$serviceName." service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to ".$serviceName." service.";
		$deactSucc = "Your request to Stop ".$serviceName." service has been submitted successfully. Thank you for using ".$serviceName." service.";
		$deactFail = "Sorry! Your request to Stop ".$serviceName." service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from ".$serviceName." service.";*/
	break;
	case '1507':
		$sc='55841';
		$s_id='1507';
		$db="airtel_vh1";
		$subscriptionTable="tbl_jbox_subscription";
		$subscriptionProcedure="JBOX_SUB";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='01';		
		/*$actSucc = "Your request to Start VH1 Radio GAGA service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to VH1 Radio GAGA service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to VH1 Radio GAGA service.";
		$deactSucc = "Your request to Stop VH1 Radio GAGA service has been submitted successfully. Thank you for using VH1 Radio GAGA service.";
		$deactFail = "Sorry! Your request to Stop VH1 Radio GAGA service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from VH1 Radio GAGA service.";*/

		if($serviceId == '1507') {
			$selData = "SELECT count(*) FROM master_db.tbl_ussd_activation WHERE circle='".$circle."' and service_id='".$serviceId."' and sysdate() between starttime and endtime and status=1 and type='direct'"; 
			$result1 = mysql_query($selData);
			$check = mysql_fetch_row($result1);

			if($check[0]>0) {
				$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
				$qry1=mysql_query($sub);
				$cont = mysql_fetch_row($qry1);	
				if($cont[0]<=0 && $reqtype==0) {
					$planid='47';
					$reqtype=1;
				}
			}
		}
	break;
	case '1513':
		$sc='5500196';
		$s_id='1513';
		$db="airtel_mnd";
		$subscriptionTable="tbl_character_subscription1";
		$subscriptionProcedure="MND_SUB";
		$unSubscriptionProcedure="MND_UNSUB";
		$unSubscriptionTable="tbl_character_unsub1";
		$lang='01';		
		/*$actSucc = "Your request to Start My Naughty Diary service has been submitted successfully.";
		$actFail = "Sorry! Your subscription to My Naughty Diary service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribed to My Naughty Diary service.";
		$deactSucc = "Your request to Stop My Naughty Diary service has been submitted successfully. Thank you for using My Naughty Diary service.";
		$deactFail = "Sorry! Your request to Stop My Naughty Diary service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are already unsubscribed from My Naughty Diary service.";*/
		if($circle == 'GUJ') { 
			$planid = '35';
			$planDesc = "Subscribe @Rs.2/day";  
		} else { 
			$planDesc = "Subscribe @Rs.30/30days"; 
		}

		if($serviceId == '1513') {
			$selData = "SELECT count(*) FROM master_db.tbl_ussd_activation WHERE circle='".$circle."' and service_id='".$serviceId."' and sysdate() between starttime and endtime and status=1 and type='direct'"; 
			$result1 = mysql_query($selData);
			$check = mysql_fetch_row($result1);
			//echo $check[0];
			if($check[0]>0) {
				$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
				$qry1=mysql_query($sub);
				$cont = mysql_fetch_row($qry1);	
				if($cont[0]<=0 && $reqtype==0) {
					$planid='51';
					$reqtype=1;
				}
			}
		}
	break;
}

function ValidateParameter($planid,$serviceId,$msisdn)
{
	if($msisdn=="" || !is_numeric($msisdn) || (!is_numeric($serviceId)) || !is_numeric($planid))
		return false;
	else
		return true;
}
 
$validateResponse=ValidateParameter($planid,$serviceId,$msisdn);

if(!$validateResponse)
{
	echo $response="Please provide the complete parameter";
	$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#Response:".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$response."#".date("Y-m-d H:i:s")."\n",3,$logPath1);
}
else
{

$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planid;
$qryAmount = mysql_query($selAmount);
list($amount) = mysql_fetch_array($qryAmount);

if($reqtype == 0) {	
	$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
	$qry1=mysql_query($sub);
	$rows1 = mysql_fetch_row($qry1);
	if($rows1[0]<=0) {
		if($isreq) {
			header('Path=/airtelFlayers');
			header('Content-Type: UTF-8');
			switch($serviceId)
			{
				case '1507': $response='Welcome to VH1 Radio GAGA.'."\n"."Reply"."\n"."1. For Rs30/month Pack"."\n"."2. For Rs2/day Pack"."\n"."3. For Unsubscribe";			header($response);
				break;
				case '1513': $response='Welcome to My Naughty Diary. '.$planDesc.' & listen naughty stories.'."\n".'Reply '."\n".'1 to Subscribe '."\n".'2 to Unsubscribe '; 
						
					header("Menu code:".$response);
				break;
				case '1503':
				case '1522':	$response = $response1;
					header("Menu code:".$response);
				break;
			}
			
			header('Freeflow: FC');
			header('charge: y');
			header('amount:30');
			header('Expires: -1');
			echo $response;
			$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Free flow state:FC#".$response."#".date("Y-m-d H:i:s")."\n";;
			error_log($logData,3,$logPath);
			error_log($msisdn."#".$circle."#Main Menu#".date("Y-m-d H:i:s")."\n",3,$logPath1);
		}
	} else {
		if($isreq) {
			header('Path=/airtelFlayers');
			header('Content-Type: UTF-8');
			switch($serviceId)
			{
				case '1507': $response='Welcome to VH1 Radio GAGA.'."\n"."Reply"."\n"."1. For Rs30/month Pack"."\n"."2. For Rs2/day Pack"."\n"."3. For Unsubscribe";			header($response);
				break;
				case '1513': $response='Welcome to My Naughty Diary. '.$planDesc.' & listen naughty stories.'."\n".'Reply '."\n".'1 to Subscribe '."\n".'2 to Unsubscribe ';  			
					header("Menu code:".$response);
				break;
				case '1503':
				case '1522': $response = $response1;
					header("Menu code:".$response);
				break;
			}
			header('Freeflow: FC');		
			echo $response;
			$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Free flow state:FC#".$response."#".date("Y-m-d H:i:s")."\n";
			error_log($logData,3,$logPath);
			error_log($msisdn."#".$circle."#Main Menu#".date("Y-m-d H:i:s")."\n",3,$logPath1);
		}
	}
}

//echo $reqtype.",".$s_id.",".$circle;
if($reqtype=='2') {		
	//($reqtype=='1' && $s_id!='1513') || ($reqtype=='1' && $s_id=='1513' && $circle!='KAR') || ($reqtype=='5' && $s_id=='1513' && $circle=='KAR')
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
	header('Response:'.$response);
	echo $response;
	$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Free flow state:FB#".$response."#".date("Y-m-d H:i:s")."\n";;
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$circle."#Activation#".date("Y-m-d H:i:s")."\n",3,$logPath1);
} /*elseif($reqtype=='1' && $s_id=='1513' && $circle=='KAR') { 
	header('Path=/airtelFlayers');
	header('Content-Type: UTF-8');
	switch($serviceId)
	{
		case '1513': 
			$response="To re-confirm your subscription reply with 5"; 						
			header("Menu code:".$response);
		break;
	}
	header('Freeflow: FC');		
	echo $response;
	$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Free flow state:FC#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$circle."#Main Menu#".date("Y-m-d H:i:s")."\n",3,$logPath1);
}*/

if($reqtype=='2')
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
	header('Response:'.$response);
	echo $response;
	$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$unsubsQuery."#Response:Free flow state:FB#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$circle."#Deactivation#".date("Y-m-d H:i:s")."\n",3,$logPath1);
}
//MSISDN not found in our database then send response to tell them for activate service and send service details like price.
/* Define a custom response header*/
	

//close database connection
mysql_close($dbConn);
} // End of else


?>   