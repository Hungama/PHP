<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    } else {
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}

//echo $date="2014-02-06";

$serviceArray = array('1202' => 'Reliance54646', '1203' => 'MTVReliance', '1202P' => 'ReliancePauseCode', '1208' => 'RelianceCM', '1201' => 'RelianceMM');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

/*
$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1202'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_54646_calllog nolock 
where date(call_date)='" . $date . "' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464646%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath1 = "/var/www/html/kmis/mis/livemis/calllogLive/1202/Reliance54646_" . $date . ".txt";
while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . $serviceArray['1202'] . "\n";
    error_log($logData, 3, $callPath1);

    //$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1202']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath1 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath1);
//========================================================================================================

$delQuery2 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1203'] . "'";
$delResult2 = mysql_query($delQuery2, $LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='" . $date . "' and dnis=546461 and operator in('relm','relc')";
$result2 = mysql_query($airtelQuery2, $dbConn);

$callPath2 = "/var/www/html/kmis/mis/livemis/calllogLive/1203/MTVReliance_" . $date . ".txt";
while ($row1 = mysql_fetch_array($result2)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . $serviceArray['1203'] . "\n";
    error_log($logData, 3, $callPath2);

    //$insertQuery2 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1203']."')";
    //$result12 = mysql_query($insertQuery2,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath2 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath2);
//========================================================================================================

$delQuery2 = "DELETE FROM misdata.tbl_calling_mod_reliance WHERE date(starttime)='" . $date . "'";
$delResult2 = mysql_query($delQuery2, $LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status 
    from mis_db.tbl_musicmania_calllog nolock where date(call_date)='" . $date . "'  and dnis like '543219%' and operator in('relm','relc')";
$result2 = mysql_query($airtelQuery2, $dbConn);

$callPath2 = "/var/www/html/kmis/mis/livemis/calllogLive/1201/MTVReliance_" . $date . ".txt";
while ($row1 = mysql_fetch_array($result2)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . "\n";
    error_log($logData, 3, $callPath2);

    //$insertQuery2 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1203']."')";
    //$result12 = mysql_query($insertQuery2,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath2 . '" INTO TABLE misdata.tbl_calling_mod_reliance
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath2);
//========================================================================================================
*/
///RelianceCricket CALLS LOGS

$delQuery2 = "DELETE FROM misdata.tbl_calling_cri_reliance WHERE date(starttime)='" . $date . "'";
$delResult2 = mysql_query($delQuery2, $LivdbConn);

$airtelQuery2 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status 
    from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "'  and dnis  in(54433,544337,5443322,5443333,544334,5443344)and operator in('relm','relc')";
$result2 = mysql_query($airtelQuery2, $dbConn);

$callPath2 = "/var/www/html/kmis/mis/livemis/calllogLive/1208/CricketReliance_" . $date . ".txt";
while ($row1 = mysql_fetch_array($result2)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . "\n";
    error_log($logData, 3, $callPath2);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath2 . '" INTO TABLE misdata.tbl_calling_cri_reliance
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath2);
echo "Done";
?>