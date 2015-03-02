<?php 
$check_pin="http://192.168.10.127/Reliance/PIN_generate.php";
$ch_pin=curl_init("$check_pin");
curl_setopt($ch_pin,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_pin= curl_exec($ch_pin);
//echo 'Curl error: ' . curl_error($ch_pin);
curl_close($ch_pin);
if($ch_execute_pin)
	echo $ch_execute_pin;
else
	echo $ch_execute_pin=rand(999,99999);
?>