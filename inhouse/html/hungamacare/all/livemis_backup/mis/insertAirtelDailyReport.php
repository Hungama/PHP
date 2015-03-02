<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

$chrg_amount="0";

// delete the prevoius record
$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConnAirtel) or die(mysql_error());
// end the deletion logic

// start the code to insert the data of activation Airtel

$get_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1502,1503,1511,1507,1514,1513) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConnAirtel) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query1))
	{	
		//if($shortCode == '5464612') $service_id='15022';
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		} else if($service_id == 1502 && $plan_id==50) {
			$service_id='15022';
		}	

		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOPUP_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}

// end the code to insert the data of activation Airtel

//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1502,1503,1511,1507,1514,1513) and event_type in('SUB','TOPUP') group by circle,service_id,event_type,mode,plan_id order by event_type,plan_id"; //and plan_id!=29 

$db_query = mysql_query($get_mode_activation_query, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		//if($shortCode == '5464612') $service_id='15022';
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		} else if($service_id == 1502 && $plan_id==50) { 
			$service_id = '15022'; 
		}

		if($event_type == 'SUB') { 
			$activation_str1="Mode_Activation_".$mode;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		} else if($event_type == 'TOPUP') {
			$activation_str1="Mode_TOP-UP_IVR";
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		}
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end the code

/////////////////////////////////// pending Base ////////////////////////////////////////////////////////////
// start code to insert the Pending Base date into the database airtel 54646
$get_pending_base="select count(ani),circle from airtel_hungama.tbl_jbox_subscription where status=11 and plan_id NOT IN (50) and date(sub_date)<='$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1502)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database Airtel 54646

// start code to insert the Pending Base date into the database airtelMPMC
$get_pending_base="select count(ani),circle from airtel_hungama.tbl_jbox_subscription where status=11 and plan_id IN (50) and date(sub_date)<='$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConnAirtel) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',15022)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database Airtel 54646

// start code to insert the Pending Base date into the database Airtel MTV

$getPendingBase="select count(ani),circle from airtel_hungama.tbl_mtv_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsMTV = mysql_num_rows($pendingBaseQuery);
if ($numRowsMTV > 0)
{
	while(list($MTVCount,$MTVCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$MTVCircle','','$MTVCount','NA','NA','NA',1503)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}

// end code to insert the active base date into the databases Airtel MTV

// start code to insert the Pending Base date into the database AirtelRIA
$getPendingBase="select count(ani),circle from airtel_manchala.tbl_riya_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($RIACount,$RIACircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$RIACircle','','$RIACount','NA','NA','NA',1509)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}
// end code to insert the active base date into the databases AirtelRIA 

// start code to insert the Pending Base date into the database AirtelVH1
$getPendingBase="select count(ani),circle from airtel_vh1.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($VH1Count,$VH1Circle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$VH1Circle','','$VH1Count','NA','NA','NA',1507)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}
// end code to insert the active base date into the databases AirtelVH1 

// start code to insert the Pending Base date into the database AirtelGL
$getPendingBase="select count(ani),circle from airtel_rasoi.tbl_rasoi_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($GLCount,$GLCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$GLCircle','','$GLCount','NA','NA','NA',1511)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}
// end code to insert the active base date into the databases AirtelGL

// start code to insert the Pending Base date into the database AirtelEDU
$getPendingBase="select count(ani),circle from airtel_EDU.tbl_jbox_subscription where status=11 and date(sub_date)<='$view_date1' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($pendingBaseQuery);
if ($numRowsRIA > 0)
{
	while(list($GLCount,$GLCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$GLCircle','','$GLCount','NA','NA','NA',1514)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}
// end code to insert the active base date into the databases AirtelEDU 

// start code to insert the Pending Base date into the database AirtelMND
$getPendingBase="select count(*),circle from airtel_mnd.tbl_character_subscription1 where status=11 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription2 where status=11 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription3 where status=11 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription4 where status=11 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription5 where status=11 and date(sub_date)<='$view_date1' group by circle";

$pendingBaseQuery = mysql_query($getPendingBase, $dbConnAirtel) or die(mysql_error());
$numRowsMND = mysql_num_rows($pendingBaseQuery);
if ($numRowsMND > 0)
{
	while(list($MNDCount,$MNDCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$MNDCircle','','$MNDCount','NA','NA','NA',1513)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConnAirtel);
	}
}
// end code to insert the active base date into the databases AirtelMND



////////////////////////////////////////////////////// Active Base ///////////////////////////////////////////////////////////////

// start code to insert the active base date into the database Airtel 54646
$get_active_base="select count(*),circle from airtel_hungama.tbl_jbox_subscription where status=1 and plan_id NOT IN (50) and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database Airtel 54646

// start code to insert the active base date into the database AirtelMPMC
$get_active_base="select count(*),circle from airtel_hungama.tbl_jbox_subscription where status=1 and plan_id IN (50) and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',15022)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelMPMC

// start code to insert the active base date into the database Airtel MTV

$getActiveBase="select count(*),circle from airtel_hungama.tbl_mtv_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsMTV = mysql_num_rows($activeBaseQuery);
if ($numRowsMTV > 0)
{
	while(list($countMTV,$circleMTV) = mysql_fetch_array($activeBaseQuery))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleMTV','NA','$countMTV','NA','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database Airtel MTV

// start code to insert the active base date into the database AirtelRIA

$getActiveBase="select count(*),circle from airtel_manchala.tbl_riya_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countRIA,$circleRIA) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleRIA','NA','$countRIA','NA','NA','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelRIA 

// start code to insert the active base date into the database AirtelVH1

$getActiveBase="select count(*),circle from airtel_vh1.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countVH1,$circleVH1) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleVH1','NA','$countVH1','NA','NA','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelVH1

// start code to insert the active base date into the database AirtelGL

$getActiveBase="select count(*),circle from airtel_rasoi.tbl_rasoi_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circleGL) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleGL','NA','$countGL','NA','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelGL

// start code to insert the active base date into the database AirtelEDU

$getActiveBase="select count(*),circle from airtel_EDU.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circleGL) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleGL','NA','$countGL','NA','NA','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelEDU

// start code to insert the active base date into the database AirtelMND

$getActiveBase="select count(*),circle from airtel_mnd.tbl_character_subscription1 where status=1 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription2 where status=1 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription3 where status=1 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription4 where status=1 and date(sub_date)<='$view_date1' group by circle
union
select count(*),circle from airtel_mnd.tbl_character_subscription5 where status=1 and date(sub_date)<='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConnAirtel) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countMND,$circleMND) = mysql_fetch_array($activeBaseQuery1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circleMND','NA','$countMND','NA','NA','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the active base date into the database AirtelMND

//////////////////////////////////////////////////// Deactivation //////////////////////////////////////////////////

// start code to insert the Deactivation Base into the MIS database Airtel 54646
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id NOT IN (50) group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646 

// start code to insert the Deactivation Base into the MIS database AirtelMPMC
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id IN (50) group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',15022)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMPMC

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV

// start code to insert the Deactivation Base into the MIS database AirtelRIA
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

// start code to insert the Deactivation Base into the MIS database AirtelVH1
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data1, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelVH1 

// start code to insert the Deactivation Base into the MIS database AirtelGL
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelGL 

// start code to insert the Deactivation Base into the MIS database AirtelEDU
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_EDU.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEDU

// start code to insert the Deactivation Base into the MIS database AirtelMND
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub2 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub3 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub4 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub5 where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMND


////////////////////////////////////////////// Mode_Deactivation /////////////////////////////////////////////////////////////////////////////

// start code to insert the Deactivation Base into the MIS database Airtel 54646
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id NOT IN (50) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646

// start code to insert the Deactivation Base into the MIS database AirtelMPMC
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id IN (50) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',15022)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMPMC

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV

// start code to insert the Deactivation Base into the MIS database AirtelRIA

$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

// start code to insert the Deactivation Base into the MIS database AirtelVH1

$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelVH1 

// start code to insert the Deactivation Base into the MIS database AirtelGL
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelGL

// start code to insert the Deactivation Base into the MIS database AirtelEDU
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_EDU.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEDU

// start code to insert the Deactivation Base into the MIS database AirtelMND
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub2 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub3 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub4 where date(unsub_date)='$view_date1' group by unsub_reason,circle
union
select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub5 where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConnAirtel) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConnAirtel);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMND

///////////////////////////////////////////////////////////// CALL_TF //////////////////////////////////////////////////////////////////////

//start code to insert the data for call_tf Airtel 54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for call_tf AirtelMPMC
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','15022','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','15022','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end


//start code to insert the data for call_tf for the service of Airtel MTV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1503','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1503','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of Airtel MTV

//start code to insert the data for call_tf for the service of AirtelRIA
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1509','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1509','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of AirtelRIA

//start code to insert the data for call_tf for the service of AirtelVH1
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of AirtelvH1

//start code to insert the data for call_tf for the service of AirtelGL
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelGL' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of AirtelGL

//start code to insert the data for call_tf for the service of AirtelEDU
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1514','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1514','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of AirtelEDU

//start code to insert the data for call_tf for the service of AirtelMND
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_tf for the service of AirtelMND

//////////////////////////////////////////////////////////// CALLS_T /////////////////////////////////////////////////////////////////////////////

//start code to insert the data for call_t for the service of Airtel 54646
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for call_t for the service of Airtel 54646

//start code to insert the data for call_t for the service of AirtelVH1
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55841' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55841' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}
//end code to insert the data for call_t for the service of AirtelVH1

//start code to insert the data for call_t for the service of AirtelGL
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55001' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle NOT IN ('DEL') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55001' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle NOT IN ('DEL') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}
//end code to insert the data for call_t for the service of AirtelGL

//start code to insert the data for call_t for the service of AirtelMND
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and operator='airm' and circle NOT IN ('DEL') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelMND' as service_name,date(call_date),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and operator='airm' and circle NOT IN ('DEL') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConnAirtel);
	}
}
//end code to insert the data for call_t for the service of AirtelMND

/////////////////////////////////////////////////////////////// MOU_TF //////////////////////////////////////////////////////////////////////////

//start code to insert the data for mous_tf for Airtel54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for mous_tf for Airtel54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','15022','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','15022','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for mous_tf for Airtel mtv
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1503','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1503','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for Airtel mtv

//start code to insert the data for mous_tf for AirtelRIA
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1509','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1509','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for AirtelRIA

//start code to insert the data for mous_tf for AirtelVH1
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for AirtelVH1

//start code to insert the data for mous_tf for AirtelGL
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for AirtelGL

//start code to insert the data for mous_tf for AirtelEDU
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1514','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1514','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for AirtelEDU

//start code to insert the data for mous_tf for AirtelMND
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_tf for AirtelMND

///////////////////////////////////////////////////////////  MOU_T ///////////////////////////////////////////////////////////////////////////////

// start code to insert the data for mous_t for Airte54646
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_t for Airtel54646


// start code to insert the data for mous_t for AirteVH1
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'55841' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'55841' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_t for AirtelVH1

// start code to insert the data for mous_t for AirtelGL
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1) $mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_t for AirtelGL

// start code to insert the data for mous_t for AirtelMND
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1) $mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConnAirtel);
	}
}
// end code to insert the data for mous_t for AirtelMND

///////////////////////////////////////////////////////////  PULSE_TF ///////////////////////////////////////////////////////////////////////////////

//start code to insert the data for PULSE_TF airtel 54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for PULSE_TF AirtelMPMC
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','15022','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','15022','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for PULSE_TF airtel MTV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1503','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1503','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF airtel MTV

//start code to insert the data for PULSE_TF AirtelRIA
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1509','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1509','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelRIA 

//start code to insert the data for PULSE_TF AirtelVH1
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelVH1 

//start code to insert the data for PULSE_TF AirtelGL
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelGL

//start code to insert the data for PULSE_TF AirtelEDU
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1514','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1514','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelEDU

//start code to insert the data for PULSE_TF AirtelMND
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelMND

//////////////////////////////////////////////////////// PULSE_T ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for PULSE_TF Airtel54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF Airtel54646

//start code to insert the data for PULSE_TF AirtelVH1
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelVH1

//start code to insert the data for PULSE_TF AirtelGL
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelGL

//start code to insert the data for PULSE_TF AirtelMND
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and operator ='airm' and circle NOT IN ('DEL') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and operator ='airm' and circle NOT IN ('DEL') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConnAirtel);
	}
}
//end code to insert the data for PULSE_TF AirtelMND

//////////////////////////////////////////////////////// UU_TF ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for Unique Users  for airtel 54646 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end Unique Users  for Tata Airtel 54646 

//start code to insert the data for Unique Users  for AirtelMPMC
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','15022','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','15022','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end Unique Users for AirtelMPMC

//start code to insert the data for Unique Users  for airtel Mtv
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1503','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1503','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end

//start code to insert the data for Unique Users  for AirtelRIA
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1509','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1509','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

// end AirtelRIA 

//start code to insert the data for Unique Users  for AirtelVH1
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelVH1 

//start code to insert the data for Unique Users  for AirtelGL
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status=1 group by circle)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelGL 

//start code to insert the data for Unique Users  for AirtelEDU
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1514','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1514','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelEDU

//start code to insert the data for Unique Users  for AirtelMND
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' and status=1 group by circle)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelMND


/////////////////////////////////////////////////////////////// UU_T /////////////////////////////////////////////////////////////////////////


//start code to insert the data for Unique Users  for Airtel54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end Airtel54646

//start code to insert the data for Unique Users  for AirtelVH1
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelVH1

//start code to insert the data for Unique Users  for AirtelGL
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelGL

//start code to insert the data for Unique Users  for AirtelMND
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConnAirtel);
	}
}
// end AirtelMND


/////////////////////////////////////////////////////////////// SEC_TF /////////////////////////////////////////////////////////////////////////

//start code to insert the data for SEC_TF  for airtel 54646 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for airtel 54646 


//start code to insert the data for SEC_TF  for AirtelMPMC
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','15022','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','15022','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelMPMC

//start code to insert the data for SEC_TF  for airtel Mtv 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1503','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1503','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for airtel Mtv 

//start code to insert the data for SEC_TF for AirtelRIA
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1509','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1509','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelRIA 

//start code to insert the data for SEC_TF for AirtelVH1
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelVH1 

//start code to insert the data for SEC_TF for AirtelGL
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelGL

//start code to insert the data for SEC_TF for AirtelEDU
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1514','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1514','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelEDU

//start code to insert the data for SEC_TF for AirtelMND
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_TF  for AirtelMND

//////////////////////////////////////////////////////// SEC_T ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for SEC_T for Airtel54646
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_T  for Airtel54646

//start code to insert the data for SEC_T for AirtelVH1
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_T  for AirtelVH1

//start code to insert the data for SEC_T for AirtelGL
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_T  for AirtelGL

//start code to insert the data for SEC_T for AirtelMND
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConnAirtel);
	}
}
// end insert the data for SEC_T  for AirtelMND

///////////////////////////////////////////////////// RBT DATA FOR AirtelVH1////////////////////////////////////////////////////////////////////////

//start code to insert the data for RBT_*  
$rbt_tf=array();
$rbt_query="select count(*),circle,Intype from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and status=1 and Intype in('CRBT','RNG') group by circle,Intype";

$rbt_tf_result = mysql_query($rbt_query, $dbConnAirtel) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='CRBT')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1507','NA','NA','NA')";
		}
		elseif($rbt_tf[2]=='RNG')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1507','NA','NA','NA')";
		}
		$queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConnAirtel);
	}
}
// end


// to inser the Migration data

$get_migrate_date="select Intype,count(*),circle from master_db.tbl_crbt_download where DATE(request_date)='$view_date1' and status=1 and Intype in('CRBT','RNG') group by circle,Intype";

$get_query = mysql_query($get_migrate_date, $dbConnAirtel) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0)
{
	$get_query = mysql_query($get_migrate_date, $dbConnAirtel) or die(mysql_error());
	while(list($crbt_mode,$count,$circle) = mysql_fetch_array($get_query))
	{
		if($circle=='')
				$circle='NA';
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1507','NA','$count','NA','NA','NA')";
		$queryIns1 = mysql_query($insert_data1, $dbConnAirtel);
	}
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConnAirtel);
echo "generated";
?>
