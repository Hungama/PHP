<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

echo $date="2015-02-14";

$serviceArray = array('1102' => 'MTS54646', '1103' => 'MTVMTS', '11012' => 'MTSComedy', '1111' => 'MTSDevo', '1101' => 'MTSMU', '1116' => 'MTSVA', '1113' => 'MTSMND', '1110' => 'REDFMMTS', '1125' => 'MTSJokes', '1126' => 'MTS Regional', '1123' => 'MTS Contest','1108'=>'MTSSU');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

$delQuery1 = "DELETE FROM misdata.tbl_calling_cri_mts WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "' and dnis like '52444%'";
$result13 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/calllogLive/1108/MTSSU_" . $date . ".txt";
if (file_exists($callPath5))
    unlink($callPath5);

while ($row1 = mysql_fetch_array($result13)) {
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
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "\n";
    error_log($logData, 3, $callPath5);

    //$insertQuery1 = "insert into misdata.tbl_calling_devo_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath5 . '" INTO TABLE misdata.tbl_calling_cri_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPath1);

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
