<?php
//error_reporting(0);
$msisdn="91".$_REQUEST['msisdn'];
$Tcharge=$_REQUEST['Tcharge'];
$RequestMode=$_REQUEST['ReqMode'];
$eventId=$_REQUEST['eventType'];
$test=$_REQUEST['test'];
$reqtype='voice';
$inid=54646;
$imsi=123456789012345;

$logDir="/var/www/html/VodafoneBilling/log/";
$logFile="OCGResponse_".date("ymd");
$logFilePath=$logDir.$logFile;
$fp=fopen($logFilePath,'a+');
$timestamp=date('ymdhis');
$reqTime=date('his');

switch($Tcharge)
{
	
		case '30':
		switch($eventId)
		{
			case 'HNG_ENTRMNTPORTAL_T_30';
				$eventId="HNG_ENTRMNTPORTAL_T_30";
			break;
			case 'HNG_REDFM_T_30';
				$eventId="HNG_REDFM_T_30";
			break;
			case 'HNG_VH1MUSIC_T_30';
				$eventId="HNG_VH1MUSIC_T_30";
			break;
		}
	break;
	case '15':
		switch($eventId)
		{
			case 'HNG_REDFM_T_15';
				$eventId="HNG_REDFM_T_15";
			break;
			case 'HNG_VH1MUSIC_T_15';
				$eventId="HNG_VH1MUSIC_T_15";
			break;
		}
	break;
	case '10':
		switch($eventId)
		{
			case 'HNG_ENTRMNTPORTAL_T_10';
				$eventId="HNG_ENTRMNTPORTAL_T_10";
			break;
		}
	break;
	case '7':
		switch($eventId)
		{
			case 'HNG_REDFM_T_7';
				$eventId="HNG_REDFM_T_7";
			break;
			case 'HNG_VH1MUSIC_T_7';
				$eventId="HNG_VH1MUSIC_T_7";
			break;
		}
	break;
	case '3':
		switch($eventId)
		{
			case 'HNG_ENTRMNTPORTAL_T_3';
				$eventId="HNG_ENTRMNTPORTAL_T_3";
			break;
		}
	break;
	case '1':
		switch($eventId)
		{
			case 'HNG_REDFM_T_1';
				$eventId="HNG_REDFM_T_1";
			break;
			case 'HNG_VH1MUSIC_T_1';
				$eventId="HNG_VH1MUSIC_T_1";
			break;
		}
	break;
}
$ocgCheckUrl1="http://10.22.8.43:80/BalValExt/SMPeriodicBalanceCheck";
$osgData1="uid=HUNGAMA&pwd=1Hun@tst&msisdn=".$msisdn;
$osgData1 .="&imsi=".$imsi."&eventid=".$eventId."&tCharge=$Tcharge&reqid=".$timestamp."&wapurl=a&cSize=a&device=a&wapnode=a";
$osgData1 .="&reqtype=".$reqtype."&inid=".$inid;

$getApiResponse=callCurl($ocgCheckUrl1,$osgData1);
$txnIdArray=explode(":",$getApiResponse);

fwrite($fp,$ocgCheckUrl1."?".$osgData1."|".$getApiResponse."|".$reqTime."|");

if($txnIdArray[2]!='' && (trim($txnIdArray[3])>=($Tcharge+1) || trim($txnIdArray[3])=='-1.0'))
{
	$ocgDeductUrl1="http://10.22.8.43:80/BalDeduction/SMPeriodicChargeDeductor";
	$ocgDeductData1="uid=HUNGAMA&pwd=1Hun@tst&txnid=$txnIdArray[2]&msisdn=$msisdn&acteventid=$eventId&acttCharge=$Tcharge";
	$getDeductApiResponse=callCurl($ocgDeductUrl1,$ocgDeductData1);
	echo str_replace(":","#",$getDeductApiResponse); 
	fwrite($fp,$ocgDeductUrl1."?".$ocgDeductData1."|".$getDeductApiResponse."|".$reqTime);
}
else
{
	echo "NOK#NOK#".str_replace(":","#",$getApiResponse); 
}


fwrite($fp,"\r\n");
fclose($fp);

if($test==1)
{
	echo $ocgCheckUrl1."?".$osgData1;
	echo "<pre>" ;
	print_r($getApiResponse);

	echo $ocgDeductUrl1."?".$ocgDeductData1;
	print_r($getDeductApiResponse);

	exit;
}
function callCurl($msgUrl,$msgData)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$msgUrl);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$msgData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$ApiResponse = curl_exec($ch);
	curl_close($ch);
	return $ApiResponse;
}


?>