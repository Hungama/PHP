<?php
$api_key='197d1472';
$api_secret='437996fa';
$from='NEXMO';
$to='919958752620';
$answer_url="http://web.hungamavoice.com/MIS/cmis/text.xml";
$redirecturl="http://119.82.69.217:8080/hungama/HMP_54646/test.vxml";
$posturl="https://rest.nexmo.com/call/json";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "api_key=$api_key&api_secret=$api_secret&from=$from&to=$to&answer_url=$redirecturl");
 //curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
 echo $chargingResponse= curl_exec ($Curl_Session);
 curl_close ($Curl_Session);  
 ?>