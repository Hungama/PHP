<?php
session_start();
$old_sessionid = session_id();
include "/var/www/html/hungamawap/config/new_functions.php";
//added for google analytikes
#include_once("/var/www/html/hungamawap/ldrGA/analyticstracking.php");
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
$logdate=date("Ymd");
$stype=$_REQUEST['stype'];
$rtype=$_REQUEST['rtype'];
$amt=$_REQUEST['amt'] * 100;
$zoneid=$_REQUEST['zoneid'];

if($_REQUEST['msisdn']!='')
$msisdn=$_REQUEST['msisdn'];

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);



if($_REQUEST['P1'])
$afid=$_REQUEST['P1'];
else
$afid=$_REQUEST['afid'];

$refererName=$_SERVER['HTTP_REFERER'];	
$contentID = $_REQUEST['contentID'];

//get circle

$msisdnval_count_val = strlen($msisdn);
$chkFoUnknown=strtolower($msisdn);
$circle='UND';
if($chkFoUnknown!='unknown')
{
		
	if ($msisdnval_count_val == 12) {
		$msisdnval2 = substr($msisdn, 2);
	} else {
		$msisdnval2 = $msisdn;
	}
	$msisdnval_count_val2 = strlen($msisdnval2);
	if($msisdnval_count_val2==10)
	{	
		$getCircle = "http://192.168.100.212/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
		$circle = file_get_contents($getCircle);
	}
	else
	{
		$circle='UND';
		
	}
}


	if(strtoupper($stype)=='ULDR')
	{

		switch($amt)
		{
		case '500':
			$CPPID='HUN0046028';
			$planid=266;
			break;
		case '1500':
			$CPPID='HUN0042153';
			$planid=272;
			break;
		default:
			$CPPID='HUN0046028';
			$planid=266;
			break;
		}
		
		$PMARKNAME=urlencode('Lifestyle Dressing Room');
		$PRICE=$amt; //500
		$SE='HUNGAMA';
		$PD=urlencode('Lifestyle Dressing Room');
		$SCODE='NA';
                if($rtype=='sub')
                {
                    $PRODTYPE='sub';
                    $REQ_TYPE='Subcription';
					//$planid=266;                    
                }
                elseif($rtype=='topup')
                {

                        $PRODTYPE='topup';
                        $REQ_TYPE='TOPUP';
                }
                else
                {
                    
               exit();
                }

		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninorldr/doubleconsent/Successldr.php?afid=$afid&zoneid=$zoneid&circle=$circle&content_id=$contentID&");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninorldr/doubleconsent/Failldr.php?afid=$afid&zoneid=$zoneid&circle=$circle&content_id=$contentID&");
	}

	//Subcription
        
$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=".$REQ_TYPE."&CP=Hungama&MSISDN=".$msisdn;
$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";

$msg='Double Consent';
//save data for live MIS purpose start here
$saveLiveMisWAPLogs = "http://192.168.100.212/kmis/services/hungamacare/2.0/wap/saveLiveWAPlogs.php?zoneid=".$zoneid."&msisdn=".$msisdn."&msg=".urlencode($msg)."&afid=".$afid."&circle=".$circle."&service=WAPUninorLDR&type=browsing";
$savelogsresponse=file_get_contents($saveLiveMisWAPLogs);
//save data for live MIS purpose end here

//save logs for MIS
$logPath_MIS218_Uninor="/var/www/html/hungamawap/uninorldr/logs/wap/logs_".$logdate.".txt";

$UA=urlencode($full_user_agent);

$logPath_MIS="/var/www/html/hungamawap/uninorldr/doubleconsent/logs/CCG/UninorLDRSendCCGVisitorMIS_".$logdate.".txt";
$logString_MIS = $stype . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $dUrl . "|" . trim($msg) . "|" .$planid."|WAP|". $CPPID. "|117.239.178.108|" .$refererName. "|".$afid."|".$rtype."|".$circle."|".date('Y-m-d H:i:s')."\r\n";
error_log($logString_MIS, 3, $logPath_MIS);
	
if($msisdn)
{
		$chkFoUnknown=strtolower($msisdn);
		if($chkFoUnknown=='unknown')
		{
		$logString_MIS218_Uninor = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $dUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
		error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
		$redirectUrl = "http://u.ldr.mobi/site/error?mobile_no=".$msisdn."&content_id=" . $contentID."&error_code=102";
		header("location:$redirectUrl");
		 exit;
		}
		
//Don't call in case of top up
		if($rtype=='sub')
            {
				//status check API		
				$StatusCheckUrl="http://192.168.100.212/hungamawap/uninorldr/checkStatusLdr.php";
				$StatusCheckUrl.="?msisdn=$msisdn";
				$statusCheck_result=curl_init($StatusCheckUrl);
				curl_setopt($statusCheck_result,CURLOPT_RETURNTRANSFER,TRUE);
				$statusapiResult= curl_exec($statusCheck_result);
				curl_close($statusCheck_result);
					if($statusapiResult=='CGOK')
					{
					$call = "http://192.168.100.212/hungamawap/uninorldr/uninorLdrWAP.php?msisdn=".$msisdn."&planid=$planid&amnt=".$amt."&AFFID=".$afid."&zoneid=".$zoneid."&contentid=".$contentID."&UA=".$UA;
					$callResponse = file_get_contents($call);
					}
			}
			elseif($rtype=='topup')
			{
			$statusapiResult=='CGOK';
			}
 
 if($statusapiResult=='CGOK')
{
    $logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $dUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGOK|".$rtype."|"."\r\n";
	error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
	header("Location:" . $dUrl);
}
else
{
    $redirectUrl = "http://u.ldr.mobi";
    $logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
	error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
	header("location:$redirectUrl");
}

}
else
{
//echo "Msisdn not found";
$redirectUrl = "http://u.ldr.mobi/site/error?mobile_no=".$msisdn."&content_id=" . $contentID."&error_code=102";
$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorLDR|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
header("location:$redirectUrl");
}
?>