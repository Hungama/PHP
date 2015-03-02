<?php
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
//echo $view_date1="2014-12-08";
//$flag=1;
//$Repeat_flag=1;
if ($view_date1) {
    $tempDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    if ($view_date1 < $tempDate) {
        $successTable = "master_db.tbl_billing_success_backup";
    } else {
        $successTable = "master_db.tbl_billing_success";
    }
}
echo $view_date1;

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');


    $condition = " AND type IN ('RBT_*','RBT_ACTIVATED_1','RBT_MIGRATED_1','RBT_SELECTION_15','RBT_EAUC') ";

$deleteprevioousdata = "delete from mis_db.mtsDailyReport where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());


///////////////////////////// VoiceAlert Special Type Code End here  /////////////////////////////////////////////////////
//////////////////////////////////////////////////////start code to insert the data for RBT_*  //////////////////////////////////////////////////////
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt') and crbt_mode='DOWNLOAD' group by circle,req_type";
//$rbt_query="select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'crbt') {
            $circle = $rbt_tf[1];
            if ($circle == "")
                $circle = "UND";
            elseif ($circle == "HAR")
                $circle = "HAY";
            elseif ($circle == "PUN")
                $circle = "PUB";

            $insert_rbt_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$circle','$rbt_tf[0]','0','1101','NA','NA','NA')";
        }
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}


// end
//////////////////////////////////////////////// to insert the Migration data///////////////////////////////////////////////////////////////////

$get_migrate_date = "select crbt_mode,count(1),circle from mts_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by crbt_mode,circle";
$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($crbt_mode, $count, $circle) = mysql_fetch_array($get_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($crbt_mode == 'ACTIVATE') {
            $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1101','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'MIGRATE') {
            $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1101','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD') {
            $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1101','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD15') {
            $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1101','NA','$count','NA','NA','NA')";
        }

        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

mysql_close($dbConn);
echo "done";
?>
