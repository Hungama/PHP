<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

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
			case '1509':
				$service_name='RIAAirtel';
			break;
			case '1513':
				$service_name='AirtelMND';
			break;
			case '1514':
				$service_name='AirtelPD';
			break;
			case '1518':
				$service_name='AirtelComedy';
			break;
			case '1517':
				$service_name='AirtelSE';
			break;
			case '1515':
				$service_name='AirtelDevo';
			break;
			case '1520':
				$service_name='AirtelPK';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','HAR'=>'Haryana');

$service_array = array('EndlessMusic','Airtel54646','MTVAirtel','AirtelGL','VH1Airtel','RIAAirtel','AirtelComedy','AirtelMND','AirtelPD','AirtelDevo', 'AirtelSE','AirtelPK');

$time = $_GET['time'];

$getDateFormatQuery="select date_format(date(now()),'%Y-%m-%d $time')";
$dateFormatQuery = mysql_query($getDateFormatQuery,$LivdbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

////// start the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////
//echo "<br>";
$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


///////// start the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1518,1514,1513,1517,1515,1520) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		}

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

/////////// End the code to insert the data of activation Airtel 54646,MTV,GL,VH1////////////////


// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1518,1514,1513,1517,1515,1520) and event_type in('SUB') group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		}

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

 $get_mode_activation_query= "select count(msisdn),circle,service_id,event_type,mode,plan_id from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1518,1514,1513,1517,1515,1520) and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		}

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

//////////////////////////////////End the code to activation Record mode wise Airtel 54646,MTV,GL,VH1 /////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelVH1 ///////////////////////////////////

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

///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelPK///////////////////////////////////

$get_pending_base="select count(ani),circle,'1520' as service_name from airtel_hungama.tbl_pk_subscription where status=11 group by circle";

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

//////////////////////////////////// end code to insert the active base date into the database AirtelPK ////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelMTV ///////////////////////////////////

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


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelMTV ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1509' as service_name from airtel_manchala.tbl_riya_subscription where status=11 group by circle";
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


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelComedy ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1518' as service_name from airtel_hungama.tbl_comedyportal_subscription where status=11 group by circle";
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

//////////////////////////////////// end code to insert the active base date into the database AirtelComedy ////////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelMND ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_subscription1 where status=11 group by circle";
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

//////////////////////////////////// end code to insert the active base date into the database AirtelMND ////////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelPD ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1514' as service_name from airtel_EDU.tbl_jbox_subscription where status=11 group by circle";
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

//////////////////////////////////// end code to insert the active base date into the database AirtelPD ////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelSE ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1517' as service_name from airtel_SPKENG.tbl_spkeng_subscription where status=11 group by circle";
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

//////////////////////////////////// end code to insert the active base date into the database AirtelSE ////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database AirtelDevo ///////////////////////////////////

$get_pending_base="select count(ani),circle,'1515' as service_name from airtel_devo.tbl_devo_subscription where status=11 group by circle";
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

//////////////////////////////////// end code to insert the active base date into the database AirtelDevo ////////////////////////////////


////////// start code to insert the active base date into the database AirtelVH1///////////////////////////////////////////////////

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

////////////////////////// end code to insert the active base date into the database AirtelVH1/////////////////////////////////////


////////// start code to insert the active base date into the database AirtelGL///////////////////////////////////////////////////

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

////////////////////////// end code to insert the active base date into the database AirtelGL/////////////////////////////////////////////

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

////////// start code to insert the active base date into the database AirtelPK ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1520' as service_name from airtel_hungama.tbl_pk_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelPK ////////////////////////////////////


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

////////// start code to insert the active base date into the database AirtelRIA ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1509' as service_name from airtel_manchala.tbl_riya_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelRIA ////////////////////////////////////

////////// start code to insert the active base date into the database AirtelComedy ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1518' as service_name from airtel_hungama.tbl_comedyportal_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelComedy ////////////////////////////////////

////////// start code to insert the active base date into the database AirtelMND ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_subscription1 where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelMND ////////////////////////////////////

////////// start code to insert the active base date into the database AirtelPD ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1514' as service_name from airtel_EDU.tbl_jbox_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelPD ////////////////////////////////////



////////// start code to insert the active base date into the database AirtelSE ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1517' as service_name from airtel_SPKENG.tbl_spkeng_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelSE ////////////////////////////////////


////////// start code to insert the active base date into the database AirtelSE ///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1515' as service_name from airtel_devo.tbl_devo_subscription where status=1 group by circle";

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

////////////////////////// end code to insert the active base date into the database AirtelDevo ////////////////////////////////////



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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelVH1//////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelGL//////////////////////

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

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelPK ////////////////////

$get_deactivation_base="select count(ani),circle,'1520' as service_name from airtel_hungama.tbl_pk_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPK /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelMTV ////////////////////

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMTV /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelRIA ////////////////////

$get_deactivation_base="select count(ani),circle,'1509' as service_name from airtel_manchala.tbl_riya_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelRIA /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelComedy ////////////////////

$get_deactivation_base="select count(ani),circle,'1518' as service_name from airtel_hungama.tbl_comedyportal_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelComedy /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelMND ////////////////////

$get_deactivation_base="select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub1 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMND /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelPD ////////////////////

$get_deactivation_base="select count(ani),circle,'1514' as service_name from airtel_EDU.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPD /////////////////////



////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelSE ////////////////////

$get_deactivation_base="select count(ani),circle,'1517' as service_name from airtel_SPKENG.tbl_spkeng_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelSE /////////////////////




////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelDevo ////////////////////

$get_deactivation_base="select count(ani),circle,'1515' as service_name from airtel_devo.tbl_devo_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelDEvo /////////////////////




/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelVH1//////////////////////

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelVH1  //////////////////////

////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelGL //////////////////////

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

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelPK //////////////////////

$get_deactivation_base="select count(ani),circle,'1520' as service_name,unsub_reason from airtel_hungama.tbl_pk_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPK  //////////////////////

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

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelRIA //////////////////////

$get_deactivation_base="select count(ani),circle,'1509' as service_name,unsub_reason from airtel_manchala.tbl_riya_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelRIA  //////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelComedy //////////////////////

$get_deactivation_base="select count(ani),circle,'1518' as service_name,unsub_reason from airtel_hungama.tbl_comedyportal_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelComedy  //////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelMND //////////////////////

$get_deactivation_base="select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub1 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMND  //////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelPD //////////////////////

$get_deactivation_base="select count(ani),circle,'1514' as service_name,unsub_reason from airtel_EDU.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPD  //////////////////////


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelPD //////////////////////

$get_deactivation_base="select count(ani),circle,'1517' as service_name,unsub_reason from airtel_SPKENG.tbl_spkeng_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPD  //////////////////////




/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelDevo //////////////////////

$get_deactivation_base="select count(ani),circle,'1515' as service_name,unsub_reason from airtel_devo.tbl_devo_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelPD  //////////////////////






$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

//////////////////////////////start code to insert the data for call_tf for Airtel////////////////////////////////////////////////
$call_tf=array();

$call_tf_query="select 'CALLS_TF',circle, count(id),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'CALLS_TF',circle, count(id),'1503' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'CALLS_TF',circle, count(id),'1509' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
UNION
select 'CALLS_TF',circle, count(id),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle
UNION
select 'CALLS_TF',circle, count(id),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle
UNION
select 'CALLS_TF',circle, count(id),'1518' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'CALLS_TF',circle, count(id),'1514' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
UNION
select 'CALLS_TF',circle, count(id),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator='airm' and circle IN ('DEL') group by circle
UNION
select 'CALLS_TF',circle, count(id),'1515' as service_name,date(call_date) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
UNION
select 'CALLS_TF',circle, count(id),'1517' as service_name,date(call_date) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
UNION
select 'CALLS_TF',circle, count(id),'1520' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle"; 

$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($circle_info[strtoupper($call_tf[1])]=='')
			$circle_info[strtoupper($call_tf[1])]='Other';
		$service_name=getServiceName($call_tf[3]);
		$insert_call_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($call_tf[1])]."','$call_tf[0]','$call_tf[2]',0)";
		$queryIns_call = mysql_query($insert_call_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for call_tf for Airtel///////////////////////////////////////////////////////////////////

//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t=array();

$call_t_query="select 'CALLS_T',circle, count(id),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'CALLS_T',circle, count(id),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(55841) and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle
union
select 'CALLS_T',circle, count(id),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator='airm' and circle NOT IN ('DEL') group by circle
union
select 'CALLS_T',circle, count(id),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator='airm' and circle NOT IN ('DEL') group by circle"; 

$call_t_result = mysql_query($call_t_query, $dbConnAirtel) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$service_name=getServiceName($call_t[3]);
		$insert_call_t_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($call_t[1])]."','$call_t[0]','$call_t[2]',0)";
		$queryIns_call = mysql_query($insert_call_t_data1,$LivdbConn);
	}
}
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////


//start code to insert the data for mous_tf for Airtel
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'1502' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'MOU_TF',circle, count(id),'1503' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'MOU_TF',circle, count(id),'1509' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1507' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1511' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1518' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1513' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1514' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1515' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1517' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1520' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle";

$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$service_name=getServiceName($mous_tf[3]);
		$insert_mous_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($mous_tf[1])]."','$mous_tf[0]','$mous_tf[5]',0)";
		$queryIns_mous = mysql_query($insert_mous_tf_data1, $LivdbConn);
	}
}
//////////////////////////////////// end//////////////////////////////////////////


///////////////////////////////////////////////////Start code to insert the data for mou_t For ////////////////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'1502' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1507' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1511' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1513' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConnAirtel) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConnAirtel) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$service_name=getServiceName($mous_t[3]);
		$insert_mous_t_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($mous_t[1])]."','$mous_t[0]','$mous_t[5]',0)";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Airtel////////////////////////////

/////////////////////////////////start code to insert the data for PULSE_TF for Airtel SErvice/////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'1502' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1503' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator ='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1509' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator ='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1507' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1511' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1518' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1513' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1514' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1515' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1517' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1520' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$service_name=getServiceName($pulse_tf[3]);
		$insert_pulse_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_tf[1])]."','$pulse_tf[0]','$pulse_tf[5]',0)";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data1, $LivdbConn);
	}
}
//////////////////////////////////End code to insert the data for PULSE_TF for Airtel SErvice/////////////////////////


/////////////////////////////////////////////////////Start code to insert the data for PULSE_T Airtel////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, count(id),'1502' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'PULSE_T',circle, count(id),'1507' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle
union
select 'PULSE_T',circle, count(id),'1511' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') group by circle
union
select 'PULSE_T',circle, count(id),'1513' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator ='airm' and circle NOT IN ('DEL') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConnAirtel) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConnAirtel) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$service_name=getServiceName($pulse_t[3]);
		$insert_pulse_t_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_t[1])]."','$pulse_t[0]','$pulse_t[5]',0)";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T Airtel////////////////////////////



////////////////////////////start code to insert the data for Unique Users //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1503' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1509' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1518' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator='airm' and circle IN ('DEL') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1514' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1515' as service_name,date(call_date) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1517' as service_name,date(call_date) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1520' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=getServiceName($uu_tf[3]);
		$insert_uu_tf_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($uu_tf[1])]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data2, $LivdbConn);
	}
}
///////////////////////////////////////////// end Unique Users//////////////////////////////////////////////////////


////////////////////////////////////////////////////////////Start code to insert the data Unique Users for toll //////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'UU_T',circle, count(distinct msisdn),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' group by circle
UNION
select 'UU_T',circle, count(distinct msisdn),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
UNION
select 'UU_T',circle, count(distinct msisdn),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=getServiceName($uu_tf[3]);
		$insert_uu_tf_data32="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($uu_tf[1])]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
	}
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll//////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  Toll Free//////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'1502' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1503' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1509' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1507' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1511' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1518' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1513' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1514' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1515' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1517' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1520' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$service_name=getServiceName($sec_tf[3]);
		$insert_sec_tf_data5="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($sec_tf[1])]."','$sec_tf[0]','$sec_tf[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_tf_data5, $LivdbConn);
	}
}
// end insert the data for SEC_TF  for toll Free


$sec_t=array();

$sec_t_query="select 'SEC_T',circle, count(msisdn),'1502' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle
union
select 'SEC_T',circle, count(msisdn),'1507' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle
union
select 'SEC_T',circle, count(msisdn),'1511' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
union
select 'SEC_T',circle, count(msisdn),'1513' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";


$sec_t_result = mysql_query($sec_t_query, $dbConnAirtel) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConnAirtel) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$service_name=getServiceName($sec_t[3]);
		$insert_sec_t_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($sec_t[1])]."','$sec_t[0]','$sec_t[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
	}
}

mysql_close($dbConnAirtel);
mysql_close($LivdbConn);

$url="http://119.82.69.212/kmis/services/hungamacare/interface_liveMIS.php?msg=1&service=airtel";
header("Location:".$url);
?>