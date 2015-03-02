<?php

/* @author: Jyoti Porwal
 * @File prupose: call status check API http://www.youngsingingstars.com/wapis/check-status.php?msisdn=<10 DIGIT MOBILE NO>&uid=<MAX USER ID> 
 * and return response in # seprated Form 
 */
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
$logDir = "/var/www/html/hungamacare/igenius/logs/callCheckStatus/"; // log path @jyoti.porwal
$logFile_dump = "logs_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";

$ipAddress = $_SERVER['REMOTE_ADDR'];

$msisdn = $_REQUEST['msisdn'];
$uid = $_REQUEST['uid'];

$logString = $msisdn . "#" . $uid . "#" . $ipAddress . "#" . date(YmdHis) . "\r\n";
//error_log($logString, 3, $logPath);

if ($msisdn == '' || $uid == '') {
    echo "Invalid Parameter";
    exit; // if msisdn or uid not found than exit @jyoti porwal
}
if ((is_numeric($msisdn)) && (strlen($msisdn) == 12 || strlen($msisdn) == 10)) {
    
} else {
    echo "msisdn is not valid";
    exit; // if msisdn not valid than exit @jyoti porwal
}

/* * ********************************************************** start to call check status API  @jyoti.porwal ********************************* */
$url = "http://www.youngsingingstars.com/wapis/check-status.php?msisdn=" . $msisdn . "&uid=" . $uid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$data = json_decode($output, true);
/* * ********************************************************** end to call check status API  @jyoti.porwal ********************************* */
if ($data['response'] == 3) {
//    $result = $data['response'] . "#" . $data['msg'];
    $result = "out_string.length=2;out_string[0]='" . $data['response'] . "';out_string[1]='" . $data['msg'] . "'";
} else {
//    $result = $data['response'] . "#" . $data['entrydate'] . "#" . $data['updatedate'];
    $result = "out_string.length=3;out_string[0]='" . $data['response'] . "';out_string[1]='" . $data['entrydate'] . "';out_string[2]='" . $data['updatedate'] . "'";
}
echo $result; // return string @jyoti.porwal
$logString = $msisdn . "#" . $uid ."#".$output."#".$result . "#" . $ipAddress . "#" . date(YmdHis) . "\r\n";
error_log($logString, 3, $logPath);

//return $logString;
exit;
?>