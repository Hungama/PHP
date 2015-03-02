<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = trim($_REQUEST['date']);
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//start code to 'no active pending will effected'
//$flag=1;
//echo $view_date1='2015-02-09';
$chrg_amount = "0";

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

//$pauseCode = array('1'=>'Love Guru','2'=>'Music World','3'=>'Movie Junction','4'=>'Celebrity World','5'=>'Astro (JAD)');
$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');

//---------------------------------

if ($flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New','CALLS_TF','CALLS_T','CALLS_T_1','CALLS_T_3','CALLS_T_5','CALLS_T_6','CALLS_T_9','MOU_TF','MOU_T','MOU_T_1','MOU_T_3','MOU_T_5','MOU_T_6','MOU_T_9','PULSE_TF','PULSE_T','PULSE_T_1','PULSE_T_3','PULSE_T_5','PULSE_T_6','PULSE_T_9','UU_TF','UU_T','UU_T_1','UU_T_3','UU_T_5','UU_T_6','UU_T_9','SEC_TF','SEC_T','SEC_T_1','SEC_T_3','SEC_T_5','SEC_T_6','SEC_T_9','L_CALLS_TF','N_CALLS_TF','L_CALLS_T','N_CALLS_T','L_CALLS_T_6','N_CALLS_T_6','L_MOU_TF','N_MOU_TF','L_MOU_T','N_MOU_T','L_MOU_T_6','N_MOU_T_6','L_PULSE_TF','N_PULSE_TF','L_PULSE_T','N_PULSE_T','L_PULSE_T_6','N_PULSE_T_6','L_UU_TF','N_UU_TF','L_UU_T','N_UU_T','L_UU_T_6','N_UU_T_6','L_SEC_TF','N_SEC_TF','L_SEC_T','N_SEC_T','L_SEC_T_6','N_SEC_T_6','L_SEC_T_1','N_SEC_T_1','L_SEC_T_3','N_SEC_T_3','L_SEC_T_5','N_SEC_T_5','L_SEC_T_9','N_SEC_T_9') ";
} else {
    $condition = " AND type NOT IN ('UU_Repeat','UU_New','CALLS_TF','CALLS_T','CALLS_T_1','CALLS_T_3','CALLS_T_5','CALLS_T_6','CALLS_T_9','MOU_TF','MOU_T','MOU_T_1','MOU_T_3','MOU_T_5','MOU_T_6','MOU_T_9','PULSE_TF','PULSE_T','PULSE_T_1','PULSE_T_3','PULSE_T_5','PULSE_T_6','PULSE_T_9','UU_TF','UU_T','UU_T_1','UU_T_3','UU_T_5','UU_T_6','UU_T_9','SEC_TF','SEC_T','SEC_T_1','SEC_T_3','SEC_T_5','SEC_T_6','SEC_T_9','L_CALLS_TF','N_CALLS_TF','L_CALLS_T','N_CALLS_T','L_CALLS_T_6','N_CALLS_T_6','L_MOU_TF','N_MOU_TF','L_MOU_T','N_MOU_T','L_MOU_T_6','N_MOU_T_6','L_PULSE_TF','N_PULSE_TF','L_PULSE_T','N_PULSE_T','L_PULSE_T_6','N_PULSE_T_6','L_UU_TF','N_UU_TF','L_UU_T','N_UU_T','L_UU_T_6','N_UU_T_6','L_SEC_TF','N_SEC_TF','L_SEC_T','N_SEC_T','L_SEC_T_6','N_SEC_T_6','L_SEC_T_1','N_SEC_T_1','L_SEC_T_3','N_SEC_T_3','L_SEC_T_5','N_SEC_T_5','L_SEC_T_9','N_SEC_T_9') ";
}

// delete the prevoius record
$deleteprevioousdata = "delete from mis_db.daily_report where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic
// start the code to insert the data of activation Airtel
$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock 
 where DATE(response_time)='$view_date1' and service_id in(1503,1511,1507,1514,1513,1518,1515,1517,1501,1520,1522) 
 and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query1)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($service_id == 1511 && ($plan_id == 30 || $plan_id == 48)) {
            $service_id = 1509;
        } elseif ($service_id == 1511 && ($plan_id == 29 || $plan_id == 46)) {
            $service_id = 1511;
        } elseif ($service_id == 1522) {
            if ($plan_id == 63)
                $service_id = 15222;
            elseif ($plan_id == 64)
                $service_id = 15221;
        } elseif ($service_id == 1513 && $plan_id == 81) {
            $service_id = '1513';
        }

        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}


$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock
  where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query1)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end the code to insert the data of activation Airtel
//Start the code to activation Record mode wise 

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,plan_id,chrg_amount from " . $successTable . " nolock 
 where DATE(response_time)='$view_date1' and service_id in(1503,1511,1507,1514,1513,1518,1515,1517,1501,1520,1522)
 and event_type in('SUB','TOPUP') group by circle,service_id,event_type,mode,plan_id,chrg_amount order by event_type,plan_id"; //and plan_id!=29 

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode, $plan_id, $charging_amt) = mysql_fetch_array($db_query)) {
        //if($service_id=='1522' ||$service_id=='15222')
        //	echo $mode;

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        //if($shortCode == '5464612') $service_id='1518';
        if ($service_id == 1511 && ($plan_id == 30 || $plan_id == 48)) {
            $service_id = 1509;
        } elseif ($service_id == 1511 && ($plan_id == 29 || $plan_id == 46)) {
            $service_id = 1511;
        } elseif ($service_id == 1522) {
            if ($plan_id == 63)
                $service_id = 15222;
            elseif ($plan_id == 64)
                $service_id = 15221;
        } elseif ($service_id == 1513 && $plan_id == 81 && $mode != 'USSD_Retail') {
            $service_id = '1513';
        }
        if ($mode == "IVR_54321_")
            $mode = "IVR_54321";
        if ($mode == "54321_RE")
            $mode = "IVR_54321_RE";
        if ($event_type == 'SUB') {
            if (strtoupper($mode) == "TC" && $service_id == 1501)
                $mode = "TELECALL";
            $activation_str1 = "Mode_Activation_" . strtoupper($mode);
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } else if ($event_type == 'TOPUP') {
            $activation_str1 = "Mode_TOP-UP_IVR";
			$charging_amt=0;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        //	if($service_id=='1522' ||$service_id=='15222')
        //	echo $insert_data;

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,plan_id,chrg_amount from " . $successTable . " nolock  
        where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','TOPUP') 
        and SC not like '%P%' group by circle,service_id,event_type,mode,plan_id,chrg_amount order by event_type,plan_id"; //and plan_id!=29 

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode, $plan_id, $charging_amt) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mode == "IVR_54321_")
            $mode = "IVR_54321";
        if ($mode == "54321_RE")
            $mode = "IVR_54321_RE";
        if ($event_type == 'SUB') {
            $activation_str1 = "Mode_Activation_" . strtoupper($mode);
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } else if ($event_type == 'TOPUP') {
            $activation_str1 = "Mode_TOP-UP_IVR";
			$charging_amt=0;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
// end the code
//---------pause code ------------------

$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,substr(SC,9,3) as p,substr(SC,14,1) as code 
    from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1502) 
        and event_type in('SUB') and SC like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $p, $code) = mysql_fetch_array($query1)) {
        if ($event_type == 'SUB') {
            $pcircle = $pauseArray[$p];
            $pauseCodeVal = $pauseCode[$code];
            $activation_str = "Mode_Activation_" . $pauseCodeVal;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pcircle','1502P','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_activation_query1 = "select count(msisdn),substr(SC,9,3) as circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','RESUB','TOPUP') 
        and SC like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query1)) {
        $pCircle = $pauseArray[$circle];
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//---------pause code end here ---------

if (!$flag) { // if flag=1 then no impact on active and pending base
    include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyActivebase.php");
    include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyPendingbase.php");
} // end of active-pending flag case
include_once("/var/www/html/kmis/services/hungamacare/mis/insertDailyDeactprice.php");

///////////////////////////////////////////////////// RBT DATA FOR AirtelVH1////////////////////////////////////////////////////////////////////////
//start code to insert the data for RBT_*  
$rbt_tf = array();
$rbt_query = "select count(*),circle,Intype from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and status=1 and dnis!='EU' and Intype in('CRBT','RNG') group by circle,Intype";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'CRBT') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1507','NA','NA','NA')";
        } elseif ($rbt_tf[2] == 'RNG') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1507','NA','NA','NA')";
        }
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}


///  Insert all REquest data of CRBT Airtel EU

$rbt_tf = array();
$rbt_query = "select count(*),circle from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and dnis='EU' and Intype in('CRBT') group by circle";
$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1501','NA','NA','NA')";
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
// end Insert all REquest data of CRBT Airtel EU
///  Insert all SUCCESS REquest data of CRBT Airtel EU

$rbt_tf = array();
$rbt_query = "select count(*),circle from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and dnis='EU' and Intype in('CRBT') and trim(response) in('0','SUCCESS') group by circle";
$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_SUCC','$rbt_tf[1]','$rbt_tf[0]','0','1501','NA','NA','NA')";
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
//////////////////////////////////// end Insert all SUCCESS Request data of CRBT Airtel EU/////////////////////////////////////////////////////
////////////////////////////////////////// Start data to insert all Request data //////////////////////////////////////////////////////////

$crbt_tf = array();

$rbt_query1 = "select count(*),circle,req_type from airtel_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and status=1 group by circle,req_type";
$rbt_tf_result1 = mysql_query($rbt_query1, $dbConn) or die(mysql_error());

$numRows61 = mysql_num_rows($rbt_tf_result1);
if ($numRows61 > 0) {
    while ($rbt_tf1 = mysql_fetch_array($rbt_tf_result1)) {
        if (trim($rbt_tf1[2]) == 'tt')
            $rbttype = 'RT_TT_REQ';
        elseif (trim($rbt_tf1[2]) == 'pt')
            $rbttype = 'RT_PT_REQ';

        $insert_rbt_tf_data1 = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1','" . $rbttype . "','$rbt_tf1[1]','$rbt_tf1[0]','0','1501','NA','NA','NA')";
        $queryIns_rbt = mysql_query($insert_rbt_tf_data1, $dbConn);
    }
}

// Start data to insert all Request data 
///////////////////////////////////// Start data to insert all Success Request data ///////////////////////////////////////////////////////

$crbt_tf = array();

$rbt_query1 = "select count(*),circle,req_type from airtel_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and status=1 and responce_code='OK' group by circle,req_type";
$rbt_tf_result1 = mysql_query($rbt_query1, $dbConn) or die(mysql_error());

$numRows61 = mysql_num_rows($rbt_tf_result1);
if ($numRows61 > 0) {
    while ($rbt_tf1 = mysql_fetch_array($rbt_tf_result1)) {
        if (trim($rbt_tf1[2]) == 'tt')
            $surbttype = 'RT_TT_SUC';
        elseif (trim($rbt_tf1[2]) == 'pt')
            $surbttype = 'RT_PT_SUC';

        $insert_rbt_tf_data1 = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1','" . $surbttype . "','$rbt_tf1[1]','$rbt_tf1[0]','0','1501','NA','NA','NA')";
        $queryIns_rbt = mysql_query($insert_rbt_tf_data1, $dbConn);
    }
}

// Start data to insert all MT Request data 
///////////////////////////////////////////// to insert the Migration data ///////////////////////////////////////////////////////////

$get_migrate_date = "select Intype,count(*),circle from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and status=1 and Intype in('CRBT','RNG') and dnis!='EU' group by circle,Intype";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($crbt_mode, $count, $circle) = mysql_fetch_array($get_query)) {
        if ($circle == '')
            $circle = 'UND';
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1507','NA','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

//----------------- failure count --------------------------

$charging_fail = "select count(*),circle,event_type,service_id from master_db.tbl_billing_failure where date(date_time)='$view_date1' group by circle,event_type,service_id order by service_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type, $service_id) = mysql_fetch_array($deactivation_base_query)) {
    if ($service_id == 1511 && ($plan_id == 30 || $plan_id == 48)) {
        $service_id = 1509;
    } else if ($service_id == 1511 && ($plan_id == 29 || $plan_id == 46)) {
        $service_id = 1511;
    } else if ($service_id == 1522) {
        if ($plan_id == 64)
            $service_id = 15221;
        elseif ($plan_id == 63)
            $service_id = 15222;
    }

    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    if ($circle == "")
        $circle = "UND";
    elseif ($circle == "HAR")
        $circle = "HAY";
    elseif ($circle == "PUN")
        $circle = "PUB";

    $insertData = "insert into mis_db.daily_report(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle', '$count', '" . $service_id . "')";
    $queryIns = mysql_query($insertData, $dbConn);
}
//------------------ failure count code end here -----------
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConn);
echo "done";
?>
