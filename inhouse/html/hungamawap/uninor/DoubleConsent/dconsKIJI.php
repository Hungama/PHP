<?php
include "/var/www/html/hungamawap/config/new_functions.php";
$logFile="logs/sdpCCGRequest_".date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$logdate=date("Ymd");

$stype=$_REQUEST['stype'];
$zoneid_new=$_REQUEST['zoneid'];

$serviceDescArray=array('OMU_NEW'=>'OMU_NEW','CMU_NEW'=>'CMU_NEW','USU_NEW'=>'USU_NEW','UMY_NEW'=>'UMY_NEW','UMR_NEW'=>'UMR_NEW','UBR_NEW'=>'UBR_NEW','U54646_NEW'=>'U54646_NEW','UKIJI_NEW'=>'UKIJI_NEW','UGAMES_NEW'=>'UGAMES_NEW');
if(in_array($stype,$serviceDescArray)) {
$dUrl="http://117.239.178.108/hungamawap/uninor/DoubleConsent/dcons_db.php?stype=".$stype."&zoneid=".$zoneid_new;
//header("location:$dUrl");
exit;
}
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];
	

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

	
if($msisdn)
{
	if(strtoupper($stype)=='UKIJI')
	{
		$CPPID='HUN0046027';
		$PMARKNAME=urlencode('Khelo India Jeeto India');
		$PRICE='500';
		$SE='HUNGAMA';
		$PD=urlencode('Contest Portal');
		$SCODE='NA';
		$PRODTYPE='sub';
		$succUrl=urlencode("http://117.239.178.108/hungamawap/uninor/DoubleConsent/Successukiji.php");
		$failureUrl=urlencode("http://117.239.178.108/hungamawap/uninor/DoubleConsent/Failukiji.php");
	}

	//Subcription
				
	$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=Subcription&CP=Hungama&MSISDN=".$msisdn;
	//$dUrl  ="http://180.178.28.63:7001/ContentPartner/ContentPartnerSynchPS?SCHN=Topup&CP=Hungama&MSISDN=".$msisdn;
	$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
	$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
	$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	
	
$logPath1="/var/www/html/hungamawap/uninor/DoubleConsent/logs/CCGVisitorRequest_".$logdate.".txt";
$logString=$msisdn."|".$stype."|".$zone_id."|".$model."|".$Remote_add."|".$full_user_agent."|".trim($dUrl)."|".date('d-m-Y H:i:s')."\r\n";
error_log($logString,3,$logPath1);		
	
	header("location:$dUrl");
	exit();
}
else
{
	echo "Msisdn not found";
}
?>