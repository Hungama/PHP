<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

#echo $view_date1='2012-08-09';

$deleteprevioousdata="delete from mis_db.dailyReportUninor where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic
//$9xmServiceId='14029xm';

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in (1402,1403,1410,1409) and event_type in('SUB','RESUB') group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle == "") $circle="UND";
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in (1402,1403,1410,1409) and event_type in('TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($circle == "") $circle="UND";
		if($plan_id==86 || $plan_id==87)
		{
			$amt = floor($charging_amt);
			if($amt<2) $charging_str="Event_1";
			else $charging_str="Event_".$amt;
		} else {
			$charging_str="TOP-UP_".$charging_amt;			
		}

		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//Start the code to activation Record mode wise for Uninor54646

$get_mode_activation_query="select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1402,1410) and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// end the code for Uninor54646


//Start the code to activation Record mode wise for UninorMTV

$get_mode_activation_query="select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1403 and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$activation_str1="Mode_Activation_".$mode;
		$insert_data2="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

// end the code for UninorMTV


//Start the code to activation Record mode wise for UninorManchala

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1409 and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query1))
        { 
				if($circle == "") $circle="UND";
                $activation_str_m="Mode_Activation_".$mode;
                $insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
                
                $queryIns = mysql_query($insert_data_m, $dbConn);
        }
}

// end the code for UninorManchala

//Start the code to activation Record mode wise for Uninor MyRingTone

$get_mode_activation_query1="select count(msisdn),circle,service_id,chrg_amount from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB') group by circle,service_id,event_type,chrg_amount order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
	$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$chrg_amount) = mysql_fetch_array($db_query1))
	{ 
		$amt = floor($chrg_amount);
		if($amt < 2) $amt1 = 1;
		elseif($amt <= 9 && $amt >= 2) $amt1 = $amt;
		else $amt1 = 10;

		if($circle == "") $circle="UND";
		$activation_str_m="Activation_".$amt;
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query1))
        { 
			if($circle == "") $circle="UND";
			$activation_str_m="Mode_Activation_".$mode;
			$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
			
			$queryIns = mysql_query($insert_data_m, $dbConn);
        }
}
// end the code for Uninor MyRingTone


// start code to insert the Pending Base data into the database for Uninor54646

$get_pending_base="select count(ani),circle from uninor_hungama.tbl_jbox_subscription where status=11 and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1402')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

// end code to insert the active base data into the database for Uninor54646

// start code to insert the Pending Base data into the database for UninorMTV

$get_pending_base="select count(ani),circle from uninor_hungama.tbl_mtv_subscription where status=11 and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base1="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1403')";
		$queryIns_pending = mysql_query($insert_pending_base1, $dbConn);
	}
}


// end code to insert the active base data into the database for UninorMTV

// start code to insert the Pending base data into the database for UninorRedFM

$get_pending_base="select count(ani),circle from uninor_redfm.tbl_jbox_subscription where status=11 and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base1="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1410')";
		$queryIns_pending = mysql_query($insert_pending_base1, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorRedFm

// start code to insert the Pending base data into the database for UninorManchla

$get_pending_base="select count(ani),circle from uninor_manchala.tbl_riya_subscription where status=11 and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1409')";
		$queryIns_pending = mysql_query($insert_pending_base_m, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorManchala

// start code to insert the Pending base data into the database for UninorRT

$get_pending_base="select count(ani),circle from uninor_myringtone.tbl_radio_ringtonesubscription where status=11 and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1412')";
		$queryIns_pending = mysql_query($insert_pending_base_m, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorRT


// start code to insert the active base data into the database for Uninor54646

$get_active_base="select count(*),circle from uninor_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1402','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}
// end code to insert the active base data into the database for Uninor54646

// start code to insert the active base data into the database for UninorMTV

$get_active_base="select count(*),circle from uninor_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data4="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1403','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data4, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorMTV


// start code to insert the active base data into the database for UninorRedFM

$get_active_base_redfm="select count(*),circle from uninor_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1410','NA','NA','NA','NA')";
		$queryIns1 = mysql_query($insert_data5, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorREdFm


// start code to insert the active base data into the database for UninorManchala

$get_active_base_redfm="select count(*),circle from uninor_manchala.tbl_riya_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1409','NA','NA','NA','NA')";
		$queryIns_m = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorManchala

// start code to insert the active base data into the database for UninorManchala

$get_active_base_redfm="select count(*),circle from uninor_myringtone.tbl_radio_ringtonesubscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1412','NA','NA','NA','NA')";
		$queryIns_m = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorManchala


// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1402')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646

// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data6="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1403')";
		$queryIns = mysql_query($insert_data6, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV


// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows2 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		if($circle == "") $circle="UND";
		$deactivation_str2="Mode_Deactivation_in";
		$insert_data6="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str2','$circle','$count','NA','NA','NA','1410')";
		$queryIns2 = mysql_query($insert_data6, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UNINORREDFM


// start code to insert the Deactivation Base into the MIS database for UninorManchala

$get_deactivation_base_m = "select count(*),circle,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_m);
if ($numRows2 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		$deactivation_str_m="Mode_Deactivation_in";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str_m','$circle','$count','NA','NA','NA','1409')";
		$queryIns2 = mysql_query($insert_data_m, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UNINORManchala


// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646

// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data7="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data7, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV

// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,unsub_reason ,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows3 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_redfm="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data_redfm, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorREdfm


// start code to insert the Deactivation Base into the MIS database for UninorManchala

$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ")
				$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorManchala


//start code to insert the data for call_tf for Uninor54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461') and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461') and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for Uninor54646


//start code to insert the data for call_tf for UninorMS
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorMS


//start code to insert the data for call_tf for UninorRiya
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
        $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
        while($call_tf = mysql_fetch_array($call_tf_result))
        {
                $insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
                $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
        }
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end call_tf for UninorRiya



//start code to insert the data for call_tf for UninorREdFm

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date) from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date),status from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id, mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorREdFm

//start code to insert the data for call_tf for UninorMTV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date) from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date),status from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
/// end call_tf for UninorMTV//////

//start code to insert the data for call_tf for UninorRT
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRT' as service_name,date(call_date) from  mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1412','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRT' as service_name,date(call_date),status from  mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1412','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end call_tf for UninorRT


//start code to insert the data for call_t for Uninor54646
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0]="L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0]="N_CALLS_T";
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end call_t for Uninor54646

//start code to insert the data for call_t for UninorRiya
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0]="L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0]="N_CALLS_T";
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end call_t for UninorRiya


//start code to insert the data for mous_tf for Uninor54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for Uninor54646


//start code to insert the data for mous_tf for UninorMS
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorMS

//start code to insert the data for mous_tf for UninorREDFM
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorREDFM



//start code to insert the data for mous_tf for UninorMTV
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorMTV


//start code to insert the data for mous_tf for UninorRiya
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorRiya

//start code to insert the data for mous_tf for UninorRT
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRT' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1412','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRT' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1412','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorRT

//start code to insert the data for mous_t for Uninor54646
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0]="L_MOU_T";
		elseif($mous_t[6] == 1) $mous_t[0]="N_MOU_T";
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end mous_t for Uninor54646

//start code to insert the data for mous_t for UninorRiya
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
        $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
        while($mous_t = mysql_fetch_array($mous_t_result))
        {
                $insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
                $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
        }
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0]="L_MOU_T";
		elseif($mous_t[6] == 1) $mous_t[0]="N_MOU_T";
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end mous_t for UninorRiya


//start code to insert the data for PULSE_TF for Uninor54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for Uninor54646


//start code to insert the data for PULSE_TF for UninorMS
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorMS


//start code to insert the data for PULSE_TF for UninorRiya
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628','5464626') and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1409','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628','5464626') and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1409','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorRiya



//start code to insert the data for PULSE_TF for UninorREdfm
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorREdfm



//start code to insert the data for PULSE_TF for UninorMTV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorMTV

//start code to insert the data for PULSE_TF for UninorRT
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRT' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1412','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRT' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1412','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorRT

//start code to insert the data for PULSE_T for Uninor54646
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] = "L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] = "N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end PULSE_T for Uninor54646

//start code to insert the data for PULSE_T for UninorRiya
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
        $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
        while($pulse_t = mysql_fetch_array($pulse_t_result))
        {
                $insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1409','NA','$pulse_t[5]','NA')";
                $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
        }
} 

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] = "L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] = "N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1409','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
} 
// end PULSE_T for UninorRiya

//start code to insert the data for Unique Users  for toll free for Uninor54646
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for Uninor54646

//start code to insert the data for Unique Users  for toll free for UninorMS
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMS

//start code to insert the data for Unique Users  for toll free for UninorRiya
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorRiya


//start code to insert the data for Unique Users  for toll free for REDFM
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{	
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for Uninor54646



//start code to insert the data for Unique Users  for toll free for UninorMTV
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMTV

//start code to insert the data for Unique Users  for toll free for UninorRT
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMTV


//start code to insert the data for Unique Users for toll for Uninor54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and operator in('unim') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and operator in('unim') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and operator in('unim') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_T";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_T";	
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll for Uninor54646

//start code to insert the data for Unique Users for toll for UninorRia
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_T";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_T";	
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll for UninorRia


//start code to insert the data for SEC_TF  for Uninor54646
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for Uninor54646


//start code to insert the data for SEC_TF  for Uninor54646
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorMS

//start code to insert the data for SEC_TF  for UninorRia
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
                $insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end SEC_TF for UninorRiya



//start code to insert the data for SEC_TF  for UninorREDFM
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end SEC_TF for UninorREDFM


//start code to insert the data for SEC_TF  for UninorMTV
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorMTV

//start code to insert the data for SEC_TF  for UninorRT
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRT' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1412','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRT' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1412','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorRT


//start code to insert the data for SEC_T for Uninor54646

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end SEC_T for Uninor54646


//start code to insert the data for SEC_T for UninorRiya
$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
        $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
        while($sec_t = mysql_fetch_array($sec_t_result))
        {
                $insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1409','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
        }
}

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1409','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end SEC_T for UninorRiya

// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646


// start code to insert the Deactivation Base into the MIS database for UninorRiya

$get_deactivation_base="select count(*),circle,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
        $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
        while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
        {
                $deactivation_str1="Deactivation_30";
                $insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1409)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

// end code to insert the Deactivation base into the MIS database for UninorRiya



// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV


// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query_fm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_fm);
if ($numRows2 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		$deactivation_str1="Deactivation_10";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorRedFM


// start code to insert the Charging Failure into the MIS database for Uninor54646

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure where date(date_time)='$view_date1' and service_id=1402 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type) = mysql_fetch_array($deactivation_base_query))
{
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";

	$insertData="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count) values('$view_date1', '$faileStr','$circle','$count')";
	$queryIns = mysql_query($insertData, $dbConn);
}

// end code to insert the Charging Failure into the MIS database for Uninor54646

// start code to insert the Charging Failure into the MIS database for UninorMTV

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure where date(date_time)='$view_date1' and service_id=1403 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type) = mysql_fetch_array($deactivation_base_query))
{
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";

	$insertData="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count) values('$view_date1', '$faileStr','$circle','$count')";
	$queryIns = mysql_query($insertData, $dbConn);
}

// end code to insert the Charging Failure into the MIS database for UninorMTV

echo "done";
mysql_close($dbConn);
?>
