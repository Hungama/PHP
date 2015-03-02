<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//echo $date="2014-10-19";
echo $date;
if ($dbConn)
    echo "connect voda";

$serviceArray = array('1302' => 'Vodafone54646', '1303' => 'VodafoneMTV', '1307' => 'VH1Vodafone', '1310' => 'REDFMVodafone', '130202' => 'VodafonePoet', '1301' => 'VodafoneMU');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

$delQuery = "DELETE FROM misdata.tbl_calling_54646 WHERE date(starttime)='" . $date . "' and service='" . $serviceArray['1302'] . "' and dnis='546465'";
$delResult = mysql_query($delQuery, $LivdbConn);

$airtelQuery41 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,ceiling((duration_in_sec-10)/60) as pulse,'546465', circle,status,mode,lastHeard from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' and  real_dnis='66291004'  and operator in('vodm')";
$result41 = mysql_query($airtelQuery41, $dbConn);
$callPath1 = "/var/www/html/kmis/mis/livemis/calllogLive/1302/Vodafone54646ChatSRK_" . $date . ".txt";
if (file_exists($callPath1))
    unlink($callPath1);


while ($row1 = mysql_fetch_array($result41)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    $lastHeard = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    if ($endTime && $serviceArray['1302']) {

        $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . $serviceArray['1302'] . "\n";
        error_log($logData, 3, $callPath1);
 }
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPath1 . '" INTO TABLE misdata.tbl_calling_54646 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,service)';
mysql_query($insertDump1, $LivdbConn);
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
