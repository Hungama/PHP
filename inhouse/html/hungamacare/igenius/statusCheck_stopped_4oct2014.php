<?php

/* @author: Jyoti Porwal
 * @File prupose: return child 1 subscription date, child 1 update date, child 2 subscription date, child 2 update date
 */
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
include ("../config/dbConnect.php"); // db connection @jyoti.porwal
$logDir = "/var/www/html/hungamacare/igenius/logs/statuscheck/"; // log path @jyoti.porwal
$logFile_dump = "logs_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";

$ipAddress = $_SERVER['REMOTE_ADDR'];

$msisdn = $_REQUEST['msisdn'];

$logString = $msisdn . "#" . $ipAddress . "#" . date(YmdHis) . "\r\n";
error_log($logString, 3, $logPath);

if ($msisdn == '') {
    echo "Invalid Parameter";
    exit; // if msisdn not found than exit @jyoti porwal
}
if ((is_numeric($msisdn)) && (strlen($msisdn) == 12 || strlen($msisdn) == 10)) {
    
} else {
    echo "msisdn is not valid";
    exit; // if msisdn not valid than exit @jyoti porwal
}

/* * ************************************************************************* satrt database intraction @jyoti.porwal ********************************* */
// as Rahul sir said he will provide database and tables deatils then details will come from table, right now display NA
$qry = "select regdate,lastupdatedatechild1,regdatechild2,lastupdatedatechild2 from  Hungama_Maxlife_IGenius.tbl_userstatus where ANI='" . $msisdn . "'";
$result = mysql_query($qry);
$details = mysql_fetch_array($result);
$hourqry = "select regdate from  Hungama_Maxlife_IGenius.tbl_userstatus where ANI='" . $msisdn . "' and regdate > DATE_SUB(NOW(), INTERVAL 48 HOUR)";
$hourresult = mysql_query($hourqry);
$hourdetails = mysql_fetch_array($hourresult);
/* * ************************************************************************* end database intraction @jyoti.porwal ********************************* */
if ($details['regdate'] != '') {
    if ($details['regdatechild2'] == '') {
        $details['regdatechild2'] = "NA";
    }
    if ($details['lastupdatedatechild2'] == '') {
        $details['lastupdatedatechild2'] = "NA";
    }
    if ($hourdetails['regdate'] == '') {
        $result = "3#" . $details['regdate'] . "#" . $details['lastupdatedatechild1'] . "#" . $details['regdatechild2'] . "#" . $details['lastupdatedatechild2'];
    } else {
        $result = "1#" . $details['regdate'] . "#" . $details['lastupdatedatechild1'] . "#" . $details['regdatechild2'] . "#" . $details['lastupdatedatechild2'];
    }
} else {
    $result = "2#NA#NA#NA#NA";
}
echo $result; // return string @jyoti.porwal
$logString = $result . "#" . $ipAddress . "#" . date(YmdHis) . "\r\n";
error_log($logString, 3, $logPath);

//return $logString;
exit;
?>