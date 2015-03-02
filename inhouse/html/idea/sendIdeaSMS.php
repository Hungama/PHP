<?php
$url = "https://112.110.33.170:55000/";

$xml_data = '<?xml version="1.0" encoding="UTF-8"?'.'>';
$xml_data.='<message><sms type="mt"><destination><address><number type="international">919999799399</number></address></destination>';
$xml_data.='<source><address><number type="abbreviated">51515</number></address>';
$xml_data.='</source><pid>0</pid><rsr type="success_failure"/>';
$xml_data.='<ud type="text" encoding="default">SDP MG Testing Text SMS. Pls Ignore</ud>';
$xml_data.='<param name="unique_id" value="71110071413371900520"/>';
$xml_data.='<param name="developer_content_id" value="IBM"/>';
$xml_data.='<param name="mo_keyword" value="text"/>';
$xml_data.='<param name="content_description" value="TESTMSG"/>';
$xml_data.='<param name="content_type" value="text"/>';
$xml_data.='</sms>';
$xml_data.='</message>';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_CAINFO,getcwd()."/tomcat/apache-tomcat-6.0.29/bin/orangechat.jks");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_USERPWD,'hgm:sms@1sms');
curl_setopt($ch, CURLOPT_HTTPAUTH,CURLAUTH_ANY); 
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
echo $output = curl_exec($ch);
echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
//

?>