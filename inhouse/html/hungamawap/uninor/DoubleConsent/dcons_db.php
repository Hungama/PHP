<?php
#include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
include "/var/www/html/hungamawap/config/new_functions.php";
$stype=strtoupper($_REQUEST['stype']);
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$logdate=date("Ymd");
$zoneid_new=$_REQUEST['zoneid'];	
$zone_id=$zoneid_new;
$refererName=$_SERVER['HTTP_REFERER'];
if($msisdn)
{
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
$getInfo="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getwapinfo.php?stype=".$stype."&msisdn=".$msisdn;
$ch_result=curl_init("$getInfo");
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
$details=explode("#",$ch_execute_response);
//print_r($details);
//put value here 
		$CPPID=$details[0];
		$PMARKNAME=$details[1];
		$PRICE=$details[2];
		$SE=$details[3];
		$PD=$details[4];
		$SCODE=$details[5];
		$PRODTYPE=$details[6];
		//$succUrl=$details[7];
		//$failureUrl=$details[8];
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/AllSuccess.php?stype=$stype&");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/AllFail.php?stype=$stype&");
	$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=Subcription&CP=Hungama&MSISDN=".$msisdn;
	$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
	$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
	$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	//echo $dUrl;
	
	$isCCg=true;
	if($CPPID=='NOK')
	{
	echo "Invalid Service.";
	$isCCg=false;
	}
	else if($CPPID=='')
	{
	echo "Invalid CPPID.";
	$isCCg=false;
	}
		
	$logPath1="/var/www/html/hungamawap/uninor/DoubleConsent/logs/CCGVisitorRequest_".$logdate.".txt";
	
	$logString=$msisdn."|".$stype."|".$zone_id."|".$model."|".$Remote_add."|".$full_user_agent."|".trim($dUrl)."|".date('d-m-Y H:i:s')."\r\n";
	error_log($logString,3,$logPath1);
	

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
	$logPath_MIS218_UNIM="/var/www/html/hungamawap/uninor/DoubleConsent/logs/AllUninorVisitorRequestMISNew_".$logdate.".txt";
	
	//Landing Page  
	$logString_MIS218_UNIM_LandingPage = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . trim($landingPage) . "|LandingPage|" .$planid."|WAP|". $stype. "|117.239.178.108|" .$refererName."|".$afid."|".$circle."|".date('Y-m-d H:i:s')."|"."\r\n";
	if($landingPage)
	{
	error_log($logString_MIS218_UNIM_LandingPage, 3, $logPath_MIS218_UNIM);
	}
	
	//Double Consent
	$logString_MIS218_UNIM = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . trim($dUrl) . "|DoubleConsent|" .$planid."|WAP|". $stype. "|117.239.178.108|" .$refererName."|".$afid."|".$circle."|".date('Y-m-d H:i:s')."|"."\r\n";
	error_log($logString_MIS218_UNIM, 3, $logPath_MIS218_UNIM);

	//Thanks Page	
	$logString_MIS218_UNIM_ThanksPage = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . trim($thanksPage) . "|ThanksPage|" .$planid."|WAP|". $stype. "|117.239.178.108|" .$refererName."|".$afid."|".$circle."|".date('Y-m-d H:i:s')."|"."\r\n";
	if($thanksPage)
	{
	error_log($logString_MIS218_UNIM_ThanksPage, 3, $logPath_MIS218_UNIM);
	}
	
	if($isCCg)
	{
	header("location:$dUrl");
	}
	exit();
}
else
{
	echo "Msisdn not found";
}
?>