<?php
/*$data1  ="POST /Air13 HTTP/1.1";
$data1  .="Content-Length: 904";
$data1  .="Content-Type: text/xml";
$data1 .="User-Agent: Hungama/3.1/1.0";
$data1 .="Authorization: Basic SHVuZ2FtYTpIdW5nYW1hMTIz";
*/

$authorization='SHVuZ2FtYTpIdW5nYW1hMTIz';
$data1  ="<?xml version='1.0'?".">";
$data1 .="<methodCall>";
$data1 .="<methodName>GetBalanceAndDate</methodName>";
$data1 .="<params>";
$data1 .="<param>";
$data1 .="<value>";
$data1 .="<struct>";
$data1 .="<member>";
$data1 .="<name>originNodeType</name>";
$data1 .="<value>";
$data1 .="<string>IVR</string>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>originHostName</name>";
$data1 .="<value>";
$data1 .="<string>Admin1</string>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>originTransactionID</name>";
$data1 .="<value>";
$data1 .="<string>123456793</string>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>originTimeStamp</name>";
$data1 .="<value>";
$data1 .="<dateTime.iso8601>";
$data1 .="20110808T16:15:21+0200";
$data1 .="</dateTime.iso8601>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>subscriberNumberNAI</name>";
$data1 .="<value>";
$data1 .="<string>2</string>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>subscriberNumber</name>";
$data1 .="<value>";
$data1 .="<string>9661901048</string>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="<member>";
$data1 .="<name>serviceClassCurrent</name>";
$data1 .="<value>";
$data1 .="<i4>5</i4>";
$data1 .="</value>";
$data1 .="</member>";
$data1 .="</struct>";
$data1 .="</value>";
$data1 .="</param>";
$data1 .="</params>";
$data1 .="</methodCall>";

//echo $url = 'http://10.137.50.30:10050/';
//904

$getData = exec("echo $data1 | curl -X POST -H 'Authorization: Basic $authorization' -d @-  http://http://10.137.50.30:10050/", $response);

echo $getData;

exit;
/*
//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Length:786'));
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/xml'));
curl_setopt($ch,CURLOPT_HTTPHEADER,array('User-Agent: Hungama/3.1/1.0'));
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: Basic SHVuZ2FtYTpIdW5nYW1hMTIz'));
curl_setopt($ch,CURLOPT_POSTFIELDS,$data1);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
echo $result.'atharas';
*/

?>