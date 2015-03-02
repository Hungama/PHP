<?php
$postdate=date("Y-m-d");
$reponseLog="logs/process_".$postdate.".txt";
$getstatus="http://124.153.75.198/fanpage/fbapps/etisalat/EtisalatFbShareLog.php";
echo $status = file_get_contents($getstatus);
$data="Response-".$status."\n\r";
error_log($data,3,$reponseLog);
//cron set in /var/www/html/all/zipemail
exit;
?>
