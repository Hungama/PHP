<?php
include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
$stype=$_REQUEST['stype'];
if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$getVendor="http://10.43.14.70/CircleApi/GetCircle.aspx?action=2&mobileno=91".$msisdn;
$getVendorResponse=file_get_contents($getVendor);

if($msisdn)
{
	switch(trim($getVendorResponse))
	{
		case 'COMVIVA':
			$CPPID='COMBO_HG30_60';
			$PMARKNAME='musicunlimited';
			$PRICE='6000';
			$SE='COMVIVA';
			$PD='Music_Unlimited';
			$SCODE='019105600674732';
			$PRODTYPE='sub';
			$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMU60.php");
			$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMU60.php");
		break;
		case 'ONMOBILE':
			$CPPID='5';
			$PMARKNAME='musicunlimited';
			$PRICE='6000';
			$SE='ONMOBILE';
			$PD='Music_Unlimited_Monthly_Pack';
			$SCODE='5755923';
			$PRODTYPE='rbt';
			$succUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/SuccessMU60.php");
			$failureUrl=urlencode("http://202.87.41.147/hungamawap/uninor/DoubleConsent/FailMU60.php");
		break;
	}

	$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=Subcription&CP=Hungama&MSISDN=".$msisdn;
	$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
	$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
	$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	
	header("location:$dUrl");
	exit();
}
else
{
	echo "Msisdn not found";
}

?>