<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
#include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");
error_reporting(0);
//$LivdbConn;
$processlog = "/var/www/html/kmis/mis/enterprise/igenius/processlog_" . date(Ymd) . ".txt";
$fileDumpPath = '/var/www/html/kmis/mis/enterprise/igenius/livedump/';
$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = $_REQUEST['date'];
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1='2014-09-13';
//$flag=1;
//added by satay
if ($view_date1) {
    $tempDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));

    if ($view_date1 < $tempDate) {
        if ($view_date1 < '2013-06-02') {
            $successTable = "master_db.tbl_billing_success_04_06_2013";
        } else {
            $successTable = "master_db.tbl_billing_success_backup";
        }
    } else {
        $successTable = "master_db.tbl_billing_success";
    }
}

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');
	
$circle_info = array('UND' => 'Others', 'DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'JNK' => 'Jammu-Kashmir', 'HAR' => 'Haryana', ' ' => 'Others');

//---------------------------------
if ($flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}

//$deleteprevioousdata = "delete from mis_db.tbl_dailymisEnterprise where date(report_date)='$view_date1' " . $condition;
$deleteprevioousdata = "delete from mis_db.tbl_dailymisEnterprise where Date='$view_date1' and service='EnterpriseMaxLifeIVR' ";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//Recordings Submitted - First time- REC1
$get_activation_query = "select 'REC1',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=1 and rec_type='Fresh' and issubmitted=1 and isrecorded=1 group by circle";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($calltype, $circle, $totalCount, $service_name) = mysql_fetch_array($query)) {
              
			  if ($circle_info[strtoupper($circle)] == '')
			$circle= 'Other';
				else
			$circle= $circle_info[strtoupper($circle)];
		
            $insert_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) values('$view_date1', '$service_name','$circle','$calltype','$totalCount','0')";
               $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Re- recording Submitted- second time -REC1_RE

$get_activation_query = "select 'REC1_RE',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=1 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1 group by circle";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($calltype, $circle, $totalCount, $service_name) = mysql_fetch_array($query)) {

			if ($circle_info[strtoupper($circle)] == '')
			$circle= 'Other';
				else
			$circle= $circle_info[strtoupper($circle)];
				$insert_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) values('$view_date1', '$service_name','$circle','$calltype','$totalCount','0')";
				$queryIns = mysql_query($insert_data, $dbConn);
    }
}

/***************************************/
//Recordings Submitted - First time- REC2

$get_activation_query = "select 'REC2',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=2 and rec_type='Fresh' and issubmitted=1 and isrecorded=1 group by circle";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($calltype, $circle, $totalCount, $service_name) = mysql_fetch_array($query)) {
                if ($circle_info[strtoupper($circle)] == '')
			$circle= 'Other';
				else
			$circle= $circle_info[strtoupper($circle)];
		$insert_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) values('$view_date1', '$service_name','$circle','$calltype','$totalCount','0')";
               $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Re- recording Submitted- second time -REC2_RE

$get_activation_query = "select 'REC2_RE',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=2 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1 group by circle";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($calltype, $circle, $totalCount, $service_name) = mysql_fetch_array($query)) {
                if ($circle_info[strtoupper($circle)] == '')
			$circle= 'Other';
				else
			$circle= $circle_info[strtoupper($circle)];
            $insert_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) values('$view_date1', '$service_name','$circle','$calltype','$totalCount','0')";
               $queryIns = mysql_query($insert_data, $dbConn);
    }
}

if (!$flag) { // if flag=1 then no impact on active and pending base
    #include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyReportIgeniusPendingBase.php");
    #include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyReportIgeniusActiveBase.php");
    #include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyUUser_repeat.php");
} // end of active-pending flag case
include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyCalls.php");
include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyMous.php");
include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyUUser.php");
include("/var/www/html/kmis/mis/enterprise/igenius/insertDailyPulse.php");
include("/var/www/html/kmis/mis/enterprise/igenius/insertDailySec.php");

echo "done";
mysql_close($dbConn);
?>