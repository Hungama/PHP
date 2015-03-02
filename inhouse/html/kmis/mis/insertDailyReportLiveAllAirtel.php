<?php
include_once("/var/www/html/LiveMIs/dbConnectLive.php");

// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1501':
				$service_name='EndlessMusic';
			break;
			case '1502':
				$service_name='Airtel54646';
			break;
			case '1503':
				$service_name='MTVAirtel';
			break;
			case '1511':
				$service_name='AirtelGL';
			break;
			case '1507':
				$service_name='VH1Airtel';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConnAirtel) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConnAirtel) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//$DateFormat[0] = '2012-04-26 15:00:00';

///////// start the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOPUP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str','$count',$revenue)";
		}
		$queryIns = mysql_query($insert_data,$LivdbConn);
		$event_type='';
		$activation_str='';
		$charging_amt='';
		$insert_data='';
		$charging_str='';
		$queryIns='';
	}
}

/////////// End the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////


// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507) and event_type in('SUB') group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$revenue=$charging_amt*$count;
		$activation_str="Activation_".$charging_amt;
		$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str','$count',$revenue)";
		
		$queryIns = mysql_query($insert_data,$LivdbConn);
		$event_type='';
		$activation_str='';
		$charging_amt='';
		$insert_data='';
		$charging_str='';
		$queryIns='';
	}
}

/////////// End the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////



//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query= "select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507) and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str1','$count',0)";
		$queryIns = mysql_query($insert_data1,$LivdbConn);
		$service_name='';
		$event_type='';
		$activation_str1='';
		$insert_data1='';
		$queryIns='';
		$mode='';
	}
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelVH1///////////////////////////////////

$get_pending_base="select count(ani),circle,'1507' as service_name from airtel_vh1.tbl_jbox_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database AirtelVH1//////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelGL///////////////////////////////////

$get_pending_base="select count(ani),circle,'1511' as service_name from airtel_rasoi.tbl_rasoi_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database AirtelGL////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database Airtel54646///////////////////////////////////

$get_pending_base="select count(ani),circle,'1502' as service_name from airtel_hungama.tbl_jbox_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database Airtel54646 ////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelMTV///////////////////////////////////

$get_pending_base="select count(ani),circle,'1503' as service_name from airtel_hungama.tbl_mtv_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database AirtelMTV ////////////////////////////////


////////// start code to insert the active base date into the database airtelVH1 ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1507' as service_name from airtel_vh1.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database airtelVH1/////////////////////////////////////


////////// start code to insert the active base date into the database airtelGL ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1511' as service_name from airtel_rasoi.tbl_rasoi_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database airtelGL/////////////////////////////////////////////

////////// start code to insert the active base date into the database Airtel54646 ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1502' as service_name from airtel_hungama.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Airtel54646 ////////////////////////////////////

////////// start code to insert the active base date into the database AirtelMTV ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1503' as service_name from airtel_hungama.tbl_mtv_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database AirtelMTV ////////////////////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelVH1 //////////////////////

$get_deactivation_base="select count(ani),circle,'1507' as service_name from airtel_vh1.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelVH1 //////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelGL //////////////////////

$get_deactivation_base="select count(ani),circle,'1511' as service_name from airtel_rasoi.tbl_rasoi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelGL //////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Airtel54646 ////////////////////

$get_deactivation_base="select count(ani),circle,'1502' as service_name from airtel_hungama.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Airtel54646 /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Airtel54646 ////////////////////

$get_deactivation_base="select count(ani),circle,'1503' as service_name from airtel_hungama.tbl_mtv_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Airtel54646 /////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelVH1 //////////////////////

$get_deactivation_base="select count(ani),circle,'1507' as service_name,unsub_reason from airtel_vh1.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelVH1 //////////////////////

////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelGL//////////////////////

$get_deactivation_base="select count(ani),circle,'1511' as service_name,unsub_reason from airtel_rasoi.tbl_rasoi_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelGL //////////////////////


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Airtel54646 //////////////////////

$get_deactivation_base="select count(ani),circle,'1502' as service_name,unsub_reason from airtel_hungama.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Airtel54646  //////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelMTV //////////////////////

$get_deactivation_base="select count(ani),circle,'1503' as service_name,unsub_reason from airtel_hungama.tbl_mtv_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMTV  //////////////////////


mysql_close($dbConnAirtel);
mysql_close($LivdbConn);
//mysql_close($dbConn);

echo "generated";
// end 

/* end code to insert the docomo endless music report */
?>
