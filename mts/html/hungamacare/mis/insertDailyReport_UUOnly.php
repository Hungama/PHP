<?php
error_reporting(0);
include ("/var/www/html/hungamacare/config/dbConnect.php");
$flag = 0;
$Repeat_flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = trim($_REQUEST['date']);
    $flag = 1;
    $Repeat_flag = 1;
	$activepending_flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1="2014-11-09";
//$flag=1;
//$Repeat_flag=1;
echo $view_date1;
$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

$condition = " AND type IN ('UU_Repeat','UU_New') ";
$deleteprevioousdata = "delete from mis_db.mtsDailyReport where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
include_once("/var/www/html/hungamacare/mis/insertDailyUUser_repeat.php");
mysql_close($dbConn);
echo "done";
?>
