<?php
$header=getallheaders();
$user_agent=$header['User-Agent'];
$msisdn=$header['msisdn'];
$time=date("H:i:s");
$dateformat = date("Ymd");
$logpath="/var/www/html/swati/logs/capture_".$dateformat.".txt";
if($msisdn)
{
	echo "Thank You";
}
else
{
	echo $msisdn="Msisdn not found";
}
$errorString=$user_agent."|".$msisdn."|".$time."\n";
error_log($errorString,3,$logpath);

?>

