<?php
error_reporting(-1);
$logDir="/var/www/html/airtel/logs/";
$logFile="airResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";

$client = new SoapClient("http://10.2.73.156/airtel/NotificationToCP.wsdl",array('trace' => 1));
$responseArr=$client->__getTypes();
//$result = $client->__soapCall('NotificationToCP');
print_r($result);
// "RESPONSE HEADERS:\n" . $client->__getLastResponseHeaders() . "\n";

$msg .=$responseArr[0]."#".$result."\r\n";
error_log($msg,3,$logPath); 
$msg='';

?>