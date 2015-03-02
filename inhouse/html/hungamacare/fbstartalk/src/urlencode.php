<?php
include("config/config.php");
//include("commonfn.php");

define("DISPLAYLOGS", "Y");

function display($log){
	global $call_id;
	if(constant('DISPLAYLOGS')==='Y')
	{
		$date = @date("Y-m-d H:i:s");
		echo "$date : $call_id :  $log\n";
	}
}

function callUrl($url,$timeout=0){
	$res_arr = array();
	log_action("## Calling URL = $url");
	try {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($timeout) {
			curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		}
		$result= curl_exec($ch);
		$info = curl_getinfo($ch);
		$totalTime = $info['total_time'];
		$httpCode = $info['http_code'];
		if ($info['http_code'] != 200) {
			$output = "Error Code:";
			if (curl_error($ch)){
				$output .=  curl_error($ch);
			}
			display($output);
			return "timeout";
		}
		curl_close($ch);
		//$result="#amitabh,2012-07-14,10:00:00,50505,Airtel";//HARDCODE
		log_action("## URL Response = $result");
		array_push($res_arr, $result);
		array_push($res_arr, $httpCode);
		array_push($res_arr, $totalTime);
		return $res_arr;
	}catch(Exception  $e){
		log_action($e->getMessage());
	}
}

function updateToken($mno,$token,$appid){
	global $forward_url1,$forward_url2,$central_url;
	global $mno,$token,$appid;
	log_action("### urlencode-->updateToken###---Calling Central URL...");

	$url_string1 =rawurlencode($central_url."action=updateaccesstoken&fbappid=$appid&msisdn=$mno&accesstoken=$token");
	$url_string1 =rawurlencode($forward_url1."md=get&curl=".$url_string1 );
	$url_string1 = $forward_url2."md=get&curl=".$url_string1;
	$handle = callUrl($url_string1  , 0);
	echo 'Handle = '.$handle;
}

function removeAccessToken($user_msisdn,$appid){
	global $forward_url1,$forward_url2,$central_url;
	global $user_msisdn,$appid;
	log_action("### urlencode-->removeAccessToken###---Calling Central URL...");

	$url_string1 =rawurlencode($central_url."action=removeaccesstoken&fbappid=$appid&msisdn=$user_msisdn");
	$url_string1 =rawurlencode($forward_url1."md=get&curl=".$url_string1 );
	$url_string1 = $forward_url2."md=get&curl=".$url_string1;
	$handle = callUrl($url_string1  , 0);
	echo 'Handle = '.$handle;
}

function checkProfile(){
	global $forward_url1,$forward_url2,$central_url;
	log_action("### urlencode-->checkProfile### ---Calling Central URL...");

	$url_string1 =rawurlencode($central_url."mode=script&action=checkaccesstoken&fbappid=1&msisdn=9650256333");
	$url_string1 =rawurlencode($forward_url1."md=get&curl=".$url_string1 );
	$url_string1 = $forward_url2."md=get&curl=".$url_string1;

	$handle = callUrl($url_string1  , 0);
	echo 'Handle = '.$handle;
}

function getEventPromoInfo(){
	global $forward_url1,$forward_url2,$central_url;
	$url_string1 =rawurlencode($central_url."action=geteventpromotion");
	$url_string1 =rawurlencode($forward_url1."md=get&curl=".$url_string1 );
	$url_string1 = $forward_url2."md=get&curl=".$url_string1;
	$handle = callUrl($url_string1  , 5);
	//$handle="Priyanka,15-07-2012,15:05:10,Airtel,50505";
	return $handle;
}

?>
