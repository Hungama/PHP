<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1301':
				$service_name='VodafoneEndless';
			break;
			case '1302':
				$service_name='Vodafone54646';
			break;
			case '1303':
				$service_name='MTVVodafone';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$service_array = array('VodafoneEndless','Vodafone54646','MTVVodafone');

$time = $_GET['time'];

$getDateFormatQuery="select date_format(date(now()),'%Y-%m-%d $time')";
$dateFormatQuery = mysql_query($getDateFormatQuery,$LivdbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
//echo "<br>";
$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1301,1302,1303) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

$query = mysql_query($get_activation_query, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='SUB')
		{
			$revenue=$charging_amt*$count;
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($circle)]."','$activation_str','$count',$revenue)";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($circle)]."','$charging_str','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOPUP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($circle)]."','$charging_str','$count',$revenue)";
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

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////


//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query= "select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1301,1302,1303) and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConnVoda) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='SUB')
		{
			$activation_str1="Mode_Activation_".$mode;
			$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str1','$count',0)";
		}
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


///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base="select count(ani),circle,'1302' as service_name from vodafone_hungama.tbl_jbox_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'".$circle_info[strtoupper($circle)]."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////

////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1302' as service_name from vodafone_hungama.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(ani),circle,'1302' as service_name from vodafone_hungama.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////



////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base="select count(ani),circle,'1302' as service_name,unsub_reason from vodafone_hungama.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

///////// start the code to insert the data of activation Voda////////////////

$call_tf=array();

$call_tf_query="select 'CALLS_TF',circle, count(id),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle
union
select 'CALLS_TF',circle, count(id),'1303' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator in('vodm') group by circle"; 

$call_tf_result = mysql_query($call_tf_query, $dbConnVoda) or die(mysql_error());
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
///////////////End code to insert the data for call_tf for Voda///////////////////////////////////////////////////////////////////

//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t=array();

$call_t_query="select 'CALLS_T',circle, count(id),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle"; 

$call_t_result = mysql_query($call_t_query, $dbConnVoda) or die(mysql_error());
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


//start code to insert the data for mous_tf for Voda
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle
union
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1303' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator in('vodm') group by circle";

$mous_tf_result = mysql_query($mous_tf_query, $dbConnVoda) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$service_name=getServiceName($mous_tf[3]);
		$insert_mous_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($mous_tf[1])]."','$mous_tf[0]','$mous_tf[2]',0)";
		$queryIns_mous = mysql_query($insert_mous_tf_data1, $LivdbConn);
	}
}
//////////////////////////////////// end//////////////////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t For Voda////////////////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$service_name=getServiceName($mous_t[3]);
		$insert_mous_t_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($mous_t[1])]."','$mous_t[0]','$mous_t[2]',0)";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Voda////////////////////////////

/////////////////////////////////start code to insert the data for PULSE_TF for the Voda SErvice/////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1303' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator in('vodm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnVoda) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$service_name=getServiceName($pulse_tf[3]);
		$insert_pulse_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_tf[1])]."','$pulse_tf[0]','$pulse_tf[2]',0)";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data1, $LivdbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for Voda/////////////////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T Voda////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$service_name=getServiceName($pulse_t[3]);
		$insert_pulse_t_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_t[1])]."','$pulse_t[0]','$pulse_t[2]',0)";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////End code to insert the data for Voda////////////////////////////



////////////////////////////////////////////start code to insert the data for Unique Users  for Voda ////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'Vodafone54646' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
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
///////////////////////////////////////////// end Unique Users  for Voda//////////////////////////////////////////////////////


//////////////////////////////////////Start code to insert the data  Unique Users for toll for Voda//////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=getServiceName($uu_tf[3]);
		$insert_uu_tf_data32="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($uu_tf[1])]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
	}
}

///////////////////////////////////End code to insert the data  Unique Users for toll for Voda//////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  for Voda /////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle,sum(duration_in_sec),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle
union
select 'SEC_TF',circle,sum(duration_in_sec),'1303' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator in('vodm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnVoda) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$service_name=getServiceName($sec_tf[3]);
		$insert_sec_tf_data5="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($sec_tf[1])]."','$sec_tf[0]','$sec_tf[2]',0)";
		$queryIns_sec = mysql_query($insert_sec_tf_data5, $LivdbConn);
	}
}
// end insert the data for SEC_TF  for Voda

$sec_t=array();

$sec_t_query="select 'SEC_T',circle,sum(duration_in_sec),'1302' as service_name,date(call_date) from master_db.tbl_voda_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('vodm') group by circle";


$sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$service_name=getServiceName($sec_t[3]);
		$insert_sec_t_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($sec_t[1])]."','$sec_t[0]','$sec_t[2]',0)";
		$queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
	}
}

mysql_close($dbConnVoda); 
mysql_close($LivdbConn); 
/* end code to insert the Vodafone LiveMIS report */

$url="http://119.82.69.212/kmis/services/hungamacare/interface_liveMIS.php?msg=1&service=vodafone";
header("Location:".$url);
?>