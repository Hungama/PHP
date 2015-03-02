<?php
include "/var/www/html/hungamawap/config/new_functions.php";
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	
$pname=$_REQUEST['pname'];
$sid=md5(uniqid(rand(), true));
$CPPID='HUN0046028';
$planid=266;
if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$logdate=date("Ymd");
$afid=$_REQUEST['afid'];
$stype=$_REQUEST['stype'];
$rtype=$_REQUEST['rtype'];
$amt=$_REQUEST['amt'];
$refererName=$_SERVER['HTTP_REFERER'].'@'.$afid;
$logPath_MIS_ULDR="/var/www/html/hungamawap/uninorldr/doubleconsent/logs/CCG/UninorLDRDirectChargingMIS_".$logdate.".txt";
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
$num=rand(3,10);
sleep($num);

$switchInfoUrl="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getswitchinfoWap.php";
$switchInfoUrl.="?sname=WAPUninorLDR&operator=UNIM&msisdn=$msisdn";
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
#type1- 1,3-Direct Activation 2,4,5-CCG Page
#type2- 1,3,5 - Direct Activation 2,4-CCG Page
#type3-1,3,4,5-Direct Activation 2-CCG Page
#type4 1-Direct Activation  2,3,4,5-CCG Page
#type5-1,2,3,4,5-CCG Page, No Direct Activation

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
    $posturl="http://117.239.178.108/hungamawap/uninorldr/doubleconsent/dcons.php?msisdn=$msisdn&stype=$stype&rtype=$rtype&amt=$amt&afid=$afid";
	
$msg='Double Consent';
$logString_MIS = $stype . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|" . trim($msg) . "|" .$planid."|WAP|". $CPPID. "|117.239.178.108|" .$refererName. "|".$afid."|".$rtype."|".$circle."|".date('Y-m-d H:i:s')."\r\n";
error_log($logString_MIS, 3, $logPath_MIS_ULDR);


	header("Location:$posturl");
	exit;
	}
}
 $posturl="http://192.168.100.212:7080/ivr-web/uninorChargingRequest.jsp";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "msisdn=$msisdn&user-agent=$full_user_agent&stype=$stype&rtype=$rtype&P1=$afid&amt=$amt");
 curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
 curl_setopt($Curl_Session, CURLOPT_CONNECTTIMEOUT ,0); 
 curl_setopt($Curl_Session, CURLOPT_TIMEOUT, 30); //timeout in seconds
 $chargingResponse= curl_exec ($Curl_Session);
 curl_close ($Curl_Session); 
 

$msg='Direct Charging';
$logString_MIS = $stype . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|" . trim($msg) . "|" .$planid."|WAP|". $CPPID. "|117.239.178.108|" .$refererName. "|".$afid."|".$rtype."|".$circle."|".date('Y-m-d H:i:s')."\r\n";
error_log($logString_MIS, 3, $logPath_MIS_ULDR);

if(trim($chargingResponse)=='Success')
{
	  if($rtype=='topup')	
		{
		$redirectUrl = "http://u.ldr.mobi/site/topupcallback?mobile_no=" . $msisdn;
		}
		else if($rtype=='sub')
		 {
		 $redirectUrl = "http://u.ldr.mobi/site/usersubscription_callback?mobile_no=" . $msisdn ."&afid=".$afid;
		}	
 }
 else
 {
     if($rtype=='topup')
		{
		$redirectUrl = "http://u.ldr.mobi/site/error?mobile_no=" . $msisdn . "&error_code=106";		
		}
		else if($rtype=='sub')
		 {
		 $redirectUrl = "http://u.ldr.mobi/site/error?mobile_no=".$msisdn."&error_code=106&afid=".$afid;
		 }
 }
//As per discussion redirect to u.ldr.mobi
	 $redirectUrl = "http://u.ldr.mobi";
	   header("location:$redirectUrl");
//echo $chargingResponse;
exit();
}
else
{
//echo "Msisdn not found";
$msg='Direct Charging';
$logString_MIS = $stype . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|" . trim($msg) . "|" .$planid."|WAP|". $CPPID. "|117.239.178.108|" .$refererName. "|".$afid."|".$rtype."|".$circle."|".date('Y-m-d H:i:s')."\r\n";
error_log($logString_MIS, 3, $logPath_MIS_ULDR);
$redirectUrl = "http://u.ldr.mobi";
header("location:$redirectUrl");
}
?>