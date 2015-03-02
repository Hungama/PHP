<?php
include ("dbDigiConnect.php");

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

$get_activation_query="select count(msisdn) from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00' and service_id in(1701) and event_type in('SUB','RESUB')";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	$get_activation_query12="select count(msisdn),'Indian' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id =1 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Nepali' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id =3 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,chrg_amount,event_type
union
select count(msisdn),'Bangla' as circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id =2 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,chrg_amount,event_type";

	$query12 = mysql_query($get_activation_query12, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query12))
	{
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','$activation_str','$count',$revenue)";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','$charging_str','$count',$revenue)";
		}
		echo "<br/>".$insert_data;
		$queryIns = mysql_query($insert_data, $LivdbConn);
	}
}


//Start the code to activation Record mode wise

	$get_mode_activation_query1="select count(msisdn),'Indian' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id =1 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,event_type,mode
union
select count(msisdn),'Nepali' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id=3 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,event_type,mode
union
select count(msisdn),'Bangla' as circle,service_id,event_type,mode from master_db.tbl_billing_success where response_time between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'
and plan_id=2 and service_id in(1701) and event_type in('SUB','RESUB') group by service_id,event_type,mode";

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
			$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','$activation_str1','$count',0)";
		}
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

	$get_deactivation_base="select count(*) from $database.tbl_digi_unsub where unsub_date between '2012-04-13 13:00:00' and '2012-04-13 14:00:00'";

	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	$numRows = mysql_num_rows($deactivation_base_query);
	if ($numRows > 0)
	{
		while(list($count) = mysql_fetch_array($deactivation_base_query))
		{
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','Deactivation_2','$count',0";
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
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','Active_Base','$count',0)";
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
$get_deactivation_base="select count(*) from $database.tbl_digi_unsub where unsub_date between '2012-04-13 13:00:00' and '2012-04-13 14:00:00' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$get_deactivation_base12="select count(*) from $database.tbl_digi_unsub where unsub_date between '2012-04-13 13:00:00' and '2012-04-13 14:00:00' group by circle";
	$deactivation_base_query12 = mysql_query($get_deactivation_base12, $dbConn) or die(mysql_error());

	while(list($count) = mysql_fetch_array($deactivation_base_query12))
	{
		$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'),'DIGIMA','".strtoupper($circle)."','Deactivation_2','$count',0)";
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
$get_deactivation_base="select count(*),unsub_reason from $database.tbl_digi_unsub where unsub_date between '2012-04-13 13:00:00' and '2012-04-13 14:00:00' group by unsub_reason,circle";

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
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('2012-04-13 14:00:00','%Y-%m-%d %H'), 'DIGIMA','".strtoupper($circle)."','$deactivation_str1','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

///////////////////////////////// end code to insert the Deactivation base into the MIS database ///////////////////////


echo "done";

mysql_close($dbConn);
?>
