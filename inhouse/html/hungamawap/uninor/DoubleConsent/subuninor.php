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

//blocked my no for unauth access start here
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$cpage=curPageURL();

if($msisdn=='8587800665')
{
$logPathBlocked="/var/www/html/hungamawap/uninor/DoubleConsent/logs/CCGBlocked_".$logdate.".txt";
$logStringBlock=$msisdn."|".$stype."|".$refererName."|".$Remote_add."|".trim($cpage)."|".date('d-m-Y H:i:s')."\r\n";
error_log($logStringBlock,3,$logPathBlocked);
echo "Blocked";
exit;
}
//end here
switch($stype)
		{
		case 'CMU_NEW':
				$landingPage="http://202.87.41.147/hungamawap/uninor/164530/index2.php3";
				$thanksPage="http://202.87.41.147/hungamawap/hungama/216288/postsub_uninor.php3";
				break;
		case 'UKIJI_NEW':
				$landingPage="http://kiji.in";
				$thanksPage="http://kiji.in";
				break;
		case 'SIMPLY_GUJJU':
				$landingPage="http://202.87.41.147/hungamawap/uninor/226281/index_simplygujju.php3";
				$thanksPage="";
				break;
		case 'ENTERTAINMENT_MALL':
				$landingPage="http://202.87.41.147/hungamawap/uninor/226291/index_entertainmentmall.php3";
				$thanksPage="";
				break;
		case 'FASHION_FACTORY':
				$landingPage="http://202.87.41.147/hungamawap/uninor/226290/index_fashionfactory.php3";
				$thanksPage="";
				break;
		case 'ULDR':
				$landingPage="http://u.ldr.mobi";
				$thanksPage="http://u.ldr.mobi";
				break;
		}
		
$logPath_MIS218_Uninor_dc="/var/www/html/hungamawap/uninor/DoubleConsent/logs/wap/sublogs_".$logdate.".txt";

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
/*
$switchInfoUrl="http://119.82.69.212/kmis/services/hungamacare/2.0/wap/getswitchinfoWap.php";
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
		//have to chnage if required
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
*/
 $posturl="http://192.168.100.212:7080/ivr-web/uninorChargingRequestAll.jsp";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "msisdn=$msisdn&user-agent=$full_user_agent&stype=$stype&afid=$afid");
 curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
 curl_setopt($Curl_Session, CURLOPT_CONNECTTIMEOUT ,0); 
 curl_setopt($Curl_Session, CURLOPT_TIMEOUT, 30); //timeout in seconds
 $chargingResponse= curl_exec ($Curl_Session);
 curl_close ($Curl_Session); 
 
if(trim($chargingResponse)=='Success')
{
	  $subtype='Subcription';
	  $redirectUrl=$thanksPage;	
	  
}
 else
 {
     $redirectUrl=$landingPage;
 }
 
$msg='Direct Charging';
$logString_MIS218_Uninor_dc = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($chargingResponse) . "|" .$planid."|WAP|".$stype."|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGOK|".$rtype."|"."\r\n";
error_log($logString_MIS218_Uninor_dc, 3, $logPath_MIS218_Uninor_dc);
	if(!empty($redirectUrl))
	{
	header("location:$redirectUrl");
	}
	else
	{
	echo "SUCCESS";
	}
exit();
}
else
{
	$msg="Msisdn not found";
	$redirectUrl=$landingPage;
	$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|".$stype."|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
	error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
	if(!empty($redirectUrl))
	{
	header("location:$redirectUrl");
	}
	else
	{
	echo $msg;
	}
}
?>
