<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

#echo $date="2014-02-03";

$serviceArray = array('1403' => 'MTVUninor', '1402' => 'Uninor54646', '1410' => 'RedFMUninor', '1409' => 'RIAUninor', '1412' => 'UninorRT', '1416' => 'UninorAstro',
    '14021' => 'UninorArtistAloud', '1408' => 'UninorSportsUnlimited', '1418' => 'UninorComedy', '1423' => 'UninorContest'
    , '1430' => 'UninorVABollyAlerts', '1431' => 'UninorVAFilmy', '1432' => 'UninorVABollyMasala', '1433' => 'UninorVAHealth', '1434' => 'UninorVAFashion');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST',
    'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');


$delQuery1 = "DELETE FROM misdata.tbl_calling_comedy WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1418'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, 
circle,status,mode from mis_db.tbl_azan_calllog nolock where date(call_date)='" . $date . "' and dnis='5464622' and operator ='unim'";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath4 = "/var/www/html/kmis/mis/livemis/calllogLive/1418/uninorComedy_" . $date . ".txt";
if (file_exists($callPath4))
    unlink($callPath4);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1418'] . "\n";
    error_log($logData, 3, $callPath4);

    //$insertQuery1 = "insert into misdata.tbl_calling_astro VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1418']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath4 . '" INTO TABLE misdata.tbl_calling_astro 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath4);

//=========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1402'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464646%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%') and dnis not like '%P%' and dnis NOT IN ('546461','5464626','5464628','5464611') and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath1 = "/var/www/html/kmis/mis/livemis/calllogLive/1402/uninor54646_" . $date . ".txt";
if (file_exists($callPath1))
    unlink($callPath1);
while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1402'] . "\n";
    error_log($logData, 3, $callPath1);

    //$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1402']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath1 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath1);
//=========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1403'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='" . $date . "' and dnis=546461 and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath2 = "/var/www/html/kmis/mis/livemis/calllogLive/1403/uninorMTV_" . $date . ".txt";
if (file_exists($callPath2))
    unlink($callPath2);
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

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . $serviceArray['1403'] . "\n";
    error_log($logData, 3, $callPath2);
    //$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1403']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}

$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath2 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath2);
//=========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1409'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' and dnis IN ('5464626','5464628','5464669') and operator in ('UNIM')";
$results1 = mysql_query($airtelQuery1, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1409/uninorRiya_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);
while ($row1 = mysql_fetch_array($results1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1409'] . "\n";
    error_log($logData, 3, $callPath3);

    //	$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1409']."')";
    //	$results11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);
//=========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_astro WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1416'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' and dnis like '5464627%' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath3 = "/var/www/html/kmis/mis/livemis/calllogLive/1416/uninorJAD_" . $date . ".txt";
if (file_exists($callPath3))
    unlink($callPath3);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1416'] . "\n";
    error_log($logData, 3, $callPath3);

    //	$insertQuery1 = "insert into misdata.tbl_calling_astro VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1416']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath3 . '" INTO TABLE misdata.tbl_calling_astro 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath3);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_redfm WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1410'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_redfm_calllog nolock where date(call_date)='" . $date . "' and dnis=55935 and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1410/uninorREDFM_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1410'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_redfm 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_aa_uninor WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' and dnis='5464611' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath6 = "/var/www/html/kmis/mis/livemis/calllogLive/14021/uninorAAV_" . $date . ".txt";
if (file_exists($callPath6))
    unlink($callPath6);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $lastHeard = trim($row1[8]);
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath6);

    //	$insertQuery1 = "insert into misdata.tbl_calling_aa_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath6 . '" INTO TABLE misdata.tbl_calling_aa_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath6);
//=========================================================================================================

$delQuery1 = "DELETE FROM misdata.tbl_calling_cri_uninor WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "' and (dnis like '52444%' or dnis like '52299%') and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath7 = "/var/www/html/kmis/mis/livemis/calllogLive/1408/uninorCRIC_" . $date . ".txt";
if (file_exists($callPath7))
    unlink($callPath7);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $lastHeard = trim($row1[8]);
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath7);

    //$insertQuery1 = "insert into misdata.tbl_calling_cri_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath7 . '" INTO TABLE misdata.tbl_calling_cri_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath7);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_rt_uninor WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_rt_calllog nolock where date(call_date)='" . $date . "' and dnis like '52888%' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath8 = "/var/www/html/kmis/mis/livemis/calllogLive/1412/uninorRT_" . $date . ".txt";
if (file_exists($callPath8))
    unlink($callPath8);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $lastHeard = trim($row1[8]);
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    //$insertQuery1 = "insert into misdata.tbl_calling_rt_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath8);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath8 . '" INTO TABLE misdata.tbl_calling_rt_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath8);

//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_contest_uninor WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,
    duration_in_sec,pulse,dnis, circle,status,lastHeard,mode from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "' and dnis 
        like '52000' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath8 = "/var/www/html/kmis/mis/livemis/calllogLive/1423/uninorContest_" . $date . ".txt";
if (file_exists($callPath8))
    unlink($callPath8);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $lastHeard = trim($row1[8]);
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    //$insertQuery1 = "insert into misdata.tbl_calling_rt_uninor VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath8);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath8 . '" INTO TABLE misdata.tbl_calling_contest_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath8);

//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_va_uninor  WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1430'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode 
                 from mis_db.tbl_bollyalerts_calllog nolock where date(call_date)='" . $date . "' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1430/uninorbollyAlerts_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1430'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_va_uninor  
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_va_uninor  WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1431'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode 
                 from mis_db.tbl_FilmiWords_calllog nolock where date(call_date)='" . $date . "' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1431/uninorFilmiWord_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1431'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_va_uninor  
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_va_uninor  WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1432'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode
    from mis_db.tbl_BollywoodMasala_calllog nolock where date(call_date)='" . $date . "' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1432/uninorBollyMasala_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1432'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_va_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_va_uninor WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1433'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode
    from mis_db.tbl_FilmiHeath_calllog nolock where date(call_date)='" . $date . "' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1433/uninorFilmiHealth_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1433'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_va_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);
//=========================================================================================================


$delQuery1 = "DELETE FROM misdata.tbl_calling_va_uninor WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1434'] . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode 
    from mis_db.tbl_CelebrityFashion_calllog nolock where date(call_date)='" . $date . "' and operator in ('UNIM')";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1434/uninorCFashion_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1434'] . "\n";
    error_log($logData, 3, $callPath5);

    //	$insertQuery1 = "insert into misdata.tbl_calling_redfm VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1410']."')";
    //	$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_va_uninor 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,
service)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath5);



mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
