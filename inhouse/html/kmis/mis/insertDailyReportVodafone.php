<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

// delete the prevoius record

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
echo $view_date;
//$view_date1= '2012-05-31';
$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in(1301,1302,1303)";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());


/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// CALL LOG DATA FOR VODAFONE :

//start code to insert the data for call_t 54646
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// Call_Tf for Vodafone 54646

$call_t=array();
$call_t_query="select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1302','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end



// CALL LOG DATA FOR VODAFONE :

//start code to insert the data for call_t mtv
$call_t=array();
$call_t_query="select 'CALLS_TF',circle, count(id),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1303','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}
// end



//start code to insert the data for mous_t 54646
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end


//Start Code for mouse_tf for 54646 Vodafone
$mous_t=array();
$mous_t_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1302','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}


//End


//start code to insert the data for mous_t mtv
$mous_t=array();
$mous_t_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1303','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end


//start code to insert the data for PULSE_T  54646
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end


//Start the code for Vodafone 54646 PULSE_TF
$pulse_t=array();
$pulse_t_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1302','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

//end

//start code to insert the data for PULSE_T  mtv
$pulse_t=array();
$pulse_t_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Vodafone54646' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1303','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end


//start code to insert the data for Unique Users for toll  54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end


//Start to code for UU_TF for vodafone 54646 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

//End

//start code to insert the data for Unique Users for toll mtv
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1303','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end


//start code to insert the data for SEC_T 54646

$sec_t=array();
$sec_t_query="select 'SEC_T',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end


//Start the code for 54646 Vodafone SEC_TF 
$sec_t=array();
$sec_t_query="select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1302','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

//End

//start code to insert the data for SEC_T mtv

$sec_t=array();
$sec_t_query="select 'SEC_TF',circle,sum(duration_in_sec),'Vodafone54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator in('vodm') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1303','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end



////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConn);
// end code to insert the Charging Failure into the MIS database
echo "Inserted Data ";

?>
