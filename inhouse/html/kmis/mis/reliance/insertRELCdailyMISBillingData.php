<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $flag = 1;
} else {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
$date='2014-08-14';
$isflag = "AND type like 'TOP-UP_%'";


$serviceArray = array('1202' => 'Reliance54646', '1203' => 'MTVReliance', '1202P' => 'ReliancePauseCode', '1208' => 'RelianceCM', '1201' => 'RelianceMM', '2121' => 'SMSEtisalatNigeria', '1701' => 'DIGIMA');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from 		Inhouse_tmp.dailyReportReliance nolock 
                where report_date = '" . $date . "' $isflag and service_id IN ('1201') group by service_id,circle,type";
$result = mysql_query($airtelQuery, $dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='" . $date . "' $isflag and service IN ('RelianceMM')";
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
    if ($serviceName) {
        $insertQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $row[3] . "', '" . $row[4] . "','" . $row[5] . "')";
        $result1 = mysql_query($insertQuery, $LivdbConn);
    }
}
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "Done";
?>
