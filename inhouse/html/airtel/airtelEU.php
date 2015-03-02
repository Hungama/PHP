<?php
$msisdn=$_REQUEST['msisdn'];
$ringid=$_REQUEST['ringid'];
$generatePin='http://202.87.41.147/waphung/contentServe/PIN_generate.php';

//echo $pinResponse =file_get_contents($generatePin);
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL,$generatePin);
curl_setopt ($ch1, CURLOPT_RETURNTRANSFER, true);
echo $pinResponse = curl_exec($ch1);


?>