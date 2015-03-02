<?php
//error_reporting(0);

$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
//$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$mode=$_REQUEST['mode'];
if($mode=='')
	$mode='net';
//$mode='DSTK';
$seviceId=$_REQUEST['serviceid'];
$seviceId1='aircel';
$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$logDir='/var/www/html/docomo/logs/docomo/subscription/'.$seviceId1.'/Wap/';
$logFile='subscription_'.date('Y-m-d').".txt";
$logPath=$logDir.$logFile;
if($msisdn)
{
	switch($planid)
	{
		case '1':
			if(strtoupper($mode)=='DSTK')
				$HitUrl="http://124.153.75.198/fanpage/WAPActivation.php?Mobileno=".$msisdn;
			elseif(strtoupper($mode)=='WAP')
				$HitUrl="http://124.153.75.198/fanpage/WAPActivation.php?Mobileno=".$msisdn."&mode=wap";
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$HitUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch); 
			if($response=='SUCCESS')
				$response="Success";
			else
				$response="Failure";
			$subscriptionString=$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#" . $rcode .  "#" .$response. "\r\n" ;
			error_log($subscriptionString,3,$logPath);
		break;
	}
	echo $response;
}
else{
	echo "msisdn not found";
}
?>   