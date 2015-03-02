<?php
$msisdn=$_GET['msisdn'];
$amount=$_GET['amount'];

$rechargeurl="http://202.87.41.148/sms/4646/mo6_mkt/Rechaged/rechaged.php?msisdn=".$msisdn."&amount=".$amount."&client_id=4&operator_id=14";
echo $response=file_get_contents($rechargeurl);
?>

