<?php
//$msisdn=9910400921;
$msisdn=$_REQUEST['msisdn'];
$circle='delhi';
$topUpUrl="http://10.2.73.158/cgi-bin/Air/ChargeAir.pl?tel=".$msisdn."&ip=10.2.22.206&port=10074&transactionCode=HM%20Top%2020&amount=1000";
$TopupResponse=file_get_contents($topUpUrl);
if($TopupResponse==0)
	echo 'Success';
else
	echo 'Charging Failed :'.$TopupResponse;
?>