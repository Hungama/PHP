<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");

function failureReason($reason) {
	switch($reason) {
		case '1307': $reason = "OTHERS"; //"Invalid Or Missing Mode";
			break;
		case '1304': $reason = "OTHERS"; //"Invalid Or Missing MSISDN";
			break;
		case '999': $reason = "OTHERS"; //"Failed";
			break;
		case '1316': $reason = "OTHERS"; //"Subscription plan not exists with try and buy offer";
			break;
		case '1305': $reason = "BAL"; //"Insufficient balance";
			break;
		case '201': $reason = "GRACE";
			break;
	}
	return $reason;
}

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1001':
				$service_name='TataDoCoMoMX';
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
				$service_name='REDFMUninor';
			break;
			case '1602':
				$service_name='TataIndicom54646';
			break;
			case '1601':
				$service_name='TataDoCoMoMXcdma';
			break;
			case '1603':
				$service_name='MTVTataDoCoMocdma';
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
				$service_name = 'RIAUninor';
			break;
			case '1801':
				$service_name = 'TataDoCoMoMXvmi';
			break;
			case '1809':
				$service_name = 'RIATataDoCoMovmi';
			break;
			case '1010':
				$service_name = 'REDFMTataDoCoMo';
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
			case '14021':
				$service_name = 'AAUninor';
			break;
			case '1408':
				$service_name ='UninorSU';
			break;
			case '1418':
				$service_name ='UninorComedy';
			break;
			case '2121':
				$service_name ='SMSEtisalatNigeria';
			break;
			case '14101':
				$service_name ='WAPREDFMUninor';
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

if($_GET['time']) {
	$DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2013-02-26 13:00:00';

$service_array = array('TataDoCoMoMX','MTVTataDoCoMo','TataDoCoMo54646','TataDoCoMoFMJ','Reliance54646','MTVReliance','RelianceCM','MTVUninor','Uninor54646', 'REDFMUninor','TataIndicom54646','TataDoCoMoMXcdma','MTVTataDoCoMocdma','TataDoCoMoFMJcdma','RIATataDoCoMocdma','RIATataDoCoMo','RIAUninor','TataDoCoMoMXvmi', 'Aircel54646','RIATataDoCoMovmi','REDFMTataDoCoMo','UninorRT','REDFMTataDoCoMocdma','REDFMTataDoCoMovmi','UninorAstro','AAUninor','UninorSU','UninorComedy','WAPREDFMUninor');


/////// start the code to delete existing data of In-house service////////////////

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());

$DeleteQuery="delete from misdata.livemis where date(date)='".$view_date1."' and date>='".$view_date1." 00:00:00' and service IN ('".implode("','",$service_array)."') and (type like 'Activation%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Mode_EVENT_%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


////////////////////////////////////////////////// remove the 1005 FMJ id from this query : show wid//////////////////////// 
$get_activation_query2 ="select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in (1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409,1809,1010,1610,1810,1416,1408,1418) and plan_id!=95 and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0)
{
	$query21 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
	while(list($activation_count,$circle,$charging_amt,$service_id,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query21))
	{
		if($plan_id == 95) { $service_id = '14021';}
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$revenue=$charging_amt*$activation_count;
		$activation_str2="Activation_".$charging_amt;		
	
		echo $insert_data2 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str2','$activation_count',$revenue)";
		echo "<br>";

		//$queryIns = mysql_query($insert_data2,$LivdbConn);

		$event_type='';
		$activation_str2='';
		$charging_amt2='';
		$insert_data2='';
		$charging_str='';
		$queryIns='';
	}
}

////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646///////

exit;














/////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////

$get_activation_query1 ="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409,1809,1010,1610,1810,1416,1408,1418) and plan_id!=95 and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)"; 

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query1))
	{
		if($plan_id == 95) { $service_id = '14021';}
		$service_name=getServiceName($service_id);		
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';

		if($event_type=='RESUB')
		{
			$charging_str1 ="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str1="TOP-UP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
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

/// Uninor AA data 

$get_activation_query1 ="select count(msisdn),circle,chrg_amount,'14021',event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1402) and plan_id=95 and event_type in('RESUB','TOPUP','SUB') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query1))
	{
		//if($plan_id == 95) { $service_id = '14021';}
		$service_name=getServiceName($service_id);		
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		
		if($event_type=='SUB')
		{
			$charging_str1 ="Activation_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
		}
		if($event_type=='RESUB')
		{
			$charging_str1 ="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str1="TOP-UP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data1 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str1','$count',$revenue)";
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

/// end here


// SWATI/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////



////////////////////////////////// Start code to insert the Failure Activation of ACT,REN,TOPUP//////////////////////////

$charging_fail="select count(*),circle,event_type,service_id,plan_id  from master_db.tbl_billing_failure nolock where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id IN (1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605, 1607,1609,1801,1409,1809, 1010,1610,1810,1416,1408,1418) group by circle,event_type,plan_id";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$service_id,$plan_id) = mysql_fetch_array($deactivation_base_query))
{
	if($plan_id == 95) { $service_id = '14021';}
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

$charging_fail="select count(*),circle,event_type,service_id,plan_id,status  from master_db.tbl_billing_failure nolock where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and service_id IN (1402,1403,1410,1409,1416,1408,1418) group by circle,event_type,plan_id,status";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$service_id,$plan_id,$status) = mysql_fetch_array($deactivation_base_query))
{
	if($plan_id == 95) { $service_id = '14021';}
	$service_name = getServiceName($service_id);
	if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';

	$fail_reason = failureReason($status);
	if($event_type=='SUB')
		$faileStr="FAIL_ACT_".$fail_reason;
	if($event_type=='RESUB')
		$faileStr="FAIL_REN_".$fail_reason;
	if($event_type=='topup')
		$faileStr="FAIL_TOP_".$fail_reason;
	$insert_data2 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($circle)]."','$faileStr','$count','0')";
	$queryIns = mysql_query($insert_data2, $LivdbConn);
}

////////////////////////////////// END code to insert the Charging Failure Activation of ACT,REN,TOPUP//////////////////////////


///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

// remove the 1005 FMJ id from this query : show wid 
$get_activation_query3="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query3 .= " where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1005) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query3))
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
			$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str3','$count',$revenue)";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str3="TOP-UP_".$charging_amt;
			$revenue=$charging_amt*$count;
			$insert_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$charging_str3','$count',$revenue)";
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
$get_activation_query4="select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query4 .= " where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1005) and event_type in('SUB') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if ($numRows4 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query4))
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
			$insert_data4 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str4','$count',$revenue)";
			

			$queryIns = mysql_query($insert_data4,$LivdbConn);

			$event_type='';
			$activation_str4='';
			$charging_amt4='';
			$insert_data4='';
			$charging_str='';
			$queryIns='';
	}
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////


// remove the UninorRT id from this query
$get_activation_query5="select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1412) and event_type in('SUB','EVENT') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query5))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$amt = floor($charging_amt);
		if($amt < 2) $amt1 = 1;
		elseif($amt <= 9 && $amt >= 2) $amt1 = $amt;
		else $amt1 = 10;
		
		$activation_str5="Activation_".$amt1;

		$revenue=$charging_amt*$count;
		$insert_data5 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str5','$count',$revenue)";

		$queryIns = mysql_query($insert_data5,$LivdbConn);

		$activation_str5='';
		$insert_data5='';
	}
}

/////////// End the code to insert the data of activation UninorRT////////////////


// Add Uninor Redfm Wapsite into Live Mis
$get_activation_query5="select count(msisdn),circle,floor(chrg_amount),service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1410,1409,1402,1009,1609) and event_type in('EVENT') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($query5))
	{
		if($service_id=='1410') { 
			$activation_str51="EVENT_FS_".$charging_amt;
			$service_id='14101';
		} else {
			$activation_str51="EVENT_".$charging_amt;
		}
		
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		
		$revenue=$charging_amt*$count;
		$insert_data5 ="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str51','$count',$revenue)";
		
		$queryIns = mysql_query($insert_data5,$LivdbConn);
		
		$activation_str5='';
		$insert_data5='';
	}
}

/////////// End the code to insert the data of Uninor REdFM Wapsite////////////////




//////////////////////////////////Start the code to activation Record mode wise: uninorRT //////////////////////////////////////////

 $get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query61 .=" where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1412) and event_type in('SUB','EVENT') group by circle,service_id,mode,hour(response_time) order by plan_id";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($db_query61))
	{
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
	
		$activation_str61="Mode_Activation_".$mode;
		$insert_data61="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name', '".$circle_info[strtoupper($circle)]."','$activation_str61','$count',0)";
		
		$queryIns = mysql_query($insert_data61,$LivdbConn);

		$activation_str61='';
		$insert_data61='';
	}
}

//////////////////////////////////End the code to activation Record mode wise: uninorRT ///////////////////////////////////////////////


//////////////////////////////////Start code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////


 $get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query61 .=" where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1410,1409,1009,1010,1402,1609) and event_type in('EVENT') group by circle,service_id,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($db_query61))
	{
		if($service_id == '1410') $service_id='14101';
		$service_name=getServiceName($service_id);
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';			
		
		$activation_str61="Mode_EVENT_".$mode;
		$insert_data61="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name', '".$circle_info[strtoupper($circle)]."','$activation_str61','$count',0)";
		
		$queryIns = mysql_query($insert_data61,$LivdbConn);

		$activation_str61='';
		$insert_data61='';
	}
}

//////////////////////////////////End the code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////


//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

 $get_mode_activation_query5= "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query5 .=" where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1001,1002,1003,1009,1202,1203,1208,1402,1403,1410,1601,1602,1603,1605,1607,1609,1801,1409,1809,1010,1610,1810,1416,1408,1418) and event_type in('SUB','RENEW') group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0)
{
	while(list($mode_activation_count,$circle,$service_id,$event_type,$mode,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($db_query5))
	{
		if($plan_id == 95) { $service_id = '14021';}
		$service_name=getServiceName($service_id);
		
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
			$activation_str5="Mode_Activation_".$mode;
			$insert_data5="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str5','$mode_activation_count',0)";
		
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

 $get_mode_activation_query6 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
 $get_mode_activation_query6 .=" where date(response_time)='".$view_date1."' and response_time<'".$DateFormat[0]."'  and service_id in(1005) and event_type in('SUB') group by circle,service_id,mode,hour(response_time) order by plan_id";

$db_query6 = mysql_query($get_mode_activation_query6, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($db_query6);
if ($numRows6 > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id,$hour,$DateFormat1) = mysql_fetch_array($db_query6))
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
			$insert_data6="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle_info[strtoupper($circle)]."','$activation_str6','$count',0)";
		
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

$get_pending_base="select count(ani),circle,'1001' as service_name from docomo_radio.tbl_radio_subscription where status IN (11,0,5) and plan_id != 40 group by circle 
UNION
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_subscription where status IN (11,0,5) group by circle 
UNION
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle 
UNION
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_subscription where status IN (11,0,5) group by circle 
UNION
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and plan_id!=73 group by circle 
UNION 
select count(ani),circle,'1809' as service_name from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and plan_id=73 group by circle 
UNION 
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_subscription where status IN (11,0,5) group by circle 
UNION 
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle 
UNION
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status IN (11,0,5) group by circle 
UNION 
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_subscription where plan_id!=95 and status IN (11,0,5) group by circle 
UNION 
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1605' as service_name from indicom_starclub.tbl_jbox_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_subscription where status IN (11,0,5) group by circle
UNION
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_subscription where status IN (11,0,5) and plan_id = 40 group by circle
UNION
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_subscription where status IN (11,0,5) group by circle
UNION
select count(ani),circle,'1010' as service_name from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and plan_id!=72 group by circle
UNION
select count(ani),circle,'1610' as service_name from indicom_redfm.tbl_jbox_subscription where status IN (11,0,5) group by circle
UNION
select count(ani),circle,'1810' as service_name from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and plan_id = 72 group by circle
UNION
select count(ani),circle,'1416' as service_name from uninor_jyotish.tbl_jyotish_subscription where status IN (11,0,5) group by circle
UNION
select count(ani),circle,'14021' as service_name from uninor_hungama.tbl_Artist_Aloud_subscription where plan_id=95 and status IN (11,0,5) group by circle
UNION
select count(ani),circle,'1408' as service_name from uninor_cricket.tbl_cricket_subscription where status IN (11,0,5) group by circle
UNION 
select count(ani),circle,'1418' as service_name from uninor_hungama.tbl_comedy_subscription where status IN (11,0,5) group by circle";

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
UNION
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_subscription where status=1 and plan_id!=73 group by circle 
UNION
select count(ani),circle,'1809' as service_name from docomo_manchala.tbl_riya_subscription where status=1 and plan_id=73 group by circle 
UNION
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_subscription where status=1 group by circle 
UNION
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_subscription where status=1 and plan_id!=95 group by circle
UNION
select count(ani),circle,'14021' as service_name from uninor_hungama.tbl_jbox_subscription where status=1 and plan_id=95 group by circle
UNION
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_subscription where status=1 group by circle
UNION
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1605' as service_name from indicom_starclub.tbl_jbox_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_subscription where status=1 group by circle
UNION
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_subscription where status=1 and plan_id = 40 group by circle
UNION
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_subscription where status=1 group by circle
UNION
select count(ani),circle,'1010' as service_name from docomo_redfm.tbl_jbox_subscription where status=1 and plan_id!=72 group by circle
UNION
select count(ani),circle,'1810' as service_name from docomo_redfm.tbl_jbox_subscription where status=1 and plan_id=72 group by circle
UNION
select count(ani),circle,'1610' as service_name from indicom_redfm.tbl_jbox_subscription where status=1 group by circle
UNION
select count(ani),circle,'1416' as service_name from uninor_jyotish.tbl_jyotish_subscription where status=1 group by circle
UNION
select count(ani),circle,'14021' as service_name from uninor_hungama.tbl_Artist_Aloud_subscription where plan_id=95 and status=1 group by circle
UNION
select count(ani),circle,'1408' as service_name from uninor_cricket.tbl_cricket_subscription where status=1 group by circle
UNION 
select count(ani),circle,'1418' as service_name from uninor_hungama.tbl_comedy_subscription where status IN (1) group by circle";

$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id) = mysql_fetch_array($active_base_query))
	{	//echo $service_id.",";
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$insert_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'".$circle_info[strtoupper($circle)]."','Active_Base','$count',0)";
		$queryIns = mysql_query($insert_data2, $LivdbConn);
		//if($service_id=='14021') {  echo "<br/>".$insert_data2; }
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(ani),circle,'1001' as service_name from docomo_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id != 40 group by circle
UNION
select count(ani),circle,'1003' as service_name from docomo_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1002' as service_name from docomo_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1005' as service_name from docomo_starclub.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1009' as service_name from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!=73 group by circle
UNION
select count(ani),circle,'1809' as service_name from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id=73 group by circle
UNION
select count(ani),circle,'1202' as service_name from reliance_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1203' as service_name from reliance_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1208' as service_name from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1402' as service_name from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!=95 group by circle
UNION
select count(ani),circle,'14021' as service_name from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id=95 group by circle
UNION
select count(ani),circle,'1403' as service_name from uninor_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1410' as service_name from uninor_redfm.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1601' as service_name from indicom_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1602' as service_name from indicom_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1603' as service_name from indicom_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1609' as service_name from indicom_manchala.tbl_riya_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1801' as service_name from docomo_radio.tbl_radio_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id = 40 group by circle
UNION
select count(ani),circle,'1409' as service_name from uninor_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1010' as service_name from docomo_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!=72 group by circle
UNION
select count(ani),circle,'1810' as service_name from docomo_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id=72 group by circle
UNION
select count(ani),circle,'1610' as service_name from indicom_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1416' as service_name from uninor_jyotish.tbl_Jyotish_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
union
select count(ani),circle,'14021' as service_name from uninor_hungama.tbl_Artist_Aloud_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1408' as service_name from uninor_cricket.tbl_cricket_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle
UNION
select count(ani),circle,'1418' as service_name from uninor_hungama.tbl_comedy_unsub
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

$get_deactivation_base="select count(ani),circle,'1001' as service_name,unsub_reason from docomo_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id != 40 group by circle,unsub_reason
UNION
select count(ani),circle,'1003' as service_name,unsub_reason from docomo_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1002' as service_name,unsub_reason from docomo_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1005' as service_name,unsub_reason from docomo_starclub.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1009' as service_name,unsub_reason from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!=73 group by circle,unsub_reason
UNION
select count(ani),circle,'1809' as service_name,unsub_reason from docomo_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id=73 group by circle,unsub_reason
UNION
select count(ani),circle,'1202' as service_name,unsub_reason from reliance_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1203' as service_name,unsub_reason from reliance_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1208' as service_name,unsub_reason from reliance_cricket.tbl_cricket_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1402' as service_name,unsub_reason from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!='95' group by circle,unsub_reason
UNION
select count(ani),circle,'14021' as service_name,unsub_reason from uninor_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id='95' group by circle,unsub_reason
UNION
select count(ani),circle,'1403' as service_name,unsub_reason from uninor_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1410' as service_name,unsub_reason from uninor_redfm.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1601' as service_name,unsub_reason from indicom_radio.tbl_radio_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1602' as service_name,unsub_reason from indicom_hungama.tbl_jbox_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1603' as service_name,unsub_reason from indicom_hungama.tbl_mtv_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1609' as service_name,unsub_reason from indicom_manchala.tbl_riya_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1801' as service_name,unsub_reason from docomo_radio.tbl_radio_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id = 40 group by circle,unsub_reason
UNION
select count(ani),circle,'1409' as service_name,unsub_reason from uninor_manchala.tbl_riya_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1010' as service_name,unsub_reason from docomo_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id!=72 group by circle,unsub_reason
UNION
select count(ani),circle,'1810' as service_name,unsub_reason from docomo_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' and plan_id=72 group by circle,unsub_reason
UNION
select count(ani),circle,'1610' as service_name,unsub_reason from indicom_redfm.tbl_jbox_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1416' as service_name,unsub_reason from uninor_jyotish.tbl_Jyotish_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
union
select count(ani),circle,'14021' as service_name,unsub_reason from uninor_hungama.tbl_Artist_Aloud_unsub 
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1408' as service_name,unsub_reason from uninor_cricket.tbl_cricket_unsub
where unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' group by circle,unsub_reason
UNION
select count(ani),circle,'1418' as service_name,unsub_reason from uninor_hungama.tbl_comedy_unsub
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
mysql_close($LivdbConn);
echo "generated";
// end 

?>
