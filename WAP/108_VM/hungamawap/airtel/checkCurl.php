<?php
//check for blacklist start here
$msisdn='8587800665';
$StatusCheckUrl="http://10.48.54.11/hungamawap/airtel/checkStatusLdr.php";
$StatusCheckUrl.="?msisdn=$msisdn";
$statusCheck_result=curl_init($StatusCheckUrl);
curl_setopt($statusCheck_result,CURLOPT_RETURNTRANSFER,TRUE);
$statusapiResult= curl_exec($statusCheck_result);
curl_close($statusCheck_result);
echo $statusapiResult;
?>
