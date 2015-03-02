<?php

include ("/var/www/html/digi/dbDigiConnect.php");

$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

//echo $date="2013-11-20";
//echo $fileDate="20131120";

$serviceArray = array('1701' => 'DIGIMA');

function getCircle($shortCode) {
    if (strpos($shortCode, '131221'))
        $circle = 'Bangla';
    elseif (strpos($shortCode, '131222'))
        $circle = 'Nepali';
    elseif (strpos($shortCode, '131224'))
        $circle = 'Indian';
    return $circle;
}

$activeDir = "/var/www/html/digi/logs/";

$delQuery = "DELETE FROM misdata.tbl_calling_mod_digi WHERE date(starttime)='" . $date . "'";
$delResult = mysql_query($delQuery, $LivdbConn);

$digilogfile = "digi_" . $fileDate . ".txt";
$digiFilePath = $activeDir . $digilogfile;

$digilogfile1 = "digi1_" . $fileDate . ".txt";
$digiFilePath1 = $activeDir . $digilogfile1;

$digilogfile2 = "digi2_" . $fileDate . ".txt";
$digiFilePath2 = $activeDir . $digilogfile2;

unlink($digiFilePath);
unlink($digiFilePath1);
unlink($digiFilePath2);

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Indian',status,mode from mis_db.tbl_digi_calllog where date(call_date)='" . $date . "' and dnis like '131224%'";
$result41 = mysql_query($airtelQuery41, $dbConn);

while ($row1 = mysql_fetch_array($result41)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleName = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";

    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;
    $digiFiledata = $msisdn . "|" . $startTime . "|" . $endTime . "|" . $totalSec . "|" . $pulse . "|" . $dnis . "|" . $circleName . "|" . $actualStatus . "|" . $mode . "\r\n";
    error_log($digiFiledata, 3, $digiFilePath);


    /* 	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES 
      ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
      $result2 = mysql_query($insertQuery,$LivdbConn);
     */
}
//msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid
$insertDump = 'LOAD DATA LOCAL INFILE "' . $digiFilePath . '" INTO TABLE misdata.tbl_calling_mod_digi FIELDS TERMINATED BY 
"|" LINES TERMINATED BY "\n" (msisdn,starttime,endtime,duration,pulses,dnis,circle,status,planid)';

if (mysql_query($insertDump, $LivdbConn)) {
    $file_process_status = 'Load Data query execute successfully-1' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
} else {
    $error = mysql_error();
    $file_process_status = 'Load Dara Error- 1' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
}


$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Bangla',status,mode from mis_db.tbl_digi_calllog where date(call_date)='" . $date . "' and dnis like '131221%'";
$result41 = mysql_query($airtelQuery41, $dbConn);

while ($row1 = mysql_fetch_array($result41)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleName = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";

    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $digiFiledata1 = $msisdn . "|" . $startTime . "|" . $endTime . "|" . $totalSec . "|" . $pulse . "|" . $dnis . "|" . $circleName . "|" . $actualStatus . "|" . $mode . "\r\n";
    error_log($digiFiledata1, 3, $digiFilePath1);
//	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //$result2 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $digiFilePath1 . '" INTO TABLE misdata.tbl_calling_mod_digi FIELDS TERMINATED BY 
"|" LINES TERMINATED BY "\n" (msisdn,starttime,endtime,duration,pulses,dnis,circle,status,planid)';
if (mysql_query($insertDump1, $LivdbConn)) {
    $file_process_status = 'Load Data query execute successfully-2' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
} else {
    $error = mysql_error();
    $file_process_status = 'Load Dara Error- 2' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
}



$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,addtime(concat(call_date,' ',call_time),duration_in_sec) as et,duration_in_sec,pulse,dnis, 'Nepali',status,mode from mis_db.tbl_digi_calllog where date(call_date)='" . $date . "' and dnis like '131222%'";
$result41 = mysql_query($airtelQuery41, $dbConn);

while ($row1 = mysql_fetch_array($result41)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleName = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";

    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $digiFiledata2 = $msisdn . "|" . $startTime . "|" . $endTime . "|" . $totalSec . "|" . $pulse . "|" . $dnis . "|" . $circleName . "|" . $actualStatus . "|" . $mode . "\r\n";
    error_log($digiFiledata2, 3, $digiFilePath2);
//	$insertQuery = "insert into misdata.tbl_calling_mod_digi VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //$result2 = mysql_query($insertQuery,$LivdbConn);
}
$insertDump2 = 'LOAD DATA LOCAL INFILE "' . $digiFilePath2 . '" INTO TABLE misdata.tbl_calling_mod_digi FIELDS TERMINATED BY 
"|" LINES TERMINATED BY "\n" (msisdn,starttime,endtime,duration,pulses,dnis,circle,status,planid)';
if (mysql_query($insertDump2, $LivdbConn)) {
    $file_process_status = 'Load Data query execute successfully-3' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
} else {
    $error = mysql_error();
    $file_process_status = 'Load Dara Error- 3' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
}

echo "Done";
?>
