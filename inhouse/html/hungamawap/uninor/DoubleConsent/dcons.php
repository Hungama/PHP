<?php
#include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
include "/var/www/html/hungamawap/config/new_functions.php";
$logdate=date("Ymd");
$stype=$_REQUEST['stype'];
$stype=trim($stype);
$zoneid_new=$_REQUEST['zoneid'];

$serviceDescArray=array('OMU_NEW'=>'OMU_NEW','CMU_NEW'=>'CMU_NEW','USU_NEW'=>'USU_NEW','UMY_NEW'=>'UMY_NEW','UMR_NEW'=>'UMR_NEW','UBR_NEW'=>'UBR_NEW','U54646_NEW'=>'U54646_NEW','UKIJI_NEW'=>'UKIJI_NEW','HUNSTORE1'=>'HUNSTORE1','FTV_DIVAS'=>'FTV_DIVAS','VIDEO_WORLD'=>'VIDEO_WORLD','VID_WORLD'=>'VID_WORLD','HUNSTORE1_UW'=>'HUNSTORE1_UW','GLAM_ZONE_UW'=>'GLAM_ZONE_UW','SIZZLING_BEAUTY_UW'=>'SIZZLING_BEAUTY_UW','HUNSTORE15'=>'HUNSTORE15','SIMPLY_GUJJU'=>'SIMPLY_GUJJU','ENTERTAINMENT_MALL'=>'ENTERTAINMENT_MALL','FASHION_FACTORY'=>'FASHION_FACTORY','FASHION_FACTORY_WEEKLY'=>'FASHION_FACTORY_WEEKLY','SIMPLY_GUJJU_WEEKLY'=>'SIMPLY_GUJJU_WEEKLY','ENTERTAINMENT_MALL_WEEKLY'=>'ENTERTAINMENT_MALL_WEEKLY','GLAM_ZONE'=>'GLAM_ZONE','SIZZLING_BEAUTY'=>'SIZZLING_BEAUTY','ULDR'=>'ULDR','DESI_BEATS'=>'DESI_BEATS','HUNSTORE30'=>'HUNSTORE30','FTV_Vid'=>'FTV_Vid');
if(in_array($stype,$serviceDescArray)) {
$dUrl="http://192.168.100.212/hungamawap/uninor/DoubleConsent/dcons_db.php?stype=".$stype."&zoneid=".$zoneid_new;
header("location:$dUrl");
exit;
}
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

	
if($msisdn)
{

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
	if($stype=='OMU')
	{
		$CPPID=8;
		$PMARKNAME='MUSICUNLIMITEDDAILYPACK';
		$PRICE='250.0';
		$SE='ONMOBILE';
		$PD='Music_Unlimited';
		$SCODE='5755923';
		$PRODTYPE='rbt';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Fail.php");
	}
	if($stype=='CMU')
	{
	$getInfo="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getwapCircleId.php?stype=".$stype."&msisdn=".$msisdn;
$ch_result=curl_init("$getInfo");
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
		if($ch_execute_response=='GUJ')
		{
		$CPPID='COMBO_DDP1';
		$PRICE='250';
		}
		else
		{
		$CPPID='COMBO_HG01_2.5';
		$PRICE='250';
		}
		//$CPPID='COMBO_HG01_2.5';
		$PMARKNAME='musicunlimited';
		//$PRICE='250';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Fail.php");
	}
	if($stype=='CMU60')
	{
		$CPPID='COMBO_HG30_60';
		$PMARKNAME='musicunlimited';
		$PRICE='6000';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessMU60.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailMU60.php");
		
		$landingPage="http://202.87.41.147/hungamawap/uninor/164530/index2.php3";
		$thanksPage="http://202.87.41.147/hungamawap/hungama/216288/postsub_uninor.php3";
	}
	/*if($stype=='CMU30')
	{
		$CPPID='COMBO_HG015_30';
		$PMARKNAME='musicunlimited';
		$PRICE='3000';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessMU30.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailMU30.php");
	}*/
	if($stype=='CMU30')
	{
$getInfo="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getwapCircleId.php?stype=".$stype."&msisdn=".$msisdn;
$ch_result=curl_init("$getInfo");
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
		if($ch_execute_response=='MAH')
		{
		$CPPID='COMBO_HG07_15';
		$PRICE='1500';
		}
		else
		{
		$CPPID='COMBO_DDP1';
		$PRICE='250';
		}
		
		$PMARKNAME='musicunlimited';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessMU30.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailMU30.php");		
		$landingPage="http://202.87.41.147/hungamawap/uninor/173723/index2.php3";
		$thanksPage="http://202.87.41.194/hungamawap/uninor/173726/index2.php3";
	}
	if(strtoupper($stype)=='USU' || $stype=='')
	{
		//$CPPID='HUI0000007';
		//$CPPID='HUI0041975';
		$CPPID='HUI0000008';
		$PMARKNAME='sports_unlimited';
		//$PRICE='3000';
		$PRICE='1500';
		$SE='HUNGAMA';
		$PD='sports_unlimited';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessSU.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailSU.php");
	}
	if(strtoupper($stype)=='UMY')
	{
		//$CPPID='HUI0002111';
		$CPPID='HUI0042003';
		$PMARKNAME='MyMusic';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='MyMusic';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessMY.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailMY.php");
	}
	if(strtoupper($stype)=='UMR')
	{
		//$CPPID='HUI0038007';
		$CPPID='HUI0041976';
		$PMARKNAME='MissRiya';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='MissRiya';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Fail.php");
	}
	if(strtoupper($stype)=='UBR')
	{
		$CPPID='HUI0002103';
		$PMARKNAME='BhaktiRaas';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='BhaktiRaas';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/SuccessUBR.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailUBR.php");
	}
	if(strtoupper($stype)=='U54646')
	{
		//$CPPID='HUI0038022';
		//$CPPID='HUI0041973';
		$CPPID='HUI0042079';		
		//$PMARKNAME='54646';
		$PMARKNAME=urlencode('Entertainment Portal');
		$PRICE='3000';
		//$PRICE='500';
		$SE='HUNGAMA';
		$PD='54646';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Success54646.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/FailU54646.php");
	}
	if(strtoupper($stype)=='UKIJI')
	{
		//$CPPID='HUI0036057';
		$CPPID='HUI0041974';
		$PMARKNAME=urlencode('Khelo India Jeeto India');
		//$PRICE='500';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD=urlencode('Contest Portal');
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Successukiji.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Failukiji.php");
	}

	if(strtoupper($stype)=='UGAMES')
	{
		$CPPID='HUN0002158';
		$PMARKNAME=urlencode('Games@3');
		$PRICE='300';
		$SE='HUNGAMA';
		$PD=urlencode('Games@3');
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Successgames.php");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninor/DoubleConsent/Successgames.php");
	}
	
	$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=Subcription&CP=Hungama&MSISDN=".$msisdn;
	$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
	$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
	$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	
	
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
$getCircle = "http://10.48.54.11/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
$circle = file_get_contents($getCircle);
}
else
{
if(!$circle)
{ 
$circle='UND';
}
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
	
$isCCg=true;		
	if($CPPID=='')
	{
	echo "Invalid CPPID.";
	$isCCg=false;
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
