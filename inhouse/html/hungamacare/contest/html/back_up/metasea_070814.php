<?php

/*
  //$url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/contentType/id/2554470";
  $url = "http://publisher.metasea.hungamatech.com:8080/MetaSeaWS";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERPWD, "uninor_contests:Uninor@1462");
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  $output = curl_exec($ch);
  print_r($output);
  echo "<br/>";
  $info = curl_getinfo($ch);
  print_r($info);
  curl_close($ch);
 */
$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);
header('Content-type: application/x-www-form-urlencoded');
/*
  $host = "http://publisher.metasea.hungamatech.com:8080/MetaSeaWS";
  $process = curl_init($host);
  //curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));

  //curl_setopt($process, CURLOPT_HEADER, 1);
  //curl_setopt($process, CURLOPT_USERPWD, "uninor_contests:Uninor@1462");
  //curl_setopt($process, CURLOPT_TIMEOUT, 30);
  //curl_setopt($process, CURLOPT_POST, 1);
  //curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
  $return = curl_exec($process);
  curl_close($process);
  print_r($return);
 */
//$url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/contentType/id/2554470";
$url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/content/id/2588408";
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_USERPWD, "uninor_contests:Uninor@1462");
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
$output = curl_exec($ch);
$xml=simplexml_load_file($output);
print_r($xml);
//print_r($output);
//echo "<br/><br/><br/>";
//$info = curl_getinfo($ch);
//print_r($info);
curl_close($ch);
?>