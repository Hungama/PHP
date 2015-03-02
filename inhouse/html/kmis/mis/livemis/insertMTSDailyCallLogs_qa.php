<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

//$date="2014-04-10";

$serviceArray = array('1102' => 'MTS54646', '1103' => 'MTVMTS', '11012' => 'MTSComedy', '1111' => 'MTSDevo', '1101' => 'MTSMU', '1116' => 'MTSVA', '1113' => 'MTSMND', '1110' => 'REDFMMTS', '1125' => 'MTSJokes', '1126' => 'MTS Regional', '1123' => 'MTS Contest');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

//for($i=11;$i<24;$i++)
//{
//$date="2014-04-".$i;
echo "Call Log For ".$date."<br>";

/************for regional service********************/

$delQuery1 = "DELETE FROM misdata.tbl_calling_reg_mts WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as 
    et,duration_in_sec,pulse,dnis, circle,status,chrg_rate,mode from mis_db.tbl_reg_calllog nolock where date(call_date)='" . $date . "' and dnis ='51111'";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPathRegionalPortal = "/var/www/html/kmis/mis/livemis/calllogLive/1126/MTSRegionalPortal_" . $date . ".txt";
if (file_exists($callPathRegionalPortal))
    unlink($callPathRegionalPortal);

while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $chrg_rate = trim($row1[8]);
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

  $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $chrg_rate . "\n";
    error_log($logData, 3, $callPathRegionalPortal);

    //$insertQuery1 = "insert into misdata.tbl_calling_54646 VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '','','".$serviceArray['1102']."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPathRegionalPortal . '" INTO TABLE misdata.tbl_calling_reg_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,uprice)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPathRegionalPortal);


/************for COntest service********************/

$delQuery1 = "DELETE FROM misdata.tbl_calling_contest_mts WHERE date(starttime)='" . $date . "'";
$delResult1 = mysql_query($delQuery1, $LivdbConn);

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as 
    et,duration_in_sec,pulse,dnis, circle,status,chrg_rate,mode from mis_db.tbl_mtv_calllog nolock where date(call_date)='" . $date . "' and dnis ='55333'";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPathContestPortal = "/var/www/html/kmis/mis/livemis/calllogLive/1123/MTSContestPortal_" . $date . ".txt";
if (file_exists($callPathContestPortal))
    unlink($callPathContestPortal);
while ($row1 = mysql_fetch_array($result1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    $circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $chrg_rate = intval(trim($row1[8]));
    $mode = trim($row1[9]);
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';
    if (!$endTime)
        $endTime = $startTime;

    $logData = $msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $chrg_rate . "\n";
    error_log($logData, 3, $callPathContestPortal);

    //$insertQuery1 = "insert into misdata.tbl_calling_contest_mts VALUES ('".$msisdn."', '".$startTime."', '".$endTime."','".$totalSec."','".$pulse."','".$dnis."', '".$circleName."', '".$actualStatus."', '0','".$mode."','".$chrg_rate."')";
    //$result11 = mysql_query($insertQuery1,$LivdbConn);
}
$insertDump1 = 'LOAD DATA LOCAL INFILE "' . $callPathContestPortal . '" INTO TABLE misdata.tbl_calling_contest_mts 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 				
(msisdn,starttime,endtime,duration,pulses,dnis,circle,status,transactionid,planid,uprice)';
mysql_query($insertDump1, $LivdbConn);
unlink($callPathContestPortal);
//sleep(4);
//}
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>