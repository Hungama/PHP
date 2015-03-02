<?php
$filename='a.txt';
$logPath="logs.txt";
$fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
   echo $totalcount=count($e);
    for ($i = 0; $i < $totalcount; $i++) {
	$url=trim($e[$i]);
	$hit=substr($url, 0, -1);
	$url_response = file_get_contents($hit);
	$logString = $url_response . "@@". $hit."\r\n";
	error_log($logString, 3, $logPath);
	}
?>