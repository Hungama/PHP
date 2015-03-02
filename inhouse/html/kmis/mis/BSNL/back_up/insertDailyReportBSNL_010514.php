<?php
error_reporting(1);
include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNL.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");
//$LivdbConn;
$flag=0;
if (isset($_REQUEST['date'])) {
    $view_date1 = $_REQUEST['date'];
	$flag=1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
$last_7day_start = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
$last_7day_end = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 8, date("Y")));
//echo $view_date1='2014-04-11';
//$flag=1;

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
 $successTable = "master_db.tbl_billing_success";
//end here
//echo $successTable;
//exit;

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

//----- pause code array ----------

$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');

//---------------------------------
if($flag) {
	$condition = " AND type NOT IN ('Active_Base','Pending_Base') ";
} else {
	$condition = " AND 1";
}

//$deleteprevioousdata = "delete from mis_db.dailyReportUninor where date(report_date)='$view_date1'";
$deleteprevioousdata="delete from mis_db.dailyReportBsnl where date(report_date)='$view_date1' ".$condition;
//$delete_result = mysql_query($deleteprevioousdata, $dbConn);
 if(mysql_query($deleteprevioousdata, $dbConn))
	{
	echo "Data Deleted";
	}
	else
	{
	echo "Error in data";
	echo $error= mysql_error();
	}
// end the deletion logic
//AND SC not like '%P%' 
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in (2202) 
        and event_type in('SUB','RESUB') group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn_BSNL);
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    //$query = mysql_query($get_activation_query, $dbConn_BSNL);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $sum_revenue) = mysql_fetch_array($query)) {
          if ($circle == "")
            $circle = "UND";
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
                        values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
                        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        }
		//echo $insert_data."<br>";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_activation_query = "select count(msisdn),circle,floor(chrg_amount),service_id,event_type,plan_id,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in (2202) 
        and event_type IN ('TOPUP','EVENT')
		group by circle,service_id,floor(chrg_amount),event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn_BSNL);
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
 //   $query = mysql_query($get_activation_query, $dbConn_BSNL);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $sum_revenue) = mysql_fetch_array($query)) {
        if ($circle == "")
            $circle = "UND";

		$amt = floor($charging_amt);

        if ($event_type == 'EVENT')
            $event_type = ucfirst(strtolower($event_type));
        if ($amt < 2)
            $charging_str = $event_type . "_1";
        else
            $charging_str = $event_type . "_" . $amt;
                
        $insert_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Start the code to activation Record mode wise for Uninor54646
$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in(2202)
        and event_type in('SUB')
		group by circle,service_id,event_type,mode order by event_type,plan_id";
		
$db_query = mysql_query($get_mode_activation_query, $dbConn_BSNL);
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn_BSNL);
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
//        elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
//            $mode = "OBD";
        elseif ($mode == "OBD_HUNG")
            $mode = "OBD-HUNG";
        elseif ($mode == "wap")
            $mode = "WAP";
        elseif ($mode == "pan")
            $mode = "Others";
        elseif ($mode == "OBD-9xm")
            $mode = "9XMOBD";
        elseif ($mode == "OBD-Jokes")
            $mode = "OBD-JOKES";

        $activation_str1 = "Mode_Activation_" . $mode;
        $insert_data1 = "insert into mis_db.dailyReportBsnl(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA','')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}


if(!$flag) { // if flag=1 then no impact on active and pending base
include("/var/www/html/kmis/mis/BSNL/insertDailyReportBSNLPendingBase.php");
include("/var/www/html/kmis/mis/BSNL/insertDailyReportBSNLActiveBase.php");
} // end of active-pending flag case
include("/var/www/html/kmis/mis/BSNL/insertDailyCalls.php");

include("/var/www/html/kmis/mis/BSNL/insertDailyMous.php");

include("/var/www/html/kmis/mis/BSNL/insertDailyUUser.php");

include("/var/www/html/kmis/mis/BSNL/insertDailyPulse.php");

include("/var/www/html/kmis/mis/BSNL/insertDailySec.php");

include("/var/www/html/kmis/mis/BSNL/insertDailyDeactprice.php");

// start code to insert the Charging Failure into the MIS database for Uninor54646

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' 
and service_id=2002 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn_BSNL);
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportBsnl(report_date,type,circle,total_count,service_id) 
    values('$view_date1', '$faileStr','$circle','$count','2202')";
    $queryIns = mysql_query($insertData, $dbConn);
}

echo "done";
mysql_close($dbConn);
mysql_close($dbConn_BSNL);
mysql_close($LivdbConn);
?>
