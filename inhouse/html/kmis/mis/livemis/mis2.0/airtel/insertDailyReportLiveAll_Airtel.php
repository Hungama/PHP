<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
// delete the prevoius record
$view_date1=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/';
//include service name configuration
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/airtel/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_Airtel******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

function getServiceName($service_id)
{
	switch($service_id)
	{
			case '1501':
				$service_name='AirtelEU';
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
			case '15221':
				$service_name='AirtelRegKK'; //planid-64 (21)
			break;
			case '15222':
				$service_name='AirtelRegTN'; //planid-63 (22)
			break;
			case '15112':
				$service_name='WAPAirtelLDR';//planid( 93,94,95,96)
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

if($_GET['time']) {
	echo $DateFormat[0] = $_GET['time'];
}
//echo $DateFormat[0] = '2013-10-23 14:00:00';

///////// start the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////

//delete data --------------
$service_array = array('AirtelEU','Airtel54646','MTVAirtel','AirtelGL','VH1Airtel','RIAAirtel','AirtelPD','AirtelMND','AirtelComedy','AirtelSE', 'AirtelDevo','AirtelPK','AirtelRegTN','AirtelRegKK');

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' 
and service IN ('".implode("','",$service_array)."') and (type not like 'CALLS_%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());
//--------------------------


// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";

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
		} else if($service_id == 1522 && $plan_id=64) { 
			$service_id = 15221; 
		}  else if($service_id == 1522 && $plan_id=63) { 
			$service_id = 15222; 
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

/////////// End the code to insert the data of activation Airtel 54646,MTV,GL,VH1 ////////////////


// remove the 1005 FMJ id from this query : show wid 
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522) and event_type in('SUB') group by circle,service_id,chrg_amount,event_type,plan_id";

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
		} else if($service_id == 1522 && $plan_id=64) { 
			$service_id = 15221; 
		}  else if($service_id == 1522 && $plan_id=63) { 
			$service_id = 15222;			
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

 $get_mode_activation_query= "select count(msisdn),circle,service_id,event_type,mode,sum(chrg_amount) as revenue,plan_id from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query .=" where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522) and event_type in('SUB') group by circle,service_id,event_type,mode order by event_type,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$revenue,$plan_id) = mysql_fetch_array($db_query))
	{
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		} else if($service_id == 1522 && $plan_id=64) { 
			$service_id = 15221; 
		}  else if($service_id == 1522 && $plan_id=63) { 
			$service_id = 15222; 
		}
		

		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str1','$count','$revenue')";
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

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelEU //////////////////////

$get_deactivation_base="select count(ani),circle,'1501' as service_name from airtel_radio.tbl_radio_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name','".$circle_info[strtoupper($circle)]."','Deactivation_10','$count',0)";
		$queryIns = mysql_query($insert_data3, $LivdbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelEU //////////////////////

/////////////////// Start code to insert the Deactivation Base into the MIS database AirtelGL ////////////////

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
//////////////////// end code to insert the Deactivation base into the MIS database AirtelGL /////////////////////


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

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database RIAAirtel ////////////////////

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
////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database RIAAirtel /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelMND ////////////////////

$get_deactivation_base="select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub1 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";
/*union
select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub2 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub3 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub4 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'1513' as service_name from airtel_mnd.tbl_character_unsub5 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle";*/

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

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelEDU ////////////////////

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelEDU /////////////////////


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

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelTN ////////////////////

$get_deactivation_base="select count(ani),circle,'15221' as service_name from airtel_hungama.tbl_arm_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id='64' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelTN /////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database AirtelKK ////////////////////

$get_deactivation_base="select count(ani),circle,'15222' as service_name from airtel_hungama.tbl_arm_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id='63' group by circle";

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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelKK /////////////////////



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


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelEU //////////////////////

$get_deactivation_base="select count(ani),circle,'1501' as service_name,unsub_reason from airtel_radio.tbl_radio_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelEU //////////////////////

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

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelMTV //////////////////////

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelMTV  //////////////////////

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelMND //////////////////////

$get_deactivation_base="select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub1 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";
/*union
select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub2 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub3 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub4 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'1513' as service_name,unsub_reason from airtel_mnd.tbl_character_unsub5 where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason";*/

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

/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelEdu //////////////////////

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelEdu  //////////////////////

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


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelTN //////////////////////

$get_deactivation_base="select count(ani),circle,'15221' as service_name,unsub_reason from airtel_hungama.tbl_arm_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id='64' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelTN  //////////////////////


/////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database AirtelKK //////////////////////

$get_deactivation_base="select count(ani),circle,'15222' as service_name,unsub_reason from airtel_hungama.tbl_arm_unsub where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id='63' group by circle,unsub_reason";

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

////////////////////////////////////////// end code to insert the Deactivation base into the MIS database AirtelKK  //////////////////////

//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
$get_firstconsent_base="select count(ANI),circle,service ,consent 
from Airtel_IVR.tbl_consent_log
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522)
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
from Airtel_IVR.tbl_consent_log
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522)
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
from Airtel_IVR.tbl_consent_log
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in(1501,1502,1503,1511,1507,1513,1518,1514,1517,1515,1520,1522)
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
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_Airtel******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

mysql_close($dbConnAirtel);
mysql_close($LivdbConn);

echo "generated";
?>