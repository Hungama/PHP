<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = $_REQUEST['date'];
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
$view_date1='2014-08-01';
//echo $view_date1;
if ($view_date1) {
    $tempDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    if ($view_date1 < $tempDate) {
        $successTable = "master_db.tbl_billing_success_backup";
    } else {
        $successTable = "master_db.tbl_billing_success";
    }
}


$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');


//----- pause code array ----------

$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');

//---------------------------------

$deleteprevioousdata = "delete from mis_db.dailyReportReliance where date(report_date)='".$view_date1."' and (type like 'Renewal_%' or type like 'Activation_%' or type like 'Mode_Activation_%' or type like 'TOP-UP_%' or type like 'Event_%' or type like 'Mode_Activation_%')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic

$get_activation_query = "select count(msisdn) from master_db.tbl_billing_success where DATE(response_time)='$view_date1' 
                        and service_id in(1202,1203,1208,1201) and event_type in('SUB','RESUB','EVENT') and SC not like '%P%'";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $get_activation_query12 = "select count(msisdn),circle,chrg_amount,service_id,event_type,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1202,1203,1208,1201) and SC not like '%P%' and event_type in('SUB','RESUB','TOPUP','Event','EVENT') group by circle,service_id,chrg_amount,event_type";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type, $mode) = mysql_fetch_array($query12)) {
        //if ($mode == 'OBD' && $service_id == '1201' && ($event_type == 'TOPUP' || strtolower(trim($event_type)) == 'event')) {
		if ($mode == 'OBD' && $service_id == '1201' && ($event_type == 'TOPUP')) {
            $activation_str = "Activation_" . $charging_amt;
            if ($activation_str) {
                $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
            }
        } else {
            if ($event_type == 'SUB') {
                $activation_str = "Activation_" . $charging_amt;
                if ($activation_str) {
                    $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif ($event_type == 'RESUB') {
                $charging_str = "Renewal_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif ($event_type == 'TOPUP') {
                $charging_str = "TOP-UP_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif (strtolower(trim($event_type)) == 'event') {
                $charging_str = "Event_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            }
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Start the code to activation Record mode wise 

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' 
                           and service_id in(1203,1208,1201) and event_type in('SUB','Event','EVENT') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query1)) {
        if ($mode == 'netb')
            $mode = 'NET';
        if ($event_type == 'SUB')
            $activation_str1 = "Mode_Activation_" . $mode;
        if (strtolower(trim($event_type)) == 'event')
            $activation_str1 = "Mode_Event_" . strtoupper($mode);
        //if ($mode == 'OBD' && $service_id == '1201' && strtolower(trim($event_type)) == 'event')
          //  $activation_str1 = "Mode_Activation_" . $mode;

        $insert_data1 = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////

$get_activation_query = "select count(msisdn) from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1202) and event_type in('SUB','RESUB') and SC not like '%P%'";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $get_activation_query12 = "select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,SC from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1202) and SC like '%P%' and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,SC";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type, $sc) = mysql_fetch_array($query12)) {
        $pCircle = $pauseArray[$circle];
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1202P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1202P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1202P','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),substr(SC,9,3) as circle1,service_id,event_type,mode,SC,substr(SC,14,1) from " . $successTable . " nolock  where DATE(response_time)='$view_date1' 
        and service_id in(1202) and event_type in('SUB') and SC like '%P%' group by circle,service_id,event_type,mode,SC order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $event_type, $mode, $sc, $p) = mysql_fetch_array($db_query)) {
        $pCircle = $pauseArray[$circle];
        $newMode = $pauseCode[$p];
        $insert_data2 = "";
        if ($event_type == 'SUB') {
            $activation_str1 = "Mode_Activation_" . $newMode;
            $insert_data2 = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$pCircle','1202P','$count','NA','NA','NA')";
        }
        $queryIns2 = mysql_query($insert_data2, $dbConn);
    }
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////Start the code to activation Pause Code ////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' 
        and service_id in(1202) and event_type in('SUB','RESUB') and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        $insert_data2 = "";
        if ($event_type == 'SUB') {
            if ($mode == 'netb')
                $mode = 'NET';
            $activation_str1 = "Mode_Activation_" . $mode;
            if ($activation_str1) {
                $insert_data2 = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
            }
        }
        $queryIns2 = mysql_query($insert_data2, $dbConn);
    }
}


// ---------- Code end here -------------------
echo "done";
mysql_close($dbConn);
?>