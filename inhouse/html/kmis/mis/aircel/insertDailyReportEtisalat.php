<?php
//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

if($_REQUEST['date']) {
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//echo $view_date1="2013-04-02";

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}
//-------------------------- Etisalat MIS --------------------------------

// delete the prevoius record
$deleteprevioousdata="delete from mis_db.dailyReportEtislat where date(report_date)='$view_date1' and service_id in ('2121')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//Active base
$activeBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Motive' FROM etislat_hsep.tbl_mot_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Lifestyle' FROM etislat_hsep.tbl_lsp_subscription WHERE status=1 and date(sub_date)<='$view_date1'";

$activeBaseQuery = mysql_query($activeBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($activeBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($activeBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Pending Base(11,0,12)
$pendingBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Motive' FROM etislat_hsep.tbl_mot_subscription WHERE status!=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Lifestyle' FROM etislat_hsep.tbl_lsp_subscription WHERE status!=1 and date(sub_date)<='$view_date1'";


$pendingBaseQuery = mysql_query($pendingBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($pendingBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Activation
$get_activation_query="select count(msisdn),chrg_amount,service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in (2121) and event_type in('SUB') group by service_id,chrg_amount,plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") 
				$circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";
                        
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Mode Activation
$get_mactivation_query="select count(msisdn),chrg_amount,service_id,plan_id,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,chrg_amount,plan_id,mode";
$get_mactivation_result = mysql_query($get_mactivation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_mactivation_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id,$mode) = mysql_fetch_array($get_mactivation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$activation_str="Mode_Activation_".$mode; //.$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// Renewal
$get_renewal_query="select count(msisdn),chrg_amount,service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('RESUB') group by service_id,chrg_amount,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$renewal_str="Renewal_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Deactivation
$unsubBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Motive' FROM etislat_hsep.tbl_mot_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Lifestyle' FROM etislat_hsep.tbl_lsp_subscription_log WHERE  date(unsub_date)='$view_date1'";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') 
			$circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous, pulse,total_sec,service_id) values('$view_date1','Deactivation_75' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// Mode Deactivation
$unsubBase = "select count(*),'SPL',UNSUB_REASON FROM etislat_hsep.tbl_sfp_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'EPL',UNSUB_REASON FROM etislat_hsep.tbl_epl_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Fun',UNSUB_REASON FROM etislat_hsep.tbl_funnews_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Jokes',UNSUB_REASON FROM etislat_hsep.tbl_jokes_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Hollywood',UNSUB_REASON FROM etislat_hsep.tbl_hollywood_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Motive',UNSUB_REASON FROM etislat_hsep.tbl_mot_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Lifestyle',UNSUB_REASON FROM etislat_hsep.tbl_lsp_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle,$unsubReason) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') 
				$circle='Others';
			if(strtoupper($unsubReason)=='INVOL')
				$unsubReason='in';
			$unsubStr = "Mode_Deactivation_".$unsubReason;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','$unsubStr' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_content
$get_activation_query="select count(*),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type='Alert' group by plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172")
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";
			else $circle="Others";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_Content','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_Content
$get_activation_query="select count(distinct ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type='Alert' group by plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";
			else $circle="Others";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_Content','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_MO
$get_renewal_query="select count(msisdn),service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id
UNION
select count(msisdn),service_id,plan_id from master_db.tbl_billing_failure nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172")
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171")
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_MO','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_MO
$get_renewal_query="select count(distinct msisdn),service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id
UNION
select count(distinct msisdn),service_id,plan_id from master_db.tbl_billing_failure nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") 
				$circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_MO','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_Invalid_MO
$get_activation_query="select count(ani),valid_status FROM etislat_hsep.tbl_mo_received where date(date_time)='$view_date1' and valid_status=0 group by valid_status";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$status) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			$circle="Others";
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_Invalid_MO','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}


// SMS_MT
$get_renewal_query="select count(msisdn),plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by plan_id
UNION
select count(ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type IN ('Alert','PRERENEW') group by plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		$service_id='2121';
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") 
				$circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") 
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_MT','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_MT
$get_renewal_query="select count(distinct msisdn),plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by plan_id
UNION
select count(distinct ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type IN ('Alert','PRERENEW') group by plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		$service_id='2121';
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166")
				$circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172")
				$circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") 
				$circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") 
				$circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") 
				$circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") 
				$circle="Astro";
			elseif($plan_id=="174" || $plan_id =="175" || $plan_id =="176") 
				$circle="Lifestyle";
			elseif($plan_id=="177" || $plan_id =="178" || $plan_id =="179") 
				$circle="Motive";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_MT','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}
//--------------------------- End here -----------------------------------
mysql_close($LivdbConn);

mysql_close($dbConn);
echo "done";
?>
