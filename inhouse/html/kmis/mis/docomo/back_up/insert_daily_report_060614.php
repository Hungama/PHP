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
//echo $view_date1='2014-04-23';
//echo $last_7day_start = '2014-04-22';
//echo $last_7day_end = '2014-04-17';
//$flag=1;
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

///////////////////////////////////////----- start code for pause code array ---------- /////////////////////////////////////////////////////////////
$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');
///////////////////////////////////////----- end code for pause code array ---------- /////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////// start code for delete the prevoius record /////////////////////////////////////////////////////
if ($flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}

echo $deleteprevioousdata = "delete from mis_db.daily_report where date(report_date)='$view_date1'
and service_id in (1001,1005,1002,1003,1009,1010,1011,1000,1013)" . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
//and SC not like '%P%'
///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////////
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1001,1003,1009,1010,1011,1013) 
        and event_type in('SUB') and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($event_type == 'SUB') {
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB') and SC not like '%P%' 
        group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($event_type == 'SUB') {
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}


$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1001,1003,1009,1010,1011,1013) and event_type in('RESUB','TOPUP') 
        and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
                        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
                        values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('RESUB','TOPUP') 
        and SC not like '%P%' group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////////////////////////////////// Riya Event Charging /////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////-----------------Pause code----------------//////////////////////////////////////////////////////

$get_activation_query = "select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,SC from " . $successTable . " nolock
        where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','RESUB','TOPUP') 
        and SC like '%P%' and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type,SC";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $sc) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        $pCircle = $pauseArray[$circle];
        if ($event_type == 'SUB') {
            if ($circle == '')
                $circle = 'UND';
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,SC,substr(SC,14,1) as p from " . $successTable . " nolock
        where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','TOPUP') and SC like '%P%' 
        group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode, $sc, $p) = mysql_fetch_array($db_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_data2 = "";
        $pMode = $pauseCode[$p];
        if ($event_type == 'SUB') {
            $activation_str1 = "Mode_Activation_" . $pMode;
            $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}
////////////////////////////////////////////////////////////////---------Pause code end here --------------////////////////////////////////////////////

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (99,100,101)
        group by circle,service_id,chrg_amount";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $charging_str = "Event_" . $charging_amt;
        $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (85)
        group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($event_type == 'SUB') {
            $charging_str = "Activation_Follow_5";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_Follow_5";
        }
        $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,floor(chrg_amount) as amount from mis_db.tbl_wapRequest_data 
    where date(datetime)='" . $view_date1 . "' and operator='TATM' and service='1009' and status like 'success%' 
        group by circle,chrg_amount";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle, $amount) = mysql_fetch_array($db_query)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $activation_str1 = "EVENT_" . $amount;
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('" . $view_date1 . "', '" . $activation_str1 . "','$circle','1009','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='" . $view_date1 . "' and operator='TATM' and service='1009' and status like 'success%' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $activation_str1 = "RT_FT_SUC";
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','1009','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}


$get_mode_activation_query = "select count(msisdn),circle from mis_db.tbl_wapRequest_data 
    where date(datetime)='" . $view_date1 . "' and operator='TATM' and service='1009' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    $db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $str1 = "RT_FT_REQ";
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1009','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

///////////////////////////////////////////////////////////////////////// code end here /////////////////////////////////////////////////////////////

$get_activation_query4 = "select count(msisdn),circle,chrg_amount,service_id,plan_id from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1005) 
        and event_type in('SUB') group by circle,service_id,chrg_amount,plan_id";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if ($numRows4 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $plan_id) = mysql_fetch_array($query4)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        //$circle_info=array();
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($plan_id == 20)
            $activation_str = "Activation_Ticket_15";
        elseif ($plan_id == 33)
            $activation_str = "Activation_Ticket_20";
        elseif ($plan_id == 34)
            $activation_str = "Activation_Ticket_10";
        elseif ($plan_id == 19)
            $activation_str = "Activation_Follow_" . $charging_amt;
        else
            $activation_str = "Activation_" . $charging_amt;

        $revenue = $charging_amt * $count;
        $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// remove the 1005 FMJ id from this query : show wid 

$get_activation_query3 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock 
        WHERE DATE(response_time)='$view_date1' and service_id in(1005) and event_type in('RESUB','TOPUP') 
        group by circle,service_id,chrg_amount, event_type, plan_id";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query3)) {
        $pieces = explode(".", $charging_amt);
        if ($pieces[1]) {
            $amt = substr($pieces[1], 0, 1);
            if ($amt != 0) {
                $charging_amt = $pieces[0] . "." . $amt;
            } else {
                $charging_amt = $pieces[0];
            }
        }
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        //$circle=array();
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'RESUB') {
            if ($plan_id == 20)
                $charging_str = "Renewal_Ticket_15";
            elseif ($plan_id == 33)
                $charging_str = "Renewal_Ticket_20";
            elseif ($plan_id == 34)
                $charging_str = "Renewal_Ticket_10";
            elseif ($plan_id == 19)
                $charging_str = "Renewal_Follow_" . $charging_amt;
            else
                $charging_str = "Renewal_" . $charging_amt;
            $revenue = $charging_amt * $count;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;

            $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646/////////
if (!$flag) {
    include_once("/var/www/html/kmis/mis/docomo/insertDailyActivebase.php");
    include_once("/var/www/html/kmis/mis/docomo/insertDailyPendingbase.php");
    include_once("/var/www/html/kmis/mis/docomo/insertDailyUUser_repeat.php");
}
include_once("/var/www/html/kmis/mis/docomo/insertDailyCalls.php");
include_once("/var/www/html/kmis/mis/docomo/insertDailyMous.php");
include_once("/var/www/html/kmis/mis/docomo/insertDailyUUser.php");
include_once("/var/www/html/kmis/mis/docomo/insertDailyPulse.php");
include_once("/var/www/html/kmis/mis/docomo/insertDailySec.php");
include_once("/var/www/html/kmis/mis/docomo/insertDailyDeactprice.php");

////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock where DATE(response_time)='$view_date1' and service_id in(1001,1005,1003,1010,1011,1013) and event_type in('SUB','RESUB','TOPUP') and plan_id NOT IN (85,99,100,101) and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data1 = "";
        if ($event_type == 'SUB') {
            if (is_numeric($mode))
                $mode = 'CC';
            if (strcasecmp($mode, 'net') == 0)
                $mode = strtoupper($mode);

            if ($mode == "155223" && ($service_id == '1001' || $service_id == '1002' || $service_id == '1010' || $service_id == '1005'))
                $mode == "IVR_155223";
            elseif ($mode == "IVR_52222" && $service_id == "1009")
                $mode = "IBD";
            elseif ($mode == "155223" && $service_id == "1005")
                $mode = "IVR";
            elseif ($mode == "TOBD" && $service_id == "1001")
                $mode = "OBD";
            elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
                $mode = "IVR";
            elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
                $mode = "OBD";
            elseif (strtoupper($mode) == "NETB")
                $mode = "NET";
            elseif (strtoupper($mode) == "TPCN")
                $mode = "PCN";
            elseif (strtoupper($mode) == "CCI" && $service_id != '1001')
                $mode = "CC";
            elseif (strtoupper($mode) == "TUSSD")
                $mode = "USSD";
            elseif (strtoupper($mode) == "HUNOBDBONUS")
                $mode = "TOBD";

            if (strtoupper($mode) == 'CCARE' && $service_id == '1001')
                $mode = 'CCI';

            $activation_str1 = "Mode_Activation_" . strtoupper($mode);
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'TOPUP') {
            $activation_str1 = "Mode_TOP-UP_IVR";
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB','TOPUP') and plan_id NOT IN (85,99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data1 = "";
        if ($event_type == 'SUB') {
            if (is_numeric($mode))
                $mode = 'CC';
            if (strcasecmp($mode, 'net') == 0)
                $mode = strtoupper($mode);

            if ($mode == "155223" && ($service_id == '1001' || $service_id == '1002' || $service_id == '1010' || $service_id == '1005'))
                $mode == "IVR_155223";
            elseif ($mode == "IVR_52222" && $service_id == "1009")
                $mode = "IBD";
            elseif ($mode == "155223" && $service_id == "1005")
                $mode = "IVR";
            elseif ($mode == "TOBD" && $service_id == "1001")
                $mode = "OBD";
            elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
                $mode = "IVR";
            elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
                $mode = "OBD";
            elseif (strtoupper($mode) == "NETB")
                $mode = "NET";
            elseif (strtoupper($mode) == "TPCN")
                $mode = "PCN";
            elseif (strtoupper($mode) == "CCI" && $service_id != '1001')
                $mode = "CC";
            elseif (strtoupper($mode) == "TUSSD")
                $mode = "USSD";
            elseif (strtoupper($mode) == "HUNOBDBONUS")
                $mode = "TOBD";

            if (strtoupper($mode) == 'CCARE' && $service_id == '1001')
                $mode = 'CCI';

            $activation_str1 = "Mode_Activation_" . strtoupper($mode);
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'TOPUP') {
            $activation_str1 = "Mode_TOP-UP_IVR";
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

// Event for Miss Riya
$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB') and plan_id IN (99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data1 = "";

        if (is_numeric($mode))
            $mode = 'CC';
        if (strcasecmp($mode, 'net') == 0)
            $mode = strtoupper($mode);

        if ($mode == "155223" && ($service_id == '1001' || $service_id == '1002' || $service_id == '1010' || $service_id == '1005'))
            $mode == "IVR_155223";
        elseif ($mode == "IVR_52222" && $service_id == "1009")
            $mode = "IBD";
        elseif ($mode == "155223" && $service_id == "1005")
            $mode = "IVR";
        elseif ($mode == "TOBD" && $service_id == "1001")
            $mode = "OBD";
        elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
            $mode = "IVR";
        elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
            $mode = "OBD";
        elseif (strtoupper($mode) == "NETB")
            $mode = "NET";
        elseif (strtoupper($mode) == "TPCN")
            $mode = "PCN";
        elseif (strtoupper($mode) == "CCI" && $service_id != '1001')
            $mode = "CC";
        elseif (strtoupper($mode) == "TUSSD")
            $mode = "USSD";
        elseif (strtoupper($mode) == "HUNOBDBONUS")
            $mode = "TOBD";

        if (strtoupper($mode) == 'CCARE' && $service_id == '1001')
            $mode = 'CCI';


        $activation_str1 = "Mode_FS_" . strtoupper($mode);

        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data2 = "";
        if ($event_type == 'SUB') {
            if (is_numeric($mode))
                $mode = 'CC';
            if (strcasecmp($mode, 'net') == 0)
                $mode = strtoupper($mode);

            if ($mode == "155223" && ($service_id == '1001' || $service_id == '1002' || $service_id == '1010' || $service_id == '1005'))
                $mode == "IVR_155223";
            elseif ($mode == "IVR_52222" && $service_id == "1009")
                $mode = "IBD";
            elseif ($mode == "155223" && $service_id == "1005")
                $mode = "IVR";
            elseif ($mode == "TOBD" && $service_id == "1001")
                $mode = "OBD";
            elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
                $mode = "IVR";
            elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
                $mode = "OBD";
            elseif (strtoupper($mode) == "NETB")
                $mode = "NET";
            elseif (strtoupper($mode) == "TPCN")
                $mode = "PCN";
            elseif (strtoupper($mode) == "CCI" && $service_id != '1001')
                $mode = "CC";
            elseif (strtoupper($mode) == "TUSSD")
                $mode = "USSD";
            elseif (strtoupper($mode) == "HUNOBDBONUS")
                $mode = "TOBD";

            if (strtoupper($mode) == 'CCARE' && $service_id == '1001')
                $mode = 'CCI';


            $activation_str1 = "Mode_Activation_" . strtoupper($mode);
            $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        if ($event_type == 'TOPUP') {
            $activation_str1 = "Mode_TOP-UP_IVR";
            $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
///////////////////// Add SMS Pack for DocomoEndless code ///////////////////////////////////////////////////////

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,event_type,mode from " . $successTable . " nolock where DATE(response_time)='$view_date1' and service_id in(1001) and event_type in('SUB') and plan_id='92' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data2 = "";
        if ($event_type == 'SUB') {
            if (is_numeric($mode))
                $mode = 'CC';

            if ($mode == "155223" && ($service_id == '1001' || $service_id == '1002' || $service_id == '1010' || $service_id == '1005'))
                $mode == "IVR_155223";
            elseif ($mode == "IVR_52222" && $service_id == "1009")
                $mode = "IBD";
            elseif ($mode == "155223" && $service_id == "1005")
                $mode = "IVR";
            elseif ($mode == "TOBD" && $service_id == "1001")
                $mode = "OBD";
            elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
                $mode = "IVR";
            elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
                $mode = "OBD";
            elseif (strtoupper($mode) == "NETB")
                $mode = "NET";
            elseif (strtoupper($mode) == "TPCN")
                $mode = "PCN";
            elseif (strtoupper($mode) == "CCI" && $service_id != '1001')
                $mode = "CC";
            elseif (strtoupper($mode) == "TUSSD")
                $mode = "USSD";
            elseif (strtoupper($mode) == "HUNOBDBONUS")
                $mode = "TOBD";

            if (strtoupper($mode) == 'CCARE' && $service_id == '1001')
                $mode = 'CCI';


            $activation_str1 = "Mode_Activation_SMSPack-" . strtoupper($mode);
            $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}

/*
  $get_mode_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock
  WHERE DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('RESUB','SUB') and plan_id='85' group by circle,service_id,chrg_amount, event_type, plan_id";

  $db_query = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($db_query);
  if ($numRows > 0)
  {
  while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($db_query))
  {
  if($circle=='' || $circle=='0') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data2="";
  if($event_type=='SUB')
  {
  $activation_str1="Activation_Follow_1";
  $insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
  }
  elseif($event_type=='RESUB')
  {
  $ren_str1="Renewal_Follow_1";
  $insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$ren_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
  }
  $queryIns = mysql_query($insert_data2, $dbConn);
  }
  }
 */

///////////////////// Add SMS Pack for DocomoEndless code end ///////////////////////////////////////////////////////
//////////////////////////// start code to insert the data for Activation_Follow_5 for Tata Docomo Filmi Meri jaan //////////////////////////////////
//$getActiveBase="select count(ani),circle from follow_up.tbl_subscription where date(sub_date)='$view_date1' and user_bal = 5 and status = 1 and service_id = 1005";

$getActiveBase = "select count(ani),circle from follow_up.tbl_subscription where date(sub_date)='$view_date1' and user_bal = 5 and service_id = 1005 and status = 1";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0) {
    while (list($countfmj, $circlefmj) = mysql_fetch_array($activeBaseQuery)) {
        if ($circlefmj[1] == '' || $circlefmj[1] == '0')
            $circlefmj[1] = 'UND';
        elseif (strtoupper($circlefmj[1]) == 'HAR')
            $circlefmj[1] = 'HAY';
        $insert_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Follow_5' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//start code to insert the data for Activation_Follow_5 for Tata Docomo Filmi Meri jaan
//start code to insert the data for Renewal_Follow_5 for Tata Docomo Filmi Meri jaan
//$getActiveBase="select count(ani),circle from follow_up.tbl_unsubscription where date(sub_date)='$view_date1' and user_bal = 5 and status = 0 and service_id = 1005";

$getActiveBase = "select count(ani),circle from follow_up.tbl_unsubscription where date(sub_date)='$view_date1' and user_bal = 5 and service_id = 1005 ";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0) {
    while (list($countfmj, $circlefmj) = mysql_fetch_array($activeBaseQuery)) {
        //$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Follow_5' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//start code to insert the data for Renewal_Follow_5 for Tata Docomo Filmi Meri jaan
//start code to insert the data for Activation_Ticket_15 for Tata Docomo Filmi Meri jaan
//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_15',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 15 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0) {
    while (list($countfmj, $circlefmj) = mysql_fetch_array($activeBaseQuery)) {
        // $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_15' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//End code to insert the data for Activation_Ticket_15 for Tata Docomo Filmi Meri jaan
//start code to insert the data for Activation_Ticket_20 for Tata Docomo Filmi Meri jaan
//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_20',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 20 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0) {
    while (list($countfmj, $circlefmj) = mysql_fetch_array($activeBaseQuery)) {
        // $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_20' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//End code to insert the data for Activation_Ticket_20 for Tata Docomo Filmi Meri jaan
//start code to insert the data for Activation_Ticket_10 for Tata Docomo Filmi Meri jaan
//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_10',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 10 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0) {
    while (list($countfmj, $circlefmj) = mysql_fetch_array($activeBaseQuery)) {
        // $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_10' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//End code to insert the data for Activation_Ticket_10 for Tata Docomo Filmi Meri jaan
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////// start code to insert the data for RBT_* /////////////////////////////////////////
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from docomo_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[1] == '' || $rbt_tf[1] == '0')
            $rbt_tf[1] = 'UND';
        elseif (strtoupper($rbt_tf[1]) == 'HAR')
            $rbt_tf[1] = 'HAY';
        if (strtoupper($rbt_tf[2]) == 'CRBT') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,
                    total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
        } elseif (strtoupper($rbt_tf[2]) == 'RNG') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,
                    total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
        }


        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////// end code to insert the data for RBT_*  /////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////// to inser the Migration data //////////////////////////////////////////////////

$get_migrate_date = "select crbt_mode,count(1),circle from docomo_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by crbt_mode,circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($crbt_mode, $count, $circle) = mysql_fetch_array($get_query)) {
        if ($circle == '' || $circle == '0')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($circle == '')
            $circle = 'NA';
        if ($crbt_mode == 'ACTIVATE') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1001','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'MIGRATE') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1001','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1001','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD15') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1001','NA','$count','NA','NA','NA')";
        }

        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

echo "done";
mysql_close($dbConn);
?>
