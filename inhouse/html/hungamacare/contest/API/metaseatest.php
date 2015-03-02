<?php
$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);
//txtMSG-->Thnks 4 downloading from Endless Music.To download,click link(Data Charges apply on download), 
//http://202.87.41.147/waphung/docomocontentServe/3601512/13759
//3487027/15334
$rngid=3601512;
//$rngid=1808084;
//, 2588764, 2089094, 2588765,
$url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/content/id/$rngid";
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
print_r($output);
?>
