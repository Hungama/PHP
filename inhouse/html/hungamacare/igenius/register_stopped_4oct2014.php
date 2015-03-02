<?php
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
$logDir = "/var/www/html/hungamacare/igenius/logs/register/"; // log path @jyoti.porwal
$logFile_dump = "logs_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";
$ipAddress = $_SERVER['REMOTE_ADDR'];
$mobile = $_REQUEST['msisdn'];
$childno = $_REQUEST['childno'];
$IsRecorded=$_REQUEST['IsRecorded'];

function postData($urltopost)
{
$result=curl_init($urltopost);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$response= curl_exec($result);
curl_close($result);
return $response;
}
$urltopost="http://www.igenius.org/WebServices/RegistrationViaIVR.asmx/RegistrationWithIVR?mobileno=".$mobile."&childno=".$childno."&IsRecorded=".$IsRecorded;
$url_response = postData($urltopost);
$url_responseOrg=$url_response;
$find1='<?xml version="1.0" encoding="utf-8"?>';
$url_response=str_replace($find1,"",$url_response);
$find='<string xmlns="http://tempuri.org/"';
$replace="";
$url_response=str_replace($find,"",$url_response);
$find='/>';
$url_response=str_replace($find,"",$url_response);
$find='</string>';
$url_response=str_replace($find,"",$url_response);
$find='>';
$url_response=str_replace($find,"",$url_response);
//echo $url_response;
$data = explode("|", $url_response);
$uid=trim($data[0]);
if($uid=='')
$res="0";
else
$res=$uid;

echo "out_string.length=1;out_string[0]='" . $res . "'";
$logString = $mobile."#".$childno."#".$IsRecorded."#".trim($res)."#".trim($url_responseOrg) ."#".$ipAddress."#".date('Y-m-d H:i:s')."\r\n";
error_log($logString, 3, $logPath);

//echo $url_response;
/*
//http://www.igenius.org/WebServices/RegistrationViaIVR.asmx/RegistrationWithIVR?mobileno=9717261850&childno=1&IsRecorded=0
//header('Content-type: text/json');http://igenius.org/WebServices/RegistrationViaIVR.asmx
$client = new SoapClient("http://igenius.org/WebServices/RegistrationViaIVR.asmx?WSDL");
//$fcs = $client->__getFunctions();
//var_dump($fcs);
$params->mobileno = $mobile;
$params->childno = $childno;
$params->IsRecorded = $IsRecorded;
$result = $client->RegistrationWithIVR($params);
$res = $result->RegistrationWithIVRResult;
print_r($res);
//ob_start();
var_dump($result);
//$response = ob_get_clean();
$logString = $mobile."#".$childno."#".trim($response)."#".$res ."#".$ipAddress."#".date(YmdHis)."\r\n";
#error_log($logString, 3, $logPath);
$data = explode("|", $res);
echo "out_string.length=1;out_string[0]='" . $data[0] . "'";
//var_dump($result);
//$obj=json_decode($result);
//$data=$obj->RegistrationWithIVRResult;
//echo $obj;
//echo $result['RegistrationWithIVRResult'];
*/
?>