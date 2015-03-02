<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $flag = 1;
} else {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}

echo $date = "2014-06-20";
//$flag=1;
if ($flag) {
    $isflag = "AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New')";
}

$serviceArray = array('1001' => 'TataDoCoMoMX', '1002' => 'TataDoCoMo54646', '1002P' => 'TataDoCoMo54646Pause', '1003' => 'MTVTataDoCoMo', '1005' => 'TataDoCoMoFMJ', '1009' => 'RIATataDoCoMo', '1010' => 'RedFMTataDoCoMo', '1011' => 'TataDoCoMoGL', '1013' => 'TataDoCoMoMND');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.daily_report where report_date = '" . $date . "' $isflag and service_id like '10%' and service_id NOT IN ('1002P','1011') group by service_id,circle,type,charging_rate";
$result = mysql_query($airtelQuery, $dbConn);
//echo mysql_num_rows($result);
$delQuery = "DELETE FROM misdata.dailymis WHERE Date='" . $date . "' $isflag and service IN ('TataDoCoMoMX','TataDoCoMo54646','TataDoCoMo54646Pause','MTVTataDoCoMo', 'TataDoCoMoFMJ','RIATataDoCoMo','RedFMTataDoCoMo','TataDoCoMoGL','TataDoCoMoMND')";
$delResult = mysql_query($delQuery, $LivdbConn);
if ($delResult)
    echo "Daily mis data deleted";

while ($row = mysql_fetch_array($result)) {
    $serviceId = trim($row[1]);
    $circleId = trim($row[2]);
    $circleName = $circle_info[strtoupper($circleId)];
    if (!$circleName)
        $circleName = 'Others';
    $serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
    if ($row[5] == "")
        $row[5] = 0;
    if ($serviceName && ($serviceId != "1002P" || $serviceId != "1011" )) {
        $insertQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $row[3] . "', '" . $row[4] . "','" . $row[5] . "')";
        $result1 = mysql_query($insertQuery, $LivdbConn);
    }
}
echo "Done";
?>
