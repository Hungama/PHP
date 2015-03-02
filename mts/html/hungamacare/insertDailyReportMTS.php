<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");


// delete the prevoius record
echo $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//////////////////////////////// Start delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
//echo $view_date1="2012-07-07";


$deleteprevioousdata = "delete from mis_db.mtsDailyReport where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
///////////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646/////////
// remove the 1005 FMJ id from this query : show wid 
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1101,1102,1103,1111,1110) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type) = mysql_fetch_array($query)) {
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            if ($service_id == 1106)
                $activation_str = "Activation_Ticket_" . $charging_amt;

            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;

            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1101,1102,1103,1111,1110) and event_type in('SUB') group by circle,service_id,mode";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode) = mysql_fetch_array($db_query)) {
        $activation_str1 = "Mode_Activation_" . $mode;
        if ($service_id == 1106)
            $activation_str1 = "Mode_Activation_Ticket_" . $mode;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Start the code to Renewal Record mode wise ////////////////////////////////////////////////////////

$get_mode_renewal_query = "select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1101,1102,1103,1111,1110) and event_type='RESUB' group by circle,service_id,mode order by mode";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $mode) = mysql_fetch_array($db_query1)) {
        $renewal_str = "Mode_Renewal_" . $mode;
        $renewal_str1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($renewal_str1, $dbConn);
    }
}


///////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid //////////////////////////////////////////////////

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query)) {
        if ($event_type == 'SUB') {
            $activation_str = "Activation_" . $charging_amt;
            if ($plan_id == 11)
                $activation_str = "Activation_Ticket_20"; //.$charging_amt;
            if ($plan_id == 12)
                $activation_str = "Activation_Ticket_15"; //.$charging_amt;
            if ($plan_id == 13)
                $activation_str = "Activation_Ticket_10"; //.$charging_amt;
            if ($plan_id == 19)
                $activation_str = "Activation_Ticket_5"; //.$charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'RESUB') {
            $activation_str = "Renewal_" . $charging_amt;
            if ($plan_id == 11)
                $activation_str = "Renewal_Ticket_20"; //.$charging_amt;
            if ($plan_id == 12)
                $activation_str = "Renewal_Ticket_15"; //.$charging_amt;
            if ($plan_id == 13)
                $activation_str = "Renewal_Ticket_10"; //.$charging_amt;
            if ($plan_id == 19)
                $activation_str = "Renewal_Ticket_5"; //.$charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }
        elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
//////////////////////////////////Start the code to activation Record mode wise ///////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB') group by circle,service_id,mode,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query)) {
        $activation_str1 = "Mode_Activation_" . $mode;
        if ($plan_id == 11)
            $activation_str1 = "Mode_Activation_Ticket_20_" . $mode; //.$charging_amt;
        if ($plan_id == 12)
            $activation_str1 = "Mode_Activation_Ticket_15_" . $mode; //.$charging_amt;
        if ($plan_id == 13)
            $activation_str1 = "Mode_Activation_Ticket_10_" . $mode; //.$charging_amt;
        if ($plan_id == 19)
            $activation_str1 = "Mode_Activation_Ticket_5_" . $mode; //.$charging_amt;
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Start the code to Renewal Record mode wise ///////////////////////////////////////////////////////

$get_mode_renewal_query = "select count(msisdn),circle,service_id,mode,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1106) and event_type='RESUB' group by circle,service_id,mode,plan_id order by mode";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query1)) {
        $activation_str1 = "Mode_Renewal_" . $mode;
        if ($plan_id == 11)
            $activation_str1 = "Mode_Renewal_Ticket_20_" . $mode; //.$charging_amt;
        if ($plan_id == 12)
            $activation_str1 = "Mode_Renewal_Ticket_15_" . $mode; //.$charging_amt;
        if ($plan_id == 13)
            $activation_str1 = "Mode_Renewal_Ticket_10_" . $mode; //.$charging_amt;
        if ($plan_id == 19)
            $activation_str1 = "Mode_Renewal_Ticket_5_" . $mode; //.$charging_amt;
        $renewal_str1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($renewal_str1, $dbConn);
    }
}


///////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS  Music UNLIMITED///////////////////////////////////

$get_pending_base = "select count(ani),circle from mts_radio.tbl_radio_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1101)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MUSIC UNLIMITED////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS 54646 Music///////////////////////////////////

$get_pending_base = "select count(ani),circle from mts_hungama.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1102)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////

$get_pending_base = "select count(ani),circle from mts_mtv.tbl_mtv_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1103)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTS Starclub//////////////////////////////////////////

$get_pending_base = "select count(ani),circle from mts_starclub.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1106)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTS-devotional //////////////////////////////////////////

$get_pending_base = "select count(ani),circle from dm_radio.tbl_digi_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1111)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTS-Devotional //////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTSRedFM //////////////////////////////////////////

$get_pending_base = "select count(ani),circle from mts_redfm.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle) = mysql_fetch_array($pending_base_query)) {
        $insert_pending_base = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1110)";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTSRedFM /////////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database Docomo  Music Unlimited////////////////////////////////////

$get_active_base = "select count(*),circle from mts_radio.tbl_radio_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database Docomo Endless Music//////////////////////////////////

$get_active_base = "select count(*),circle from mts_hungama.tbl_jbox_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////
////////////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base = "select count(*),circle from mts_mtv.tbl_mtv_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////
////////////////// start code to insert the active base date into the database Starclub///////////////////////////////////////////////////

$get_active_base = "select count(*),circle from mts_starclub.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music////////////////////////////////
///////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base = "select count(*),circle from dm_radio.tbl_digi_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database MTS-Devotional ///////////////////////////////////////////////
///////// start code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////////

$get_active_base = "select count(*),circle from mts_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($active_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo Music Unlimited//////////////////////

$get_deactivation_base = "select count(*),circle from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base = "select count(*),circle from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base = "select count(*),circle from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Starclub//////////////////////

$get_deactivation_base = "select count(*),circle from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database  MTS Starclub//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS-Devotional //////////////////////

$get_deactivation_base = "select count(*),circle from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional //////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSRedfm //////////////////////

$get_deactivation_base = "select count(*),circle from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTSRedfm //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo  Music UNLIMITED//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        $chrg_amount = "";
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Starclub//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $chrg_amount = "";
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS MTS-Devotional //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $chrg_amount = "";
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS MTSRedfm //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($unsub_reason == 'IN-Voluntary') {
            $unsub_reason = 'in';
        }
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTSRedfm  //////////////////////
////////////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1101','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1101','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis != 546461  group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        echo $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis != 546461  group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        echo "<br>" . $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////
//////////start code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////End code to insert the data for call_tf MTS Starclub ///////////////////////////////////////////////////////////////////
////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T';
        else
            $call_tf[0] = 'N_CALLS_T';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of Tata Docomo Mtv////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1103','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1103','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of Tata Docomo Mtv//////////////////////////////////////////
////////start code to insert the data for call_t for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T';
        else
            $call_tf[0] = 'N_CALLS_T';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////End code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of MTS-Devotional////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1111','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1111','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTS-Devotional //////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of MTSRedFM ////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1110','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1110','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTSRedFM //////////////////////////////////
/////////////////////////////////////start code to insert the data for mous_tf for tata Docomo Endless////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
////////////////////////////////////////start code to insert the data for mous_tf for MTS Starclub////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////// end to insert the data for mous_tf for MTS Starclub////////////////////////////
////////////////////////////////////////////start code to insert the data for mous_t for tata Docomo 54646//////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous ,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
////////////////////////////////////////////start code to insert the data for mous_t for MTS Starclub//////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
///////////////////////////////// end to insert the data for mous_tf for MTS Starclub/////////////////////////////
//start code to insert the data for mous_tf for tata Docomo mtv
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for tata Docomo mtv
//start code to insert the data for mous_tf for MTS-Devotional
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTS-Devotional
//start code to insert the data for mous_tf for MTSRedFM
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTSRedFM
/////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Starclub /////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse ,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here 
////////////////////End code to insert the data for PULSE_TF for the MTSRedFM /////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here 
//////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////
////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////// end code to insert the data for Unique Users  for Tata Docomo Mtv///////////////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////// end code to insert the data for Unique Users  for MTS-Devotional /////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for MTSRedFM ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////// end code to insert the data for Unique Users for MTSRedFM /////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
/////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
/////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1101','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=52222 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1101','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Endless 
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646 
///////////////////////////////////////////start code to insert the data for SEC_TF  for Mts Starcllub///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////// end insert the data for SEC_TF  for MTS Starclub ////////////////////////////////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646
////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646
///////////start code to insert the data for SEC_TF  for tata Docomo Mtv /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1103','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1103','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Mtv ////////////////////////////////////
///////////start code to insert the data for SEC_TF  for MTS-Devotional /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1111','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1111','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF  for MTS-Devotional ////////////////////////////////////////
///////////start code to insert the data for SEC_TF for MTSRedFM /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1110','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1110','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSRedFM ////////////////////////////////////////
//////////////////////////////////////////////////////start code to insert the data for RBT_*  //////////////////////////////////////////////////////
$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt','rngtone') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'crbt') {

            $insert_rbt_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1101','NA','NA','NA')";
        } elseif ($rbt_tf[2] == 'rngtone') {
            $insert_rbt_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1101','NA','NA','NA')";
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
        if ($circle == '')
            $circle = 'NA';
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

echo "generated";
// end 
?>
