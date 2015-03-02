<?php
error_reporting(0);
ob_start();
$reqName=strtoupper($_GET['rn']);
$msisdn=trim($_GET['msisdn']);
$fname=trim($_GET['fname']);
$date=date("dmY H:i:s");
$tranx_id=date("YmdHis");
$logDir="/var/www/html/billing_api/getBalance/log/";
$logFile=$fname;
$logFilePath=$logDir.$logFile;
$filePointer=fopen($logFilePath,'a+');
$urltopost = "http://10.130.14.40:8080//cvp/chargingServlet";
switch($reqName)
{
	case 'QB':
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1 .="<REQUEST_NAME>QB</REQUEST_NAME>";
		$data1 .="<MSISDN>$msisdn</MSISDN>";
		$data1 .="</RealTimeOperationRequest>";
	break;
}


$resultData=postData($urltopost,$data1);

$start_pos=strpos($resultData,"_CODE>");
$end_pos=strpos($resultData,"</RESULT_CODE>");
$response_code=substr($resultData,$start_pos+6,$end_pos-74);



$start_pos_desc=strpos($resultData,"<RESULT_DESC>");
$end_pos_desc=strpos($resultData,"</RESULT_DESC>");
$response_Desc=substr($resultData,$start_pos_decs+107,$end_pos_desc-107);


if($reqName=='QB' && $response_code==2001)
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

$response_str1=$msisdn."#".$response_str."#".$response_code."#".$response_Desc."#".$tranx_id;
	if($reqName=='QB')
		$response_str1 .="#".$response_balance;

	echo $response_str1."\r\n";

	fwrite($filePointer,$response_str1."\r\n");
	fclose($filePointer);
	//error_log($response_str1,3,$logFilePath);


function postData($urltopost,$data1)
{
	$ch = curl_init ($urltopost);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec ($ch);
	return $returndata;
//	exit;
}
//unset all variable to reduce memory leak
unset($response_str1);
unset($reqName);
unset($msisdn);
unset($fname);
unset($date);
unset($tranx_id);
unset($resultData);
unset($urltopost);
unset($data1);
?>