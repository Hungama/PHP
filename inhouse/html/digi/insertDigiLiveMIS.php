<?php
ini_set('max_execution_time', 0);
include ("dbDigiConnect.php");
if($_GET['time']) 
	$time = $_GET['time'];

$processlog = "/var/www/html/digi/livekpi_digi_".date('Ymd').".txt";
$file_process_status = 'Digi process file-insertDigiLiveMIS#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$query1="SELECT Plan_id,sname FROM master_db.tbl_plan_bank WHERE S_id='1701'";
$planResult = mysql_query($query1,$dbConn);
while($row = mysql_fetch_array($planResult)) {
	//echo $row['sname'];
	if($row['sname'] == '17011') {
		$planInd[]=$row['Plan_id'];
	} elseif($row['sname'] == '17012') {
		$planBang[]=$row['Plan_id'];
	} elseif($row['sname'] == '17013') {
		$planNep[]=$row['Plan_id'];
	} 
}


function getCircle($shortCode)
{
	if(strpos($shortCode,'131221'))
		$circle='Bangla';
	elseif(strpos($shortCode,'131222'))
		$circle='Nepali';
	elseif(strpos($shortCode,'131224'))
		$circle='Indian';
	return $circle;
}

$service_array = array('DIGIMA');

//$time = $_GET['time'];

$getDateFormatQuery="select date_format(date(now()),'%Y-%m-%d $time')";
$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

//$DateFormat[0] = "2012-10-30 01:00:00";
////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


$get_activation_query="select count(msisdn) from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id IN (1701) and event_type in('SUB','RESUB','TOPUP')";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$get_activation_query12="select count(msisdn),'Indian' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planInd).") and service_id in(1701) and event_type in('SUB','RESUB','TOPUP') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Nepali' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planNep).") and service_id in(1701) and event_type in('SUB','RESUB','TOPUP') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Bangla' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planBang).") and service_id in(1701) and event_type in('SUB','RESUB','TOPUP') group by service_id,chrg_amount,event_type";

	$query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query12))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','$activation_str','$count',$revenue)";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','$charging_str','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$topup_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','$topup_str','$count',$revenue)";
		}
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}


//Start the code to activation Record mode wise

	$get_mode_activation_query1="select count(msisdn),'Indian' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planInd).") and service_id in(1701) and event_type in('SUB') group by service_id,event_type,mode
union
select count(msisdn),'Nepali' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planNep).") and service_id in(1701) and event_type in('SUB') group by service_id,event_type,mode
union
select count(msisdn),'Bangla' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planBang).") and service_id in(1701) and event_type in('SUB') group by service_id,event_type,mode";

$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0)
{
	$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query1))
	{
		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','$activation_str1','$count',0)";
		$queryIns1 = mysql_query($insert_data1, $LivdbConn);
	}
}

///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database DIGIMA//////////////////////

for($k=1;$k<4;$k++)
{
	switch($k)
	{
		case '1':
			$database='dm_radio';
			$circle='Indian';
		break;
		case '2':
			$database='dm_radio_nepali';
			$circle='Nepali';
		break;
		case '3':
			$database='dm_radio_bengali';
			$circle='Bangla';
		break;
	}

	$get_deactivation_base="select count(*) from $database.tbl_digi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'";

	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	$numRows = mysql_num_rows($deactivation_base_query);
	if ($numRows > 0)
	{
		while(list($count) = mysql_fetch_array($deactivation_base_query))
		{
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','Deactivation_2','$count',0";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////

//////////////////////////////////////////////// Start code to insert the active base date into the database Digi //////////////////////////////////

for($k=1;$k<4;$k++)
{
	switch($k)
	{
		case '1':
			$database='dm_radio';
			$circle='Indian';
		break;
		case '2':
			$database='dm_radio_nepali';
			$circle='Nepali';
		break;
		case '3':
			$database='dm_radio_bengali';
			$circle='Bangla';
		break;
	}

	$get_active_base="select count(*) from $database.tbl_digi_subscription where status=1";
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	$numRows = mysql_num_rows($active_base_query);
	if ($numRows > 0)
	{
		$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
		while(list($count) = mysql_fetch_array($active_base_query))
		{
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','Active_Base','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

///////////////////////////// end code to insert the active base date into the database Digi /////////////////////////////////////


/////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Digi //////////////////////////

for($k=1;$k<4;$k++)
{
	switch($k)
	{
		case '1':
			$database='dm_radio';
			$circle='Indian';
		break;
		case '2':
			$database='dm_radio_nepali';
			$circle='Nepali';
		break;
		case '3':
			$database='dm_radio_bengali';
			$circle='Bangla';
		break;
	}
$get_deactivation_base="select count(*) from $database.tbl_digi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*) from $database.tbl_digi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count) = mysql_fetch_array($deactivation_base_query12))
	{
		$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($circle)."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}
}

/////////////////////// end code to insert the Deactivation base into the MIS database  ////////////////////////


///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database  ////////////////

for($k=1;$k<4;$k++)
{
	switch($k)
	{
		case '1':
			$database='dm_radio';
			$circle='Indian';
		break;
		case '2':
			$database='dm_radio_nepali';
			$circle='Nepali';
		break;
		case '3':
			$database='dm_radio_bengali';
			$circle='Bangla';
		break;
	}
$get_deactivation_base="select count(*),unsub_reason from $database.tbl_digi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
	if ($numRows > 0)
	{
		$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
		while(list($count,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
		{
			if($unsub_reason=="SELF_REQ")
				$unsub_reason="IVR";
			$deactivation_str1="Mode_Deactivation_".$unsub_reason;
			if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', 'DIGIMA','".strtoupper($circle)."','$deactivation_str1','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

///////////////////////////////// end code to insert the Deactivation base into the MIS database ///////////////////////

///////////////////////////////////////////////////////////////start code to insert the data for call_tf////////////////////////  
$call_tf=array();
$call_tf_query="select 'CALLS_TF','Indian' as circle,count(id),'DIGI' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131224%' group by circle
union
select 'CALLS_TF','Bangla' as circle,count(id),'DIGI' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131221%' group by circle
union
select 'CALLS_TF','Nepali' as circle,count(id),'DIGI' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131222%' group by circle
";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($call_tf[1])."' ,'$call_tf[0]','$call_tf[2]',0)";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////////End code to insert the data for call_tf  ///////////////////////////////////////

/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf ////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF','Indian' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131224%' group by circle
union
select 'MOU_TF','Bangla' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131221%' group by circle
union
select 'MOU_TF','Nepali' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131222%' group by circle
";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($mous_tf[1])."' ,'$mous_tf[0]','$mous_tf[2]',0)";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf ////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF ////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF','Indian' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131224%' group by circle
Union
select 'PULSE_TF','Bangla' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131221%' group by circle
union
select 'PULSE_TF','Nepali' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131222%' group by circle
";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($pulse_tf[1])."' ,'$pulse_tf[0]','$pulse_tf[2]',0)";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF ////////////////////////////


///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for  
$uu_tf=array();
$uu_tf_query="select 'UU_TF','Indian' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131224%' group by circle
union
select 'UU_TF','Bangla' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131221%' group by circle
union
select 'UU_TF','Nepali' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131222%' group by circle
";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($uu_tf[1])."' ,'$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for  

////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For  /////////////////////////////
 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF','Indian' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131224%' group by circle
union
select 'SEC_TF','Bangla' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131221%' group by circle
union
select 'SEC_TF','Nepali' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '131222%' group by circle
";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($sec_tf[1])."' ,'$sec_tf[0]','$sec_tf[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For  /////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);
//echo "done";
header("Location:interface_liveMIS.php?msg=1");
?>
