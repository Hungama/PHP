<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("http://119.82.69.212/kmis/services/hungamacare/insertTblLogVodafone.php");
// delete the prevoius record

//$view_date1="2011-07-22";
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));


$deleteprevioousdata="delete from mis_db.dailyReportVodafone where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());


// end the deletion logic

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id=1302 and event_type in('SUB','RESUB') group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id=1302 and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($event_type=='SUB')
		{
			$activation_str1="Mode_Activation_".$mode;
			$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end the code 

// start code to insert the Pending Base date into the database

$get_pending_base="select count(ani),circle from vodafone_hungama.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

// end code to insert the active base date into the database

// start code to insert the active base date into the database

$get_active_base="select count(*),circle from vodafone_hungama.tbl_jbox_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base date into the database


// start code to insert the Deactivation Base into the MIS database

$get_deactivation_base="select count(*),circle,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database



// start code to insert the Deactivation Base into the MIS database

$get_deactivation_base="select count(*),circle,unsub_reason ,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database









//start code to insert the data for call_tf
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1302','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end 

//start code to insert the data for call_t
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}
// end

//start code to insert the data for mous_tf
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1302','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end
//start code to insert the data for mous_t
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'Vodafone54646' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end

//start code to insert the data for PULSE_TF 
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1302','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for PULSE_T 
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, count(id),'Vodafone54646' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end

//start code to insert the data for Unique Users  for toll free
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis in(546460) and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for Unique Users for toll 
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis in(54646) and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for SEC_TF  
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for SEC_T

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_jbox_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end

// start code to insert the Deactivation Base into the MIS database

$get_deactivation_base="select count(*),circle,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database

// start code to insert the Charging Failure into the MIS database

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1302 group by circle,event_type";
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

	$insertData="insert into mis_db.dailyReportVodafone(report_date,type,circle,total_count) values('$view_date1', '$faileStr','$circle','$count')";
	$queryIns = mysql_query($insertData, $dbConn);
}
mysql_close($dbConn);
// end code to insert the Charging Failure into the MIS database


?>
