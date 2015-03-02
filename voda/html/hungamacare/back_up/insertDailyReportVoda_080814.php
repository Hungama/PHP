<?php

include("dbConnect.php");
$flag = 0;
if (isset($_REQUEST['date'])) {
    $view_date1 = trim($_REQUEST['date']);
    $flag = 1;
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
//echo $view_date1="2014-06-12";
//$flag = 1;

if ($view_date1) {
    $tempDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    if ($view_date1 < $tempDate) {
        $successTable = " master_db.tbl_billing_success_backup";
    } else {
        $successTable = " master_db.tbl_billing_success ";
    }
}

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

if ($flag) {
    $condition = " AND type NOT IN ('UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}
$deleteprevioousdata = "delete from master_db.dailyReportVodafone where date(report_date)='$view_date1'" . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic
//----- pause code array ----------

$pauseArray = array('201' => 'Lava', '202' => 'Lemon', '203' => 'Maxx', '204' => 'Videocon', '205' => 'MVL', '206' => 'Chaze', '207' => 'Intex', '208' => 'iBall', '209' => 'Fly', '210' => 'Karbonn', '211' => 'Hitech', '212' => 'MTech', '213' => 'Rage', '214' => 'Zen', '215' => 'Micromax', '216' => 'Celkon');

$pauseCode = array('1' => 'LG', '2' => 'MW', '3' => 'MJ', '4' => 'CW', '5' => 'JAD');

//---------------------------------

$get_activation_query = "select count(msisdn) from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302,1303,1310,1307,1301) and event_type in('SUB','RESUB','TOPUP')";


$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $get_activation_query12 = "select count(msisdn),circle,chrg_amount,service_id,event_type from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302,1303,1310,1307,1301) and event_type in('SUB','RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,chrg_amount,event_type";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query12)) {
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Start the code to activation Record mode wise 

$get_mode_activation_query1 = "select count(msisdn),circle,service_id,event_type,mode from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302,1303,1310,1307,1301) and event_type in('SUB') and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $event_type, $mode) = mysql_fetch_array($db_query1)) {
        if ($event_type == 'SUB') {
            if ($mode == '121_VAS' || $mode == 'IVR' || $mode == 'IVR-MPMC' || $mode == 'IVR-MTV' || $mode == 'null' || $mode == 'SMS' || $mode == 'SM' || $mode == 'TIVR')
                $mode = 'IVR';
            elseif ($mode == 'TOBD' || $mode == 'push')
                $mode = 'OBD';
            elseif ($mode == 'IVR-9xT' && $service_id == '1302')
                $mode = '9XTIVR';
            elseif ($mode == 'IVR-9xT' && ($service_id == '1310' || $service_id == '1307'))
                $mode = 'IVR';

            $activation_str1 = "Mode_Activation_" . $mode;
            $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
        }
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////
//-----------Pause code start from here --------------------
//---------------------------------

$get_activation_query = "select count(msisdn) from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302) and event_type in('SUB','RESUB','TOPUP') and SC like '%P%'";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    $get_activation_query12 = "select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,SC from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302) and event_type in('SUB','RESUB','TOPUP') and SC like '%P%' group by circle,service_id,chrg_amount,event_type,SC";

    $query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

    while (list($count, $circle, $charging_amt, $service_id, $event_type, $sc) = mysql_fetch_array($query12)) {
        $pCircle = $pauseArray[$circle];
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1302P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1302P','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1302P','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//Start the code to activation Record mode wise 

$get_mode_activation_query1 = "select count(msisdn),substr(SC,9,3) as circle1,service_id,event_type,mode,SC,substr(SC,14,1) as code1 from  " . $successTable . "  where DATE(response_time)='$view_date1' and service_id in(1302) and event_type in('SUB') and SC like '%P%' group by circle,service_id,event_type,mode,SC order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
    while (list($count, $circle, $service_id, $event_type, $mode, $sc, $code) = mysql_fetch_array($db_query1)) {
        $pcircle = $pauseArray[$circle];
        $pauseCodeVal = $pauseCode[$code];

        if ($event_type == 'SUB') {
            if ($mode == '121_VAS' || $mode == 'IVR' || $mode == 'IVR-MPMC' || $mode == 'IVR-MTV' || $mode == 'null' || $mode == 'SMS' || $mode == 'SM' || $mode == 'TIVR')
                $mode = 'IVR';
            elseif ($mode == 'TOBD' || $mode == 'push')
                $mode = 'OBD';
            elseif ($mode == 'IVR-9xT' && $service_id == '1302')
                $mode = '9XTIVR';
            elseif ($mode == 'IVR-9xT' && ($service_id == '1310' || $service_id == '1307'))
                $mode = 'IVR';

            $activation_str1 = "Mode_Activation_" . $pauseCodeVal;
            $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$pcircle','1302P','$count','NA','NA','NA')";
        }
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

//-----------Pause code end here ---------------------------
///////////////////////// start code to insert the Pending Base date into the database Vodafone 54646//////////////////////////////////////
/*
  $get_pending_base="select count(ani),circle from vodafone_hungama.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' and dnis not like '%P%' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1302)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='Vodafone54646' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1302)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_pending_base = "select count(ani),substr(dnis,9,3) as circle1,dnis from vodafone_hungama.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' and dnis like '%P%' group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($pending_base_query)) {
        $pcircle = $pauseArray[$p];
        $insert_pending_base = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pcircle','','$count','NA','NA','NA','1302P')";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

////////////// end code to insert the pending base date into the database Vodafone 54646///////////////////////////////////////
///////////////////////// start code to insert the Pending Base date into the database VodafoneVH1//////////////////////////////////////
/*
  $get_pending_base="select count(ani),circle from vodafone_vh1.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1307)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='VH1Vodafone' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1307)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////// end code to insert the pending base date into the database VodafoneVH1///////////////////////////////////////
///////////////////////// start code to insert the Pending Base date into the database VodafoneMU//////////////////////////////////////

$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='VodafoneMU' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1301)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////// end code to insert the pending base date into the database VodafoneVH1///////////////////////////////////////
///////////////////////// start code to insert the Pending Base date into the database Vodafone RedFM//////////////////////////////////////
/*
  $get_pending_base="select count(ani),circle from vodafone_redfm.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1310)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='RedFMVodafone' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1310)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////// end code to insert the pending base date into the database Vodafone RedFM///////////////////////////////////////
//////////////////////////////////////// start code to insert the active base date into the database Vodafone 54646//////////////////////////////////

/* $get_active_base="select count(*),circle from vodafone_hungama.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' and dnis not like '%P%' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1302)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='Vodafone54646' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1302)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_active_base = "select count(*),substr(dnis,9,3) as circle1,dnis from vodafone_hungama.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($active_base_query)) {
        $pcircle = $pauseArray[$circle];
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$pcircle','NA','$count','NA','NA','NA','NA','NA','1302P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////// end code to insert the active base date into the database Vodafone 54646/////////////////////////////////////
//////////////////////////////////////// start code to insert the active base date into the database Vodafone VH1//////////////////////////////////
/*
  $get_active_base="select count(*),circle from vodafone_vh1.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1307)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='VH1Vodafone' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1307)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// end code to insert the active base date into the database Vodafone VH1/////////////////////////////////////
//////////////////////////////////////// start code to insert the active base date into the database VodafoneMU//////////////////////////////////

$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='VodafoneMU' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1301)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// end code to insert the active base date into the database VodafoneMU/////////////////////////////////////
//////////////////////////////////////// start code to insert the active base date into the database Vodafone RedFM//////////////////////////////////
/*
  $get_active_base="select count(*),circle from vodafone_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1310)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from master_db.tbl_activepending_base where service='RedFMVodafone' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
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
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1310)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// end code to insert the active base date into the database Vodafone RedFM/////////////////////////////////////
///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone 54646////////////////
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if (strtoupper($unsub_reason) == "SELF_REQ" || strtoupper($unsub_reason) == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif (strtoupper($unsub_reason) == "INVOLUNTRY" || $unsub_reason == "LowBalance" || strtoupper($unsub_reason) == "LOWBALANCE")
            $unsub_reason = "in";
        elseif (strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CRM")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "155223_SMS" || strtoupper($unsub_reason) == "SM" || strtoupper($unsub_reason) == "321_SMS")
            $unsub_reason = "SMS";
        elseif (strtoupper($unsub_reason) == "321_USSD")
            $unsub_reason = "USSD";
        elseif (strtoupper($unsub_reason) == "IVR-9xM")
            $unsub_reason = "9XMIVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1302)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_deactivation_base = "select count(*),substr(dnis,9,3) as circle1,unsub_reason,status,substr(dnis,14,1) as code,dnis from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status, $code, $dnis) = mysql_fetch_array($deactivation_base_query)) {
        $pcircle = $pauseArray[$circle];
        $pauseCodeVal = $pauseCode[$code];
        $deactivation_str1 = "Mode_Deactivation_" . $pauseCodeVal;
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pcircle','$count','$unsub_reason','NA','NA','NA','1302P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone 54646///////////////////////
///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone VH1////////////////
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if (strtoupper($unsub_reason) == "SELF_REQ" || strtoupper($unsub_reason) == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif (strtoupper($unsub_reason) == "INVOLUNTRY" || $unsub_reason == "LowBalance" || strtoupper($unsub_reason) == "LOWBALANCE")
            $unsub_reason = "in";
        elseif (strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CRM")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "155223_SMS" || strtoupper($unsub_reason) == "SM" || strtoupper($unsub_reason) == "321_SMS")
            $unsub_reason = "SMS";
        elseif (strtoupper($unsub_reason) == "321_USSD")
            $unsub_reason = "USSD";
        elseif (strtoupper($unsub_reason) == "IVR-9xM")
            $unsub_reason = "9XMIVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1307)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone VH1///////////////////////
///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone VH1////////////////
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from vodafone_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if (strtoupper($unsub_reason) == "SELF_REQ" || strtoupper($unsub_reason) == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif (strtoupper($unsub_reason) == "INVOLUNTRY" || $unsub_reason == "LowBalance" || strtoupper($unsub_reason) == "LOWBALANCE")
            $unsub_reason = "in";
        elseif (strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CRM")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "155223_SMS" || strtoupper($unsub_reason) == "SM" || strtoupper($unsub_reason) == "321_SMS")
            $unsub_reason = "SMS";
        elseif (strtoupper($unsub_reason) == "321_USSD")
            $unsub_reason = "USSD";
        elseif (strtoupper($unsub_reason) == "IVR-9xM")
            $unsub_reason = "9XMIVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1301)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone VH1///////////////////////
///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone RedFM////////////////
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if (strtoupper($unsub_reason) == "SELF_REQ" || strtoupper($unsub_reason) == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif (strtoupper($unsub_reason) == "INVOLUNTRY" || $unsub_reason == "LowBalance" || strtoupper($unsub_reason) == "LOWBALANCE")
            $unsub_reason = "in";
        elseif (strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CRM")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "155223_SMS" || strtoupper($unsub_reason) == "SM" || strtoupper($unsub_reason) == "321_SMS")
            $unsub_reason = "SMS";
        elseif (strtoupper($unsub_reason) == "321_USSD")
            $unsub_reason = "USSD";
        elseif (strtoupper($unsub_reason) == "IVR-9xM")
            $unsub_reason = "9XMIVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1310)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone RedFM///////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////
$get_deactivation_base = "select count(*),circle,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%p%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1302)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone VH1////////////////////////////////
$get_deactivation_base = "select count(*),circle,status from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1307)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone VH1////////////////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For VodafoneMU////////////////////////////////
$get_deactivation_base = "select count(*),circle,status from vodafone_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1301)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone VH1////////////////////////////////
//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone RedFM////////////////////////////////
$get_deactivation_base = "select count(*),circle,status from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1310)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone RedFM////////////////////////////////
///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Vodafone//////////////////////////
$charging_fail = "select count(*),circle,event_type,service_id from master_db.tbl_billing_failure where date(date_time)='$view_date1' and service_id IN (1302,1307,1310,1301) group by circle,event_type,service_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type, $service_id) = mysql_fetch_array($deactivation_base_query)) {
    if ($event_type == 'SUB')
        $faileStr = "FAIL_ACT";
    if ($event_type == 'RESUB')
        $faileStr = "FAIL_REN";
    if ($event_type == 'topup')
        $faileStr = "FAIL_TOP";

    $insertData = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','$service_id')";
    $queryIns = mysql_query($insertData, $dbConn);
}
////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Vodafone 54646//////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// CALL LOG DATA FOR VODAFONE :
//start code to insert the data for call_t 54646
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' 
or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
 and operator in('vodm','voda') and dnis not like '%P%' and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
//end code to insert the data for call_t 54646
/*
  //start code to insert the data for call_t VodafonePoet
  $call_t=array();
  $call_t_query="select 'CALLS_T',circle, count(id),'VodafonePoet' as service_name,date(call_date) from master_db.tbl_voda_calllog
  where date(call_date)='$view_date1' and (dnis like '5464681') and operator in('vodm','voda') and dnis not like '%P%' and status in (0,-1,1,11) group by circle";
  $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($call_t_result);
  if ($numRows12 > 0)
  {
  $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
  while($call_t = mysql_fetch_array($call_t_result))
  {
  $insert_call_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','130202','NA','NA','NA')";
  $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
  }
  }

  //end code to insert the data for call_t VodafonePoet

  //start code to insert the data for call_t VodafoneMND
  $call_t=array();
  $call_t_query="select 'CALLS_T',circle, count(id),'VodafoneMND' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '546468%' and operator in('vodm','voda') and dnis not like '%P%' and status in (0,-1,1,11) group by circle";
  $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($call_t_result);
  if ($numRows12 > 0)
  {
  $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
  while($call_t = mysql_fetch_array($call_t_result))
  {
  $insert_call_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1313','NA','NA','NA')";
  $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
  }
  }
  //end code to insert the data for call_t VodafoneMND
 */
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Vodafone54646' as service_name,date(call_date),status from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and operator in('vodm','voda') and dnis not like '%P%'  and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_T';
        else
            $call_t[0] = 'N_CALLS_T';

        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// Call_Tf for Vodafone 54646
//start code to insert the data for Pause
$call_t = array();
$call_t_query = "select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'pause' as service_name,date(call_date),dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') and status in (0,-1,1,11) group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $p = $call_t[1];
        $pcircle = $pauseArray[$p];
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pcircle','0','$call_t[2]','','1302P','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'Pause' as service_name,date(call_date),status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle,status,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';

        $p = $call_t[1];
        $pcircle = $pauseArray[$p];
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pcircle','0','$call_t[2]','','1302P','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'pause' as service_name,date(call_date),dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') and status in (0,-1,1,11) group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $p = $call_t[1];
        $pcircle = $pauseArray[$p];
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pcircle','0','$call_t[2]','','1302P','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'Pause' as service_name,date(call_date),status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle,status,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_T';
        else
            $call_t[0] = 'N_CALLS_T';

        $p = $call_t[1];
        $pcircle = $pauseArray[$p];
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pcircle','0','$call_t[2]','','1302P','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// Call_Tf for Pause

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm','voda') and dnis not like '%P%'  and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm','voda') and dnis not like '%P%'  and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// end
// CALL LOG DATA FOR VODAFONE :
//start code to insert the data for call_t mtv
$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1303','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1303','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// end
// Call_Tf for Vodafone VH1
$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'VodafoneVH1' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55841' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1307','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'VodafoneVH1' as service_name,date(call_date),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55841' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1307','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// end VH1
// Call_Tf for VodafoneMU
$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'VodafoneMU' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55665' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1301','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'VodafoneMU' as service_name,date(call_date),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55665' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1301','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// end VodafoneMU
// Call_Tf for Vodafone RedFM
$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'RedFM' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55935' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1310','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'RedFM' as service_name,date(call_date),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis='55935' and operator in('vodm','voda')  and status in (0,-1,1,11) group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = 'L_CALLS_TF';
        else
            $call_t[0] = 'N_CALLS_TF';
        $insert_call_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1310','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
// end RedFM
/////////////////////////////////////////   start code to insert the data for mous_t 54646  ///////////////////////////////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' 
or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////   end code to insert the data for mous_t 54646  ///////////////////////////////////////////////////////
/*
  /////////////////////////////////////////   start code to insert the data for mous_t VodafonePoet  ///////////////////////////////////////////////////////
  $mous_t=array();
  $mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'VodafonePoet' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '5464681' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
  $numRows21 = mysql_num_rows($mous_t_result);
  if ($numRows21 > 0)
  {
  $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
  while($mous_t = mysql_fetch_array($mous_t_result))
  {
  $insert_mous_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','130202','$mous_t[5]','NA','NA')";
  $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
  }
  }

  /////////////////////////////////////////   end code to insert the data for mous_t VodafonePoet  ///////////////////////////////////////////////////////

  /////////////////////////////////////////   start code to insert the data for mous_t VodafoneMND  ///////////////////////////////////////////////////////
  $mous_t=array();
  $mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'VodafoneMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '546468' and dnis !='5464681' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
  $numRows21 = mysql_num_rows($mous_t_result);
  if ($numRows21 > 0)
  {
  $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
  while($mous_t = mysql_fetch_array($mous_t_result))
  {
  $insert_mous_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1313','$mous_t[5]','NA','NA')";
  $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
  }
  } */
/////////////////////////////////////////   end code to insert the data for mous_t VodafoneMND  ///////////////////////////////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,
'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_T';
        else
            $mous_t[0] = 'N_MOU_T';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_t Pause code
$mous_t = array();
$mous_t_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'Pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,dnis";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $p = $mous_t[1];
        $pcircle = $pauseArray[$p];
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pcircle','0','$mous_t[5]','','1302P','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'Pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $p = $mous_t[1];
        $pcircle = $pauseArray[$p];
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';

        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pcircle','0','$mous_t[5]','','1302P','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'Pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,dnis";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $p = $mous_t[1];
        $pcircle = $pauseArray[$p];
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pcircle','0','$mous_t[5]','','1302P','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'Pause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $p = $mous_t[1];
        $pcircle = $pauseArray[$p];
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_T';
        else
            $mous_t[0] = 'N_MOU_T';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pcircle','0','$mous_t[5]','','1302P','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end pause
//Start Code for mouse_tf for 54646 Vodafone
$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
//End
//start code to insert the data for mous_t mtv
$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1303','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1303','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_t RedFM
$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'RedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1310','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'RedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1310','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_t VH1
$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'VH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1307','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'VH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1307','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_t VodafoneMU
$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'VodafoneMU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1301','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'VodafoneMU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle,status";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = 'L_MOU_TF';
        else
            $mous_t[0] = 'N_MOU_TF';
        $insert_mous_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1301','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
// end VodafoneMU
/////////////////////////////////////////////start code to insert the data for PULSE_T  54646 //////////////////////////////////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'Vodafone54646' as service_name,date(call_date), 
sum(ceiling((duration_in_sec-10)/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////end code to insert the data for PULSE_T  54646 //////////////////////////////////////////////////////////
/*
  /////////////////////////////////////////////start code to insert the data for PULSE_T  VodafonePoet //////////////////////////////////////////////////////////
  $pulse_t=array();
  $pulse_t_query="select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'VodafonePoet' as service_name,date(call_date), sum(ceiling((duration_in_sec-10)/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '5464681'  and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
  $numRows31 = mysql_num_rows($pulse_t_result);
  if ($numRows31 > 0)
  {
  $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
  while($pulse_t = mysql_fetch_array($pulse_t_result))
  {
  $insert_pulse_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','130202','NA','$pulse_t[5]','NA')";
  $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
  }
  }
  /////////////////////////////////////////////end code to insert the data for PULSE_T  VodafonePoet //////////////////////////////////////////////////////////

  /////////////////////////////////////////////start code to insert the data for PULSE_T  VodafoneMND //////////////////////////////////////////////////////////
  $pulse_t=array();
  $pulse_t_query="select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'VodafoneMND' as service_name,date(call_date),
  sum(ceiling((duration_in_sec-10)/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '546468' and dnis != '5464681' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
  $numRows31 = mysql_num_rows($pulse_t_result);
  if ($numRows31 > 0)
  {
  $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
  while($pulse_t = mysql_fetch_array($pulse_t_result))
  {
  $insert_pulse_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','1313','NA','$pulse_t[5]','NA')";
  $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
  }
  }
 */

/////////////////////////////////////////////end code to insert the data for PULSE_T  VodafoneMND //////////////////////////////////////////////////////////

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'Vodafone54646' as service_name,date(call_date), 
sum(ceiling((duration_in_sec-10)/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_T';
        else
            $pulse_t[0] = 'N_PULSE_T';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//start code to insert the data for PULSE_T  Pause
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $p = $pulse_t[1];
        $pcircle = $pauseArray[$p];

        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pcircle','0','$pulse_t[5]','','1302P','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'pause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,status,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $p = $pulse_t[1];
        $pcircle = $pauseArray[$p];

        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';

        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pcircle','0','$pulse_t[5]','','1302P','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling((duration_in_sec-10)/60)),'pause' as service_name,date(call_date), sum(ceiling((duration_in_sec-10)/60)) as pulse,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $p = $pulse_t[1];
        $pcircle = $pauseArray[$p];

        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pcircle','0','$pulse_t[5]','','1302P','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling((duration_in_sec-10)/60)),'pause' as service_name,date(call_date), sum(ceiling((duration_in_sec-10)/60)) as pulse,status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,status,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $p = $pulse_t[1];
        $pcircle = $pauseArray[$p];

        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_T';
        else
            $pulse_t[0] = 'N_PULSE_T';

        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pcircle','0','$pulse_t[5]','','1302P','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//Start the code for Vodafone 54646 PULSE_TF
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
//end
//start code to insert the data for PULSE_T  mtv
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1303','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1303','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//start code to insert the data for PULSE_T  mtv
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VH1' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1307','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1307','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//start code to insert the data for PULSE_T  VodafoneMU
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VodafoneMU' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1301','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VodafoneMU' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1301','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//start code to insert the data for PULSE_T  mtv
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RedFM' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1310','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RedFM' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = 'L_PULSE_TF';
        else
            $pulse_t[0] = 'N_PULSE_TF';
        $insert_pulse_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1310','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
// end
//////////////////////////////////////////////start code to insert the data for Unique Users for toll  54646 //////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646') and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////end code to insert the data for Unique Users for toll  54646 //////////////////////////////////////////
/*
  //////////////////////////////////////////////start code to insert the data for Unique Users for toll  VodafonePoet //////////////////////////////////////////
  $uu_tf=array();
  $uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'VodafonePoet' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '5464681' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

  $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
  $numRows4 = mysql_num_rows($uu_tf_result);
  if ($numRows4 > 0)
  {
  $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
  while($uu_tf = mysql_fetch_array($uu_tf_result))
  {
  $insert_uu_tf_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','130202','NA','NA','NA')";
  $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
  }
  }
  //////////////////////////////////////////////end code to insert the data for Unique Users for toll  VodafonePoet //////////////////////////////////////////

  //////////////////////////////////////////////start code to insert the data for Unique Users for toll  VodafoneMND //////////////////////////////////////////
  $uu_tf=array();
  $uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'VodafoneMND' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '546468' and dnis !='5464681' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

  $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
  $numRows4 = mysql_num_rows($uu_tf_result);
  if ($numRows4 > 0)
  {
  $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
  while($uu_tf = mysql_fetch_array($uu_tf_result))
  {
  $insert_uu_tf_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1313','NA','NA','NA')";
  $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
  }
  }
  //////////////////////////////////////////////end code to insert the data for Unique Users for toll  VodafoneMND //////////////////////////////////////////
 */
$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not like '%P%' and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id, mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not like '%P%' and dnis !='546461' and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end
//start code to insert the data for Unique Users for pause
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),dnis 
from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') and status in (0,1,-1,11) 
group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pcircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pcircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),dnis 
from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') and status in (0,1,-1,11) 
group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pcircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'pause' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pcircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end for pause
//start code to insert the data for Unique Users for toll mtv
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'VodafoneMTV' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1303','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'VodafoneMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'VodafoneMTV' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone (report_date,type,circle,charging_rate,total_count,mode_of_sub , service_id, mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1303','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end
//start code to insert the data for Unique Users for toll VH1
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'VH1' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1307','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'VH1' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'VodafoneMTV' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone (report_date,type,circle,charging_rate,total_count,mode_of_sub , service_id, mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1307','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end
//start code to insert the data for Unique Users for VodafoneMU
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'VodafoneMU' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1301','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'VodafoneMU' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'VodafoneMU' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone (report_date,type,circle,charging_rate,total_count,mode_of_sub , service_id, mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1301','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end VodafoneMU
//start code to insert the data for Unique Users for toll RedFM
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'RedFM' as service_name,date(call_date) from master_db.tbl_voda_calllog 
where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1310','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'RedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'RedFM' as service_name,date(call_date),status,'Active' as 'user_status' from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone (report_date,type,circle,charging_rate,total_count,mode_of_sub , service_id, mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1310','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

// end
//////////////////////////////////////////////// start code to insert the data for SEC_T 54646 ///////////////////////////////////////////////////
$sec_t = array();
$sec_t_query = "select 'SEC_T',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),
sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
//////////////////////////////////////////////// end code to insert the data for SEC_T 54646 ///////////////////////////////////////////////////
/*
  //////////////////////////////////////////////// start code to insert the data for SEC_T VodafonePoet ///////////////////////////////////////////////////
  $sec_t=array();
  $sec_t_query="select 'SEC_T',circle,sum(duration_in_sec),'VodafonePoet' as service_name,date(call_date),sum(duration_in_sec)
  from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '5464681' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
  $numRows6 = mysql_num_rows($sec_t_result);
  if ($numRows6 > 0)
  {
  $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
  while($sec_t = mysql_fetch_array($sec_t_result))
  {
  $insert_sec_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','130202','NA','NA','NA')";
  $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
  }
  }
  //////////////////////////////////////////////// end code to insert the data for SEC_T VodafonePoet ///////////////////////////////////////////////////

  //////////////////////////////////////////////// start code to insert the data for SEC_T VodafoneMND ///////////////////////////////////////////////////
  $sec_t=array();
  $sec_t_query="select 'SEC_T',circle,sum(duration_in_sec),'VodafoneMND' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1'
  and dnis like '546468'  and dnis !='5464681' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

  $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
  $numRows6 = mysql_num_rows($sec_t_result);
  if ($numRows6 > 0)
  {
  $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
  while($sec_t = mysql_fetch_array($sec_t_result))
  {
  $insert_sec_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1313','NA','NA','NA')";
  $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
  }
  }
 */
//////////////////////////////////////////////// end code to insert the data for SEC_T VodafoneMND ///////////////////////////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_T';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_T';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1302','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end
//Start the code for 54646 Vodafone SEC_TF 
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
//End
//Start the code for 54646 Vodafone SEC_TF Pause
$sec_t = array();
$sec_t_query = "select 'SEC_TF',substr(dnis,9,3) as circle1,sum(duration_in_sec),'Pause' as service_name,date(call_date),sum(duration_in_sec),dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $p = $sec_t[1];
        $pcircle = $pauseArray[$p];
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_t[0]','$pcircle','0','$sec_t[5]','','1302P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',substr(dnis,9,3) as circle1,sum(duration_in_sec),'Pause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $p = $sec_t[1];
        $pcircle = $pauseArray[$p];
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_t[0]','$pcircle','0','$sec_t[5]','','1302P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',substr(dnis,9,3) as circle1,sum(duration_in_sec),'Pause' as service_name,date(call_date),sum(duration_in_sec),dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $p = $sec_t[1];
        $pcircle = $pauseArray[$p];
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_t[0]','$pcircle','0','$sec_t[5]','','1302P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',substr(dnis,9,3) as circle1,sum(duration_in_sec),'Pause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $p = $sec_t[1];
        $pcircle = $pauseArray[$p];
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_T';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_T';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_t[0]','$pcircle','0','$sec_t[5]','','1302P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
//End Pause
//start code to insert the data for SEC_T mtv
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1303','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1303','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end
//start code to insert the data for SEC_T VH1
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'VH1' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1307','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'VH1' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1307','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end
//start code to insert the data for SEC_T VodafoneMU
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'VodafoneMU' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1301','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'VodafoneMU' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55665) and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1301','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end VodafoneMU
//start code to insert the data for SEC_T RedFM
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'RedFM' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1310','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle,sum(duration_in_sec),'RedFM' as service_name,date(call_date),sum(duration_in_sec),status from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(55935) and operator in('vodm','voda') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = 'L_SEC_TF';
        if ($sec_t[6] != 1)
            $sec_t[0] = 'N_SEC_TF';
        $insert_sec_t_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1310','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
// end
////////////////////////////////////////// start code to insert the data for RBT_* ////////////////////////////////////////////////////////////
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type FROM vodafone_hungama.tbl_jbox_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in ('CRBT','RNG') group by req_type,circle";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'crbt') {
            $insert_rbt_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1302','NA','NA','NA')";
        } elseif ($rbt_tf[2] == 'RNG') {
            $insert_rbt_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1302','NA','NA','NA')";
        }
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
////////////////////////////////////////// end code to insert the data for RBT_* ////////////////////////////////////////////////////////////
////////////////////////////////////////// start code to insert VodafoneMU  data for RBT_* ////////////////////////////////////////////////////////////
$rbt_tf = array();
//$rbt_query = "select count(*),circle,req_type FROM vodafone_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in ('CRBT','RNG') group by req_type,circle";
$rbt_query = "select count(*),circle,req_type FROM vodafone_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in ('CRBT','mt','pt','tt','fsd') group by req_type,circle";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'crbt') {
            $insert_rbt_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1301','NA','NA','NA')";
//        } elseif ($rbt_tf[2] == 'RNG') {
        } elseif ($rbt_tf[2] == 'mt' || $rbt_tf[2] == 'pt' || $rbt_tf[2] == 'tt' || $rbt_tf[2] == 'fsd') {
            $insert_rbt_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1301','NA','NA','NA')";
        }
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
////////////////////////////////////////// end code to insert VodafoneMU data for RBT_* 
echo $get_crbgt_succ_data = "select count(1),circle from vodafone_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by circle";

$get_crbt_succ_query = mysql_query($get_crbgt_succ_data, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_crbt_succ_query);
if ($numRows12 > 0) {
    $get_crbt_succ_query = mysql_query($get_crbgt_succ_data, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($get_crbt_succ_query)) { //$crbt_mode
        if ($circle == '')
            $circle = 'UND';
        $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SUCC','$circle','1301','NA','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}

////////////////////////////////////////////////////////////

$get_migrate_date = "select count(1),circle from vodafone_hungama.tbl_jbox_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and responce_code IN ('SUCCESS') group by circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($get_query)) { //$crbt_mode
        if ($circle == '')
            $circle = 'UND';
        /* if($crbt_mode=='ACTIVATE')
          {
          $insert_data1="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1302','NA','$count','NA','NA','NA')";
          }
          elseif($crbt_mode=='MIGRATE')
          {
          $insert_data1="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1302','NA','$count','NA','NA','NA')";
          }
          elseif($crbt_mode=='DOWNLOAD')
          {
          $insert_data1="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1302','NA','$count','NA','NA','NA')";
          }
          elseif($crbt_mode=='DOWNLOAD15')
          {
          $insert_data1="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1302','NA','$count','NA','NA','NA')";
          } */
        $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SUCC','$circle','1302','NA','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}
//---------end -----------
//---------- vodafone CRBT Data ----------------
$get_migrate_date = "select count(1),circle from vodafone_vh1.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' group by circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($get_query)) { //$crbt_mode
        if ($circle == '')
            $circle = 'UND';
        $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_*','$circle','1307','NA','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}


$get_migrate_date = "select count(1),circle from vodafone_vh1.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0) {
    $get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
    while (list($count, $circle) = mysql_fetch_array($get_query)) { //$crbt_mode
        if ($circle == '')
            $circle = 'UND';
        $insert_data1 = "insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SUCC','$circle','1307','NA','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}


//RU RT Data start here
//RT- Total Reqs (RT_TT_REQ / RT_PT_REQ / RT_MT_REQ)
$rt_reqs = array();
$rt_query = "select count(*),circle,req_type FROM vodafone_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in ('mt','pt','tt','fsd') group by req_type,circle";

$rt_req_result = mysql_query($rt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rt_req_result);
if ($numRows6 > 0) {
    while ($rt_reqs = mysql_fetch_array($rt_req_result)) {
        if ($rt_reqs[2] == 'tt') {
            $insert_rt_reqs_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_TT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1301','NA','NA','NA')";
        } elseif ($rt_reqs[2] == 'mt') {
            $insert_rt_reqs_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_MT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1301','NA','NA','NA')";
        } elseif ($rt_reqs[2] == 'pt') {
            $insert_rt_reqs_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_PT_REQ','$rt_reqs[1]','$rt_reqs[0]','0','1301','NA','NA','NA')";
        }
        $queryIns_rt_reqs = mysql_query($insert_rt_reqs_data, $dbConn);
    }
}
//RT- Total Success Count (RT_TT_SUC / RT_PT_SUC / RT_MT_SUC)
$rt_succ = array();
$rt_query_succ = "select count(*),circle,req_type FROM vodafone_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in ('mt','pt','tt','fsd') and status=1 group by req_type,circle";

$rt_succ_result = mysql_query($rt_query_succ, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rt_succ_result);
if ($numRows6 > 0) {
    while ($rt_succ = mysql_fetch_array($rt_succ_result)) {
        if ($rt_succ[2] == 'tt') {
            $insert_rt_succ_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_TT_SUC','$rt_succ[1]','$rt_succ[0]','0','1301','NA','NA','NA')";
        } elseif ($rt_succ[2] == 'mt') {
            $insert_rt_succ_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_MT_SUC','$rt_succ[1]','$rt_succ[0]','0','1301','NA','NA','NA')";
        } elseif ($rt_succ[2] == 'pt') {
            $insert_rt_succ_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_PT_SUC','$rt_succ[1]','$rt_succ[0]','0','1301','NA','NA','NA')";
        }
        $queryIns_rt_success = mysql_query($insert_rt_succ_data, $dbConn);
    }
}
// ---------- Code end here -------------------
if (!$flag) {
    include_once("/var/www/html/hungamacare/insertDailyUUser_repeat.php");
}
echo 'done';
mysql_close($dbConn);
?>
