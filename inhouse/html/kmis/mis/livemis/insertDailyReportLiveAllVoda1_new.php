<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");

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
				$service_name='VodafoneMTV';
			break;
			case '1307':
				$service_name='VH1Vodafone';
			break;
			case '1310':
				$service_name='REDFMVodafone';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConnVoda) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConnVoda) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $DateFormat[0]='2013-04-22 16:00:00';

if($_GET['time']) {
	echo $DateFormat[0]= $_GET['time'];
}

$service_array = array('VodafoneEndless','Vodafone54646','VodafoneMTV','VH1Vodafone','REDFMVodafone');

/////// start the code to delete existing data of In-house service////////////////

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1301,1302,1303,1307,1310) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";

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
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str','$count',$revenue)";
		}
		elseif($event_type=='RESUB')
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

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////


//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query= "select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1301,1302,1303,1307,1310) and event_type in('SUB','RESUB') group by circle,service_id,event_type,mode order by event_type";

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

$get_pending_base="select count(ani),circle,'1302' as service_name from vodafone_hungama.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

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

$get_pending_base="select count(ani),circle,'1307' as service_name from vodafone_vh1.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

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

$get_pending_base="select count(ani),circle,'1310' as service_name from vodafone_redfm.tbl_jbox_subscription where status IN (11,0,5) group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConnVoda) or die(mysql_error());

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
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
	}
}

$get_active_base="select count(ani),circle,'1307' as service_name from vodafone_vh1.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
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

$get_active_base="select count(ani),circle,'1310' as service_name from vodafone_redfm.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConnVoda) or die(mysql_error());
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
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_2','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

$get_deactivation_base="select count(ani),circle,'1307' as service_name from vodafone_vh1.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
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

$get_deactivation_base="select count(ani),circle,'1310' as service_name from vodafone_redfm.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnVoda) or die(mysql_error());
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

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

$get_deactivation_base="select count(ani),circle,'1307' as service_name,unsub_reason from vodafone_vh1.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

$get_deactivation_base="select count(ani),circle,'1310' as service_name,unsub_reason from vodafone_redfm.tbl_jbox_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$deactivation_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////

//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
$get_firstconsent_base="select count(ANI),circle,service ,consent 
from Vodafone_IVR.tbl_consent_log_voda
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in('1302')
 and consent='firstconsent' and response ='OK' group by circle,service,consent order by consent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$consent) = mysql_fetch_array($firstconsent_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_1";

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

//////////////////////////////////////////first consent logs end here //////////////////////////////////////

//////////////////////////////////////////insert second consent logs start here ////////////////////////////////
$get_firstconsent_base="select count(ANI),circle,service ,consent 
from Vodafone_IVR.tbl_consent_log_voda
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in('1302')
 and consent='secondconsent' and response ='submitPackChosen' group by circle,service,consent order by consent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$consent) = mysql_fetch_array($firstconsent_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_2";

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

//////////////////////////////////////////second consent logs end here //////////////////////////////////////
//////////////////////////////////////////insert Notification consent logs start here ////////////////////////////////
$get_consentnotification_base="select ANI,circle,service,date_time
from Vodafone_IVR.tbl_consent_log_voda
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in('1302')
 and consent='secondconsent' and response ='submitPackChosen' order by date_time ASC";
// where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'  group by circle,service order by date_time ASC
$notificationconsent_base_query = mysql_query($get_consentnotification_base,$dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($notificationconsent_base_query);
if ($numRows > 0)
{
while($row = mysql_fetch_array($notificationconsent_base_query)) {
	$count=0;
	$ANI = $row['ANI'];
	$circle = $row['circle'];
	$service_id = $row['service'];
	$date_time = $row['date_time'];
	$service_name=getServiceName($service_id);
	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success nolock WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure nolock WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' ";

	$statusResult = mysql_query($totalStatusQuery,$dbConnAirtel);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}
	if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_NOTIF";
		if($status['Success']||$status['Failure'])
		{
		$count=1;
		}
		if($count)
		{
		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
		}
	}
 }

//////////////////////////////////////////Notification consent logs end here //////////////////////////////////////

mysql_close($dbConnVoda);

echo "generated";

?>
