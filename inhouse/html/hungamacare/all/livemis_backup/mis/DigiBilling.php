<?php
include_once("DesAlgo.php");
echo $login_name=stringToHex ($ciphertext);
exit;

$service_id='DG_HG_IVR7';
$cp_id=7868;
$charge_party='S';
$source_mobtel=$_REQUEST['smsisdn'];
$destination_mobtel=$_REQUEST['dmsisdn'];
$delivery_channel='IVR';
$price_code='VAS220020';

$referenceCode = date('dmHis').'000022'.substr($source_mobtel,-4);

// start code to write the log
$logDir='/var/www/html/billing/log/digi_billing';
$logFile='log_'.date('Ymd').".txt";
$logPath=$logDir.$logFile;
$fp=fopen($logPath,'a+');
chmod($logPath,0777);
try {
	$soapClient = new SoapClient ("http://192.100.86.204:8001/billing/services/SDPValidateBill?wsdl");
	$param_array = array("AdditionalInfo" =>array('value'=>$AdditionalInfo),"login_name" =>$login_name,"ServiceID"=>$service_id,"cp_id"=>$cp_id,"price_code"=>$price_code,"charge_party"=>$charge_party,"source_mobtel"=>$source_mobtel,"destination_mobtel"=>$destination_mobtel,"delivery_channel"=>$delivery_channel);
	$response=$soapClient->__soapCall("ValidateAndBill",array_values($param_array));	
	print_r($response);
	echo $referenceCode."#ok";
	fwrite($fp,$billingText."|".$response."|".date('his')."\r\n");
}
catch (Exception $e) {
	echo "Error!<br />";
	echo $referenceCode."#".$e->faultstring;
	fwrite($fp,$billingText."|".$e."|".date('his')."\r\n");
}
fclose($fp);

?>
