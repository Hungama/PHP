<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//echo $LivdbConn.'athar';

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

$deleteprevioousdata="delete from misdata.livemis where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic

$get_activation_query="select count(msisdn) from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1202,1203,1208) and event_type in('SUB','RESUB')";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$get_activation_query12="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1202,1203,1208) and event_type in('SUB','RESUB') group by circle,service_id,chrg_amount,event_type";

	$query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query12))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into misdata.livemis(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into misdata.livemis(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1203,1202,1208) and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type";
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
			$insert_data="insert into misdata.livemis(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////// start code to insert the Pending Base date into the database Reliance 54646//////////////////////////////////////

$get_pending_base="select count(ani),circle from reliance_hungama.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1202)";
		$queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
	}
}

//////////////////////////////////////////////// end code to insert the pending base date into the database REliance 54646///////////////////////////////////////

/////////////////////////////////////////////// start code to insert the Pending Base date into the database Cricket Mania//////////////////////////////////////

$get_pending_base="select count(ani),circle from reliance_cricket.tbl_cricket_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1208)";
		$queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
	}
}

//////////////////////////////////////////////// end code to insert the pending base date into the database Cricket Mania///////////////////////////////////////


/////////////////////////////////////////////// start code to insert the Pending Base date into the database Reliance Mtv//////////////////////////////////////

$get_pending_base="select count(ani),circle from reliance_hungama.tbl_mtv_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1203)";
		$queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
	}
}

//////////////////////////////////////////////// end code to insert the active base date into the database REliance Mtv///////////////////////////////////////



//////////////////////////////////////////////// start code to insert the active base date into the database REliance 54646//////////////////////////////////

$get_active_base="select count(*),circle from reliance_hungama.tbl_jbox_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1202)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}
////////////////////////////////////////////////// end code to insert the active base date into the database REliance 54646/////////////////////////////////////


//////////////////////////////////////////////// start code to insert the active base date into the database Cricket Mania//////////////////////////////////

$get_active_base="select count(*),circle from reliance_cricket.tbl_cricket_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1208)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}
////////////////////////////////////////////////// end code to insert the active base date into the database Cricket Mania/////////////////////////////////////



//////////////////////////////////////////////// start code to insert the active base date into the database REliance Mtv//////////////////////////////////

$get_active_base="select count(*),circle from reliance_hungama.tbl_mtv_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}
////////////////////////////////////////////////// end code to insert the active base date into the database REliance Mtv/////////////////////////////////////



/////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Reliance 54646//////////////////////////

$get_deactivation_base="select count(*) from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*),circle,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query12))
	{
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1202)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance 54646////////////////////////


/////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Cricket mania//////////////////////////

$get_deactivation_base="select count(*) from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*),circle,status from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query12))
	{
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1208)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Cricket mania////////////////////////


/////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Reliance Mtv//////////////////////////

$get_deactivation_base="select count(*) from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*),circle,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query12))
	{
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance Mtv////////////////////////




///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database REliance 54646////////////////

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
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1202)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance 54646///////////////////////

///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Cricket Mania////////////////

$get_deactivation_base="select count(*),circle,unsub_reason ,status from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

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
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1208)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Cricket Mania///////////////////////


///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database REliance Mtv////////////////

$get_deactivation_base="select count(*),circle,unsub_reason ,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

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
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database REliance MTV///////////////////////



///////////////////////////////////////////////////////////////start code to insert the data for call_tf Reliance 54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1202','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////////End code to insert the data for call_tf REliance 54646///////////////////////////////////////

///////////////////////////////////////////////////////////////start code to insert the data for call_tf Cricket Mania //////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1208','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////////End code to insert the data for call_tf Cricket Mania///////////////////////////////////////


///////////////////////////////////////////////////////////////Start code to insert the data for call_tf REliance MTV///////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Reliance Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relc','relm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1203','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////////// end code to insert the data for call_tf for the service of Reliance Mtv/////////////////////////


///////////////////////////////////////////////////////////////////////start code to insert the data for call_t Reliance 54646/////////////////////////////////
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1202','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////////END code to insert the data for call_t Reliance 54646/////////////////////////////////////


///////////////////////////////////////////////////////////////////////start code to insert the data for call_t Cricket Mania/////////////////////////////////
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1208','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////////END code to insert the data for call_t Cricket Mania/////////////////////////////////////


/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Reliance 54646////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1202','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance 54646////////////////////////////

/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Cricket Mania////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1208','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf Cricket Mania////////////////////////////



/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf Reliance MTV////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'relianceMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1203','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf REliance MTV////////////////////////////

/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t REliance 54646////////////////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'reliance54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1202','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t Cricket Mania////////////////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1208','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Cricket Mania////////////////////////////

/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF REliance 54646////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Reliance54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1202','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance 54646////////////////////////////

/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Cricket Mania ////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'RelianceCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1208','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF Cricket Mania ////////////////////////////

/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF Reliance MTV////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1203','NA','$pulse_tf[2]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF REliance MTV////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T REliance 54646////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1202','NA','$pulse_t[2]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////

/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T Cricket Mania ////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[2]','','1208','NA','$pulse_t[2]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T Cricket Mania////////////////////////////

///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for REliance 54646
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(546460) and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance 54646

///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for Cricket Mania 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('relm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1208','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for Cricket Mania 

///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for REliance MTV
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'RelianceMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =546461 and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1203','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for REliance MTV



////////////////////////////////////////////////////////////Start code to insert the data  Unique Users for toll for Reliance 54646//////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Reliance54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(54646) and operator in('relm','relc') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll for REliance 54646//////////////////////////////


////////////////////////////////////////////////////////////Start code to insert the data  Unique Users for toll for Cricket Mania //////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'RelianceCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('relm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1208','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll for Cricket Mania //////////////////////////////




////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance 54646/////////////////////////////
 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=546460 and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1202','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance 54646/////////////////////////////



////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Cricket Mania /////////////////////////////
 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1208','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data,$LivdbConn);
	}
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Cricket Mania /////////////////////////////


////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For Reliance MTV/////////////////////////////
 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'RelianceMTV' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relm','relc') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1203','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For Reliance MTV/////////////////////////////



////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Reliance 54646/////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Reliance54646' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=54646 and operator in('relm','relc') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1202','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Reliance 54646/////////////////////////////


////////////////////////////////////////////////////////////Start code to insert the data for SEC_T For Cricket Mania /////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'RelianceCricket' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('relm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into misdata.livemis(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1208','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////End code to insert the data for SEC_T For Cricket Mania /////////////////////////////


///////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database For REliance 54646////////////////////////////////

$get_deactivation_base="select count(*),circle,status from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1202)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////// End code to insert the Deactivation Base into the MIS database For REliance 54646////////////////////////////////

///////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database For Cricket Mania ////////////////////////////////

$get_deactivation_base="select count(*),circle,status from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1208)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}

///////////////////////////////////////////// End code to insert the Deactivation Base into the MIS database For Cricket Mania ////////////////////////////////



///////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database For REliance MTV////////////////////////////////

$get_deactivation_base="select count(*),circle,status from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into misdata.livemis(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data,$LivdbConn);
	}
}

///////////////////////////////////////////// End code to insert the Deactivation Base into the MIS database For Reliance MTV////////////////////////////////



///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Reliance 54646//////////////////////////

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1202 group by circle,event_type";
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

	$insertData="insert into misdata.livemis(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count',1202)";
	$queryIns = mysql_query($insertData, $LivdbConn);
}

///////////////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Reliance 54646//////////////////////////

///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Cricket Mania //////////////////////////

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1208 group by circle,event_type";
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

	$insertData="insert into misdata.livemis(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count',1208)";
	$queryIns = mysql_query($insertData, $dbConn);
}

///////////////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Cricket Mania //////////////////////////


///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Reliance MTV//////////////////////////

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure 
where date(date_time)='$view_date1' and service_id=1203 group by circle,event_type";
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

	$insertData="insert into misdata.livemis(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count',1203)";
	$queryIns = mysql_query($insertData, $dbConn);
}
echo "done";
/////////////////////////////////////////////////////////////// Start code to insert the data for call_tf for the service of Reliance Mtv/////////////////////


///////////////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Reliance MTV//////////////////////////

mysql_close($dbConn);
?>
