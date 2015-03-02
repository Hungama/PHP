<?php
$header=getallheaders();

$userAgent=$header['User-Agent'];
$contentId=$_REQUEST['contentId'];

$HitUrl="http://202.87.41.147/CMT/api/Voice/checkCompatibility.php";
$dataPost="userAgent=".$userAgent."&contentId=".$contentId;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$HitUrl);
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS,$dataPost);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
echo $response = curl_exec($ch);


?>   