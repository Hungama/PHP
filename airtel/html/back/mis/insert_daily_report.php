<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//include("http://119.82.69.212/kmis/services/hungamacare/insert_tbl_log.php");

// to insert the data for activation
// delete the prevoius record
echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
echo $view_date1='2012-09-01';

$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic

// start the code to insert the data of activation Airtel

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1502,1503,1511,1507) and event_type in('SUB','RESUB') and plan_id!=29 group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end the code to insert the data of activation Airtel

//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1502,1503,1511,1507) and event_type in('SUB') and plan_id!=29 group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		$activation_str1="Mode_Activation_".$mode;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end the code

/////////////////////////////////// pending Base ////////////////////////////////////////////////////////////
// start code to insert the Pending Base date into the database airtel 54646

$get_pending_base="select count(ani),circle from airtel_hungama.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1502)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}
// end code to insert the active base date into the database Airtel 54646

// start code to insert the Pending Base date into the database Airtel MTV

$getPendingBase="select count(ani),circle from airtel_hungama.tbl_mtv_subscription where status=11 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsMTV = mysql_num_rows($pendingBaseQuery);
if ($numRowsMTV > 0)
{
	while(list($MTVCount,$MTVCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$MTVCircle','','$MTVCount','NA','NA','NA',1503)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

// end code to insert the active base date into the databases Airtel MTV

// start code to insert the Pending Base date into the database AirtelRIA
$getPendingBase="select count(ani),circle from airtel_manchala.tbl_riya_subscription where status=11 and plan_id=30 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($RIACount,$RIACircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$RIACircle','','$RIACount','NA','NA','NA',1509)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}
// end code to insert the active base date into the databases AirtelRIA 

// start code to insert the Pending Base date into the database AirtelVH1
$getPendingBase="select count(ani),circle from airtel_vh1.tbl_jbox_subscription where status=11 and plan_id=30 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($RIACount,$RIACircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$RIACircle','','$RIACount','NA','NA','NA',1507)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}
// end code to insert the active base date into the databases AirtelVH1 

////////////////////////////////////////////////////// Active Base ///////////////////////////////////////////////////////////////

// start code to insert the active base date into the database Airtel 54646

$get_active_base="select count(*),circle from airtel_hungama.tbl_jbox_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base date into the database Airtel 54646

// start code to insert the active base date into the database Airtel MTV

$getActiveBase="select count(*),circle from airtel_hungama.tbl_mtv_subscription where status=1 group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsMTV = mysql_num_rows($activeBaseQuery);
if ($numRowsMTV > 0)
{
	while(list($countMTV,$circleMTV) = mysql_fetch_array($activeBaseQuery))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleMTV','NA','$countMTV','NA','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base date into the database Airtel MTV

// start code to insert the active base date into the database AirtelRIA

$getActiveBase="select count(*),circle from airtel_manchala.tbl_riya_subscription where status=1 and plan_id=30 group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countRIA,$circleRIA) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleRIA','NA','$countRIA','NA','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base date into the database AirtelRIA 

//////////////////////////////////////////////////// Deactivation //////////////////////////////////////////////////

// start code to insert the Deactivation Base into the MIS database Airtel 54646
$get_deactivation_base="select count(*),circle from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646 

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*) from airtel_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1'";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV

// start code to insert the Deactivation Base into the MIS database AirtelRIA
$get_deactivation_base1="select count(*) from airtel_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id = 30";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

////////////////////////////////////////////// Mode_Deactivation /////////////////////////////////////////////////////////////////////////////
// start code to insert the Deactivation Base into the MIS database Airtel 54646

$get_deactivation_base="select count(*),circle,unsub_reason,unsub_reason from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*),unsub_reason from airtel_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV

// start code to insert the Deactivation Base into the MIS database AirtelRIA

$get_deactivation_base2="select count(*),unsub_reason from airtel_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id = 30 group by unsub_reason";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

///////////////////////////////////////////////////////////// CALL_TF //////////////////////////////////////////////////////////////////////

//start code to insert the data for call_tf Airtel 54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=59090 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end 

//start code to insert the data for call_tf for the service of Airtel MTV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='bham' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1503','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of Airtel MTV

//start code to insert the data for call_tf for the service of AirtelRIA
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelRIA

/////////////////////////////////////////////////////////////// MOU_TF //////////////////////////////////////////////////////////////////////////

//start code to insert the data for mous_tf for Airtel54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for mous_tf for Airtel mtv
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='bham' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1503','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for Airtel mtv

//start code to insert the data for mous_tf for Airtel mtv
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelRIA' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelRIA


///////////////////////////////////////////////////////////  PULSE_TF ///////////////////////////////////////////////////////////////////////////////

//start code to insert the data for PULSE_TF airtel 54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for PULSE_TF airtel MTV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='bham' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1503','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF airtel MTV

//start code to insert the data for PULSE_TF AirtelRIA
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelRIA' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelRIA 

//////////////////////////////////////////////////////// UU_TF ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for Unique Users  for airtel 54646 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end Unique Users  for Tata Airtel 54646 

//start code to insert the data for Unique Users  for airtel Mtv
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='bham' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1503','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for Unique Users  for AirtelRIA
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelRIA 

/////////////////////////////////////////////////////////////// SEC_TF /////////////////////////////////////////////////////////////////////////

//start code to insert the data for SEC_TF  for airtel 54646 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for airtel 54646 

//start code to insert the data for SEC_TF  for airtel Mtv 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='bham' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1503','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for airtel Mtv 

//start code to insert the data for SEC_TF for AirtelRIA
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelRIA 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo $view_date1;
mysql_close($dbConn);

echo "generated";
?>
