<?php 

$transId=date('YmdHis');
$reqsId=date('YmdHis')."12";

//set POST variables
//$url = 'https://182.19.20.38/cg/wap/';
//$url = 'https://cgwap.vodafone.in/cg/wap';
$url='http://202.87.41.147/hungamawap/uninor/DoubleConsent/action_vodadcons.php';
$param1='';
$param2='';
$param3='';
$consentMsg=1;
$call_starttime=date('his');
sleep(2);
$call_endtime=date('his');
$SecondConsentTimestamp=date('his');
$Validity='30 days';
$Service='HNG_ENTRMNTPORTAL';
$org_id='Hungama';
$Action='ACT';
$Class='ENTRMNTPORTAL';
$MSISDN='919930130510';
$password='U{y2604^7G-17]1';
$PromptFileId='v';
$requesttime=date('his');
$mode='WAP';
$Loginid='wapauth@cg';
$Price=1;
$ShortCode='2424';
$keyword='df';
//$requestid='123456789';
$requestid=date('YmdHis');
$CallBackURL='http://202.87.41.147/hungamawap/uninor/DoubleConsent/vodaindex.php';
$ORIGIN_ADDR='dgf';
$from='VENDOR';
$CircleId='15';
$consentStatus=0;
$consentKeyword='N';
$fields = array(
						'param1' => urlencode($param1),
						'param2' => urlencode($param2),
						'param3' => urlencode($param3),
						'consentMsg' => urlencode($consentMsg),
						'call_endtime' => urlencode($call_endtime),
						'call_starttime' => urlencode($call_starttime),
						'SecondConsentTimestamp' => urlencode($SecondConsentTimestamp),
						'Validity' => urlencode($Validity),
						'Service' => urlencode($Service),
						'org_id' => urlencode($org_id),
						'Action' => urlencode($Action),
						'Class' => urlencode($Class),
						'MSISDN' => urlencode($MSISDN),
						'password' => urlencode($password),
						'PromptFileId' => urlencode($PromptFileId),
						'requesttime' => urlencode($requesttime),
						'mode' => urlencode($mode),
						'Loginid' => urlencode($Loginid),
						'Price' => urlencode($Price),
						'ShortCode' => urlencode($ShortCode),
						'keyword' => urlencode($keyword),
						'requestid' => urlencode($requestid),
						'CallBackURL' => urlencode($CallBackURL),
						'ORIGIN_ADDR' => urlencode($ORIGIN_ADDR),
						'from' => urlencode($from),
						'CircleId' => urlencode($CircleId),
						'consentStatus' => urlencode($consentStatus),
						'consentKeyword' => urlencode($consentKeyword)
				);

//foreach($fields as $key=>$value)
//{ 
//	$fields_string .= $key.'='.$value.'&'; 
//}
////$finalUrl=$url."?".$fields_string;
////header( 'Location:'. $finalUrl ) ;
////exit;
//$ch = curl_init();
//curl_setopt($ch,CURLOPT_URL, $url);
//curl_setopt($ch,CURLOPT_POST, count($fields));
//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//echo $result = curl_exec($ch);
//curl_close($ch);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');
//open connection
$ch = curl_init();

$logFile="logs/vodadoubleconsent_".date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);

fwrite($filePointer,$fields_string."|");
fwrite($filePointer,date('H:i:s')."\n");

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
echo $result = curl_exec($ch);
//close connection
curl_close($ch);

?>