<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

// delete the prevoius record
$type=strtolower($_REQUEST['last']);
if($type=='y')
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
else
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$view_time1 = date("h:i:s");

function getServiceName($service_id) {
    switch ($service_id) {
        case '1302':
            $service_name = 'Vodafone54646';
            break;
        case '1303':
            $service_name = 'VodafoneMTV';
            break;
        case '1307':
            $service_name = 'VH1Vodafone';
            break;
        case '1301':
            $service_name = 'VodafoneMU';
            break;
        case '1310':
            $service_name = 'REDFMVodafone';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');


$getCurrentTimeQuery = "select now()";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConnVoda) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery = "select date_format('" . $currentTime[0] . "','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery, $dbConnVoda) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $DateFormat[0]='2013-04-22 16:00:00';

if ($_GET['time']) {
    echo $DateFormat[0] = $_GET['time'];
}

$service_array = array('VodafoneMU', 'Vodafone54646', 'VodafoneMTV', 'VH1Vodafone', 'REDFMVodafone');

/////// start the code to delete existing data of In-house service////////////////

//$DeleteQuery = "delete from misdata.livemis where date='$DateFormat[0]' and service IN('" . implode("','", $service_array) . "')";
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and date>'" . $view_date1 . " 00:00:00' and service IN ('" . implode("','", $service_array) . "') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%')";

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
// remove the 1005 FMJ id from this query : show wid 
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where date(response_time)='" . $view_date1 . "'  and service_id in(1301,1302,1303,1307,1310) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,hour(response_time)";

$query = mysql_query($get_activation_query, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $hour, $DateFormat1) = mysql_fetch_array($query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB') {
            $revenue = $charging_amt * $count;
            $activation_str = "Activation_" . $charging_amt;
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str','$count',$revenue)";
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $revenue = $charging_amt * $count;
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOPUP_" . $charging_amt;
            $revenue = $charging_amt * $count;
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
        }
        $queryIns = mysql_query($insert_data, $LivdbConn);
        $event_type = '';
        $activation_str = '';
        $charging_amt = '';
        $insert_data = '';
        $charging_str = '';
        $queryIns = '';
    }
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query .=" where date(response_time)='" . $view_date1 . "'  and service_id in(1301,1302,1303,1307,1310) and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type,hour(response_time)";

$db_query = mysql_query($get_mode_activation_query, $dbConnVoda) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode, $hour, $DateFormat1) = mysql_fetch_array($db_query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB') {
            $activation_str1 = "Mode_Activation_" . $mode;
            $insert_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str1','$count',0)";
        }
        $queryIns = mysql_query($insert_data1, $LivdbConn);
        $service_name = '';
        $event_type = '';
        $activation_str1 = '';
        $insert_data1 = '';
        $queryIns = '';
        $mode = '';
    }
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base = "select count(ani),circle,'1302' as service_name, from vodafone_hungama.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";
        $queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
        $insert_pending_base = '';
        $queryIns_pending = '';
        $count = '';
        $circle = '';
        $service_id = '';
    }
}

$get_pending_base = "select count(ani),circle,'1307' as service_name from vodafone_vh1.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";
        $queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
        $insert_pending_base = '';
        $queryIns_pending = '';
        $count = '';
        $circle = '';
        $service_id = '';
    }
}

$get_pending_base = "select count(ani),circle,'1301' as service_name from vodafone_radio.tbl_radio_subscription  where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";
        $queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
        $insert_pending_base = '';
        $queryIns_pending = '';
        $count = '';
        $circle = '';
        $service_id = '';
    }
}

$get_pending_base = "select count(ani),circle,'1310' as service_name from vodafone_redfm.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";
        $queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
        $insert_pending_base = '';
        $queryIns_pending = '';
        $count = '';
        $circle = '';
        $service_id = '';
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////
////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base = "select count(ani),circle,'1302' as service_name from vodafone_hungama.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Active_Base','$count',0)";
        $queryIns = mysql_query($insert_data2, $LivdbConn);
    }
}

$get_active_base = "select count(ani),circle,'1307' as service_name from vodafone_vh1.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Active_Base','$count',0)";
        $queryIns = mysql_query($insert_data2, $LivdbConn);
    }
}

$get_active_base = "select count(ani),circle,'1301' as service_name from vodafone_radio.tbl_radio_subscription  where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Active_Base','$count',0)";
        $queryIns = mysql_query($insert_data2, $LivdbConn);
    }
}

$get_active_base = "select count(ani),circle,'1310' as service_name from vodafone_redfm.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Active_Base','$count',0)";
        $queryIns = mysql_query($insert_data2, $LivdbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////
////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base = "select count(ani),circle,'1302' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "'  group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1','$service_name','" . $circle_info[strtoupper($circle)] . "','Deactivation_2','$count',0)";
        $queryIns = mysql_query($insert_data3, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1307' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1','$service_name','" . $circle_info[strtoupper($circle)] . "','Deactivation_2','$count',0)";
        $queryIns = mysql_query($insert_data3, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1301' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_radio.tbl_radio_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1','$service_name','" . $circle_info[strtoupper($circle)] . "','Deactivation_2','$count',0)";
        $queryIns = mysql_query($insert_data3, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1310' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1','$service_name','" . $circle_info[strtoupper($circle)] . "','Deactivation_2','$count',0)";
        $queryIns = mysql_query($insert_data3, $LivdbConn);
    }
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base = "select count(ani),circle,'1302' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $unsub_reason,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1307' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $unsub_reason,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1301' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_radio.tbl_radio_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $unsub_reason,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

$get_deactivation_base = "select count(ani),circle,'1310' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $unsub_reason,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
echo $get_firstconsent_base = "select count(ANI),circle,service ,firstconsent 
from Vodafone_IVR.tbl_consent_log_voda
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1301,1302,1303,1307,1310)
 and firstconsent='Y' group by circle,service,firstconsent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $consent) = mysql_fetch_array($firstconsent_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $consent_str1 = "CNS_1";

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','" . $circle_info[strtoupper($circle)] . "','$consent_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

//////////////////////////////////////////first consent logs end here //////////////////////////////////////

mysql_close($dbConnVoda);

echo "generated";
?>
