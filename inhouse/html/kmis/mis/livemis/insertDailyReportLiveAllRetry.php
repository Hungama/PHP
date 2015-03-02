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
		}
		return $service_name;
}

$serviceNameArray=array('1001'=>'TataDocomoMX','1003'=>'MTVTataDoCoMo','1002'=>'TataDoCoMo54646','1005'=>'TataDoCoMoFMJ','1202'=>'Reliance54646','1203'=>'MTVReliance','1208'=>'RelianceCM','1403'=>'MTVUninor','1402'=>'Uninor54646','1410'=>'RedFMUninor','1602'=>'TataIndicom54646','1601'=>'TataDoCoMoMXcdma','1603'=>'MTVTataIndicom','1605'=>'TataDoCoMoFMJcdma','1609'=>'RIATataDoCoMocdma','1009'=>'RIATataDoCoMo','1409'=>'RiaUninor','1801'=>'TataDocomoMXVMI');


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H:00:00')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
$ik=0;
foreach ($serviceNameArray as $service_id=>$service_name)
{
	echo $getCurrentStatus="select count(*) from misdata.livemis where date='$DateFormat[0]' and service='".$service_name."'";
	echo "<br>";
	$dateFormatQuery = mysql_query($getCurrentStatus,$LivdbConn) or die(mysql_error());
	list($count) = mysql_fetch_array($dateFormatQuery);
	if($count==0)
		$pendingService[$ik]=$service_id;
	$ik++;
}
echo "<pre>";
print_r($pendingService);

echo $serviceIdStr=implode(',',$pendingService);
exit;



/////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////

$get_activation_query1 ="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success";
$get_activation_query1 .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

$query1 = mysql_query($get_activation_query1,$dbConn) or die(mysql_error());
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
			$charging_str1="TOPUP_".$charging_amt;
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
$get_activation_query2 ="select count(msisdn),circle,chrg_amount,service_id from master_db.tbl_billing_success where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409) and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id";

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

////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646/ SWATI///////

///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query3="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success";
$get_activation_query3 .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1005) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query3))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='RESUB')
		{
			if($plan_id==20)
				$charging_str3="Renewal_Ticket_15";
			elseif($plan_id==33)
				$charging_str3="Renewal_Ticket_20";
			elseif($plan_id==34)
				$charging_str3="Renewal_Ticket_10";
			elseif($plan_id==19)
				$charging_str3="Renewal_Follow_5";
			else
				$charging_str3="Renewal_".$charging_amt;
			//$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str3','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str3="TOPUP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str3','$count',$revenue)";
		}
		$queryIns = mysql_query($insert_data3,$LivdbConn);
		$event_type='';
		$activation_str3='';
		$charging_amt3='';
		$insert_data3='';
		$charging_str='';
		$queryIns='';
	}
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////



///////// SWATI/start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query4="select count(msisdn),circle,chrg_amount,service_id,plan_id from master_db.tbl_billing_success";
$get_activation_query4 .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1005) and event_type in('SUB','RENEW') group by circle,service_id,chrg_amount,plan_id";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if ($numRows4 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query4))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($plan_id==20)
				$activation_str4="Activation_Ticket_15";
			elseif($plan_id==33)
				$activation_str4="Activation_Ticket_20";
			elseif($plan_id==34)
				$activation_str4="Activation_Ticket_10";
			elseif($plan_id==19)
				$activation_str4="Activation_Follow_5";
			else
				$activation_str4="Activation_".$charging_amt;

			$revenue=$charging_amt*$count;
			$insert_data4 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str4','$count',$revenue)";
			$queryIns = mysql_query($insert_data4,$LivdbConn);
			$event_type='';
			$activation_str4='';
			$charging_amt4='';
			$insert_data4='';
			$charging_str='';
			$queryIns='';
	}
}

/////////// SWATI///End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////



//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query5= "select count(msisdn),circle,service_id,event_type, mode from master_db.tbl_billing_success";
 $get_mode_activation_query5 .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409) and event_type in('SUB','RENEW') group by circle,service_id,mode order by event_type";

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


//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query6 = "select count(msisdn),circle,service_id,mode,plan_id from master_db.tbl_billing_success";
 $get_mode_activation_query6 .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1005) and event_type in('SUB','RENEW') group by circle,service_id,mode order by plan_id";

$db_query6 = mysql_query($get_mode_activation_query6, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($db_query6);
if ($numRows6 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query6))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($plan_id==20)
				$activation_str6="Mode_Activation_Ticket_15_".$mode;
			elseif($plan_id==33)
				$activation_str6="Mode_Activation_Ticket_20_".$mode;
			elseif($plan_id==34)
				$activation_str6="Mode_Activation_Ticket_10_".$mode;
			elseif($plan_id==19)
				$activation_str6="Mode_Activation_Follow_5_".$mode;
			else
				$activation_str6="Mode_Activation_".$mode;

			//$activation_str1="Mode_Activation_".$mode;
			$insert_data6="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str6','$count',0)";
		
		$queryIns = mysql_query($insert_data6,$LivdbConn);
		$service_name='';
		$event_type='';
		$activation_str6='';
		$insert_data6='';
		$queryIns='';
		$mode='';
	}
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base="select count(ani),circle,'1001' as service_name from docomo_radio.tbl_radio_subscription where status=11 and plan_id != 40 group by circle 
union
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_subscription where status=11 group by circle 
union
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_subscription where status=11 group by circle 
union
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_subscription where status=11 group by circle 
union
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_subscription where status=11 group by circle 
union 
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_subscription where status=11 group by circle 
union 
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_subscription where status=11 group by circle 
union
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status=11 group by circle 
union 
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_subscription where status=11 group by circle 
union 
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_subscription where status=11 group by circle
union 
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_subscription where status=11 group by circle
union 
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_subscription where status=11 group by circle
union 
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_subscription where status=11 group by circle
union 
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_subscription where status=11 group by circle
union 
select count(ani),circle,'1605' as service_name from indicom_starclub.tbl_jbox_subscription where status=11 group by circle
union 
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_subscription where status=11 group by circle
union
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_subscription where status=11 and plan_id = 40 group by circle
union
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_subscription where status=11 group by circle
";

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

$get_active_base="select count(ani),circle,'1001' as service_name from docomo_radio.tbl_radio_subscription where status=1 and plan_id != 40 group by circle 
union
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_subscription where status=1 group by circle 
union
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_subscription where status=1 group by circle 
union
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_subscription where status=1 group by circle 
union
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_subscription where status=1 group by circle 
union
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_subscription where status=1 group by circle 
union
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_subscription where status=1 group by circle 
union
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status=1 group by circle 
union
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_subscription where status=1 group by circle 
union
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_subscription where status=1 group by circle
union
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_subscription where status=1 group by circle
union 
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_subscription where status=1 group by circle
union 
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_subscription where status=1 group by circle
union 
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_subscription where status=1 group by circle
union 
select count(ani),circle,'1605' as service_name from indicom_starclub.tbl_jbox_subscription where status=1 group by circle
union 
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_subscription where status=1 group by circle
union
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_subscription where status=1 and plan_id = 40 group by circle
union
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_subscription where status=1 group by circle
";

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

$get_deactivation_base="select count(ani),circle,'1001' as service_name from docomo_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id != 40 group by circle
union
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id = 40 group by circle
union
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
";

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

$get_deactivation_base="select count(ani),circle,'1001' as service_name,unsub_reason from docomo_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id != 40 group by circle,unsub_reason
union
select count(ani),circle,'1003' as service_name,unsub_reason from docomo_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1002' as service_name,unsub_reason from docomo_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1005' as service_name,unsub_reason from docomo_starclub.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1009' as service_name,unsub_reason from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1202' as service_name,unsub_reason from reliance_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1203' as service_name,unsub_reason from reliance_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1208' as service_name,unsub_reason from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1402' as service_name,unsub_reason from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1403' as service_name,unsub_reason from uninor_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1410' as service_name,unsub_reason from uninor_redfm.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1601' as service_name,unsub_reason from indicom_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1602' as service_name,unsub_reason from indicom_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1603' as service_name,unsub_reason from indicom_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1609' as service_name,unsub_reason from indicom_manchala.tbl_riya_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1801' as service_name,unsub_reason from docomo_radio.tbl_radio_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id = 40 group by circle,unsub_reason
union
select count(ani),circle,'1409' as service_name,unsub_reason from uninor_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
";

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

/* end code to insert the docomo endless music report */

?>
