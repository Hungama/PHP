<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

// delete the prevoius record
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo $view_date1='2013-02-01';

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

//$successTable = "master_db.tbl_billing_success_backup";
//$successTable = "master_db.tbl_billing_success";


/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

//and SC not like '%P%'
///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////////
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB') and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type"; 
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
echo $numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			if($circle=='') $circle='UND';
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('RESUB','TOPUP') and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
	
		if($event_type=='RESUB')
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

// Riya Event Charging 

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (99,100,101) group by circle,service_id,chrg_amount";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		$charging_str="Event_".$charging_amt;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (85) group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		if($event_type == 'SUB') { 
			$charging_str="Activation_Follow_5";
		} elseif($event_type == 'RESUB') {
			$charging_str="Renewal_Follow_5";
		}
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,floor(chrg_amount) as amount from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' and status like 'success%' group by circle,chrg_amount";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$amount) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$activation_str1="EVENT_".$amount;
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('".$view_date1."', '".$activation_str1."','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' and status like 'success%' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$activation_str1="RT_FT_SUC";
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}


$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str1="RT_FT_REQ";
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// code end here


////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB','TOPUP') and plan_id NOT IN (85,99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		$insert_data1="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
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

// Event for Miss Riya
$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB') and plan_id IN (99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		$insert_data1="";

		if(is_numeric($mode)) $mode='CC';	
		if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
		$activation_str1="Mode_FS_".$mode;
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


$get_mode_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock WHERE DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('RESUB','SUB') and plan_id='85' group by circle,service_id,chrg_amount, event_type, plan_id";

$db_query = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		$insert_data2="";
		if($event_type=='SUB')
		{
			$activation_str1="Activation_Follow_1";
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$ren_str1="Renewal_Follow_1";
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$ren_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

echo "done";
mysql_close($dbConn);


?>
