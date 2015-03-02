<?php
$logDir="/var/www/html/vodafone/logs/dc/";
$curdate = date("Ymd");
$logPath2 = $logDir."ccg_test_".$curdate.".txt";

$transId=date('YmdHis');
$reqsId=date('YmdHis')."12";
$msisdn=$_REQUEST['ani'];
$cid=$_REQUEST['cid'];
$servicename=$_REQUEST['sid'];
//$msisdn='918587800665';
//echo $msisdn."***".$cid."**".$servicename;
//exit;
//$cid='05';
//sleep(5);
if($servicename=='vodafone_54646')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_ENTRMNTPORTAL&Class=ENTRMNTPORTAL&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*13&From=VENDOR&param1=NA&param2=NA&param3NA";
}
else if($servicename=='vodafone_redfm')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_REDFM&Class=REDFM&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*11&From=VENDOR&param1=NA&param2=NA&param3NA";
}
else if($servicename=='vodafone_vh1')
{
$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_VH1MUSIC&Class=VH1_MUSIC&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*12&From=VENDOR&param1=NA&param2=NA&param3NA";
}

//$url="https://cgussd.vodafone.in/VodafoneConfirmation/RequestConfirmation?MSISDN=".$msisdn."&Service=HNG_ENTRMNTPORTAL&Class=ENTRMNTPORTAL&Mode=USSD&Requestid=".$reqsId."&Circle-id=".$cid."&Loginid=HungamaIBM1671&password=3379IBM8655&partner_id=PIBM1300&Action=ACT&Timestamp=".$transId."&ussdString=*573*13&From=VENDOR&param1=NA&param2=NA&param3NA";

$logurl="#url#".$url."#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);

$logurl="#CGUSSD Request-Start#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
$status = file_get_contents($url);
$logresponse="#Response#".$status."#".date("Y-m-d H:i:s")."\n";
error_log($logresponse,3,$logPath2);
$logurl="#CGUSSD Request-End#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
echo "1";
	exit;
?>