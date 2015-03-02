<?php

/* @author: Jyoti Porwal
 * @File prupose: call add details API http://www.youngsingingstars.com/wapis/add-details.php?msisdn=<10 DIGIT MOBILE NO>&uid=<MAX USER ID>&filepath=<PATH OF FILE>&dtime=<DATE TIME YYYY-M-D H:i:s> 
 * and return response in # seprated Form 
 */
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}

$logDir = "/var/www/html/hungamacare/igenius/logs/callAddDetails/"; // log path @jyoti.porwal
$logFile_dump = "callAddDetailslogs_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";

$ipAddress = $_SERVER['REMOTE_ADDR'];

$msisdn = $_REQUEST['msisdn'];
$uid = $_REQUEST['uid'];
$filepath = $_REQUEST['filepath'];
if (isset($_REQUEST['dtime'])) {
$dtime = $_REQUEST['dtime'];
}
else
{
$dtime=date('Y-m-d H:i:s');
}
$dtime=date('Y-m-d H:i:s');
$logString = $msisdn . "#" . $uid . "#" . $filepath . "#" . $dtime . "#" . $ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
//error_log($logString, 3, $logPath);

/* * ***************************************** start function for replace space with '%20' string @jyoti.porwal ******************************************* */

function makeString($str) {
    $str1 = str_replace(' ', '%20', $str);
    return $str1;
}

/* * ***************************************** end function for replace space with '%20' string @jyoti.porwal ******************************************* */


if ($msisdn == '' || $uid == '' || $filepath == '' || $dtime == '') {
    echo "Invalid Parameter";
    exit; // if msisdn or uid not found than exit @jyoti porwal
}
if ((is_numeric($msisdn)) && (strlen($msisdn) == 12 || strlen($msisdn) == 10)) {
    
} else {
    echo "msisdn is not valid";
    exit; // if msisdn not valid than exit @jyoti porwal
}

/* * ********************************************************** start to call add details API  @jyoti.porwal ********************************* */
$dtime = makeString($dtime);
$url = "http://www.youngsingingstars.com/wapis/add-details.php?msisdn=" . $msisdn . "&uid=" . $uid . "&filepath=" . $filepath . "&dtime=" . $dtime;
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$data = json_decode($output, true);
/* * ********************************************************** end to call add details API  @jyoti.porwal ********************************* */
//$result = $data['response'] . "#" . $data['msg'];
$result = "out_string.length=2;out_string[0]='" . $data['response'] . "';out_string[1]='" . $data['msg'] . "'";
echo $result; // return string @jyoti.porwal
$logString = $msisdn . "#" . $uid . "#" . $filepath."#".$output."#".$result . "#" . $url."#".$ipAddress . "#" . date('Y-m-d H:i:s') . "\r\n";
error_log($logString, 3, $logPath);

//return $logString;
exit;
?>
