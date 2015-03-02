<?php
ini_set('max_execution_time', 0);
include ("dbDigiConnect.php");
$processlog = "/var/www/html/digi/livekpi_digi_".date('Ymd').".txt";
$file_process_status = 'Digi process file-insertDailyReportLiveAll1.php#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$planResult = mysql_query("SELECT Plan_id,sname FROM master_db.tbl_plan_bank WHERE S_id='1701'",$dbConn);
while($row = mysql_fetch_array($planResult)) {
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
//echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$service_array = array('DIGIMA');

$getCurrentTimeQuery="select now()";

$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);


$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $DateFormat[0]='2013-11-27 01:00:00';

$DeleteQuery="DELETE FROM misdata.livemis WHERE date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$file_process_status = 'Query#'.$DeleteQuery.'#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());

$get_activation_query="select count(msisdn) from master_db.tbl_billing_success where 
response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1701) and event_type in('SUB','RESUB','TOPUP')";


$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$get_activation_query12="select count(msisdn),'Indian' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time
 between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id IN (".implode(",",$planInd).") 
and service_id in(1701) and event_type in('SUB','RESUB','TOPUP') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Nepali' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success 
where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
and plan_id IN (".implode(",",$planNep).") and service_id in(1701) and event_type in('SUB','RESUB','TOPUP') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Bangla' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success 
where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
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
			$topup_str="TOP-UP_".$charging_amt;
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


echo "done";

mysql_close($dbConn);
mysql_close($LivdbConn);
?>
