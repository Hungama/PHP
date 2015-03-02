<?php
error_reporting(0);
$mobno=trim($_REQUEST['msisdn']);
//make curl call for this request start here
$mainurltocurl="http://119.82.69.212/hungama/aavService.php?msisdn=".$mobno;

$api_call= curl_init($mainurltocurl);
	curl_setopt($api_call,CURLOPT_RETURNTRANSFER,TRUE);
	$api_exec= curl_exec($api_call);
	curl_close($api_call);
	echo $crl_resp=trim($api_exec);
	if($crl_resp=='SUCCESS')
	{
	echo 'Successfully subscribed';
	}
	else if($crl_resp=='FAILURE')
	{
	//echo 'Invalid operator/MDN';
	echo 'Subscription failed. Please try again';
	}
	else
	{
	echo 'ALREADY SUBSCRIBED';
	}
//echo 'SUCCESS';
//echo 'FAILURE';
//ALREADY SUBSCRIBED
//

?>