<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectTune.php");

// delete the prevoius record
$view_date1=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");


$serviceArray = array('1901'=>'TuneTalkIVR');


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana', 'PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

if($_GET['time']) {
	$DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2013-04-08 08:00:00';

//echo $DateFormat[0];

///////// start the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////

//delete data --------------
$service_array = array('TuneTalkIVR');

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());
//--------------------------


// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),'Indian',chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1901) and event_type in('RESUB','TOPUP') group by service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		$service_name=$serviceArray[$service_id];
		if($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle."','$charging_str','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOPUP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle."','$charging_str','$count',$revenue)";
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
$get_activation_query="select count(msisdn),'Indian',chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1901) and event_type in('SUB') group by service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		$service_name=$serviceArray[$service_id];

		$revenue=$charging_amt*$count;
		$activation_str="Activation_".$charging_amt;
		$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle."','$activation_str','$count',$revenue)";
		
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

 $get_mode_activation_query= "select count(msisdn),'Indian',service_id,event_type,mode,plan_id from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1901) and event_type in('SUB') group by service_id,event_type,mode order by event_type,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		$service_name=$serviceArray[$service_id];

		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle."','$activation_str1','$count',0)";
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

$get_pending_base="select count(ani),'Indian','1901' as service_name from tunetalk_radio.tbl_tunetalk_subscription where status IN (11,0,5)";

$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($pending_base_query))
	{
		$service_name=$serviceArray[$service_id];

		$insert_pending_base="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle."','Pending_Base','$count',0)";
		$queryIns_pending = mysql_query($insert_pending_base,$LivdbConn);
		$insert_pending_base='';
		$queryIns_pending='';
		$count='';
		$circle='';
		$service_id='';

	}
}

//////////////////////////////////// end code to insert the active base date into the database AirtelVH1//////////////////////////////////////////


////////// start code to insert the active base date into the database airtelVH1 ///////////////////////////////////////////////////

$get_active_base="select count(ani),'Indian','1901' as service_name from tunetalk_radio.tbl_tunetalk_subscription where status=1";

$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{
		$service_name=$serviceArray[$service_id];

		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

////////////////////////// end code to insert the active base date into the database airtelVH1/////////////////////////////////////



////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelVH1 //////////////////////

$get_deactivation_base="select count(ani),'Indian','1901' as service_name from tunetalk_radio.tbl_tunetalk_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		$service_name=$serviceArray[$service_id];
		if($count) {
			$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle."','Deactivation_2','$count',0)";
			$queryIns = mysql_query($insert_data3, $LivdbConn);
		}
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelVH1 //////////////////////


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelMTV //////////////////////

$get_deactivation_base="select count(ani),'Indian','1901' as service_name,unsub_reason from tunetalk_radio.tbl_tunetalk_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		$service_name=$serviceArray[$service_id];

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMTV  //////////////////////

//////////////////////////////start code to insert the data for call_tf for Tata Docomo Endless////////////////////////////////////////////////
$call_tf=array();

$call_tf_query="select 'CALLS_TF','Indian', count(id),'1901' as service_name,date(call_date) from mis_db.tbl_tune_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '13131%'"; 

$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$service_name=$serviceArray['1901'];
		$insert_call_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$call_tf[1]."','$call_tf[0]','$call_tf[2]',0)";
		$queryIns_call = mysql_query($insert_call_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


//////////////////////////////start code to insert the data for PULSE_tf for Tata Docomo Endless////////////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF','Indian','1901' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_tune_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '13131%'"; 

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($pulse_tf_result);
if ($numRows1 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$service_name=$serviceArray['1901'];
		$insert_pulse_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$pulse_tf[1]."','$pulse_tf[0]','$pulse_tf[4]',0)";
		$queryIns_call = mysql_query($insert_pulse_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for PULSE_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


//////////////////////////////start code to insert the data for MOU_tf for Tata Docomo Endless////////////////////////////////////////////////
$mou_tf=array();

$mou_tf_query="select 'MOU_TF','Indian', count(id),'1901' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_tune_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '13131%'"; 

$mou_tf_result = mysql_query($mou_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($mou_tf_result);
if ($numRows1 > 0)
{
	while($mou_tf = mysql_fetch_array($mou_tf_result))
	{
		$service_name=$serviceArray['1901'];

		$insert_mou_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$mou_tf[1]."','$mou_tf[0]','$mou_tf[5]',0)";
		$queryIns_call = mysql_query($insert_mou_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for MOU_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

//////////////////////////////start code to insert the data for SEC_tf for LiveMIS////////////////////////////////////////////////
$sec_tf=array();

$sec_tf_query="select 'SEC_TF','Indian', count(msisdn),'1901' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_tune_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '13131%'"; 

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($sec_tf_result);
if ($numRows1 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$service_name=$serviceArray['1901'];
		$insert_sec_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$sec_tf[1]."','$sec_tf[0]','$sec_tf[5]',0)";
		$queryIns_call = mysql_query($insert_sec_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for SEC_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


//////////////////////////////start code to insert the data for UU_TF for LiveMIS////////////////////////////////////////////////
$uu_tf=array();

$uu_tf_query="select 'UU_TF','Indian', count(distinct msisdn),'1901' as service_name,date(call_date) from mis_db.tbl_tune_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '13131%'"; 

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($uu_tf_result);
if ($numRows1 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=$serviceArray['1901'];

		$insert_uu_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$uu_tf[1]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_call = mysql_query($insert_uu_tf_data1,$LivdbConn);
	}
}
///////////////End code to insert the data for UU_TF for LiveMIS///////////////////////////////////////////////////////////////////


mysql_close($dbConn);
mysql_close($LivdbConn);

echo "generated";
?>
