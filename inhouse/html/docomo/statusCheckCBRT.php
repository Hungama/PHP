<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$url="http://10.124.13.18:8085/rbt/rbt_promotion.jsp?MSISDN=$msisdn&REQUEST=STATUS&XML_REQUIRED=TRUE";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	echo $response;
	curl_close($ch);
?>