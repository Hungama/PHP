<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $flag = 1;
} else {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//$date="2014-11-25";
echo $date;
//$flag=1;
if ($flag) {
	    $isflag = "AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New')";
	//	$isflag = "AND type NOT IN ('Active_Base','Pending_Base')";
}

$isflag = " AND (type like 'Activation_%' or type like 'Renewal_%' or type like 'TOP-UP_%' or type like 'Event_%'
or type like 'EVENT_%' or type like 'Event_FS_%' or type like 'Total_Success_Download%' or type like 'Mode_Event_%'
or type like 'Mode_FS_%' or type like 'Mode_Activation_%') ";


$serviceArray = array('1403' => 'MTVUninor', '1402' => 'Uninor54646', '1410' => 'RedFMUninor', '1413' => 'RIAUninor', '1412' => 'UninorRT', '1416' => 'UninorAstro',
    '14021' => 'AAUninor', '1408' => 'UninorSU', '1418' => 'UninorComedy', '14101' => 'WAPREDFMUninor', '1423' => 'UninorContest'
    , '1430' => 'UninorVABollyAlerts', '1431' => 'UninorVAFilmy', '1432' => 'UninorVABollyMasala', '1433' => 'UninorVAHealth', '1434' => 'UninorVAFashion','1439'=>'SMSUninorGujarati','1440'=>'SMSUninorAlert','1438'=>'SMSUninorFashion');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

/*
  $airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.dailyReportUninor
  where report_date = '".$date."' $isflag  and service_id like '14%' group by service_id,circle,type"; */
$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),sum(Revenue) as 'Rev' from mis_db.dailyReportUninor 
where report_date = '" . $date . "' $isflag  and service_id like '14%' group by service_id,circle,type";

$result = mysql_query($airtelQuery, $dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='" . $date . "' $isflag  and service IN ('MTVUninor','Uninor54646','RedFMUninor','RIAUninor','UninorRT','UninorAstro', 'UninorArtistAloud', 'UninorSU','UninorComedy','WAPREDFMUninor','UninorContest','AAUninor','UninorVABollyAlerts','UninorVABollyMasala','UninorVAFashion','UninorVAFilmy','UninorVAHealth','SMSUninorGujarati','SMSUninorAlert','SMSUninorFashion')";

$delResult = mysql_query($delQuery, $LivdbConn);

while ($row = mysql_fetch_array($result)) {
    $serviceId = trim($row[1]);
    $circleId = trim($row[2]);
    $circleName = $circle_info[strtoupper($circleId)];
    if (!$circleName)
        $circleName = 'Others';
    $serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
    if ($row[5] == "")
        $row[5] = 0;
    if ($serviceName && $row[3]) {
        $insertQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $row[3] . "', '" . $row[4] . "','" . $row[5] . "')";
        $result1 = mysql_query($insertQuery, $LivdbConn);
    }
}
echo "Done";
?>
