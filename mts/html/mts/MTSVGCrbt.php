<?php
error_reporting(0);
$logPath ="/var/www/html/MTS/logs/MTS/crbt/VG/crbt_log_".date("Ymd").".txt";
$msisdn = $_REQUEST['msisdn'];
$vcode = $_REQUEST['vcode'];
$cgid = $_REQUEST['cgid'];
if (($msisdn == "") || ($vcode == "") || ($cgid == "")) {
    echo "Please provide the complete parameter";
	exit;
	}
$HitUrl="http://10.130.7.35:80/interfaces/ordertone.do?operatoraccount=OBD1&operatorpwd=OBD1&phonenumber=".$msisdn."&resourcecode=".$vcode."&resourcetype=1&operator=10&cg_id=".$cgid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$HitUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);
$logData = $msisdn."#".$vcode."#".$cgid."#".$HitUrl."#".trim($response)."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
curl_close($ch);
echo trim($response);
?>