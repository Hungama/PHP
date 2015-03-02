<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

//echo $date="2014-02-03";

$serviceArray = array('1102' => 'MTS54646', '1103' => 'MTVMTS', '11012' => 'MTSComedy', '1111' => 'MTSDevo', '1101' => 'MTSMU', '1116' => 'MTSVA', '1113' => 'MTSMND', '1110' => 'REDFMMTS', '1125' => 'MTSJokes', '1126' => 'MTS Regional', '1123' => 'MTS Contest');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');


//========================================================================================================
                //MTS IBD Calling insert
//========================================================================================================
$delQueryR = "DELETE FROM misdata.tbl_calling_ibd_mts WHERE date(starttime)='" . $date . "'";
$delResultR = mysql_query($delQueryR, $LivdbConn);


//Vasportal callog insert
$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='" . $date . "'";
$resultsR = mysql_query($airtelQueryR, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1124/ibd_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($rowR = mysql_fetch_array($resultsR)) {
    $msisdn = trim($rowR[0]);
    $startTime = trim($rowR[1]);
    $endTime = trim($rowR[2]);
    $totalSec = trim($rowR[3]);
    $pulse = trim($rowR[4]);
    $dnis = trim($rowR[5]);
    $circleCode = trim($rowR[6]);
    $status = trim($rowR[7]);
    $lastHeard = trim($rowR[8]);
    $mode = 'MTSIBD_'.trim($rowR[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . "\n";
    error_log($logData, 3, $callPath3);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_ibd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);

//mtsmu ibd callog insert

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_radio_calllog nolock where date(call_date)='" . $date . "' and dnis like '55789%'";
$resultsR = mysql_query($airtelQueryR, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1124/muibd_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($rowR = mysql_fetch_array($resultsR)) {
    $msisdn = trim($rowR[0]);
    $startTime = trim($rowR[1]);
    $endTime = trim($rowR[2]);
    $totalSec = trim($rowR[3]);
    $pulse = trim($rowR[4]);
    $dnis = trim($rowR[5]);
    $circleCode = trim($rowR[6]);
    $status = trim($rowR[7]);
    $lastHeard = trim($rowR[8]);
    $mode = 'MTSMU_'.trim($rowR[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . "\n";
    error_log($logData, 3, $callPath3);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_ibd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);

//mtsdevo ibd callog

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_Devotional_calllog nolock where date(call_date)='" . $date . "' and dnis like '55789%'";
$resultsR = mysql_query($airtelQueryR, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1124/devoibd_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($rowR = mysql_fetch_array($resultsR)) {
    $msisdn = trim($rowR[0]);
    $startTime = trim($rowR[1]);
    $endTime = trim($rowR[2]);
    $totalSec = trim($rowR[3]);
    $pulse = trim($rowR[4]);
    $dnis = trim($rowR[5]);
    $circleCode = trim($rowR[6]);
    $status = trim($rowR[7]);
    $lastHeard = trim($rowR[8]);
    $mode = 'MTSDevo_'.trim($rowR[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . "\n";
    error_log($logData, 3, $callPath3);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_ibd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);

//contest ibd callog

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_mtv_calllog nolock where date(call_date)='" . $date . "' and dnis like '55789%'";
$resultsR = mysql_query($airtelQueryR, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1124/contestibd_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($rowR = mysql_fetch_array($resultsR)) {
    $msisdn = trim($rowR[0]);
    $startTime = trim($rowR[1]);
    $endTime = trim($rowR[2]);
    $totalSec = trim($rowR[3]);
    $pulse = trim($rowR[4]);
    $dnis = trim($rowR[5]);
    $circleCode = trim($rowR[6]);
    $status = trim($rowR[7]);
    $lastHeard = trim($rowR[8]);
    $mode = 'MTSContest_'.trim($rowR[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . "\n";
    error_log($logData, 3, $callPath3);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_ibd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);

//Regional ibd callog

$airtelQueryR = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_reg_calllog nolock where date(call_date)='" . $date . "' and dnis like '55789%'";
$resultsR = mysql_query($airtelQueryR, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1124/regibd_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($rowR = mysql_fetch_array($resultsR)) {
    $msisdn = trim($rowR[0]);
    $startTime = trim($rowR[1]);
    $endTime = trim($rowR[2]);
    $totalSec = trim($rowR[3]);
    $pulse = trim($rowR[4]);
    $dnis = trim($rowR[5]);
    $circleCode = trim($rowR[6]);
    $status = trim($rowR[7]);
    $lastHeard = trim($rowR[8]);
    $mode = 'MTSReg_'.trim($rowR[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . "\n";
    error_log($logData, 3, $callPath3);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_ibd_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);


//========================================================================================================

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>