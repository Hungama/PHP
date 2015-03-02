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
$last_7day_start = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
$last_7day_end = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 8, date("Y")));
//$flag=1;
//echo $view_date1='2013-11-07';

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

if ($flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base') ";
} else {
    $condition = " AND 1";
}
$deleteprevioousdata = "delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in(1601,1602,1603,1605,1608,1609,1610,1611,1600)" . $condition;
;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic
// start the code to insert the data of activation IndicomMtv & IndicomEndless

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1601,1602,1603,1605,1609,1610,1611) and event_type in('RESUB') group by circle,service_id,chrg_amount,event_type"; //'SUB',
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
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
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        /* if($event_type=='SUB')
          {
          $activation_str="Activation_".$charging_amt;
          $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          }
          elseif($event_type=='RESUB')
          {
          $charging_str="Renewal_".$charging_amt;
          $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          }
          /*elseif($event_type=='TOPUP')
          {
          $charging_str="TOP-UP_".$charging_amt;
          $insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          } */
        $charging_str = "Renewal_" . $charging_amt;
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1601,1602,1603,1605,1609,1610,1611) and event_type in('TOPUP') group by circle,service_id,chrg_amount,event_type"; //'SUB',
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
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
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        /* if($event_type=='SUB')
          {
          $activation_str="Activation_".$charging_amt;
          $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          }
          elseif($event_type=='RESUB')
          {
          $charging_str="Renewal_".$charging_amt;
          $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          }
          elseif($event_type=='TOPUP')
          {
          $charging_str="TOP-UP_".$charging_amt;
          $insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
          } */
        $charging_str = "TOP-UP_" . $charging_amt;
        $insert_data = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}


$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1601,1602,1603,1605,1609,1610,1611) and event_type in('SUB') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
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
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $activation_str = "Activation_" . $charging_amt;
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}

// end the code to insert the data of activation IndicomMtv & IndicomEndless
//Start the code to activation Record mode wise

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1601,1602,1603,1605,1609,1610,1611) and event_type in('SUB') group by circle,service_id,mode";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if ($mode == "155223" && $service_id == "1605")
            $mode = "IVR";
        elseif ($mode == "155223")
            $mode == "IVR_155223";
        elseif ($mode == "IVR_52222" && $service_id == "1609")
            $mode = "IBD";
        elseif (strtoupper($mode) == "TOBD" && $service_id == "1601")
            $mode = "OBD";
        elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
            $mode = "IVR";
        elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
            $mode = "OBD";
        elseif (strtoupper($mode) == "NETB")
            $mode = "NET";
        elseif (strtoupper($mode) == "TPCN")
            $mode = "PCN";
        elseif (strtoupper($mode) == "CCI" || strtoupper($mode) == "CCARE")
            $mode = "CC";
        elseif (strtoupper($mode) == "TUSSD")
            $mode = "USSD";
        elseif (strtoupper($mode) == "HUNOBDBONUS")
            $mode = "TOBD";

        if (strtoupper($mode) == "CC" && $service_id == '1601')
            $mode = "CCI";

        $activation_str1 = "Mode_Activation_" . strtoupper($mode);
        $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}

// end the code to activation Record mode wise
//Start the code to EVENT Record mode/charge amount wise

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1609) and event_type in('EVENT') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0) {
    $query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
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
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $activation_str = "EVENT_" . $charging_amt;
        $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data1, $dbConn);
    }
}


$get_mode_activation_query = "select count(msisdn),circle,service_id,mode from " . $successTable . " nolock  where DATE(response_time)='$view_date1' and service_id in(1609) and event_type in('EVENT') group by circle,service_id,mode";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode) = mysql_fetch_array($db_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if ($mode == "155223" && $service_id == "1605")
            $mode = "IVR";
        elseif ($mode == "155223")
            $mode == "IVR_155223";
        elseif ($mode == "IVR_52222" && $service_id == "1609")
            $mode = "IBD";
        elseif (strtoupper($mode) == "TOBD" && $service_id == "1601")
            $mode = "OBD";
        elseif (strtoupper($mode) == "TIVR" || strtoupper($mode) == "IVR_52222" || strtoupper($mode) == "IVR-BOSKEY" || strtoupper($mode) == "IVR1")
            $mode = "IVR";
        elseif (strtoupper($mode) == "OBD-MPMC" || strtoupper($mode) == "OBD197" || strtoupper($mode) == "OBD-BOSKEY")
            $mode = "OBD";
        elseif (strtoupper($mode) == "NETB")
            $mode = "NET";
        elseif (strtoupper($mode) == "TPCN")
            $mode = "PCN";
        elseif (strtoupper($mode) == "CCI" || strtoupper($mode) == "CCARE")
            $mode = "CC";
        elseif (strtoupper($mode) == "TUSSD")
            $mode = "USSD";
        elseif (strtoupper($mode) == "HUNOBDBONUS")
            $mode = "TOBD";

        if (strtoupper($mode) == "CC" && $service_id == '1601')
            $mode = "CCI";

        $activation_str1 = "Mode_EVENT_" . strtoupper($mode);
        $insert_data2 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data2, $dbConn);
    }
}

// end the code to EVENT Record mode/charge amount wise
// start code to insert the Pending Base date into the database IndicomEndless

/* $get_pending_base="select count(ani),circle from indicom_radio.tbl_radio_subscription where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1601)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  }
 */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMXcdma' and status='Pending' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1601)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database IndicomEndless
// start code to insert the Pending Base date into the database Indicom54646 

/* $get_pending_base="select count(ani),circle from indicom_hungama.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1602)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataIndicom54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1602)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database Indicom54646
// start code to insert the Pending Base date into the database IndicomMtv
if (!$flag) {
    $get_pending_base = "select count(ani),circle from indicom_hungama.tbl_mtv_subscription nolock where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

    $numRows12 = mysql_num_rows($pending_base_query);
    if ($numRows12 > 0) {
        while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $insert_pending_base = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1603)";
            $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database IndicomMtv
// start code to insert the Pending Base date into the database IndicomFMJ

/* $get_pending_base="select count(ani),circle from indicom_starclub.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1605)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoFMJcdma' and status='Pending' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1605)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database IndicomFMJ
// start code to insert the Pending Base date into the database Indicom Riya

/* $get_pending_base="select count(ani),circle from indicom_manchala.tbl_riya_subscription where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1609)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMocdma' and status='Pending' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1609)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database Indicom Riya
// start code to insert the Pending Base date into the database Redfm

/* $get_pending_base="select count(ani),circle from indicom_redfm.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1610)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMocdma' and status='Pending' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1610)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database Redfm
// start code to insert the Pending Base date into the database Indicom GL
if (!$flag) {
    $get_pending_base = "select count(ani),circle from indicom_rasoi.tbl_rasoi_subscription nolock where status IN (11,0,5) and date(sub_date)<='$view_date1' group by circle";
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

    $numRows12 = mysql_num_rows($pending_base_query);
    if ($numRows12 > 0) {
        while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $insert_pending_base = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1611)";
            $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
    }
}
// end code to insert the Pending base date into the database Indicom GL
// start code to insert the active base date into the database IndicomEndless
/*
  $get_active_base="select count(*),circle from indicom_radio.tbl_radio_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {	//updated by shashank 02-12-2011 insert_data5
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data5="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1601)";
  $queryIns = mysql_query($insert_data5, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMXcdma' and status='Active' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1601)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomEndless
// start code to insert the active base date into the database Indicom54646

/* $get_active_base="select count(*),circle from indicom_hungama.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  //updated by shashank 02-12-2011 insert_data4
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data4="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1602)";
  $queryIns = mysql_query($insert_data4, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataIndicom54646' and status='Active' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1602)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the active base date into the database Indicom54646
// start code to insert the active base date into the database IndicomMtv
if (!$flag) {
    $get_active_base = "select count(*),circle from indicom_hungama.tbl_mtv_subscription nolock where status=1 and date(sub_date)<='$view_date1' group by circle";
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    $numRows = mysql_num_rows($active_base_query);
    if ($numRows > 0) {
        while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
            //updated by shashank 02-12-2011 insert_data3
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $insert_data3 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1603)";
            $queryIns = mysql_query($insert_data3, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomMtv
// start code to insert the active base date into the database IndicomFMJ
/*
  $get_active_base="select count(*),circle from indicom_starclub.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data6="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1605)";
  $queryIns = mysql_query($insert_data6, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoFMJcdma' and status='Active' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1605)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomFMJ
// start code to insert the active base date into the database Indicom MIss Riya
/*
  $get_active_base="select count(*),circle from indicom_manchala.tbl_riya_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data6="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1609)";
  $queryIns = mysql_query($insert_data6, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMocdma' and status='Active' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1609)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomFMJ
// start code to insert the active base date into the database Indicom RedFM
/*
  $get_active_base="select count(*),circle from indicom_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle=='') $circle='UND';
  elseif(strtoupper($circle)=='HAR') $circle='HAY';
  $insert_data6="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1610)";
  $queryIns = mysql_query($insert_data6, $dbConn);
  }
  } */
if (!$flag) {
    $getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMocdma' and status='Active' and date(date)='$view_date1' group by circle";
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
            $insert_data = "insert into mis_db.daily_report (report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1610)";
            $queryIns = mysql_query($insert_data, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomRedFM
// start code to insert the active base date into the database Indicom GL
if (!$flag) {
    $get_active_base = "select count(*),circle from indicom_rasoi.tbl_rasoi_subscription nolock where status=1 and date(sub_date)<='$view_date1' group by circle";
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    $numRows = mysql_num_rows($active_base_query);
    if ($numRows > 0) {
        while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
            if ($circle == '')
                $circle = 'UND';
            elseif (strtoupper($circle) == 'HAR')
                $circle = 'HAY';
            $insert_data6 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1611)";
            $queryIns = mysql_query($insert_data6, $dbConn);
        }
    }
}
// end code to insert the active base date into the database IndicomGL
// start code to insert the Deactivation Base into the MIS database IndicomEndless

$get_deactivation_base = "select count(*),circle from indicom_radio.tbl_radio_unsub nolock where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data9 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1601)";
        $queryIns = mysql_query($insert_data9, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomEndless
// start code to insert the Deactivation Base into the MIS database Indicom54646

$get_deactivation_base = "select count(*),circle from indicom_hungama.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data8 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1602)";
        $queryIns = mysql_query($insert_data8, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database Indicom54646
// start code to insert the Deactivation Base into the MIS database IndicomMtv

$get_deactivation_base = "select count(*),circle from indicom_hungama.tbl_mtv_unsub nolock where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        //updated by shashank 02-12-2011 insert_data7
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data7 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1603)";
        $queryIns = mysql_query($insert_data7, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomMtv
// start code to insert the Deactivation Base into the MIS database IndicomFMJ

$get_deactivation_base = "select count(*),circle from indicom_starclub.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {   //updated by shashank 02-12-2011 insert_data10
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data10 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1605)";
        $queryIns = mysql_query($insert_data10, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomFMJ
// start code to insert the Deactivation Base into the MIS database Indicom Miss Riya

$get_deactivation_base = "select count(*),circle,unsub_reason from indicom_manchala.tbl_riya_unsub nolock where date(unsub_date)='$view_date1' and status=1 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";

        if ($unsub_reason == "155223")
            $unsub_reason = "155223";
        elseif (strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data10 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','NA','$count','NA','NA','NA','NA',1609)";
        $queryIns = mysql_query($insert_data10, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database Indicom Miss Riya
// start code to insert the Deactivation Base into the MIS database Indicom Miss Riya

$get_deactivation_base = "select count(*),circle from indicom_manchala.tbl_riya_unsub nolock where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data10 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1609)";
        $queryIns = mysql_query($insert_data10, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database Indicom Miss Riya
// start code to insert the Deactivation Base into the MIS database IndicomRedFM

$get_deactivation_base = "select count(*),circle from indicom_redfm.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' and status in(1,11,0,5)group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data10 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1610)";
        $queryIns = mysql_query($insert_data10, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database IndicomRedFM
// start code to insert the Deactivation Base into the MIS database IndicomGL
$get_deactivation_base = "select count(*),circle from indicom_rasoi.tbl_rasoi_unsub nolock where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';
        $insert_data10 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1611)";
        $queryIns = mysql_query($insert_data10, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database IndicomGL
// start code to insert the Deactivation Base into the MIS database IndicomEndless
$get_deactivation_base = "select count(*),circle,unsub_reason from indicom_radio.tbl_radio_unsub nolock where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "IVR_155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CCI";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $insert_data13 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1601)";
        $queryIns = mysql_query($insert_data13, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomEndless
// start code to insert the Deactivation Base into the MIS database Indicom54646

$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_hungama.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "IVR_155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason; //updated by shashank 02-12-2011 insert_data12

        $insert_data12 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1602)";
        $queryIns = mysql_query($insert_data12, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database  Indicom54646
// start code to insert the Deactivation Base into the MIS database IndicomMtv

$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_hungama.tbl_mtv_unsub nolock where date(unsub_date)='$view_date1' group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "IVR_155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        //updated by shashank 02-12-2011 insert_data11		
        $insert_data11 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1603)";
        $queryIns = mysql_query($insert_data11, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database  IndicomMtv
// start code to insert the Deactivation Base into the MIS database IndicomFMJ

$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_starclub.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ" || strtoupper($unsub_reason) == "SELF_REQS" || $unsub_reason == "155223")
            $unsub_reason = "IVR";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        //updated by shashank 02-12-2011 insert_data14
        $insert_data14 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1605)";
        $queryIns = mysql_query($insert_data14, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomFMJ
// start code to insert the Deactivation Base into the MIS database Indicom MIss Riya

$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_manchala.tbl_riya_unsub nolock where date(unsub_date)='$view_date1' and status in(11) group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $insert_data14 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1609)";
        $queryIns = mysql_query($insert_data14, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database Indicom Miss Riya
// start code to insert the Deactivation Base into the MIS database IndicomRedFM

$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_redfm.tbl_jbox_unsub nolock where date(unsub_date)='$view_date1' and status in(11,1,0,5) group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "IVR_155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $insert_data14 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1610)";
        $queryIns = mysql_query($insert_data14, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database IndicomRedFM
// start code to insert the Deactivation Base into the MIS database IndicomGL
$get_deactivation_base = "select count(*),circle,unsub_reason,unsub_reason from indicom_rasoi.tbl_rasoi_unsub nolock where date(unsub_date)='$view_date1' and status in(11) group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == '')
            $circle = 'UND';
        elseif (strtoupper($circle) == 'HAR')
            $circle = 'HAY';

        if (strtoupper($unsub_reason) == "SELF_REQ")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223")
            $unsub_reason = "IVR_155223";
        elseif (strtoupper($unsub_reason) == "CC" || strtoupper($unsub_reason) == "CCI" || strtoupper($unsub_reason) == "CCARE")
            $unsub_reason = "CC";
        elseif (strtoupper($unsub_reason) == "CHURN" || strtoupper($unsub_reason) == "SYSTEM" || strtoupper($unsub_reason) == "WDSCHURN" || strtoupper($unsub_reason) == "LOWBALANCE" || strtoupper($unsub_reason) == "IMIADMIN")
            $unsub_reason = "in";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $insert_data14 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1611)";
        $queryIns = mysql_query($insert_data14, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database IndicomGL
////////////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) nolock from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1601','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data1, $dbConn);
    }
}
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1601','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data1, $dbConn);
    }
}
/////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////start code to insert the data for call_tf Indicom 54646
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Indicom54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in ('546461','5464626') and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1602','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Indicom54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in ('546461','5464626') and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1602','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}
///////////////////////////////////End code to insert the data for call_tf Indicom 54646///////////////////////////////////////
///////////////////////////////////////////////////////////////start code to insert the data for call_tf IndicomMS
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1600','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomMS' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1600','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}
///////////////////////////////////End code to insert the data for call_tf IndicomMS///////////////////////////////////////
///////////////////////////////////////////////////////////////start code to insert the data for call_tf Indicom Miss Riya
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomMissRiya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1609','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomMissRiya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1609','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data2, $dbConn);
    }
}
//////////////////////////////////////End code to insert the data for call_tf Indicom Indicom Miss Riya///////////////////////////////////////
////////////////////////////////////start code to insert the data for call_tf Cricket Mania //////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data3 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1608','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data3, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'RelianceCricket' as service_name,date(call_date),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data3 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1608','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data3, $dbConn);
    }
}
////////////////////////////////////////End code to insert the data for call_tf Cricket Mania///////////////////////////////////////
///////////////////////////////////////Start code to insert the data for call_tf REliance MTV///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1603','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Reliance Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1603','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

////////////////////////////////////////////////////// end code to insert the data for call_tf for the service of Reliance Mtv/////////////////////////
///////////////////////////////////////////////////////////////Start code to insert the data for call_tf FMJ///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'FMJ' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1605','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'FMJ' as service_name,date(call_date),status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1605','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

////////////////////////////////////////////////////// end code to insert the data for call_tf for the service of FMJ/////////////////////////
///////////////////////////////////////////////////////////////Start code to insert the data for call_tf IndicomRedFM///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1610','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1610','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}
////////////////////////////////////////////////////// end code to insert the data for call_tf for the service of IndicomRedFM/////////////////////////
///////////////////////////////////////////////////////////////Start code to insert the data for call_tf IndicomGL///////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1611','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'IndicomGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data4 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1611','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data4, $dbConn);
    }
}
////////////////////////////////////////////////////// end code to insert the data for call_tf for the service of IndicomGL/////////////////////////
///////////////////////////////////////////////////start code to insert the data for call_t Reliance 54646/////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        $insert_call_t_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1602','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data1, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_tf[1] == '')
            $call_tf[1] = 'UND';
        elseif (strtoupper($call_tf[1]) == 'HAR')
            $call_tf[1] = 'HAY';
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1602','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data1, $dbConn);
    }
}
////////////////////////////////////////////////////////////////END code to insert the data for call_t Reliance 54646/////////////////////////////////////
///////////////////////////////////////////////////start code to insert the data for call_t Reliance 54646/////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        if ($call_t[5] == 5464669)
            $call_t[0] = 'CALLS_T';
        else
            $call_t[0] = 'CALLS_T_1';
        $insert_call_t_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1609','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data1, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        if ($call_t[5] == 5464669) {
            if ($call_t[6] == 1)
                $call_t[0] = "L_CALLS_T";
            elseif ($call_t[6] != 1)
                $call_t[0] = "N_CALLS_T"; //	$call_t[0]='CALLS_T';
        } else {
            if ($call_t[6] == 1)
                $call_t[0] = "L_CALLS_T_1";
            elseif ($call_t[6] != 1)
                $call_t[0] = "N_CALLS_T_1"; //$call_t[0]='CALLS_T_1';
        }
        $insert_call_t_data1 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1609','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data1, $dbConn);
    }
}
//////////////////////////////////////////////////END code to insert the data for call_t Tata Indicom Miss Riya/////////////////////////////////////
///////////////////////////////////////////start code to insert the data for call_t Cricket Mania/////////////////////////////////

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        $insert_call_t_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1608','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data2, $dbConn);
    }
}


$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        if ($call_t[6] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[6] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1608','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data2, $dbConn);
    }
}
////////////////////////////////////////////////////////////////END code to insert the data for call_t Cricket Mania/////////////////////////////////////
///////////////////////////////////////////start code to insert the data for call_t Cricket Mania/////////////////////////////////

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'indicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        $insert_call_t_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1611','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data2, $dbConn);
    }
}


$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'indicomGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[1] == '')
            $call_t[1] = 'UND';
        elseif (strtoupper($call_t[1]) == 'HAR')
            $call_t[1] = 'HAY';
        if ($call_t[6] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[6] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data2 = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1611','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data2, $dbConn);
    }
}

////////////////////////////////////////////////////////////////END code to insert the data for call_t Cricket Mania/////////////////////////////////////
//start code to insert the data for mous_tf for tata Indicom Endless
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1601','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1601','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

// end
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Indicom 54646////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1602','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1602','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf IndicomMS////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'IndicomMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1600','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'IndicomMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1600','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf IndicomMS////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Indicom Miss Riya////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1609','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1609','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf Miss Riya////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Cricket Mania////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1608','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1608','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf Cricket Mania////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Reliance MTV////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'relianceMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1603','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'relianceMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1603','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance MTV////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf FMJ ////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'FMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1605','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'FMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1605','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf FMJ////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf indicomRedFM ////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'indicomRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1610','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'indicomRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1610','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf indicomRedFM////////////////////////////
/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf indicomGL ////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'indicomGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1611','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'indicomGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1611','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf indicomGL////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t REliance 54646////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1602','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_tf[1] == '')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        elseif ($mous_t[6] != 1)
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1602','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t REliance 54646////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        if ($mous_t[6] == 5464669)
            $mous_t[0] = 'MOU_T';
        else
            $mous_t[0] = 'MOU_T_1';
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1609','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}


$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        if ($mous_t[6] == 5464669) {
            if ($mous_t[7] == 1)
                $mous_t[0] = "L_MOU_T";
            elseif ($mous_t[7] != 1)
                $mous_t[0] = "N_MOU_T";  //$mous_t[0]='MOU_T';
        } else {
            if ($mous_t[7] == 1)
                $mous_t[0] = "L_MOU_T_1";
            elseif ($mous_t[7] != 1)
                $mous_t[0] = "N_MOU_T_1";  //$mous_t[0]='MOU_T_1';
        }
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1609','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t Cricket Mania////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1608','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        elseif ($mous_t[6] != 1)
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1608','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Cricket Mania////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t IndicomGL////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1611','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[1] == '')
            $mous_t[1] = 'UND';
        elseif (strtoupper($mous_t[1]) == 'HAR')
            $mous_t[1] = 'HAY';
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        elseif ($mous_t[6] != 1)
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1611','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t IndicomGL////////////////////////////
/////////////////////////////////start code to insert the data for PULSE_TF for the Tata Indicom Endless SErvice/////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1601','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse, status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle, status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1601','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF REliance 54646////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1602','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}


$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1602','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF IndicomMS////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'IndicomMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1600','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}


$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'IndicomMS' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1600','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF IndicomMS ////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF REliance MISS Riya////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1609','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1609','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Cricket Mania ////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RelianceCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1608','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RelianceCricket' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1608','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF Cricket Mania ////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Reliance MTV////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1603','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMTV' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1603','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance MTV////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF FMJ////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'FMJ' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1605','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'FMJ' as service_name,date(call_date),status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1605','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF FMJ////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF IndicomRedFM////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1610','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1610','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF IndicomRedFM////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF IndicomGL////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1611','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[1] == '')
            $pulse_tf[1] = 'UND';
        elseif (strtoupper($pulse_tf[1]) == 'HAR')
            $pulse_tf[1] = 'HAY';
        if ($pulse_tf[5] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[5] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1611','NA','$pulse_tf[2]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF IndicomGL////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T REliance 54646////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[2]','','1602','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        if ($pulse_t[5] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[5] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1602','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T REliance 54646////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        if ($pulse_t[5] == 5464669)
            $pulse_t[0] = 'PULSE_T';
        else
            $pulse_t[0] = 'PULSE_T_1';
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[2]','','1609','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}


$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        if ($pulse_t[5] == 5464669) {
            if ($pulse_t[6] == 1)
                $pulse_t[0] = "L_PULSE_T";
            elseif ($pulse_t[6] != 1)
                $pulse_t[0] = "N_PULSE_T";  //$pulse_t[0]='PULSE_T';
        } else {
            if ($pulse_t[6] == 1)
                $pulse_t[0] = "L_PULSE_T_1";
            elseif ($pulse_t[6] != 1)
                $pulse_t[0] = "N_PULSE_T_1";  //$pulse_t[0]='PULSE_T_1';
        }
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1609','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T Cricket Mania ////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1608','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceCricket' as service_name,date(call_date),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        if ($pulse_t[5] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[5] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1608','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T Cricket Mania////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T IndicomGL ////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1611','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'IndicomGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[1] == '')
            $pulse_t[1] = 'UND';
        elseif (strtoupper($pulse_t[1]) == 'HAR')
            $pulse_t[1] = 'HAY';
        if ($pulse_t[5] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[5] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1611','NA','$pulse_t[2]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T IndicomGL////////////////////////////
/////////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog
where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc')  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1601','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1601','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '59090%' and operator in('TATC','tatc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATC','tatc') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1601','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATC','tatc') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '59090%' and operator in('TATC','tatc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATC','tatc') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1601','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for Indicom 54646
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicom54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicom54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicom54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'indicom54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'indicom54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T";
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicom54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') 
and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') 
and operator in('TATC')  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicom54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') 
and operator in('TATC')  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') 
and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('546461','5464626','5464669','5464668') 
and operator in('TATC')  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1602','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance 54646
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for Indicom 54646
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicomMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1600','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicomMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicomMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1600','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicomMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '5464630%' and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1600','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicomMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '5464630%' and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('TATC')  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1600','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for IndicomMS///
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for  Tata Indicom Miss Riya
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicomRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog
where date(call_date)='$view_date1' and dnis =5464626 and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicomRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =5464626 and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =5464626 and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicomRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =5464626 and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == '5464669') {
            $uu_tf[0] = 'UU_T';
        } elseif ($uu_tf[5] == '5464668') {
            $uu_tf[0] = 'UU_T_1';
        }
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'indicomRia' as service_name,date(call_date),dnis,status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'indicomRia' as service_name,date(call_date),dnis,status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') and status=1 group by circle,dnis)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == '5464669') {
            if ($uu_tf[6] == 1)
                $uu_tf[0] = "L_UU_T";
            elseif ($uu_tf[6] != 1)
                $uu_tf[0] = "N_UU_T"; //$uu_tf[0]='UU_T';
        } elseif ($uu_tf[5] == '5464668') {
            if ($uu_tf[6] == 1)
                $uu_tf[0] = "L_UU_T_1";
            elseif ($uu_tf[6] != 1)
                $uu_tf[0] = "N_UU_T_1";  //$uu_tf[0]='UU_T_1';
        }
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicomRia' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in('5464669','5464668','5464626') and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in('5464669','5464668','5464626') and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicomRia' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and dnis in('5464669','5464668','5464626') and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in('5464669','5464668','5464626') and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in('5464669','5464668','5464626') and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1609','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for Tata Indicom Miss Riya
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for Cricket Mania 
//$uu_tf = array();
//$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicomCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog 
//where date(call_date)='$view_date1' and dnis in(54433) and operator in('TATC') group by circle";
//
//$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_tf_result);
//if ($numRows4 > 0) {
//    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
//        if ($uu_tf[1] == '')
//            $uu_tf[1] = 'UND';
//        elseif (strtoupper($uu_tf[1]) == 'HAR')
//            $uu_tf[1] = 'HAY';
//        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
//        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1608','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
//    }
//}
//
//$uu_tf = array();
//$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicomCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis =54433 and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis =54433 and operator in('TATC') and status IN (1)) group by circle)";
//$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicomCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis =54433 and operator in('TATC') and status=1 group by circle)";
//
//$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_tf_result);
//if ($numRows4 > 0) {
//    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
//        if ($uu_tf[1] == '')
//            $uu_tf[1] = 'UND';
//        elseif (strtoupper($uu_tf[1]) == 'HAR')
//            $uu_tf[1] = 'HAY';
//        if ($uu_tf[6] == 'Non Active')
//            $uu_tf[0] = 'N_UU_TF';
//        if ($uu_tf[6] == 'Active')
//            $uu_tf[0] = 'L_UU_TF';
//
//        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
//        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1608','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
//    }
//}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog 
where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1608','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'indicomCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'indicomCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,546468) and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T";
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1608','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicomCricket' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in(54433,546468) and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54433,546468) and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1608','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicomCricket' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item  where date(item.call_date)='$view_date1' 
and dnis in(54433,546468) and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in(54433,546468) and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54433,546468) and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1608','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for Cricket Mania 
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for REliance MTV
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicomMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis =546461 and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1603','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicomMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicomMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1603','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicomMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =546461 and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =546461 and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1603','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicomMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item  where date(item.call_date)='$view_date1' 
and dnis =546461 and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =546461 and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =546461 and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1603','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance MTV
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for FMJ
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'indicomFMJ' as service_name,date(call_date) from mis_db.tbl_starclub_calllog 
where date(call_date)='$view_date1' and dnis =56666 and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1605','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'indicomFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis =56666 and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis =56666 and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'indicomFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis =56666 and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1605','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'indicomFMJ' as service_name,date(item.call_date)
from mis_db.tbl_starclub_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_starclub_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =56666 and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =56666 and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1605','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'indicomFMJ' as service_name,date(item.call_date)
from mis_db.tbl_starclub_calllog item  where date(item.call_date)='$view_date1' 
and dnis =56666 and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_starclub_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_starclub_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =56666 and operator in('TATC') )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =56666 and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1605','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for FMJ
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for IndicomRedFM
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'IndicomRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog 
where date(call_date)='$view_date1' and dnis =55935 and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1610','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'IndicomRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis =55935 and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis =55935 and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'IndicomRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis =55935 and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1610','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'IndicomRedFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =55935 and operator in('TATC'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =55935 and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1610','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'IndicomRedFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item  where date(item.call_date)='$view_date1' 
and dnis =55935 and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis =55935 and operator in('TATC'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis =55935 and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1610','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////////////////////////////End code to insert the data for Unique Users  for toll free for IndicomRedFM///////////
///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for IndicomRedFM
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog 
where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog 
where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'IndicomGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('TATC') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T";
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'IndicomGL' as service_name,date(item.call_date)
from mis_db.tbl_rasoi_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rasoi_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '55001%'  and operator in('TATC'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55001%'  and operator in('TATC') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'IndicomGL' as service_name,date(item.call_date)
from mis_db.tbl_rasoi_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '55001%'  and operator in('TATC') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_rasoi_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rasoi_calllog where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '55001%'  and operator in('TATC'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55001%'  and operator in('TATC') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1611','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////////////////////////////End code to insert the data for Unique Users  for toll free for IndicomGL///////////
//////////////////////////////start code to insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1601','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1601','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo Endless 
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance 54646/////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1602','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1602','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance 54646/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For IndicomMS/////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1600','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1600','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For IndicomMS /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Indidcom Miss Riya/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Indicom Miss Riya' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1609','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Indicom Miss Riya' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1609','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Indidcom Miss Riya/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Cricket Mania /////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1608','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1608','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Cricket Mania /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance MTV/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMTV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1603','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'RelianceMTV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1603','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance MTV/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For FMJ/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'FMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1605','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'FMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1605','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For FMJ /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For IndicomRedFM/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1610','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1610','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For IndicomRedFM /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For IndicomGL/////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1611','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1611','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For IndicomGL /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Reliance 54646/////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1602','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1602','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Reliance 54646/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Reliance 54646/////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        if ($sec_t[6] == 5464669)
            $sec_t[0] = 'SEC_T';
        else
            $sec_t[0] = 'SEC_T_1';
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1609','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        if ($sec_t[6] == 5464669) {
            if ($sec_t[7] == 1)
                $sec_t[0] = "L_SEC_T";
            elseif ($sec_t[7] != 1)
                $sec_t[0] = "N_SEC_T"; //$sec_t[0]='SEC_T';
        } else {
            if ($sec_t[7] == 1)
                $sec_t[0] = "L_SEC_T_1";
            elseif ($sec_t[7] != 1)
                $sec_t[0] = "N_SEC_T_1"; //$sec_t[0]='SEC_T_1';
        }
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1609','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Reliance 54646/////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Cricket Mania /////////////////////////////
$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1608','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1608','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Cricket Mania /////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For IndicomGL /////////////////////////////

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1611','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'IndicomGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('TATC') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[1] == '')
            $sec_t[1] = 'UND';
        elseif (strtoupper($sec_t[1]) == 'HAR')
            $sec_t[1] = 'HAY';
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1611','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////End code to insert the data for SEC_T For IndicomGL /////////////////////////////
///////////////////////// start code to insert the Deactivation Base into the MIS database For REliance 54646////////////////////////
///////////////////////////////////////////////////// RBT DATA FOR TataDoCoMoMXcdma ////////////////////////////////////////////////////////
//start code to insert the data for RBT_*  
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from indicom_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[1] == '')
            $rbt_tf[1] = 'UND';
        elseif (strtoupper($rbt_tf[1]) == 'HAR')
            $rbt_tf[1] = 'HAY';
        if (strtoupper($rbt_tf[2]) == 'CRBT') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1601','NA','NA','NA')";
        } elseif (strtoupper($rbt_tf[2]) == 'RNG') {
            $insert_rbt_tf_data = "insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1601','NA','NA','NA')";
        }


        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
// end
// to inser the Migration data

$get_migrate_date = "select crbt_mode,count(1),circle from indicom_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and (responce_code like '00%' or responce_code ='99') group by crbt_mode,circle";

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
        if ($crbt_mode == 'ACTIVATE') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1601','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'MIGRATE') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1601','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1601','NA','$count','NA','NA','NA')";
        } elseif ($crbt_mode == 'DOWNLOAD15') {
            $insert_data1 = "insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1601','NA','$count','NA','NA','NA')";
        }

        $queryIns1 = mysql_query($insert_data1, $dbConn);
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConn);
echo "done";
?>
