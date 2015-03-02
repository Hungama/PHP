<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");
error_reporting(0);
//$LivdbConn;
$processlog = "/var/www/html/kmis/mis/uninor/processlog_uninor_" . date(Ymd) . ".txt";
$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = $_REQUEST['date'];
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1='2015-02-23';
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
//end here
//echo $successTable;
//exit;

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

//----- pause code array ----------

$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');

//---------------------------------
if ($flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}

//$deleteprevioousdata = "delete from mis_db.dailyReportUninor where date(report_date)='$view_date1'";
$deleteprevioousdata = "delete from mis_db.dailyReportUninor where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic
//AND SC not like '%P%' //1409 // add 1441 for uninor desi beats on 16 jan
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in (1402,1403,1410,1413,1416,1408,1418,1423,1430,1431,1432,1433,1434,1438,1439,1440,1441) 
        and event_type in('SUB','RESUB') and plan_id NOT IN (86,87,93,94,270) AND SC not like '%P%' 
	group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $sum_revenue) = mysql_fetch_array($query)) {
        if ($plan_id == 95 && $service_id == '1402')
            $service_id = '14021';
        if ($circle == "")
            $circle = "UND";
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
                        values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
                        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        }
        //echo $insert_data."<br>";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// 
$get_activation_query = "select count(msisdn),circle,floor(chrg_amount),service_id,event_type,plan_id,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in (1402,1403,1413,1416,1418,1423,1430,1431,1432,1433,1434) 
        and event_type IN ('TOPUP','EVENT') and SC not like '%P%'
        group by circle,service_id,floor(chrg_amount),event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $sum_revenue) = mysql_fetch_array($query)) {
        if ($circle == "")
            $circle = "UND";

        if ($plan_id == 95 && $service_id == '1402')
            $service_id = '14021';
        if ($event_type == 'TOPUP' && $service_id == '1423') {
            $event_type = 'TOP-UP';
        }
        $amt = floor($charging_amt);

        if ($event_type == 'EVENT')
            $event_type = ucfirst(strtolower($event_type));
        if ($amt < 2)
            $charging_str = $event_type . "_1";
        else
            $charging_str = $event_type . "_" . $amt;

        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA',$sum_revenue)";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Start the code to activation Record mode wise for Uninor54646
$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id,sum(chrg_amount) as rev  from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in(1402,1410,1416,1408,1418,1423,1430,1431,1432,1433,1434,1438,1439,1440,1441)
        and event_type in('SUB') and plan_id NOT IN (86,87,93,94,95,270)
        and SC not like '%P%' group by circle,service_id,chrg_amount,event_type,mode order by mode,event_type,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $plan_id, $rev) = mysql_fetch_array($db_query)) {
        if ($plan_id == 95 && $service_id == '1402')
            $service_id = '14021';
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "CROSSENT" && $service_id != '1413')
            $mode = "IVR";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
      //  elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
       //     $mode = "OBD";
	    elseif ($mode == "OBD_HUNG" && $service_id != '1402')
            $mode = "OBD";
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
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id,sum(chrg_amount) as rev from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in(1402) and event_type in('SUB') 
        and plan_id IN (95) and SC not like '%P%' group by circle,service_id,chrg_amount,event_type,mode order by event_type,plan_id";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $plan_id, $rev) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "CROSSENT" && $service_id != '1413')
            $mode = "IVR";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
        //elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
          //  $mode = "OBD";
		 elseif ($mode == "OBD_HUNG" && $service_id != '1402')
            $mode = "OBD";	
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
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str1','$circle','14021','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

// end the code for Uninor54646
// uninor Pause code 

$get_activation_query = "select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,plan_id,SC,sum(chrg_amount)
    from " . $successTable . "  nolock where DATE(response_time)='$view_date1' and service_id in (1402)
        and event_type in('SUB','RESUB') and plan_id NOT IN (86,87,93,94) AND SC like '%P%' 
        group by circle,service_id,chrg_amount,event_type,plan_id,SC";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $sc, $sum_revenue) = mysql_fetch_array($query)) {
        $pCircle = $pauseArray[$circle];
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
            values('$view_date1', '$activation_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
            values('$view_date1', '$charging_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec,Revenue) 
            values('$view_date1', '$charging_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA',$sum_revenue)";
        }
        $queryIns = mysql_query($insert_data, $dbConn);

        //echo $insert_data."<br>";
    }
}


$get_mode_activation_query = "select count(msisdn),substr(SC,9,3) as circle1,service_id,mode,plan_id,SC,substr(SC,14,1) 
    as p, sum(chrg_amount) as rev from " . $successTable . "  nolock where DATE(response_time)='$view_date1' and service_id in(1402) and event_type in('SUB') 
        and plan_id NOT IN (86,87,93,94) and SC like '%P%' group by circle,service_id,chrg_amount,event_type,mode order by event_type,plan_id,SC";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $plan_id, $sc, $p, $rev) = mysql_fetch_array($db_query)) {
        $pMode = $pauseCode[$p];
        $pCircle = $pauseArray[$circle];
        if ($mode == "")
            $mode = "IVR";
        $activation_str1 = "Mode_Activation_" . $pMode;
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str1','$pCircle','1402P','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}
// end
//Start the code to activation Record mode wise for Uninor54646

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,floor(chrg_amount) from " . $successTable . "  
        nolock 
        where DATE(response_time)='$view_date1' and service_id in(1409) and event_type in('EVENT') and plan_id IN (87) 
        group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $chrg_amount) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $activation_str1 = "Total_Success_Download";
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA','')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}


$get_mode_activation_query = "select count(msisdn),circle from mis_db.tbl_wapRequest_data 
    where date(datetime)='" . $view_date1 . "' and operator='UNIM' and service='1409' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $str1 = "Total_Number_Of_Clicks";
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$str1','$circle','1409','$count','NA','NA','NA','')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

// end the code for Uninor54646
// Event charging Uninor RedFM

$get_mode_activation_query = "select count(msisdn),circle,service_id,floor(chrg_amount),sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in(1410) and event_type in('EVENT') and plan_id IN (93,34,133) 
        group by circle,service_id,event_type,floor(chrg_amount) order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $chrg_amount, $sum_revenue) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $str = "Event_FS_" . $chrg_amount;
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,charging_rate,Revenue) 
        values('$view_date1', '$str','$circle','14101','$count','NA','NA','NA','$chrg_amount',$sum_revenue)";
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,floor(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id in(1410) and event_type in('EVENT') and plan_id IN (93,34,133) 
        group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $chrg_amount) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $str = "Mode_FS_" . $mode;
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) 
        values('$view_date1', '$str','$circle','14101','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='" . $view_date1 . "' 
    and operator='UNIM' and service='1410' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $str1 = "FS_REQ";
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec)
        values('$view_date1', '$str1','$circle','1410','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='" . $view_date1 . "' 
    and operator='UNIM' and service='1410' and status='Success' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        $str1 = "FS_SUC";
        $insert_data1 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1410','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

// End of Event charging Uninor RedFM
//Start the code to activation Record mode wise for UninorMTV

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,sum(chrg_amount) as rev from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1403 and event_type in('SUB') and plan_id NOT IN (86,87,93,94) 
        group by circle,service_id,chrg_amount,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $rev) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "CROSSENT" && $service_id != '1409')
            $mode = "IVR";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
        //elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
        //    $mode = "OBD";
        elseif ($mode == "OBD_HUNG" && $service_id != '1402')
            $mode = "OBD";
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
        $insert_data2 = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}

// end the code for UninorMTV
//Start the code to activation Record mode wise for UninorManchala

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,mode, sum(chrg_amount) as rev from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1413 and event_type in('SUB') and plan_id NOT IN (86,87,93,94) 
        group by circle,service_id,chrg_amount,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $rev) = mysql_fetch_array($db_query1)) {
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "CROSSENT" && $service_id != '1413')
            $mode = "IVR";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
        //elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
         //   $mode = "OBD";
         elseif ($mode == "OBD_HUNG" && $service_id != '1402')
            $mode = "OBD";
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

        $activation_str_m = "Mode_Activation_" . $mode;
        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) 
        values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}

// end the code for UninorManchala
//Start the code to activation Record mode wise for Uninor MyRingTone

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,chrg_amount,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') 
        group by circle,service_id,event_type,chrg_amount order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $chrg_amount, $sum_revenue) = mysql_fetch_array($db_query1)) {
        $amt = floor($chrg_amount);
        if ($amt < 2)
            $amt1 = 1;
        elseif ($amt <= 9 && $amt >= 2)
            $amt1 = $amt;
        else
            $amt1 = 10;

        if ($circle == "")
            $circle = "UND";
        //$activation_str_m = "Activation_" . $amt;
        $activation_str_m = "Event_" . $amt;
        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,charging_rate,Revenue) 
        values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA','$amt1',$sum_revenue)";

        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,mode,floor(chrg_amount),sum(chrg_amount) as rev from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') 
        group by circle,service_id,chrg_amount,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $chrg_amount, $rev) = mysql_fetch_array($db_query1)) {
        if ($circle == "")
            $circle = "UND";
        if ($mode == "")
            $mode = "IVR";

        if (($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode == "CROSSRR") && $service_id == '1409')
            $mode = "REDFMRIYA";
        elseif ($mode == "CROSSENT" && $service_id != '1409')
            $mode = "IVR";
        elseif ($mode == "IVR-MPMC" || $mode == "TIVR")
            $mode = "IVR";
        elseif (($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id != '1402')
            $mode = "OBD";
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

        //$activation_str_m = "Mode_Activation_" . $mode;
        $activation_str_m = "Mode_Event_" . $mode;
        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,Revenue) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA','$rev')";

        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}



// start code to insert the Charging Failure into the MIS database for Uninor54646

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' 
and service_id=1402 and SC not like '%P%' group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1402')";
    $queryIns = mysql_query($insertData, $dbConn);
}

// end code to insert the Charging Failure into the MIS database for Uninor54646
// start code to insert the Charging Failure into the MIS database for UninorMTV
$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' 
and service_id=1403 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1403')";
    $queryIns = mysql_query($insertData, $dbConn);
}
// end code to insert the Charging Failure into the MIS database for UninorMTV
// start code to insert the Charging Failure into the MIS database for UninorMTV
$charging_fail = "select count(*),circle,event_type,plan_id from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1'
and service_id=1412 group by circle,event_type,plan_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type, $plan_id) = mysql_fetch_array($deactivation_base_query)) {
    if ($plan_id == 69)
        $type = 'PT_REQ';
    elseif ($plan_id == 70)
        $type = 'MT_REQ';
    elseif ($plan_id == 71)
        $type = 'TT_REQ';

    $faileStr = "RT_" . $type;

    $insertData = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1412')";
    $queryIns = mysql_query($insertData, $dbConn);
}

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,mode,plan_id,floor(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') 
        group by circle,service_id,event_type,mode,plan_id order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $plan_id, $chrg_amount) = mysql_fetch_array($db_query1)) {
        if ($circle == "")
            $circle = "UND";

        if ($plan_id == 69) {
            $rtype = 'PT_REQ';
            $stype = 'PT_SUC';
        } elseif ($plan_id == 70) {
            $rtype = 'MT_REQ';
            $stype = 'MT_SUC';
        } elseif ($plan_id == 71) {
            $rtype = 'TT_REQ';
            $stype = 'TT_SUC';
        }

        $rt_req_str = "RT_" . $rtype;
        $insertReqData = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$rt_req_str','$circle','$service_id','$count','NA','NA','NA')";
        $queryIns = mysql_query($insertReqData, $dbConn);

        $rtSucStr = "RT_" . $stype;
        $insertSucData = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$rtSucStr','$circle','$service_id','$count','NA','NA','NA')";
        $queryIns = mysql_query($insertSucData, $dbConn);
    }
}
// end code to insert the Charging Failure into the MIS database for UninorMTV
// --------------- insert the Event Charging ------------------
$get_mode_activation_query1 = "select count(msisdn),circle,service_id,mode,plan_id,chrg_amount,sum(chrg_amount) from " . $successTable . "  nolock 
        where DATE(response_time)='$view_date1' and service_id=1408 and event_type in('EVENT')
        group by circle,service_id,event_type,mode,plan_id,chrg_amount order by event_type";

$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $mode, $plan_id, $chrg_amount, $sum_revenue) = mysql_fetch_array($db_query1)) {
        if ($circle == "")
            $circle = "UND";

        $amt = floor($chrg_amount);
        if ($amt < 2)
            $amt1 = 1;
        else
            $amt1 = $amt;

        $event_type = 'Event';
        $eventStr = $event_type . "_" . $amt1;

        $insertReqData = "insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,charging_rate,Revenue) 
        values('$view_date1', '$eventStr','$circle','$service_id','$count','NA','NA','NA','$amt1',$sum_revenue)";
        $queryIns = mysql_query($insertReqData, $dbConn);
    }
}
// end code to insert the Event Charging ------------------

include("/var/www/html/kmis/mis/uninor/insertDailyCalls.php");
include("/var/www/html/kmis/mis/uninor/insertDailyMous.php");
include("/var/www/html/kmis/mis/uninor/insertDailyUUser.php");
include("/var/www/html/kmis/mis/uninor/insertDailyPulse.php");
include("/var/www/html/kmis/mis/uninor/insertDailySec.php");
include("/var/www/html/kmis/mis/uninor/insertDailyDeactprice.php");

// end the code for Uninor MyRingTone
if (!$flag) { // if flag=1 then no impact on active and pending base
    include("/var/www/html/kmis/mis/uninor/insertDailyReportUninorPendingBase.php");
    include("/var/www/html/kmis/mis/uninor/insertDailyReportUninorActiveBase.php");
    include("/var/www/html/kmis/mis/uninor/insertDailyUUser_repeat.php");
} // end of active-pending flag case




echo "done";
mysql_close($dbConn);
?>
