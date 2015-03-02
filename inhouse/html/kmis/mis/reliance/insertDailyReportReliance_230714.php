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
//$flag=1;
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
if ($flag) {
    $condition = " AND type NOT IN ('UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}

$deleteprevioousdata = "delete from mis_db.dailyReportReliance where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic

$get_activation_query = "select count(msisdn) from master_db.tbl_billing_success where DATE(response_time)='$view_date1' 
                        and service_id in(1202,1203,1208,1201) and event_type in('SUB','RESUB','EVENT') and SC not like '%P%'";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $get_activation_query12 = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1202,1203,1208,1201) and SC not like '%P%' and event_type in('SUB','RESUB','TOPUP','Event','EVENT') group by circle,service_id,chrg_amount,event_type";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query12)) {
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

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////
///////////////////////// start code to insert the Pending Base date into the database Reliance 54646//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis not like '%P%' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1202)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Reliance54646' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_pending_base = "select count(ani),substr(dnis,9,3) as circle1,dnis from reliance_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis like '%P%' group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($pending_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_pending_base = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1202P')";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

///////////////////////////////// end code to insert the pending base date into the database REliance 54646///////////////////////////////////////
//////////////////////////////// start code to insert the Pending Base date into the database Cricket Mania//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_cricket.tbl_cricket_subscription where status IN (11,0,5) group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1208)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceCM' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the pending base date into the database Cricket Mania///////////////////////////////////////
/////////////////////////////// start code to insert the Pending Base date into the database Reliance Mtv//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1203)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVReliance' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database REliance Mtv///////////////////////////////////////
///////////////////////////////// start code to insert the active base date into the database REliance 54646//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis not like '%P%' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1202)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Reliance54646' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_active_base = "select count(*),substr(dnis,9,3) as circle1,dnis from reliance_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($active_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','NA','NA','NA','NA','1202P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////////////////// end code to insert the active base date into the database REliance 54646/////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database Cricket Mania//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_cricket.tbl_cricket_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1208)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceCM' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////////////////// end code to insert the active base date into the database Cricket Mania/////////////////////////////////////
///////////////////////////////// start code to insert the active base date into the database relianceMM @jyoti.porwal/////////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceMM' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
        values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the active base date into the database relianceMM @jyoti.porwal////////////////////////////////////
///////////////////////////////// start code to insert the pending base date into the database relianceMM @jyoti.porwal////////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceMM' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
        values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the pending base date into the database relianceMM @jyoti.porwal///////////////////////////////////
/////////////////////// start code to insert the active base date into the database REliance Mtv//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1203)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVReliance' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////// end code to insert the active base date into the database REliance Mtv/////////////////////////////////////
///////////////////////////////// start code to insert the Deactivation Base into the MIS database Reliance 54646//////////////////////////

$get_deactivation_base = "select count(*) from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $get_deactivation_base12 = "select count(*),circle,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) and dnis not like '%P%' group by circle";
    $deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query12)) {
        $deactivation_str1 = "Mode_Deactivation_in";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) 
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_deactivation_base = "select count(*) from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $get_deactivation_base12 = "select count(*),substr(dnis,9,3) as circle1,status,dnis from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' and status in(11) group by circle,dnis";
    $deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $status, $dnis) = mysql_fetch_array($deactivation_base_query12)) {
        $pCircle = $pauseArray[$circle];
        $deactivation_str1 = "Mode_Deactivation_in";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$pCircle','$count','NA','NA','NA','1202P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////// end code to insert the Deactivation base into the MIS database REliance 54646////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database Cricket mania//////////////////////////

$get_deactivation_base = "select count(*) from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $get_deactivation_base12 = "select count(*),circle,status from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
    $deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query12)) {
        $deactivation_str1 = "Mode_Deactivation_in";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////////////// end code to insert the Deactivation base into the MIS database Cricket mania////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database RelianceMM @jyoti.porwal//////////////////////////

$get_deactivation_base = "select count(*) from reliance_music_mania.tbl_MusicMania_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $get_deactivation_base12 = "select count(*),circle,status from reliance_music_mania.tbl_MusicMania_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
    $deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query12)) {
        $deactivation_str1 = "Mode_Deactivation_in";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////////////// end code to insert the Deactivation base into the MIS database RelianceMM @jyoti.porwal////////////////////////
///////////////////////////////////// start code to insert the Deactivation Base into the MIS database Reliance Mtv//////////////////////////

$get_deactivation_base = "select count(*) from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $get_deactivation_base12 = "select count(*),circle,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
    $deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query12)) {
        $deactivation_str1 = "Mode_Deactivation_in";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance Mtv////////////////////////
//////////////////////////////////////// start code to insert the Deactivation Base into the MIS database REliance 54646////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == "SELF_REQ")
            $unsub_reason = "IVR";
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_deactivation_base = "select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub_reason1,status,dnis from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status, $dnis) = mysql_fetch_array($deactivation_base_query)) {
        $pCircle = $pauseArray[$circle];
        $mode = $pauseCode[$unsub_reason];
        $deactivation_str1 = "Mode_Deactivation_" . $mode;
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$pCircle','$count','$unsub_reason','NA','NA','NA','1202P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////////////// end code to insert the Deactivation base into the MIS database REliance 54646///////////////////////
////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Cricket Mania////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == "SELF_REQ")
            $unsub_reason = "IVR";
        if ($unsub_reason == "SMS")
            $unsub_reason = "BULK";
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Cricket Mania///////////////////////
////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database RelianceMM @jyoti.porwal////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from reliance_music_mania.tbl_MusicMania_unsub where date(unsub_date)='$view_date1' 
and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == "SELF_REQ")
            $unsub_reason = "IVR";
        if ($unsub_reason == "SMS")
            $unsub_reason = "BULK";
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////////////////////// end code to insert the Deactivation Base into the MIS database RelianceMM @jyoti.porwal////////////////
//////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database REliance Mtv////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == "SELF_REQ")
            $unsub_reason = "IVR";
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance MTV///////////////////////
///////////////////////////////////////////////////start code to insert the data for call_tf Reliance 54646
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1202','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1202','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for call_tf REliance 54646///////////////////////////////////////
///////////////////////////////////////////////////start code to insert the data for call_tf Pause
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'Pause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'pause' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];

        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'Pause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $c = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'pause' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47%' and operator in('relm','relc') group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $c = $call_tf[1];
        $pCircle = $pauseArray[$p];

        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_T";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_T";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

/////////////////////////////////////////End code to insert the data for call_tf REliance 54646///////////////////////////////////////
///////////////////////////////////////////////////start code to insert the data for call_tf RElianceMS
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RElianceMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1200','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RElianceMS' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1200','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for call_tf RElianceMS///////////////////////////////////////
////////////////////////////start code to insert the data for call_tf Cricket Mania //////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == '544334' || $call_tf[5] == '5443344') {
            $call_type = "CALLS_T_6";
        }
        if ($call_tf[5] == '544337') {
            $call_type = "CALLS_T_9";
        }
        if ($call_tf[5] != '544334' && $call_tf[5] != '544337' && $call_tf[5] != '5443344') {
            $call_type = "CALLS_T";
        }

        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_type','$call_tf[1]','0','$call_tf[2]','','1208','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),dnis,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == '544334' || $call_tf[5] == '5443344') {
            if ($call_tf[6] == 1)
                $call_type = "L_CALLS_T_6";
            elseif ($call_tf[6] != 1)
                $call_type = "N_CALLS_T_6";  //$call_type="CALLS_T_6";
        }
        if ($call_tf[5] == '544337') {
            if ($call_tf[6] == 1)
                $call_type = "L_CALLS_T_9";
            elseif ($call_tf[6] != 1)
                $call_type = "N_CALLS_T_9";  //$call_type="CALLS_T_9";
        }
        if ($call_tf[5] != '544334' && $call_tf[5] != '544337' && $call_tf[5] != '5443344') {
            if ($call_tf[6] == 1)
                $call_type = "L_CALLS_T";
            elseif ($call_tf[6] != 1)
                $call_type = "N_CALLS_T";  //$call_type="CALLS_T";
        }

        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_type','$call_tf[1]','0','$call_tf[2]','','1208','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

//////////////////////////////////////////////End code to insert the data for call_tf Cricket Mania///////////////////////////////////////
/////////////////////////////////////////Start code to insert the data for call_tf REliance MTV///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relc','relm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1203','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}


$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relc','relm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1203','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

///////////////////////////////////////////// end code to insert the data for call_tf for the service of Reliance Mtv/////////////////////////
/////////////////////////////////////////////start code to insert the data for call_t Reliance 54646/////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') and dnis not like '%P%' group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == '5464669' || $call_t[5] == '5464666' || $call_t[5] == '5464645') {
            $callType = "CALLS_T_6";
        } else {
            $callType = $call_t[0];
        }
        $insert_call_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callType','$call_t[1]','0','$call_t[2]','','1202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') and dnis not like '%P%' group by circle,dnis,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $callType = "";
        if ($call_t[5] == '5464669' || $call_t[5] == '5464666' || $call_t[5] == '5464645') {
            if ($call_t[6] == 1)
                $callType = "L_CALLS_T_6";
            elseif ($call_t[6] != 1)
                $callType = "N_CALLS_T_6";  //$callType="CALLS_T_6";
        } else {
            if ($call_t[6] == 1)
                $callType = "L_CALLS_T";
            elseif ($call_t[6] != 1)
                $callType = "N_CALLS_T";  //$callType=$call_t[0];
        }
        $insert_call_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callType','$call_t[1]','0','$call_t[2]','','1202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////END code to insert the data for call_t Reliance 54646/////////////////////////////////////
////////////////////////////////////////Start code to insert the data for call_tf RelianceMM///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RelianceMM' as service_name,date(call_date) from mis_db.tbl_musicmania_calllog 
where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relc','relm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1201','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}


$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RelianceMM' as service_name,date(call_date),status from mis_db.tbl_musicmania_calllog
where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relc','relm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1201','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

///////////////////////////////////////////// end code to insert the data for call_tf for the service of RelianceMM/////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Reliance 54646////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') and dnis not like '%P%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1202','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') and dnis not like '%P%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1202','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert Pause code////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60 as count,'pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1202P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60 as count,'pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];

        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";

        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1202P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60 as count,'pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1202P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60 as count,'pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];

        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_T";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_T";

        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1202P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code ////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf RelianceMS////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'RelianceMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1200','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'RelianceMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1200','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf RelianceMS ////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Cricket Mania////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, sum(duration_in_sec)/60 as count,'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == '544334' || $mous_tf[6] == '5443344') {
            $mous_type = "MOU_T_6";
            $callRate = 0.06;
        }
        if ($mous_tf[6] == '544337' || $mous_tf[6] == '5443377') {
            $mous_type = "MOU_T_9";
            $callRate = 0.09;
        }
        if ($mous_tf[6] != '544334' && $mous_tf[6] != '544337' && $mous_tf[6] != '5443377' && $mous_tf[6] != '5443344') {
            $mous_type = "MOU_T";
            $callRate = 0.10;
        }





        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_type','$mous_tf[1]','$callRate','$mous_tf[5]','','1208','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, sum(duration_in_sec)/60 as count,'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == '544334' || $mous_tf[6] == '5443344') {
            if ($mous_tf[7] == 1)
                $mous_type = "L_MOU_T_6";
            elseif ($mous_tf[7] != 1)
                $mous_type = "N_MOU_T_6";  //$mous_type="MOU_T_6";
            $callRate = 0.06;
        }
        if ($mous_tf[6] == '544337' || $mous_tf[6] == '5443377') {
            if ($mous_tf[7] == 1)
                $mous_type = "L_MOU_T_9";
            elseif ($mous_tf[7] != 1)
                $mous_type = "N_MOU_T_9";  //$mous_type="MOU_T_9";
            $callRate = 0.09;
            //$callRate=9;
        }
        if ($mous_tf[6] != '544334' && $mous_tf[6] != '544337' && $mous_tf[6] != '5443377' && $mous_tf[6] != '5443344') {
            if ($mous_tf[7] == 1)
                $mous_type = "L_MOU_T";
            elseif ($mous_tf[7] != 1)
                $mous_type = "N_MOU_T";  //$mous_type="MOU_T";
            $callRate = 0.10;
        }

        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,
		service_id,mous,pulse,total_sec) values('$view_date1', '$mous_type','$mous_tf[1]','$callRate','$mous_tf[5]','','1208','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf Cricket Mania////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Reliance MTV////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'relianceMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1203','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'relianceMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1203','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance MTV////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t REliance 54646////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == '5464669' || $mous_t[6] == '5464666' || $mous_t[6] == '5464645') {
            $mouType = "MOU_T_6";
        } else {
            $mouType = $mous_t[0];
        }

        $insert_mous_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mouType','$mous_t[1]','0','$mous_t[5]','','1202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == '5464669' || $mous_t[6] == '5464666' || $mous_t[6] == '5464645') {
            if ($mous_t[7] == 1)
                $mouType = "L_MOU_T_6";
            elseif ($mous_t[7] != 1)
                $mouType = "N_MOU_T_6";  //$mouType="MOU_T_6";
        } else {
            if ($mous_t[7] == 1)
                $mouType = "L_MOU_T";
            elseif ($mous_t[7] != 1)
                $mouType = "N_MOU_T";  //$mouType=$mous_t[0];
        }

        $insert_mous_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mouType','$mous_t[1]','0','$mous_t[5]','','1202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf RelianceMM////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'RelianceMM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1201','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'RelianceMM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1201','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance MTV////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF REliance 54646////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1202','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1202','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for Pausecode////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'Pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1202P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'Pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1202P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'Pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1202P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'Pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_T";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_T";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1202P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

/////////////////////////////////////////////////////////////////END code ////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF RelianceMS////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RelianceMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1200','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RelianceMS' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1200','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF RelianceMS////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Cricket Mania ////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(pulse),'RelianceCricket' as service_name,date(call_date),sum(pulse) as pulse,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == '544334' || $pulse_tf[6] == '5443344') {
            $pulse_type = "PULSE_T_6";
            $pulserate = 6;
        }
        if ($pulse_tf[6] == '544337') {
            $pulse_type = "PULSE_T_9";
            $pulserate = 9;
        }
        if ($pulse_tf[6] != '544334' && $pulse_tf[6] != '544337' && $pulse_tf[6] != '5443344') {
            $pulse_type = "PULSE_T";
            //$pulserate=3;
            $pulserate = 0.10;
        }

        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,
		service_id,mous,pulse,total_sec) 
		values('$view_date1','$pulse_type','$pulse_tf[1]'," . $pulserate . ",'$pulse_tf[5]','','1208','NA','$pulse_tf[5]','NA')";

        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}


$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(pulse),'RelianceCricket' as service_name,date(call_date),sum(pulse) as pulse,dnis,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == '544334' || $pulse_tf[6] == '5443344') {
            if ($pulse_tf[7] == 1)
                $pulse_type = "L_PULSE_T_6";
            elseif ($pulse_tf[7] != 1)
                $pulse_type = "N_PULSE_T_6";  //$pulse_type="PULSE_T_6";
        }
        if ($pulse_tf[6] == '544337') {
            if ($pulse_tf[7] == 1)
                $pulse_type = "L_PULSE_T_9";
            elseif ($pulse_tf[7] != 1)
                $pulse_type = "N_PULSE_T_9";  //$pulse_type="PULSE_T_9";
        }
        if ($pulse_tf[6] != '544334' && $pulse_tf[6] != '544337' && $pulse_tf[6] != '5443344') {
            if ($pulse_tf[7] == 1)
                $pulse_type = "L_PULSE_T";
            elseif ($pulse_tf[7] != 1)
                $pulse_type = "N_PULSE_T";   //$pulse_type="PULSE_T";
        }

        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,
		mous,pulse,total_sec) 
		values('$view_date1','$pulse_type','$pulse_tf[1]','0','$pulse_tf[5]','','1208','NA','$pulse_tf[5]','NA')";

        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF Cricket Mania ////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Reliance MTV////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1203','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}


$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMTV' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1203','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance MTV////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T REliance 54646////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[5] == '5464669' || $pulse_t[5] == '5464666' || $pulse_t[5] == '5464645') {
            $pulseType = "PULSE_T_6";
            $pulserate = 6;
        } else {
            $pulseType = $pulse_t[0];
            $pulserate = 3;
        }
        $insert_pulse_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulseType','$pulse_t[1]'," . $pulserate . ",'$pulse_t[2]','','1202','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}


$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[5] == '5464669' || $pulse_t[5] == '5464666' || $pulse_t[5] == '5464645') {
            if ($pulse_t[6] == 1)
                $pulseType = "L_PULSE_T_6";
            elseif ($pulse_t[6] != 1)
                $pulseType = "N_PULSE_T_6";   //$pulseType="PULSE_T_6";
        } else {
            if ($pulse_t[6] == 1)
                $pulseType = "L_PULSE_T";
            elseif ($pulse_t[6] != 1)
                $pulseType = "N_PULSE_T";   //$pulseType=$pulse_t[0];
        }
        $insert_pulse_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulseType','$pulse_t[1]','0','$pulse_t[2]','','1202','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF RelianceMM////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMM' as service_name,date(call_date) 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1201','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}


$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMM' as service_name,date(call_date),status 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1201','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF RelianceMM////////////////////////////
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for REliance 54646
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == '5464669' || $uu_tf[5] == '5464666' || $uu_tf[5] == '5464645') {
            $uuType = "UU_T_6";
        } else {
            $uuType = $uu_tf[0];
        }
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uuType','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),dnis,status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') and status IN (1)) group by circle,dnis)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),dnis,status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == '5464669' || $uu_tf[5] == '5464666' || $uu_tf[5] == '5464645') {
            if ($uu_tf[6] == 1)
                $uuType = "L_UU_T_6";
            elseif ($uu_tf[6] != 1)
                $uuType = "N_UU_T_6";  //$uuType="UU_T_6";
        } else {
            if ($uu_tf[6] == 1)
                $uuType = "L_UU_T";
            elseif ($uu_tf[6] != 1)
                $uuType = "N_UU_T";  //$uuType=$uu_tf[0];
        }
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uuType','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance 54646
///////////////////////////////////////////////////////////start code to insert Pausecode ///////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];

        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'Pausecode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];

        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1202P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////End code ////////////////////////////////
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for RelianceMS
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'RelianceMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
            values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1200','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'RelianceMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and dnis !='546461' and operator in('relm','relc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'RelianceMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1200','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

/////////////////////////////////////////End code to insert the data for Unique Users  for toll free for RelianceMS///////////
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for Cricket Mania 
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date),dnis from mis_db.tbl_cricket_calllog 
where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == '544334' || $uu_tf[5] == '5443344')
            $uu_type = "UU_T_6";
        if ($uu_tf[5] == '544337')
            $uu_type = "UU_T_9";
        if ($uu_tf[5] != '544334' && $uu_tf[5] != '544337' && $uu_tf[5] != '5443344')
            $uu_type = "UU_T";

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_type','$uu_tf[1]','0','$uu_tf[2]','','1208','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date),dnis,status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date),dnis,status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == '544334' || $uu_tf[5] == '5443344') {
            if ($uu_tf[6] == 1)
                $uu_type = "L_UU_T_6";
            elseif ($uu_tf[6] != 1)
                $uu_type = "N_UU_T_6";  //$uu_type="UU_T_6";
        }
        if ($uu_tf[5] == '544337') {
            if ($uu_tf[6] == 1)
                $uu_type = "L_UU_T_9";
            elseif ($uu_tf[6] != 1)
                $uu_type = "N_UU_T_9";  //$uu_type="UU_T_9";
        }
        if ($uu_tf[5] != '544334' && $uu_tf[5] != '544337' && $uu_tf[5] != '5443344') {
            if ($uu_tf[6] == 1)
                $uu_type = "L_UU_T";
            elseif ($uu_tf[6] != 1)
                $uu_type = "N_UU_T";  //$uu_type="UU_T";
        }

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$uu_type','$uu_tf[1]','0','$uu_tf[2]','','1208','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for Cricket Mania 
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for REliance MTV
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'RelianceMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis =546461 and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
            values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1203','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'RelianceMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('relm','relc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'RelianceMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('relm','relc') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0]="L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0]="N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1203','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance MTV
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for RelianceMM
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'RelianceMM' as service_name,date(call_date) from mis_db.tbl_musicmania_calllog 
where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
            values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1201','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'RelianceMM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%'  and operator in('relm','relc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'RelianceMM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0]="L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0]="N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1201','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for RelianceMM
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance 54646/////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not like '%P%' and dnis !='546461' and operator in('relm','relc') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance 54646/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert Pause/////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'Pause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1202P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'Pause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1202P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'Pause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('relm','relc') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1202P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'Pause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('relm','relc') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_T";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_T";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1202P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////end code/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For RelianceMS/////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1200','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('relm','relc') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1200','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For RelianceMS/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Cricket Mania /////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == '544334' || $sec_tf[6] == '5443344') {
            $sec_type = "SEC_T_6";
            $callRate = 0.001;
        }
        if ($sec_tf[6] == '544337' || $sec_tf[6] == '5443377') {
            $sec_type = "SEC_T_9";
            $callRate = 0.009;
        }
        if ($sec_tf[6] != '544334' && $sec_tf[6] != '544337' && $sec_tf[6] != '5443377' && $sec_tf[6] != '5443344') {
            $sec_type = "SEC_T";
            $callRate = 0.010;
        }

        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_type','$sec_tf[1]','$callRate','$sec_tf[5]','','1208','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == '544334' || $sec_tf[6] == '5443344') {
            if ($sec_tf[7] == 1)
                $sec_type = "L_SEC_T_6";
            elseif ($sec_tf[7] != 1)
                $sec_type = "N_SEC_T_6";  //$sec_type="SEC_T_6";
        }
        if ($sec_tf[6] == '544337') {
            if ($sec_tf[7] == 1)
                $sec_type = "L_SEC_T_9";
            elseif ($sec_tf[7] != 1)
                $sec_type = "N_SEC_T_9";  //$sec_type="SEC_T_9";
        }
        if ($sec_tf[6] != '544334' && $sec_tf[6] != '544337' && $sec_tf[6] != '5443344') {
            if ($sec_tf[7] == 1)
                $sec_type = "L_SEC_T";
            elseif ($sec_tf[7] != 1)
                $sec_type = "N_SEC_T"; //$sec_type="SEC_T";
        }

        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_type','$sec_tf[1]','0','$sec_tf[5]','','1208','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Cricket Mania /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance MTV/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMTV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1203','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMTV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1203','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance MTV/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Reliance 54646/////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == '5464669' || $sec_t[6] == '5464666' || $sec_t[6] == '5464645') {
            $secType = 'SEC_T_6';
        } else {
            $secType = $sec_t[0];
        }
        $insert_sec_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$secType','$sec_t[1]','0','$sec_t[5]','','1202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}


$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('relm','relc') group by circle,dnis,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == '5464669' || $sec_t[6] == '5464666' || $sec_t[6] == '5464645') {
            if ($sec_t[7] == 1)
                $secType = "L_SEC_T_6";
            elseif ($sec_t[7] != 1)
                $secType = "N_SEC_T_6"; //$secType='SEC_T_6';
        } else {
            if ($sec_t[7] == 1)
                $secType = "L_SEC_T";
            elseif ($sec_t[7] != 1)
                $secType = "N_SEC_T";  //$secType=$sec_t[0];
        }
        $insert_sec_t_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$secType','$sec_t[1]','0','$sec_t[5]','','1202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Reliance 54646/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For RelianceMM/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMM' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1201','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMM' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relm','relc') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1201','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For RelianceMM/////////////////////////////
////////////////////////// start code to insert the Deactivation Base into the MIS database For REliance 54646////////////////////////////////

$get_deactivation_base = "select count(*),circle,status from reliance_hungama.tbl_jbox_unsub 
where date(unsub_date)='$view_date1' and status in(1,11) and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////// End code to insert the Deactivation Base into the MIS database For REliance 54646////////////////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For Cricket Mania ////////////////////////////////

$get_deactivation_base = "select count(*),circle,status from reliance_cricket.tbl_cricket_unsub 
where date(unsub_date)='$view_date1' and status in(1) and dnis not like '%p%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_49";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////// End code to insert the Deactivation Base into the MIS database For Cricket Mania ////////////////////////////////
///////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database For REliance MTV////////////////////////////////

$get_deactivation_base = "select count(*),circle,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' 
and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////////////////////////// End code to insert the Deactivation Base into the MIS database For Reliance MTV/////////////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For relianceMM ////////////////////////////////

$get_deactivation_base = "select count(*),circle,status from reliance_music_mania.tbl_MusicMania_unsub where date(unsub_date)='$view_date1' 
and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_10";
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////// End code to insert the Deactivation Base into the MIS database For relianceMM ////////////////////////////////
///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Reliance 54646//////////////////////////

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure
where date(date_time)='$view_date1' and service_id=1202 and SC not like '%P%' group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,service_id) 
    values('$view_date1', '$faileStr','$circle','$count',1202)";
    $queryIns = mysql_query($insertData, $dbConn);
}

//////////////////////////// END code to insert the Charging Failure into the MIS database for the Reliance 54646//////////////////////////
//////////////////////// Start code to insert the Charging Failure into the MIS database for the Cricket Mania //////////////////////////

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1208 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,service_id) 
    values('$view_date1', '$faileStr','$circle','$count',1208)";
    $queryIns = mysql_query($insertData, $dbConn);
}

///////////////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Cricket Mania //////////////////////////
///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Reliance MTV//////////////////////////

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1203 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,service_id) 
    values('$view_date1', '$faileStr','$circle','$count',1203)";
    $queryIns = mysql_query($insertData, $dbConn);
}

//////////////////////////////////////////////////// Start code to insert the data for call_tf for the service of Reliance Mtv/////////////////////
///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the RelianceMM//////////////////////////

$charging_fail = "select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1201 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,service_id) 
    values('$view_date1', '$faileStr','$circle','$count',1201)";
    $queryIns = mysql_query($insertData, $dbConn);
}

//////////////////////////////////////////////////// Start code to insert the data for call_tf for the service of RelianceMM/////////////////////
//start code to insert the data for RBT_*  
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from reliance_hungama.tbl_pausecodecrbt_reqs 
where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[1] == '')
            $rbt_tf[1] = 'UND';
        elseif (strtoupper($rbt_tf[1]) == 'HAR')
            $rbt_tf[1] = 'HAY';

        if (strtoupper($rbt_tf[2]) == 'CRBT') {
            $insert_rbt_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) 
            values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1202','NA','NA','NA')";
        } elseif (strtoupper($rbt_tf[2]) == 'RNG') {
            $insert_rbt_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) 
            values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1202','NA','NA','NA')";
        }


        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
// end
// to inser the Migration data

$get_migrate_date = "select count(*),circle from reliance_hungama.tbl_pausecodecrbt_resp where DATE(date_time)='$view_date1' and status=1 group by circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($crbt_mode, $count, $circle) = mysql_fetch_array($get_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if ($circle == '')
            $circle = 'NA';

        $insert_data1 = "insert into mis_db.dailyReportReliance(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1202','NA','$count','NA','NA','NA')";

        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}



//RU RT Data start here
//RT- Total Reqs (RT_TT_REQ / RT_PT_REQ / RT_MT_REQ)
$rt_reqs = array();
$rt_query = "select count(*),circle,req_type FROM reliance_music_mania.tbl_crbtrng_reqs_log
where DATE(date_time)='$view_date1' and req_type in ('mt','pt','tt','crbt') group by req_type,circle";

$rt_req_result = mysql_query($rt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rt_req_result);
if ($numRows6 > 0) {
    while ($rt_reqs = mysql_fetch_array($rt_req_result)) {
        if ($rt_reqs[2] == 'tt') {
            $insert_rt_reqs_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_TT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1201','NA','NA','NA')";
        } elseif ($rt_reqs[2] == 'mt') {
            $insert_rt_reqs_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_MT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1201','NA','NA','NA')";
        } elseif ($rt_reqs[2] == 'pt') {
            $insert_rt_reqs_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_PT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1201','NA','NA','NA')";
        } elseif (strtoupper($rt_reqs[2]) == 'CRBT') {
            $insert_rt_reqs_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RBT_*','$rt_reqs[1]','$rt_reqs[0]','0','1201','NA','NA','NA')";
        }
        $queryIns_rt_reqs = mysql_query($insert_rt_reqs_data, $dbConn);
    }
}
/* if (strtoupper($rbt_tf[2]) == 'CRBT') {
  $insert_rbt_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
  values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1202','NA','NA','NA')";
  } */
//RT- Total Success Count (RT_TT_SUC / RT_PT_SUC / RT_MT_SUC)
$rt_succ = array();
$rt_query_succ = "select count(*),circle,req_type FROM reliance_music_mania.tbl_crbtrng_reqs_log
where DATE(date_time)='$view_date1' and req_type in ('mt','pt','tt','crbt') and status=1 group by req_type,circle";

$rt_succ_result = mysql_query($rt_query_succ, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rt_succ_result);
if ($numRows6 > 0) {
    while ($rt_succ = mysql_fetch_array($rt_succ_result)) {
        if ($rt_succ[2] == 'tt') {
            $insert_rt_succ_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_TT_SUC','$rt_succ[1]','$rt_succ[0]','0','1201','NA','NA','NA')";
        } elseif ($rt_succ[2] == 'mt') {
            $insert_rt_succ_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_MT_SUC','$rt_succ[1]','$rt_succ[0]','0','1201','NA','NA','NA')";
        } elseif ($rt_succ[2] == 'pt') {
            $insert_rt_succ_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RT_PT_SUC','$rt_succ[1]','$rt_succ[0]','0','1201','NA','NA','NA')";
        } elseif (strtoupper($rt_succ[2]) == 'CRBT') {
            $insert_rt_succ_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec)
            values('$view_date1', 'RBT_SUCC','$rt_succ[1]','$rt_succ[0]','0','1201','NA','NA','NA')";
        }
        $queryIns_rt_success = mysql_query($insert_rt_succ_data, $dbConn);
    }
}
// ---------- Code end here -------------------


$cur_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//if ($view_date1 == $cur_date) {
if (!$flag) {
    include_once("/var/www/html/kmis/mis/reliance/insertDailyUUser_repeat.php");
}
echo "done";
mysql_close($dbConn);
?>
