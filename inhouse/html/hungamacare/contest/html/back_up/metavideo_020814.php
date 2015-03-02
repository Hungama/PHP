<?php

$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);
//$url = "http://mdn.hungama.com/download/2446646/1/2/abc";
$url = "http://mdn.hungama.com/download/2446646/1/4/abc?duration=PT0H0M30S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";

//http:// mdn.hungama.com/download/12345/4/8/Test      //test video url
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
print_r($output);
curl_close($ch);
?>