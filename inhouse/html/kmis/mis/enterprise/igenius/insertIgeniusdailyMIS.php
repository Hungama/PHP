<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $flag = 1;
} else {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//$date="2014-09-13";
echo $date;
$serviceArray = array('EnterpriseMaxLifeIVR' => 'EnterpriseMaxLifeIVR');

$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

$airtelQuery = "select Date,Service,Circle,Type,Value,Revenue from mis_db.tbl_dailymisEnterprise 
where Date = '" . $date . "'  and Service='EnterpriseMaxLifeIVR'";

$result = mysql_query($airtelQuery, $dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='" . $date . "' and service IN ('EnterpriseMaxLifeIVR')";

$delResult = mysql_query($delQuery, $LivdbConn);

while ($row = mysql_fetch_array($result)) {
    $serviceId = trim($row['Service']);
    $circleName = trim($row['Circle']);
     $serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
    if ($row[5] == "")
        $row[5] = 0;
    if ($serviceName && $row[3]) {
        $insertQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $row[3] . "', '" . $row[4] . "','" . $row[5] . "')";
        $result1 = mysql_query($insertQuery, $LivdbConn);
    }
}
echo "Done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>