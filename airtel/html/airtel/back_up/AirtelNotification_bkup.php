<?php

$logDir="/var/www/html/airtel/logs/";
$logFile="airResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";

$arrCnt=sizeof($_REQUEST);

for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
}

$cnt=sizeof($keys);
for($i=0;$i<$cnt;$i++)
{
	$msg .= $keys[$i]."->".$_REQUEST[$keys[$i]]."|";
}
$msg .="\r\n";


error_log($msg,3,$logPath); 

$msg='';
$nameSpaceString ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sub="http://SubscriptionEngine.ibm.com"><soapenv:Header><soapenv:Body><sub:notificationToCP>';
$endNameSpace="</sub:notificationToCP></soapenv:Body></soapenv:Header></soapenv:Envelope>";

$xmlstring = "<?xml version='1.0' encoding='ISO-8859-1'?".">";
$xmlstring1 ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sub="http://SubscriptionEngine.ibm.com">';

$xmlstring1 .="<soapenv:Header><soapenv:Body><sub:notificationToCP><notificationRespDTO><xactionId>0</xactionId><errorCode>1</errorCode><errorMsg>Success</errorMsg><temp1>33</temp1><temp2>0</temp2><lowBalance>0.0</lowBalance><amount>1.0</amount><chargigTime>2011-10-04T15:45:40.890Z</chargigTime><msisdn>9999999999</msisdn><productId>111</productId></notificationRespDTO></sub:notificationToCP></soapenv:Body></soapenv:Header></soapenv:Envelope>";

$start=str_replace($nameSpaceString,'',$xmlstring1);
$end=str_replace($endNameSpace,'',$start);

$finalStr=$xmlstring.$end;
$xmlResult = simplexml_load_string($finalStr);

foreach($xmlResult as $a => $b)
{
	if($a=='xactionId')
		$xactionId=$b;
	elseif($a=='errorCode')
		$errorCode=$b;
	elseif($a=='errorMsg')
		$errorMsg=$b;
	elseif($a=='temp1')
		$temp1=$b;
	elseif($a=='temp2')
		$temp2=$b;
	elseif($a=='lowBalance')
		$lowBalance=$b;
	elseif($a=='amount')
		$amount=$b;
	elseif($a=='chargigTime')
		$chargigTime=$b;
	elseif($a=='msisdn')
		$msisdn=$b;
	elseif($a=='productId')
		$productId=$b;
}
//echo $xactionId."#".$errorCode."#".$errorMsg."#".$temp1."#".$temp2."#".$amount."#".$chargigTime."#".$msisdn."#".$productId;

echo '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><soapenv:Body><notificationToCPResponse xmlns="http://SubscriptionEngine.ibm.com"/></soapenv:Body></soapenv:Envelope>';

?>