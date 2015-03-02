<?php

/* @author: Jyoti Porwal
 * @File Purpose: insert Airtel Calling data into dailymis table
 */
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php"); // db connection @jyoti.porwal

$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = trim($_REQUEST['date']);
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

if ($flag) { //if flag=1 then no impact on repeat and new user @jyoti.porwal
    $condition = " AND type IN ('CALLS_TF','CALLS_T','CALLS_T_1','CALLS_T_3','CALLS_T_5','CALLS_T_6','CALLS_T_9','MOU_TF','MOU_T','MOU_T_1','MOU_T_3','MOU_T_5','MOU_T_6','MOU_T_9','PULSE_TF','PULSE_T','PULSE_T_1','PULSE_T_3','PULSE_T_5','PULSE_T_6','PULSE_T_9','UU_TF','UU_T','UU_T_1','UU_T_3','UU_T_5','UU_T_6','UU_T_9','SEC_TF','SEC_T','SEC_T_1','SEC_T_3','SEC_T_5','SEC_T_6','SEC_T_9') ";
} else {
    $condition = " AND type IN ('UU_Repeat','UU_New','CALLS_TF','CALLS_T','CALLS_T_1','CALLS_T_3','CALLS_T_5','CALLS_T_6','CALLS_T_9','MOU_TF','MOU_T','MOU_T_1','MOU_T_3','MOU_T_5','MOU_T_6','MOU_T_9','PULSE_TF','PULSE_T','PULSE_T_1','PULSE_T_3','PULSE_T_5','PULSE_T_6','PULSE_T_9','UU_TF','UU_T','UU_T_1','UU_T_3','UU_T_5','UU_T_6','UU_T_9','SEC_TF','SEC_T','SEC_T_1','SEC_T_3','SEC_T_5','SEC_T_6','SEC_T_9') ";
}

///////////////////////////////////////////////////////////// start code for delete the prevoius record @jyoti.porwal ////////////////////////////////////
$deleteprevioousdata = "delete from mis_db.daily_report where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
///////////////////////////////////////////////////////////// end code for delete the prevoius record @jyoti.porwal ////////////////////////////////////


if (!$flag) { // if flag=1 then no impact on repeat and new user @jyoti.porwal
    include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyUUser_repeat.php");
} // end of active-pending flag case @jyoti.porwal
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyCalls.php");
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyMous.php");
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyPulse.php");
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyUUser.php");
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailySec.php");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConn); // db connection close @jyoti.porwal
echo "done";
?>
