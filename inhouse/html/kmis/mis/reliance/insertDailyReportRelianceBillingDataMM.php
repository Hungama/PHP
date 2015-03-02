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
$view_date1='2014-08-14';
echo $view_date1;
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

$deleteprevioousdata = "delete from Inhouse_tmp.dailyReportReliance where date(report_date)='".$view_date1."' and (type like 'Renewal_%' or type like 'Activation_%' or type like 'Mode_Activation_%' or type like 'TOP-UP_%' or type like 'Event_%' or type like 'Mode_Activation_%')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic

   $get_activation_query12 = "select count(msisdn),circle,chrg_amount,service_id,event_type,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1201) and event_type in('TOPUP') group by circle,service_id,chrg_amount,event_type";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type, $mode) = mysql_fetch_array($query12)) {
        if ($mode == 'OBD' && $service_id == '1201' && ($event_type == 'TOPUP')) {
            $activation_str = "Activation_" . $charging_amt;
            if ($activation_str) {
                $insert_data = "insert into Inhouse_tmp.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
            }
        } else {
            if ($event_type == 'SUB') {
                $activation_str = "Activation_" . $charging_amt;
                if ($activation_str) {
                    $insert_data = "insert into Inhouse_tmp.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif ($event_type == 'RESUB') {
                $charging_str = "Renewal_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into Inhouse_tmp.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif ($event_type == 'TOPUP') {
                $charging_str = "TOP-UP_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into Inhouse_tmp.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            } elseif (strtolower(trim($event_type)) == 'event') {
                $charging_str = "Event_" . $charging_amt;
                if ($charging_str) {
                    $insert_data = "insert into Inhouse_tmp.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
            }
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }

// ---------- Code end here -------------------
echo "done";
mysql_close($dbConn);
?>
