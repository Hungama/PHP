<?php
include "/usr/local/apache/htdocs/hungamawap/new_functions.php3";
$posturl="http://192.168.10.62/device/getDevice.php";
$Curl_Session = curl_init($posturl);
curl_setopt ($Curl_Session, CURLOPT_POST, 1);
curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "ua=$full_user_agent");
curl_setopt($Curl_Session,CURLOPT_RETURNTRANSFER,TRUE);
$Response= curl_exec ($Curl_Session);
curl_close ($Curl_Session); 
$obj=json_decode($Response);
$device_id = $obj->device_id;
$widthD = isset($obj->wallpaper_resolution_width) ? $obj->wallpaper_resolution_width :"320";

if($device_id == ''){
	// If device is not detected
	$user_agent = $full_user_agent;
	if(strpos($user_agent,"iPhone") !== false  || strpos($user_agent,"Windows NT") !== false || strpos($user_agent,"Windows Phone") !== false || strpos($user_agent,"BlackBerry") !== false || strpos($user_agent,"Android") !== false || strpos($user_agent,"NokiaX6") !== false || strpos($user_agent,"SAMSUNG-GT-i8000")!== false || strpos($user_agent,"BB10")!== false){
		$widthD = "320";
	}else{
		$widthD = "240";
	}
}else{
	// If width is detected but sometime its desired due to wrong information in DB. You can remove this code if you are using actual widht //of device to serve data below logic is implemented on VME to get the quality content on android and ios devices.
	// If device is detected
	
	$user_agent = $full_user_agent;
	if(strpos($user_agent,"iPhone") !== false  || strpos($user_agent,"Windows NT") !== false || strpos($user_agent,"Windows Phone") !== false || strpos($user_agent,"BlackBerry") !== false || strpos($user_agent,"Android") !== false || strpos($user_agent,"NokiaX6") !== false || strpos($user_agent,"SAMSUNG-GT-i8000")!== false || strpos($user_agent,"BB10") !== false){
		$widthD = "320";
	}
}
echo $widthD;
?>