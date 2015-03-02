<?php 
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

//$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
echo $view_date1='2012-07-08';

$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in (1902)";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////


/////// start the code to insert the data of activation Virgin Mobile 54646////////////////

///////////////////////////////////////// remove the 1902 FMJ id from this query : show wid ////////////////////////////////////////////////
/*$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1902) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";
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
                elseif($event_type=='TOPUP')
                {
                        $charging_str="TOP-UP_".$charging_amt;
                        $insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }

                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

////////// End the code to insert the data of activation Virgin Mobile 54646////////////////

////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(date_time)='$view_date1' and service_id in(1902) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
        while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
        {
                if($event_type=='SUB')
                {
                        $activation_str1="Mode_Activation_".$mode;
                        $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
                elseif($event_type=='TOPUP')
                {
                        $activation_str1="Mode_TOP-UP_IVR";
                        $insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }
                $queryIns = mysql_query($insert_data1, $dbConn);
        }
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Virgin 54646 Music//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 40 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
        while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
        {
                if($unsub_reason=="SELF_REQ")
                        $unsub_reason="IVR";
                $deactivation_str1="Mode_Deactivation_".$unsub_reason;

                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1902)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Virgin 54646 Music  //////////////////////


///////////////// Start code to insert the Pending Base date into the database Docomo 54646 Music///////////////////////////////////

$get_pending_base="select count(ani),circle from docomo_radio.tbl_radio_subscription where status=11 and date(sub_date) = '$view_date1' AND plan_id = 40 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
        while(list($count,$circle) = mysql_fetch_array($pending_base_query))
        {
                $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1902)";
                $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo 54646 Music//////////////////////////////


///////////// start code to insert the active base date into the database Docomo 54646 Music///////////////////////////////////////////////////

$get_active_base="select count(*),circle from docomo_radio.tbl_radio_subscription where status=1 AND plan_id = 40 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($active_base_query))
        {
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1902)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

////////////////////////// end code to insert the active base date into the database Docomo 54646 Music/////////////////////////////////////



////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo 54646 Music//////////////////////

$get_deactivation_base="select count(*),circle from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 40 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
        {
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1902)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Aircle 54646 //////////////////////
*/
//////////start code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in ('airc') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1902','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in ('airc') group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0] = "L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0] = "N_CALLS_T";
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1902','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

//////////////End code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for MOU_T for Aircel 54646///////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1902','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0] = "L_MOU_T";
		elseif($mous_t[6] != 1) $mous_t[0] = "N_MOU_T";
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1902','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end

/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1902','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] ="L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] ="N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1902','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for Aircel 54646 //////////////////////////////////////////////
$uu_t=array();
$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','','1902','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}

$uu_t=array();
$uu_t_query = "(select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') and status IN (1)) group by circle)";
$uu_t_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') and status=1 group by circle)";

//$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		if($uu_t[5] == 1) $uu_t[0] = "L_UU_T";
		elseif($uu_t[5] != 1) $uu_t[0] = "N_UU_T";
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','','1902','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}
/////////////////////////// end Unique Users  for Aircel 54646/////////////////////////////////////////////////////////////////////////

/////////////////////start code to insert the data for SEC_T  for Aircel 54646 ///////////////////////////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1902','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1902','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end insert the data for SEC_T  for Aircel 54646 

//------------log write-----------------------
$Logfile = "/var/www/html/kmis/mis/MISRegenerate/log/aircel_log_".date("Ymd").".txt";
$logWrite = "Regenerate Date:".$view_date1."#Original Date:".date("Y-m-d H:i:s")."\n";
error_log($logWrite,3,$Logfile);
//------------ log end here ------------------

mysql_close($dbConn);
echo "done";
?>
