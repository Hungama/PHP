<?php
include "/var/www/html/hungamawap/config/new_functions.php";
date_default_timezone_set('Asia/Kolkata');
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	
if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$logdate=date("Ymd");
$afid=$_REQUEST['afid'];
$stype=$_REQUEST['stype'];
$rtype=$_REQUEST['rtype'];
$amt=$_REQUEST['amt'];//in rs
$zoneid=$_REQUEST['zoneid'];
$refererName=$_SERVER['HTTP_REFERER'];

$logPath_MIS218_Uninor_dc="/var/www/html/hungamawap/uninorcontest/logs/wap/directChraginglogs_".$logdate.".txt";
$logPath_MIS218_Uninor="/var/www/html/hungamawap/uninorcontest/logs/wap/logs_".$logdate.".txt";
if($msisdn)
{
//get circle
$msisdnval_count_val = strlen($msisdn);
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
if(!$circle)
{ 
$circle='UND';
}
}
//put randam logic here start

$switchInfoUrl="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getswitchinfoWap.php";
$switchInfoUrl.="?sname=WAPUninorContest&operator=UNIM&msisdn=$msisdn";
$switch_result=curl_init($switchInfoUrl);
curl_setopt($switch_result,CURLOPT_RETURNTRANSFER,TRUE);
$switchId= curl_exec($switch_result);
curl_close($switch_result);
$switchData=explode("#",$switchId);
$switchId=$switchData[0];
$switchType=$switchData[1];
//echo $switchInfoUrl."#".$switchId;
//exit;
$randSwitch=mt_rand(1,5);
if($switchId==1)
{
	if($switchType=='type1')
	{
		if($randSwitch==2 || $randSwitch==4 || $randSwitch==5)
		{
		$isCcg=true;
		}
	}
	else if($switchType=='type2')
	{
		if($randSwitch==2 || $randSwitch==4)
			{
			$isCcg=true;
			}
	}
	else if($switchType=='type3')
	{
		if($randSwitch==2)
			{
			$isCcg=true;
			}
	}
	else if($switchType=='type4')
	{
		if($randSwitch==2 || $randSwitch==3 || $randSwitch==4 || $randSwitch==5)
			{
			$isCcg=true;
			}
	}
	else if($switchType=='type5')
	{
		if($randSwitch==1 || $randSwitch==2 || $randSwitch==3 || $randSwitch==4 || $randSwitch==5)
			{
			$isCcg=true;
			}
	}

		if($isCcg)
		{
		$chargingResponse="Double consent";
	// If Random no 2 & 4 will be generated corresponding to MDN, we need to hit the CCG consent page with Second consent confirmation.
		$posturl="http://117.239.178.108/hungamawap/uninorcontest/doubleconsent/dconsKIJI.php?msisdn=$msisdn&stype=$stype&rtype=$rtype&amt=$amt&afid=$afid";
		$msg='Double Consent';
	    $logString_MIS218_Uninor_dc = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
	    error_log($logString_MIS218_Uninor_dc, 3, $logPath_MIS218_Uninor_dc);
		header("Location:$posturl");
		exit;
		}
}

 $posturl="http://192.168.100.212:7080/ivr-web/uninorChargingRequestContest.jsp";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "msisdn=$msisdn&user-agent=$full_user_agent&stype=$stype&rtype=$rtype&P1=$afid&amt=$amt");
 curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
 curl_setopt($Curl_Session, CURLOPT_CONNECTTIMEOUT ,0); 
 curl_setopt($Curl_Session, CURLOPT_TIMEOUT, 30); //timeout in seconds
 $chargingResponse= curl_exec ($Curl_Session);
 curl_close ($Curl_Session); 
 

if(trim($chargingResponse)=='Success')
{
	  $subtype='Subcription';
	  $redirectUrl='http://117.239.178.108/hungamawap/uninorcontest/html/postccg.php?type='.$subtype;	
}
 else
 {
     $redirectUrl='http://117.239.178.108/hungamawap/uninorcontest/html/failure.php';
 }

$msg='Direct Charging';
$logString_MIS218_Uninor_dc = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($chargingResponse) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGOK|".$rtype."|"."\r\n";
error_log($logString_MIS218_Uninor_dc, 3, $logPath_MIS218_Uninor_dc);
header("location:$redirectUrl");
exit();
}
else
{
$msg="Msisdn not found";
$redirectUrl="http://117.239.178.108/hungamawap/uninorcontest/html/postccg.php?type=NOMDN";
$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
header("location:$redirectUrl");
}
?>