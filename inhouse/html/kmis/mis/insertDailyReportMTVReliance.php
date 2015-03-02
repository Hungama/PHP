<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//include("http://119.82.69.212/kmis/services/hungamacare/insert_tbl_log.php");

// to insert the data for activation
// delete the prevoius record

$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)=date(date_add(now(),interval -1 day))";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic

// start the code to insert the data of activation MTVTataIndicom

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(date_time)=date(date_add(now(),interval -1 day)) and service_id in(1203) and event_type in('SUB','RESUB') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end the code to insert the data of activation MTVTataIndicom


//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(date_time)=date(date_add(now(),interval -1 day)) and service_id in(1203) and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($event_type=='SUB')
		{
			$activation_str1="Mode_Activation_".$mode;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end the code 
// pending Base


// start code to insert the Pending Base date into the database MTVTataIndicom

$get_pending_base="select count(ani),circle from reliance_hungama.tbl_mtv_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values(date(date_add(now(),interval -1 day)),'Pending_Base' ,'$circle','','$count','NA','NA','NA',1203)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

// end code to insert the active base date into the database MTVTataIndicom

// start code to insert the active base date into the database MTVTataIndicom

$get_active_base="select count(*),circle from reliance_hungama.tbl_mtv_subscription where status=1 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values(date(date_add(now(),interval -1 day)),'Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the active base date into the database MTVTataIndicom

// start code to insert the Deactivation Base into the MIS database MTVTataIndicom

$get_deactivation_base="select count(*),circle from reliance_hungama.tbl_mtv_unsub where date(unsub_date)=date(date_add(now(),interval -1 day)) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values(date(date_add(now(),interval -1 day)), 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database MTVTataIndicom


// start code to insert the Deactivation Base into the MIS database MTVTataIndicom

$get_deactivation_base="select count(*),circle,unsub_reason,unsub_reason from reliance_hungama.tbl_mtv_unsub where date(unsub_date)=date(date_add(now(),interval -1 day)) group by circle,unsub_reason,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values(date(date_add(now(),interval -1 day)), '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1203)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database  MTVTataIndicom

// CALLING CHANGES

/*

//start code to insert the data for call_tf
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)=date((date_add(now(),interval -1 day))) and dnis=546461 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1203','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end 


//start code to insert the data for mous_tf
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),ceiling(sum(duration_in_sec)/60) as mous from mis_db.tbl_radio_calllog where date(call_date)=date((date_add(now(),interval -1 day))) and dnis=546461 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1203','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end


//start code to insert the data for PULSE_TF 
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),(duration_in_sec/60)+1 as pulse from mis_db.tbl_radio_calllog where date(call_date)=date((date_add(now(),interval -1 day))) and dnis=546461 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1203','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end


//start code to insert the data for Unique Users  
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)=date((date_add(now(),interval -1 day))) and dnis=546461 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1203','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for SEC_TF  
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_radio_calllog where date(call_date)=date((date_add(now(),interval -1 day))) and dnis=546461 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1203','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
*/

// end

/*
//start code to insert the data for RBT_*  
$rbt_tf=array();
$rbt_query="select count(*),circle,req_type from docomo_radio.tbl_crbtrng_totalreqs where DATE(date_time)=date(date_add(now(),interval -1 day)) and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='CRBT')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
		}
		elseif($rbt_tf[2]=='RNG')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
		}


		$queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}
// end


// to inser the Migration data


$get_migrate_date="select crbt_mode,count(1),circle from docomo_radio.tbl_crbtrng_reqs_log where date(date_time)=date(adddate(now(),-1)) and req_type='crbt' and status=1 group by crbt_mode,circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0)
{
	$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
	while(list($crbt_mode,$count,$circle) = mysql_fetch_array($get_query))
	{
		if($circle=='')
				$circle='NA';
		if($crbt_mode=='ACTIVATE')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)), 'RBT_ACTIVATED_1','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='MIGRATE')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)),'RBT_MIGRATED_1','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)),'RBT_EAUC','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD15')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values(date(date_add(now(),interval -1 day)),'RBT_SELECTION_15','$circle','1001','NA','$count','NA','NA','NA')";
		}

		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}
*/
mysql_close($dbConn);

// end 

/* end code to insert the MTVTataIndicom report */

?>
