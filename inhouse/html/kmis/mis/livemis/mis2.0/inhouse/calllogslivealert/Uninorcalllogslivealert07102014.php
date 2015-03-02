<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(0);
$dbConn=$dbConn212;
$serviceArray = array('1403' => 'MTVUninor', '1402' => 'Uninor54646', '1410' => 'RedFMUninor', '1409' => 'RIAUninor', '1412' => 'UninorRT', '1416' => 'UninorAstro',
    '14021' => 'UninorArtistAloud', '1408' => 'UninorSportsUnlimited', '1418' => 'UninorComedy', '1423' => 'UninorContest'
    , '1430' => 'UninorVABollyAlerts', '1431' => 'UninorVAFilmy', '1432' => 'UninorVABollyMasala', '1433' => 'UninorVAHealth', '1434' => 'UninorVAFashion');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST',
    'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');
//get current hour start here
$getCurrentTimeQuery="select hour(now())";
$timequery = mysql_query($getCurrentTimeQuery, $dbConn);
$resulth = mysql_fetch_row($timequery);
$gethour = sprintf("%02s", $resulth[0]);

if($gethour==00)
{
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$cond="";
$chour="23";
}
else
{
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$cond=" and hour(call_time)<'".$gethour."' ";
//$gethour= date('H', strtotime('-1 hour'));
$chour=$gethour;
$chour = sprintf("%02s", $chour);
}

echo 'Data for '.$chour."#".$gethour."#".$cond;
//exit;
//$time= date('H', strtotime('-1 hour'));
//get current hour end here
echo "Uninor54646_54646_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,lastHeard,hour(call_time) from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' 
$cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464646%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%') and dnis not like '%P%' and dnis NOT IN ('546461','5464626','5464628','5464611') and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath1 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/Uninor54646_54646_00_".$chour.".txt";
if (file_exists($callPath1))
    unlink($callPath1);
	$logData = "CurrentHour#MSISDN#CALL_STARTTIME#CALL_ENDTIME#DURATION(In SEC)#PULSE#DNIS#CIRCLE#STATUS#LAST HEARD#MODE#SERVICE". "\n";
    error_log($logData, 3, $callPath1);
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
    $lastHeard = trim($row1[9]);
    
	$callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
	
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "#" . $serviceArray['1402'] . "\n";
    error_log($logData, 3, $callPath1);

}

/*
echo "UninorComedy_5464622_00_".$chour.".txt"."<br>";
echo $airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, 
circle,status,mode,hour(call_time) from mis_db.tbl_azan_calllog nolock where date(call_date)='" . $date . "' $cond and dnis='5464622' and operator ='unim' order by hour(call_time)";

$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath4 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorComedy_5464622_00_".$chour.".txt";
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
	$callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1418'] . "\n";
    error_log($logData, 3, $callPath4);
}

echo "MTVUninor_546461_00_".$chour.".txt"."<br>";

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,hour(call_time) from mis_db.tbl_mtv_calllog nolock where date(call_date)='" . $date . "' $cond and dnis=546461 and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath2 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/MTVUninor_546461_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[8]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#0#" . $serviceArray['1403'] . "\n";
    error_log($logData, 3, $callPath2);

}

echo "RIAUninor_5464628_00_".$chour.".txt"."<br>";


$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_mnd_calllog nolock where date(call_date)='" . $date . "' $cond and dnis IN ('5464628','66291428') and operator in ('UNIM') order by hour(call_time)";
$results1 = mysql_query($airtelQuery1, $dbConn);
$callPath3 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/RIAUninor_5464628_00_".$chour.".txt";
if (file_exists($callPath3))
    unlink($callPath3);
while ($row1 = mysql_fetch_array($results1)) {
    $msisdn = trim($row1[0]);
    $startTime = trim($row1[1]);
    $endTime = trim($row1[2]);
    $totalSec = trim($row1[3]);
    $pulse = trim($row1[4]);
    $dnis = trim($row1[5]);
    
	
	if($dnis=='66291428')
	$dnis='5464628';
    
	$circleCode = trim($row1[6]);
    $status = trim($row1[7]);
    $mode = trim($row1[8]);
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1409'] . "\n";
    error_log($logData, 3, $callPath3);

}

echo "UninorAstro_5464627_00_".$chour.".txt"."<br>";

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' $cond and dnis like '5464627%' and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath3 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorAstro_5464627_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1416'] . "\n";
    error_log($logData, 3, $callPath3);

}

echo "RedFMUninor_55935_00_".$chour.".txt"."<br>";

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_redfm_calllog nolock where date(call_date)='" . $date . "' $cond and dnis=55935 and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/RedFMUninor_55935_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1410'] . "\n";
    error_log($logData, 3, $callPath5);

}

echo "UninorArtistAloud_5464611_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode,hour(call_time) from mis_db.tbl_54646_calllog nolock where date(call_date)='" . $date . "' $cond and dnis='5464611' and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath6 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorArtistAloud_5464611_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath6);

}

echo "UninorSportsUnlimited_52444_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode,hour(call_time) from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "' $cond and (dnis like '52444%' or dnis like '52299%') and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath7 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorSportsUnlimited_52444_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath7);

}

echo "UninorRT_52888_00_".$chour.".txt"."<br>";

$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode,hour(call_time) from mis_db.tbl_rt_calllog nolock where date(call_date)='" . $date . "' $cond and dnis like '52888%' and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath8 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorRT_52888_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath8);
}

echo "UninorContest_52000_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,lastHeard,mode,hour(call_time) from mis_db.tbl_cricket_calllog nolock where date(call_date)='" . $date . "' $cond and dnis like '52000' and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath8 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/UninorContest_52000_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

   $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#" . $lastHeard . "#" . $mode . "\n";
    error_log($logData, 3, $callPath8);
}

echo "uninorbollyAlerts_5464624_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_bollyalerts_calllog nolock where date(call_date)='" . $date . "' $cond and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);

$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/uninorbollyAlerts_5464624_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[10]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1430'] . "\n";
    error_log($logData, 3, $callPath5);
}

echo "uninorFilmiWord_5464624_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode ,hour(call_time) from mis_db.tbl_FilmiWords_calllog nolock where date(call_date)='" . $date . "' $cond and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/uninorFilmiWord_5464624_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1431'] . "\n";
    error_log($logData, 3, $callPath5);

}

echo "uninorBollyMasala_5464624_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_BollywoodMasala_calllog nolock where date(call_date)='" . $date . "' $cond and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/uninorBollyMasala_5464624_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1432'] . "\n";
    error_log($logData, 3, $callPath5);
}

echo "uninorFilmiHealth_5464624_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_FilmiHeath_calllog nolock where date(call_date)='" . $date . "' $cond and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/uninorFilmiHealth_5464624_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1433'] . "\n";
    error_log($logData, 3, $callPath5);

}

echo "uninorCFashion_5464624_00_".$chour.".txt"."<br>";
$airtelQuery1 = "select msisdn,concat(call_date,' ',call_time) as st,DATE_ADD(concat(call_date,' ',call_time), INTERVAL duration_in_sec SECOND) as et,duration_in_sec,pulse,dnis, circle,status,mode,hour(call_time) from mis_db.tbl_CelebrityFashion_calllog nolock where date(call_date)='" . $date . "' $cond and operator in ('UNIM') order by hour(call_time)";
$result1 = mysql_query($airtelQuery1, $dbConn);
$callPath5 = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/callogs/".$chour."/uninorCFashion_5464624_00_".$chour.".txt";
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
    $callhour = sprintf("%02s", trim($row1[9]));
	$hour = $callhour.':00:00';
    if ($status == 1)
        $actualStatus = "Active";
    else
        $actualStatus = "NotActive";
    $circleName = $circle_info[strtoupper($circleCode)];
    if (!$circleName)
        $circleName = 'Others';

    $logData = $hour."#".$msisdn . "#" . $startTime . "#" . $endTime . "#" . $totalSec . "#" . $pulse . "#" . $dnis . "#" . $circleName . "#" . $actualStatus . "#0#" . $mode . "#" . $serviceArray['1434'] . "\n";
    error_log($logData, 3, $callPath5);
}
 * 
 */

mysql_close($dbConn);
echo "Done";
?>
