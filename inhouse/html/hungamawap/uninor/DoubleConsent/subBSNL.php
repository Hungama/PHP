<?php
include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	
if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$logdate=date("Ymd");
$zoneid_new=$_REQUEST['zoneid'];	
$zone_id=49716;
$afid=$_REQUEST['afid'];
$clickid=$_REQUEST['clickid'];
$stype=$_REQUEST['stype'];
if($stype=='bsnl')
{
$serviceName='BSNL';
}
if(empty($stype))
{
$serviceName='BSNL';
$stype='bsnl';
}

$refererName=$_SERVER['HTTP_REFERER'].'@'.$afid;

if($msisdn)
{
//put randam logic here start
$num=rand(1,5);
$switchInfoUrl="http://119.82.69.212/kmis/services/hungamacare/2.0/wap/getswitchinfoWap.php";
$switchInfoUrl.="?sname=$stype&operator=Bsnl&msisdn=$msisdn";
$switch_result=curl_init($switchInfoUrl);
curl_setopt($switch_result,CURLOPT_RETURNTRANSFER,TRUE);
$switchId= curl_exec($switch_result);
curl_close($switch_result);
$switchData=explode("#",$switchId);
$switchId=$switchData[0];
$switchType=$switchData[1];


$randSwitch=mt_rand(1,5);
if($switchId==1){

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


		if($isCcg){
		//if($randSwitch==4){
		// If Random no 2 & 4 will be generated corresponding to MDN, we need to hit the CCG consent page with Second consent confirmation.
			//We need to hit the CCG consent page with Second consent confirmation.
	$posturl="http://202.87.41.147/hungamawap/bsnl/49716/subscribe.php3?move_zon0e=226769&znmp=226769&cost=5";
	$logPath_MIS_Aircel="/usr/local/apache/htdocs/hungamawap/uninor/DoubleConsent/AllBSNLVisitorRequestMIS_".$logdate.".txt";
	$logString_MIS_Aircel = $zone_id . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|Double consent|" .$planid."|WAP|". $serviceName. "|202.87.41.147|" .$refererName. "|".$randSwitch."|".$model."|".$afid."|".$clickid."\r\n";
	error_log($logString_MIS_Aircel, 3, $logPath_MIS_Aircel);
	header("Location:http://202.87.41.147/hungamawap/bsnl/49716/subscribe.php3?move_zon0e=226769&znmp=226769&cost=5");
	exit;
	}
}
//put randam logic here start
$num_sleep=rand(3,10);
//sleep($num_sleep);

 $posturl="http://119.82.69.212:7080/ivr-web/bsnlChargingRequest.jsp";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "msisdn=$msisdn&user-agent=$full_user_agent");
 //curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
 $chargingResponse= curl_exec ($Curl_Session);
 curl_close ($Curl_Session); 
 

$logPath_MIS_Aircel="/usr/local/apache/htdocs/hungamawap/uninor/DoubleConsent/AllBSNLVisitorRequestMIS_".$logdate.".txt";
$logString_MIS_Aircel = $zone_id . "|" . date('Y-m-d H:i:s')."|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $posturl . "|" . trim($chargingResponse) . "|" .$planid."|WAP|". $serviceName. "|202.87.41.147|" .$refererName. "|".$randSwitch."|".$model."|".$afid."|".$clickid."\r\n";
error_log($logString_MIS_Aircel, 3, $logPath_MIS_Aircel);
	
header("Location:http://202.87.41.147/hungamawap/bsnl/49716");
exit();
}
else
{
	echo "Msisdn not found";
}
?>