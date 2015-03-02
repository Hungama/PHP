<?php
error_reporting(0);
$msisdn="91".$_REQUEST['msisdn'];
$reqtype=$_REQUEST['req'];
$RequestMode=strtoupper($_REQUEST['reqMode']);

$logDir="/var/www/html/VodafoneBilling/log/";
$logFile="MSGREsponse_".date("ymd");
$logFilePath=$logDir.$logFile;
$fp=fopen($logFilePath,'a+');

$timestamp=date('ymdhis');
$reqTime=date('his');
$msgUrl1="http://10.22.8.48:7071/SGSM/sgsm";
$msgData1="org_id=Hungama&timestamp=".$timestamp."&msisdn=".$msisdn;
$msgData1 .="&action=".$reqtype."&service=HNG_ENTRMNTPORTAL&class=ENTRMNTPORTAL&loginid=HunGamA@";
$msgData1 .="&password=MsgHunGama&requestid=".$timestamp."&mode=".$RequestMode;

$getApiResponse=callCurl($msgUrl1,$msgData1);
//echo $msgUrl1."?".$msgData1;
//echo $getApiResponse;


$msgResponse1=explode("</TD><TD>",$getApiResponse);
$msgResponse2=explode("</TD></TR><TR><TD>",$msgResponse1[1]);
$msgResponse3=explode("</TD></TR></TABLE></BODY></HTML>",$msgResponse1[2]);

fwrite($fp,$msgUrl1."?".$msgData1."|".$getApiResponse."|".$reqTime."\r\n");
fclose($fp);

if($msgResponse2[0]==500)
{
	echo "OK#".$timestamp."#".$msgResponse2[0];
}
elseif($msgResponse2[0]!='')
{
	echo "NOK#".$timestamp."#".$msgResponse2[0];
}
else
{
	echo "NOK#".$timestamp."#NoResponse";
}


function callCurl($msgUrl,$msgData)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$msgUrl);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$msgData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$ApiResponse = curl_exec($ch);
	curl_close($ch);
	return $ApiResponse;
}


?>