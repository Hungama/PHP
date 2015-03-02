<?php

include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
$stype=$_REQUEST['stype'];
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

if($msisdn)
{
	if($stype=='OMU')
	{
		$CPPID=8;
		$PMARKNAME='MUSICUNLIMITEDDAILYPACK';
		$PRICE='250.0';
		$SE='ONMOBILE';
		$PD='Music_Unlimited';
		$SCODE='5755923';
		$PRODTYPE='rbt';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
	}
	if($stype=='CMU')
	{
		$CPPID='COMBO_HG01_2.5';
		$PMARKNAME='musicunlimited';
		$PRICE='250';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
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
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMU60.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMU60.php");
	}
	if($stype=='CMU30')
	{
		$CPPID='COMBO_HG015_30';
		$PMARKNAME='musicunlimited';
		$PRICE='3000';
		$SE='COMVIVA';
		$PD='Music_Unlimited';
		$SCODE='019105600674732';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMU30.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMU30.php");
	}
	if(strtoupper($stype)=='USU' || $stype=='')
	{
		$CPPID='HUI0000007';
		$PMARKNAME='sports_unlimited';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='sports_unlimited';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessSU.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailSU.php");
	}
	if(strtoupper($stype)=='UMY')
	{
		$CPPID='HUI0002111';
		$PMARKNAME='MyMusic';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='MyMusic';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMY.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMY.php");
	}
	if(strtoupper($stype)=='UMR')
	{
		$CPPID='HUI0038007';
		$PMARKNAME='MissRiya';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='MissRiya';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Fail.php");
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
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessUBR.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailUBR.php");
	}
	if(strtoupper($stype)=='U54646')
	{
		$CPPID='HUI0038022';
		$PMARKNAME='54646';
		$PRICE='3000';
		$SE='HUNGAMA';
		$PD='54646';
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Success54646.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailU54646.php");
	}
	if(strtoupper($stype)=='UKIJI')
	{
		$CPPID='HUI0036057';
		$PMARKNAME=urlencode('Khelo India Jeeto India');
		$PRICE='500';
		$SE='HUNGAMA';
		$PD=urlencode('Contest Portal');
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Successukiji.php");
		$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/Failukiji.php");
	}
	
	if(isset($_REQUEST['amt'])) 
	{
	$PRICE= trim($_REQUEST['amt'])*100;
	}
	
	$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=Subcription&CP=Hungama&MSISDN=".$msisdn;
	$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
	$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
	$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	//echo $dUrl;

	header("location:$dUrl");
	exit();
}
else
{
	echo "Msisdn not found";
}

?>