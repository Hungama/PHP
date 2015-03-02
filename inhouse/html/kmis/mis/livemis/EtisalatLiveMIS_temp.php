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

$service_array = array('SMSEtisalatNigeria');

/////// start the code to delete existing data of In-house service////////////////

/*$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN('".implode("','",$service_array)."')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());

$DeleteQuery1="delete from misdata.livemis where date(date)='".$view_date1."' and service IN('".implode("','",$service_array)."') and type like '%Activation%'";
$deleteResult13 = mysql_query($DeleteQuery1,$LivdbConn) or die(mysql_error());

$DeleteQuery2="delete from misdata.livemis where date(date)='".$view_date1."' and service IN('".implode("','",$service_array)."') and type like 'Renewal%'";
$deleteResult14 = mysql_query($DeleteQuery1,$LivdbConn) or die(mysql_error());


//-------------------------- Etisalat MIS --------------------------------


//Active base
$activeBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status=1 
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status=1 
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status=1 
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status=1 
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status=1 ";

$activeBaseQuery = mysql_query($activeBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($activeBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($activeBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$service_name=getServiceName('2121');
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'".$circle."','Active_Base','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

//Pending Base
$pendingBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status IN (11,0,12) 
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status IN (11,0,12) 
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status IN (11,0,12) 
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status IN (11,0,12)
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status IN (11,0,12) ";

$pendingBaseQuery = mysql_query($pendingBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($pendingBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$service_name=getServiceName('2121');
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'".$circle."','Pending_Base','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}
*/
//Activation
$get_activation_query="select count(msisdn),chrg_amount,service_id,plan_id,hour(response_time) from master_db.tbl_billing_success nolock where date(response_time)='".$view_date1."' and service_id in ('2121') and event_type in('SUB') group by service_id,chrg_amount,plan_id,hour(response_time)"; 
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
echo $numRows = mysql_num_rows($get_activation_result); 
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id,$hour) = mysql_fetch_array($get_activation_result))
	{
		if($count) { 
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120") $circle="Astro";

			$activation_str="Activation_75"; //.$charging_amt;
			$service_name=getServiceName('2121');
			$revenue=$charging_amt*$count;
			$DateFormat1=$view_date1." ".$hour.":00:00";
			echo "<br/>".$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle."','$activation_str','$count',$revenue)";
			
			$queryIns = mysql_query($insert_data, $LivdbConn);
			//echo $count; exit;
		}
	}
}
/*
//Mode Activation
$get_mactivation_query="select count(msisdn),chrg_amount,service_id,plan_id,mode,hour(response_time) from master_db.tbl_billing_success nolock where date(response_time)='".$view_date1."' and service_id in(2121) and event_type in('SUB') group by service_id,chrg_amount,plan_id,mode,hour(response_time)"; 
$get_mactivation_result = mysql_query($get_mactivation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_mactivation_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id,$mode,$hour) = mysql_fetch_array($get_mactivation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120") $circle="Astro";
			$service_name=getServiceName('2121');
			$DateFormat1=$view_date1." ".$hour.":00:00";
			$activation_str="Mode_Activation_".$mode; //.$charging_amt;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle."','$activation_str','$count',0)";
			
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

// Renewal
$get_renewal_query="select count(msisdn),chrg_amount,service_id,plan_id,hour(response_time) from master_db.tbl_billing_success nolock where date(response_time)='".$view_date1."' and service_id in(2121) and event_type in('RESUB') group by service_id,chrg_amount,plan_id,hour(response_time)"; 
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id,$hour) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120") $circle="Astro";
			
			$service_name=getServiceName('2121');
			$revenue=$charging_amt*$count;
			$DateFormat1=$view_date1." ".$hour.":00:00";		
			$renewal_str="Renewal_75"; //.$charging_amt;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','".$circle."','$renewal_str','$count','$revenue')";
			
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

//Deactivation
$unsubBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription_log WHERE  unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription_log WHERE  unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription_log WHERE  unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription_log WHERE  unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$service_name=getServiceName('2121');
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name','".$circle."','Deactivation_75','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

// Mode Deactivation
$unsubBase = "select count(*),'SPL',UNSUB_REASON FROM etislat_hsep.tbl_sfp_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'EPL',UNSUB_REASON FROM etislat_hsep.tbl_epl_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Fun',UNSUB_REASON FROM etislat_hsep.tbl_funnews_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Jokes',UNSUB_REASON FROM etislat_hsep.tbl_jokes_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'
UNION
select count(*),'Hollywood',UNSUB_REASON FROM etislat_hsep.tbl_hollywood_subscription_log WHERE unsub_date between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle,$unsubReason) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$service_name=getServiceName('2121');
			$unsubStr = "Mode_Deactivation_SMS"; //.$unsubReason;
			$insert_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name','".$circle."','$unsubStr','$count',0)";
			$queryIns = mysql_query($insert_data, $LivdbConn);
		}
	}
}

*/
mysql_close($dbConn);
echo "generated";
// end 

?>
