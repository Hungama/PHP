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
//echo $view_date1="2015-02-14";
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

if ($Repeat_flag) {
    $condition = " AND type NOT IN ('Active_Base','Pending_Base','UU_Repeat','UU_New') ";
} else {
    $condition = " AND 1";
}
$deleteprevioousdata = "delete from mis_db.mtsDailyReport where date(report_date)='$view_date1' " . $condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////// start the code to insert the data of activation Data/////////
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock  
        where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126,1108) 
        and event_type in('SUB','RESUB','TOPUP','Event','EVENT','SUB_RETRY') group by circle,service_id,chrg_amount,event_type,plan_id";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query)) {
        $flag = 0;
        if ($plan_id == '29' && $service_id == '1101')
            $flag = 1; //$service_id='11012';
        if ($event_type == 'SUB' || $event_type == 'SUB_RETRY') {
            $activation_str = "Activation_" . $charging_amt;
            if ($service_id == 1106)
                $activation_str = "Activation_Ticket_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

            if ($flag) {
                $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
                $queryIns = mysql_query($insert_data1, $dbConn);
            }
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

            if ($flag) {
                $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
                $queryIns = mysql_query($insert_data1, $dbConn);
            }
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOP-UP_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

            if ($flag) {
                $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
                $queryIns = mysql_query($insert_data1, $dbConn);
            }
        } elseif (strtoupper($event_type) == 'EVENT') {
            if ($charging_amt == '02')
                $charging_amt = 2;
            else if ($charging_amt == '03')
                $charging_amt = 3;
            else if ($charging_amt == '04')
                $charging_amt = 4;
            else if ($charging_amt == '06')
                $charging_amt = 6;
            else if ($charging_amt == '08')
                $charging_amt = 8;
            else if ($charging_amt == '09')
                $charging_amt = 9;


            $charging_str = "Event_" . $charging_amt;
            $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

            if ($flag) {
                $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
                $queryIns = mysql_query($insert_data1, $dbConn);
            }
        }

        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id,event_type,chrg_amount from " . $successTable . " nolock  
        where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126,1108) 
        and event_type in('SUB','Event','EVENT','SUB_RETRY','TOPUP') group by circle,service_id,mode,plan_id,event_type,chrg_amount";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id, $event_type,$charging_amt) = mysql_fetch_array($db_query)) {
        $flag = 0;
        if ($plan_id == '29' && $service_id == '1101')
            $flag = 1; //$service_id='11012';
		if($plan_id == '109' && $service_id == '1101')
           $mode = "OneStop";		
		if($plan_id == '113' && $service_id == '1101')
           $mode = "OneStop";		
		if($plan_id == '110' && $service_id == '1111')
           $mode = "OneStop";		
		if($plan_id == '111' && $service_id == '1123')
           $mode = "OneStop";		
		if($plan_id == '112' && $service_id == '1126')
           $mode = "OneStop";

        if ($mode == "OBD-Artist" || $mode == "push")
            $mode = "OBD";
        elseif ($mode == "TIVR")
            $mode = "IVR";

        $activation_str1 = "Mode_Activation_" . $mode;
        if ($service_id == 1106)
            $activation_str1 = "Mode_Activation_Ticket_" . $mode;

        if (strtoupper($event_type) == 'EVENT')
            $activation_str1 = "Mode_Event_" . $mode;
			
		
        if (strtoupper($event_type) == 'TOPUP')
            $activation_str1 = "Mode_TOP-UP_" . $mode;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns = mysql_query($insert_data, $dbConn);

        if ($flag) {
            $insert_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','11012','$charging_amt','$count','NA','NA','NA')";
            $queryIns = mysql_query($insert_data1, $dbConn);
        }
    }
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Start the code to Renewal Record mode wise ////////////////////////////////////////////////////////

$get_mode_renewal_query = "select count(msisdn),circle,service_id,mode,plan_id from " . $successTable . " nolock  
         where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126,1108) 
         and event_type='RESUB' group by circle,service_id,mode,chrg_amount order by mode,plan_id,chrg_amount";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query1)) {
        $flag = 0;
		$charging_amt=0;
        if ($plan_id == '29' && $service_id == '1101')
            $flag = 1; // $service_id='11012';

        if ($mode == "OBD-Artist" || $mode == "OBD-MS" || $mode == "push" || $mode == "push2" || $mode == "OBD-LBR" || $mode == "OBD_LBR" || $mode == "OBD_One97" || $mode == "OBD_VG")
            $mode = "OBD";
        elseif ($mode == "TIVR")
            $mode = "IVR";
		if($plan_id == '109' && $service_id == '1101')
           $mode = "OneStop";		
		if($plan_id == '113' && $service_id == '1101')
           $mode = "OneStop";		
		if($plan_id == '110' && $service_id == '1111')
           $mode = "OneStop";		
		if($plan_id == '111' && $service_id == '1123')
           $mode = "OneStop";		
		if($plan_id == '112' && $service_id == '1126')
           $mode = "OneStop";

        $renewal_str = "Mode_Renewal_" . $mode;
        $renewal_str1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
        $queryIns1 = mysql_query($renewal_str1, $dbConn);

        if ($flag) {
            $renewal_str2 = "insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
            $queryIns1 = mysql_query($renewal_str2, $dbConn);
        }
    }
}


///////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////

$flag = 0;

////////////////// remove the 1005 FMJ id from this query : show wid //////////////////

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from " . $successTable . " nolock 
        where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB','RESUB','TOPUP','SUB_RETRY') 
        group by circle,service_id,chrg_amount,event_type,plan_id";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id) = mysql_fetch_array($query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($event_type == 'SUB' || $event_type == 'SUB_RETRY') {
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

$get_mode_activation_query = "select count(msisdn),circle,service_id,mode,plan_id from " . $successTable . " nolock  
         where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB','SUB_RETRY') 
         group by circle,service_id,mode,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mode == "OBD-Artist" || $mode == "push")
            $mode = "OBD";
        elseif ($mode == "TIVR")
            $mode = "IVR";

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

$get_mode_renewal_query = "select count(msisdn),circle,service_id,mode,plan_id from " . $successTable . " nolock  
         where DATE(response_time)='$view_date1' and service_id in(1106) and event_type='RESUB' 
         group by circle,service_id,mode,plan_id,chrg_amount order by mode";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $mode, $plan_id) = mysql_fetch_array($db_query1)) {
	    $charging_amt=0;
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mode == "OBD-Artist" || $mode == "OBD-MS" || $mode == "push" || $mode == "push2" || $mode == "OBD-LBR" || $mode == "OBD_LBR" || $mode == "OBD_One97" || $mode == "OBD_VG")
            $mode = "OBD";
        elseif ($mode == "TIVR")
            $mode = "IVR";

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

//Deactivation data
include_once("/var/www/html/hungamacare/mis/insertDeactivationData.php");
//Calling data
include_once("/var/www/html/hungamacare/mis/insertDailyCalls.php");
//UU & Sec data
include_once("/var/www/html/hungamacare/mis/insertDailyUU_Sec.php");
//Active Base data
if (!$activepending_flag) {
include_once("/var/www/html/hungamacare/mis/insertActivePendingBase.php");
}

///////////////////////////// VoiceAlert Special Type ////////////////////////////////////////////////////////////////////
$va_logs1 = array();
$va_query = "select 'VA_NoAnswer',count(ani),circle from mts_voicealert.tbl_OBD_SMS_logs where date(date_time)='$view_date1' group by circle";

$va_query_result = mysql_query($va_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($va_query_result);
if ($numRows > 0) {
    while ($va_data = mysql_fetch_array($va_query_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if (!$va_data[2])
            $va_data[2] = 'UND';
        $insert_va_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data[0]','$va_data[2]','0','$va_data[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data, $dbConn);
    }
}

$va_logs2 = array();
//$va_query1="select 'VA_Calls',count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle";
$va_query1 = "select 'VA_Calls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle";
$va_query_result1 = mysql_query($va_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($va_query_result1);
if ($numRows1 > 0) {
    while ($va_data1 = mysql_fetch_array($va_query_result1)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_va_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data1[0]','$va_data1[2]','0','$va_data1[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data1, $dbConn);
    }
}

$va_logs3 = array();
//count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle
$va_query3 = "select 'VA_ExpectedCalls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle
UNION
select 'VA_ExpectedCalls',count(ani),circle from mts_voicealert.tbl_OBD_SMS_logs where date(date_time)='$view_date1' group by circle";

$va_query_result3 = mysql_query($va_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($va_query_result3);
if ($numRows3 > 0) {
    while ($va_data3 = mysql_fetch_array($va_query_result3)) {
        $circle = $va_data3[2];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_va_data3 = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data3[0]','$circle','0','$va_data3[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data3, $dbConn);
    }
}


$va_logs3 = array();
$va_query3 = "select 'VA_ActiveBase',count(distinct ani),circle from mts_voicealert.tbl_voice_category where date(sub_date)<='$view_date1' and status=1 group by circle";

$va_query_result3 = mysql_query($va_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($va_query_result3);
if ($numRows3 > 0) {
    while ($va_data3 = mysql_fetch_array($va_query_result3)) {
        $circle = $va_data3[2];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_va_data3 = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data3[0]','$circle','0','$va_data3[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data3, $dbConn);
    }
}


///////////////////////////// VoiceAlert Special Type Code End here  /////////////////////////////////////////////////////
//////////////////////////////////////////////////////start code to insert the data for RBT_*  //////////////////////////////////////////////////////
//Mts mu old table :- mts_radio.tbl_crbtrng_reqs_log

$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from mts_mu.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt') and crbt_mode='DOWNLOAD' group by circle,req_type";
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

$rbt_tf = array();
$rbt_query = "select count(*),circle,req_type from mts_mu.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type='rngtone' group by circle";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0) {
    while ($rbt_tf = mysql_fetch_array($rbt_tf_result)) {
        if ($rbt_tf[2] == 'rngtone') {
            $circle = $rbt_tf[1];
            if ($circle == "")
                $circle = "UND";
            elseif ($circle == "HAR")
                $circle = "HAY";
            elseif ($circle == "PUN")
                $circle = "PUB";

            $insert_rbt_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$circle','$rbt_tf[0]','0','1101','NA','NA','NA')";
        }
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
    }
}
// end
//////////////////////////////////////////////// to insert the Migration data///////////////////////////////////////////////////////////////////

$get_migrate_date = "select crbt_mode,count(1),circle from mts_mu.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by crbt_mode,circle";
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

//----------------- failure count --------------------------

$charging_fail = "select count(*),circle,event_type,service_id from master_db.tbl_billing_failure where date(date_time)='$view_date1' group by circle,event_type,service_id order by service_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while (list($count, $circle, $event_type, $service_id) = mysql_fetch_array($deactivation_base_query)) {
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


    $insertData = "insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','" . $service_id . "')";
    $queryIns = mysql_query($insertData, $dbConn);
}
//------------------ failure count code end here -----------
if (!$Repeat_flag) {
    include_once("/var/www/html/hungamacare/mis/insertDailyUUser_repeat.php");
}
mysql_close($dbConn);
echo "done";
?>
