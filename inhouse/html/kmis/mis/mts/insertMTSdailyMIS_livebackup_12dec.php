<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
	$flag = 1;
} else {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//Added for mode wise revenue insertion
//$flag = 1;
//echo $date = "2014-12-08";
if ($flag) {
	    $isflag = "AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New')";
			}
$serviceArray = array('1102' => 'MTS54646', '1103' => 'MTVMTS', '11012' => 'MTSComedy', '1111' => 'MTSDevo', '1101' => 'MTSMU',
    '1116' => 'MTSVA', '1113' => 'MTSMND', '1110' => 'RedFMMTS', '1106' => 'MTSFMJ', '1123' => 'MTSContest', '1125' => 'MTSJokes', '1126' => 'MTSReg');
$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');
$delQuery = "DELETE FROM misdata.dailymis WHERE Date='" . $date . "' $isflag and service IN ('MTS54646','MTVMTS','MTSComedy','MTSDevo','MTSMU','MTSVA','MTSMND', 'RedFMMTS','MTSFMJ','MTSContest','MTSVA','MTSJokes','MTSReg')";
$delResult = mysql_query($delQuery, $LivdbConn);
$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count))*(charging_rate) as 'Rev' from mis_db.mtsDailyReport where report_date = '" . $date . "' and service_id like '11%' $isflag and type not like 'mode_%' group by type,circle,service_id,charging_rate";
$result = mysql_query($airtelQuery, $dbConn);

while ($row = mysql_fetch_array($result)) {
    $serviceId = trim($row[1]);
    $circleId = trim($row[2]);
    $circleName = $circle_info[strtoupper($circleId)];
    if (!$circleName)
        $circleName = 'Others';
    if ($row[5] == "")
        $row[5] = 0;
    $serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
    if ($row[5] == "")
        $row[5] = 0;
		
		$type = $row[3];
	
        $insertQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $type . "', '" . $row[4] . "','" . $row[5] . "')";
		 $result1 = mysql_query($insertQuery, $LivdbConn);
    }

//mode wise data insertion
$modewiseQuery = "select report_date,service_id,circle,type,sum(total_count),(sum(total_count * charging_rate)) AS 'Rev' FROM mis_db.mtsDailyReport where report_date = '" . $date . "' and service_id like '11%' and type like 'Mode_%' group by type,circle,service_id";
$mod_result = mysql_query($modewiseQuery, $dbConn);

while ($rows = mysql_fetch_array($mod_result)) 
{
    $serviceId = trim($rows[1]);
    $circleId = trim($rows[2]);
    $circleName = $circle_info[strtoupper($circleId)];
    if (!$circleName)
        $circleName = 'Others';
    if ($rows[5] == "")
        $rows[5] = 0;
    $serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
    if ($rows[5] == "")
        $rows[5] = 0;
    if ($serviceName) {
        $type = $rows[3];
        if ($type == "Mode_Activation_OBD-Artist" || $type == "Mode_Activation_push")
            $type = "Mode_Activation_OBD";
        elseif ($type == "Mode_Activation_TIVR")
            $type = "Mode_Activation_IVR";
        elseif ($type == "Mode_Deactivation_Insufficient Balance" || $type == "Mode_Deactivation_TNB_CHURN")
            $type = "Mode_Deactivation_in";
        elseif (($serviceId != '1101' && $type == "Mode_Deactivation_push") || $type == "Mode_Deactivation_BACKEND" || $type == "Mode_Deactivation_COMEDY_REQ")
            $type = "Mode_Deactivation_CC";
        elseif ($type == "Mode_Deactivation_SELF_REQ" || $type == "Mode_Deactivation_SELF_REQS")
            $type = "Mode_Deactivation_IVR";
        elseif ($type == "Mode_Renewal_OBD-Artist" || $type == "Mode_Renewal_OBD-MS" || $type == "Mode_Renewal_push" || $type == "Mode_Renewal_push2" || $type == "Mode_Renewal_OBD-LBR" || $type == "Mode_Renewal_OBD_LBR" || $type == "Mode_Renewal_OBD_One97" || $type == "Mode_Renewal_OBD_VG")
            $type = "Mode_Renewal_OBD";
        elseif ($type == "Mode_Renewal_TIVR")
            $type = "Mode_Renewal_IVR";

        $insertmodeQuery = "INSERT INTO misdata.dailymis VALUES ('" . $date . "','" . $serviceName . "','" . $circleName . "', '" . $type . "', '" . $rows[4] . "','" . $rows[5] . "')";
        $result = mysql_query($insertmodeQuery, $LivdbConn);
    }
}
echo "Done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
