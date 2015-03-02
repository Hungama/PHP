<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1001':
				$service_name='TataDocomoMX';
			break;
			case '1003':
				$service_name='MTVTataDoCoMo';
			break;
			case '1002':
				$service_name='TataDoCoMo54646';
			break;
			case '1005':
				$service_name='TataDoCoMoFMJ';
			break;
			case '1202':
				$service_name='Reliance54646';
			break;
			case '1203':
				$service_name='MTVReliance';
			break;
			case '1208':
				$service_name='RelianceCM';
			break;
			case '1403':
				$service_name='MTVUninor';
			break;
			case '1402':
				$service_name='Uninor54646';
			break;
			case '1410':
				$service_name='RedFMUninor';
			break;
			case '1602':
				$service_name='TataIndicom54646';
			break;
			case '1601':
				$service_name='TataDoCoMoMXcdma';
			break;
			case '1603':
				$service_name='MTVTataIndicom';
			break;
			case '1605':
				$service_name='TataDoCoMoFMJcdma';
			break;
			case '1609':
				$service_name='RIATataDoCoMocdma';
			break;
			case '1009':
				$service_name='RIATataDoCoMo';
			break;
			case '1409':
				$service_name = 'RiaUninor';
			break;
			case '1801':
				$service_name = 'TataDocomoMXVMI';
			break;
			case '1809':
				$service_name = 'RIATataDoCoMovmi';
			break;
			case '1010':
				$service_name = 'RedFMTataDoCoMo';
			break;
			case '1412':
				$service_name = 'UninorRT';
			break;
			case '1610':
				$service_name = 'REDFMTataDoCoMocdma';
			break;
			case '1810':
				$service_name = 'REDFMTataDoCoMovmi';
			break;
			case '1416':
				$service_name = 'UninorAstro';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $DateFormat[0] = '2012-07-03 16:00:00';


echo $DateFormat[0]='2012-11-22 13:00:00';

$service_array = array('TataDocomoMX','MTVTataDoCoMo','TataDoCoMo54646','TataDoCoMoFMJ','Reliance54646','MTVReliance','RelianceCM','MTVUninor','Uninor54646', 'RedFMUninor','TataIndicom54646','TataDoCoMoMXcdma','MTVTataIndicom','TataDoCoMoFMJcdma','RIATataDoCoMocdma','RIATataDoCoMo','RiaUninor','TataDocomoMXVMI', 'Aircel54646','RIATataDoCoMovmi','RedFMTataDoCoMo','UninorRT','REDFMTataDoCoMocdma','REDFMTataDoCoMovmi','UninorAstro');

/////// start the code to delete existing data of In-house service////////////////

/*$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());*/

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN('RelianceCM') and type NOT IN ('CALLS_T','SEC_T','MOU_T','UU_T','PULSE_T')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());

/////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////

$get_activation_query1 ="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1208) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query1))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='RESUB')
		{
			$charging_str1 ="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str1="TOP-UP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
		}
		$queryIns = mysql_query($insert_data1,$LivdbConn);
		$event_type='';
		$activation_str1 ='';
		$charging_amt='';
		$insert_data='';
		$charging_str='';
		$queryIns='';
	}
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////

// SWATI/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

////////////////////////////////////////////////// remove the 1005 FMJ id from this query : show wid//////////////////////// 
$get_activation_query2 ="select count(msisdn),circle,chrg_amount,service_id from master_db.tbl_billing_success nolock where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in (1208) and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id";

$query2 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0)
{
	$query21 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
	while(list($activation_count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query21))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$revenue=$charging_amt*$activation_count;
		$activation_str2="Activation_".$charging_amt;

		$insert_data2 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str2','$activation_count',$revenue)";
		$queryIns = mysql_query($insert_data2,$LivdbConn);

		$event_type='';
		$activation_str2='';
		$charging_amt2='';
		$insert_data2='';
		$charging_str='';
		$queryIns='';
	}
}

////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646///////

////////////////////////////////// Start code to insert the Failure Activation of ACT,REN,TOPUP//////////////////////////

$charging_fail="select count(*),circle,event_type,service_id from master_db.tbl_billing_failure nolock where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id IN (1208) group by circle,event_type";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$service_id) = mysql_fetch_array($deactivation_base_query))
{
	$service_name=getServiceName($service_id);
	if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";
	$insert_data2 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($circle)]."','$faileStr','$count','0')";
	$queryIns = mysql_query($insert_data2, $LivdbConn);
}

////////////////////////////////// END code to insert the Charging Failure Activation of ACT,REN,TOPUP//////////////////////////



//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query5= "select count(msisdn),circle,service_id,event_type, mode from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query5 .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1208) and event_type in('SUB','RENEW') group by circle,service_id,mode order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0)
{
	while(list($mode_activation_count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query5))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
			$activation_str5="Mode_Activation_".$mode;
			$insert_data5="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str5','$mode_activation_count',0)";
		
		$queryIns = mysql_query($insert_data5,$LivdbConn);
		$service_name='';
		$event_type='';
		$activation_str5='';
		$insert_data5='';
		$queryIns='';
		$mode='';
	}
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////




///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base="select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

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

////////////////////////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base="select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status=1 group by circle ";

$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
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

$get_deactivation_base="select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////



////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base="select count(ani),circle,'1208' as service_name,unsub_reason from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////

mysql_close($dbConn);
echo "generated";
// end 

?>
