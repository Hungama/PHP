<?php
include("dbConnect.php");

//echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
echo $view_date1="2012-07-10";

$deleteprevioousdata="delete from master_db.dailyReportVodafone where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic

$get_activation_query="select count(msisdn) from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1302,1303) and event_type in('SUB','RESUB','TOPUP')";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$get_activation_query12="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1302,1303) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

	$query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());

	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query12))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOPUP_".$charging_amt;
			$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//Start the code to activation Record mode wise 

$get_mode_activation_query1="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1302,1303) and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0)
{
	$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query1))
	{
		if($event_type=='SUB')
		{
			$activation_str1="Mode_Activation_".$mode;
			$insert_data1="insert into master_db.dailyReportVodafone(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
		}
		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////


///////////////////////// start code to insert the Pending Base date into the database Vodafone 54646//////////////////////////////////////

$get_pending_base="select count(ani),circle from vodafone_hungama.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
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
}

////////////// end code to insert the pending base date into the database Vodafone 54646///////////////////////////////////////


//////////////////////////////////////// start code to insert the active base date into the database Vodafone 54646//////////////////////////////////

$get_active_base="select count(*),circle from vodafone_hungama.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
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
}

/////////////////////////////// end code to insert the active base date into the database Vodafone 54646/////////////////////////////////////



/////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone 54646//////////////////////////

$get_deactivation_base="select count(*) from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*),circle,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(11) group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query12))
	{   
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////// end code to insert the Deactivation base into the MIS database Vodafone 54646////////////////////////



///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone 54646////////////////

$get_deactivation_base="select count(*),circle,unsub_reason ,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone 54646///////////////////////


//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////

$get_deactivation_base="select count(*),circle,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and status in(1,11) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////////////////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////



///////////////////////////////////////////// Start code to insert the Charging Failure into the MIS database for the Vodafone 54646//////////////////////////

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure where date(date_time)='$view_date1' and service_id=1302 group by circle,event_type";
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

	$insertData="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count',1302)";
	$queryIns = mysql_query($insertData, $dbConn);
}

////////////////////////////////// END code to insert the Charging Failure into the MIS database for the Vodafone 54646//////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CALL LOG DATA FOR VODAFONE :

//start code to insert the data for call_t 54646
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// Call_Tf for Vodafone 54646

$call_t=array();
$call_t_query="select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end



// CALL LOG DATA FOR VODAFONE :

//start code to insert the data for call_t mtv
$call_t=array();
$call_t_query="select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1303','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}
// end



//start code to insert the data for mous_t 54646
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end


//Start Code for mouse_tf for 54646 Vodafone
$mous_t=array();
$mous_t_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}


//End


//start code to insert the data for mous_t mtv
$mous_t=array();
$mous_t_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1303','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end


//start code to insert the data for PULSE_T  54646
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end


//Start the code for Vodafone 54646 PULSE_TF
$pulse_t=array();
$pulse_t_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

//end

//start code to insert the data for PULSE_T  mtv
$pulse_t=array();
$pulse_t_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1303','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end


//start code to insert the data for Unique Users for toll  54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end


//Start to code for UU_TF for vodafone 54646 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

//End

//start code to insert the data for Unique Users for toll mtv
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1303','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end


//start code to insert the data for SEC_T 54646

$sec_t=array();
$sec_t_query="select 'SEC_T',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end


//Start the code for 54646 Vodafone SEC_TF 
$sec_t=array();
$sec_t_query="select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

//End

//start code to insert the data for SEC_T mtv

$sec_t=array();
$sec_t_query="select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1303','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end


echo 'done';
mysql_close($dbConn);
?>
