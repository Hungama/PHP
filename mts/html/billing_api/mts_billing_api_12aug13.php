<?php
$reqName=strtoupper($_GET['rn']);
$msisdn=trim($_GET['msisdn']);
$test=trim($_GET['test']);
$RPid=trim($_GET['RPid']);
$serviceid=($_GET['serviceid']);
$serviceid1=($_GET['serviceid']);
$flag = $_GET['flag'];
$date=date("dmY H:i:s");
$tranx_id=date("YmdHis");
$logDir="/var/www/html/billing_api/log/";
$logFile=date('dmY')."_log";
$logFilePath=$logDir.$logFile.".txt";
$filePointer=fopen($logFilePath,'a+');

if($serviceid==1103)
  $serviceid=156;
elseif($serviceid==1101 || $serviceid==1124) 
{
	if($flag == 1)
	  { 
		$serviceid=171;
	 }
	 else { $serviceid=160;	}
}
elseif($serviceid==1102)
   $serviceid=155;
elseif($serviceid==1106)
   $serviceid=174;
elseif($serviceid==1111)
   $serviceid=169;
elseif($serviceid==1110)
   $serviceid=173;
elseif($serviceid==1116)
{
   if($flag == 1)
	  $serviceid=182;
else 
	 $serviceid=181;
}


switch($serviceid)
{
	case '1113':
		switch($RPid)
		{
			case '90502972':
				$serviceid=192;
			break;
			case '91002969':
				$serviceid=192;
			break;
			case '91502971':
				$serviceid=192;
			break;
			case '92002957':
				$serviceid=192;
			break;
			case '92502942':
				$serviceid=192;
			break;
			case '93002950':
				$serviceid=192;
			break;
			case '90502973':
				$serviceid=193;
			break;
			case '91002970':
				$serviceid=193;
			break;
			case '91502972':
				$serviceid=193;
			break;
			case '92002958':
				$serviceid=193;
			break;
			case '92502943':
				$serviceid=193;
			break;
			case '93002951':
				$serviceid=193;
			break;
			case '91002971':
				$serviceid=194;
			break;
			case '92002959':
				$serviceid=194;
			break;
			case '93002952':
				$serviceid=194;
			break;
		}
	break;
	case '1125':
	switch($RPid)
		{
			case '93003011':
				$serviceid=222;
			break;
			case '93003010':
				$serviceid=223;
			break;
			case '92503007':
				$serviceid=222;
			break;
			case '92503006':
				$serviceid=223;
			break;
			case '92003011':
				$serviceid=222;
			break;
			case '92003010':
				$serviceid=223;
			break;
			case '91503007':
				$serviceid=222;
			break;
			case '91503006':
				$serviceid=223;
			break;
			case '91003009':
				$serviceid=222;
			break;
			case '91003008':
				$serviceid=223;
			break;
			case '90503007':
				$serviceid=222;
			break;
			case '90503006':
				$serviceid=223;
			break;
			case '90303002':
				$serviceid=222;
			break;
			case '90303001':
				$serviceid=223;
			break;
			case '90203003':
				$serviceid=222;
			break;
			case '90203002':
				$serviceid=223;
			break;
			case '90103003':
				$serviceid=222;
			break;
			case '90103002':
				$serviceid=223;
			break;
			case '93003012':
				$serviceid=224;
			break;
			case '92003012':
				$serviceid=224;
			break;
			case '91003010':
				$serviceid=224;
			break;

		}
	break;
}

switch($serviceid1)
{
	case '1101':
	case '1124':
		switch($RPid)
		{
			case '90103000':
				$serviceid=215;
			break;
			case '90103001':
				$serviceid=215;
			break;
			case '91702906':
				$serviceid=255;
			break;
			case '91902906':
				$serviceid=255;
			break;

		}
	break;
}
$rpId54646Array=array(90102962,90202917,90302922,90402911,90502980,90602914,90702963,90802911,90902910,91002979,91102912,91202913,91302912,91402911,91502993,91602911,91702911,
91802913,91902911,92002967,92102912,92202911,92302910,92402911,92502950,92602911,92702910,92802911,92902910,93002974);
if(in_array($RPid,$rpId54646Array) && $serviceid1==1102)
{
	$serviceid=253;

}

$rpIddevoArray=array(90202913,90302918,90402907,90502976,90602910,90702959,90802907,90902906,91002975,91102908,91202909,91302908,91402907,
91502989,91602907,91702907,91802909,91902907,92002963,92102908,92202907,92302906,92402907,92502946,92602907,92702906,92802907,92902906,93002970);
if(in_array($RPid,$rpIddevoArray) && $serviceid1==1111)
{
	$serviceid=254;

}

$rpIdMUArray=array(90102958,90202912,90402906,90602909,90802906,91002974,91202908,91402906,91602906,91802908,92002962,92202906,92402906,92602906,92802906,93002969);
if(in_array($RPid,$rpIdMUArray) && $serviceid1==1101)
{
	$serviceid=255;

}


$urltopost = "http://10.130.14.40:8080//cvp/chargingServlet";
switch($reqName)
{
	case 'QB':
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1 .="<REQUEST_NAME>QB</REQUEST_NAME>";
		$data1 .="<MSISDN>$msisdn</MSISDN>";
		$data1 .="</RealTimeOperationRequest>";
	break;
	case 'TP':
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1.="<SERVICE_ID>$serviceid</SERVICE_ID>";
		$data1.="<ISV_ID>4</ISV_ID>";
		$data1.="<REQUEST_NAME>EventSubscription</REQUEST_NAME>"; 
		$data1.="<REQUEST_TYPE>0</REQUEST_TYPE>";  
		$data1.="<MSISDN>$msisdn</MSISDN>";    
		$data1.="<RATE_PLAN_ID>$RPid</RATE_PLAN_ID>";
		$data1.="</RealTimeOperationRequest>";	
		break;
	default:
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1.="<SERVICE_ID>$serviceid</SERVICE_ID>";
		$data1.="<ISV_ID>4</ISV_ID>";
		$data1.="<REQUEST_NAME>EventSubscription</REQUEST_NAME>"; 
		$data1.="<REQUEST_TYPE>0</REQUEST_TYPE>";  
		$data1.="<MSISDN>$msisdn</MSISDN>";    
		$data1.="<RATE_PLAN_ID>$RPid</RATE_PLAN_ID>";
		$data1.="</RealTimeOperationRequest>";
	break;
}


$resultData=postData($urltopost,$data1);

if($test==1)
{
	echo $urltopost."?".$data1;
	echo $resultData;
	exit;
}

$start_pos=strpos($resultData,"_CODE>");
$end_pos=strpos($resultData,"</RESULT_CODE>");
$response_code=substr($resultData,$start_pos+6,$end_pos-74);



$start_pos_desc=strpos($resultData,"<RESULT_DESC>");
$end_pos_desc=strpos($resultData,"</RESULT_DESC>");
$response_Desc=substr($resultData,$start_pos_decs+107,$end_pos_desc-107);


if($reqName=='QB')
{
	$start_pos_qb=strpos($resultData,"<CUSTOMER_BALANCE>");
	$end_pos_qb=strpos($resultData,"</CUSTOMER_BALANCE>");
	$response_balance=substr($resultData,$start_pos_qb+18,$end_pos_qb-195);
}

if($response_code==2001)
	$response_str='OK';
else
	$response_str='NOK';


if($reqName=='QB' && $response_code==2001)
	$response_str='OK';

$response_str1=$response_str."#".$response_code."#".$response_Desc."#".$tranx_id;
	if($reqName=='QB')
		$response_str1 .="#".$response_balance;

	echo $response_str1;

	fwrite($filePointer,$data1."|".$response_str1."|".date("his")."\r\n");
	fclose($filePointer);


function postData($urltopost,$data1)
{
	$ch = curl_init ($urltopost);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec ($ch);
	return $returndata;
	exit;
}


?>
