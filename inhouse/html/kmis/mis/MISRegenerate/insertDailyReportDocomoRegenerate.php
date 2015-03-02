<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$view_date1='2012-07-18';
echo $view_date1;

$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in (1001,1005,1002,1003,1009,1010,1011)";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////


/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////////
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1001,1002,1003,1009,1010,1011) and event_type in('SUB') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			if($circle=='') $circle='UND';
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1001,1002,1003,1009,1010,1011) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		/*if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		else*/
		if($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOP-UP_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query4="select count(msisdn),circle,chrg_amount,service_id,plan_id from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1005) and event_type in('SUB') group by circle,service_id,chrg_amount,plan_id";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if($numRows4 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($query4))
	{		
		//$circle_info=array();
		if($circle=='') $circle='UND';
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($plan_id==20)
				$activation_str="Activation_Ticket_15";
			elseif($plan_id==33)
				$activation_str="Activation_Ticket_20";
			elseif($plan_id==34)
				$activation_str="Activation_Ticket_10";
			elseif($plan_id==19)
				$activation_str="Activation_Follow_".$charging_amt;
			else
				$activation_str="Activation_".$charging_amt;

			$revenue=$charging_amt*$count;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// remove the 1005 FMJ id from this query : show wid 

$get_activation_query3="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from master_db.tbl_billing_success WHERE DATE(response_time)='$view_date1' and service_id in(1005) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount, event_type, plan_id";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query3))
	{
		if($circle=='') $circle='UND';
		//$circle=array();
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		if($event_type=='RESUB')
		{
			if($plan_id==20)
				$charging_str="Renewal_Ticket_15";
			elseif($plan_id==33)
				$charging_str="Renewal_Ticket_20";
			elseif($plan_id==34)
				$charging_str="Renewal_Ticket_10";
			elseif($plan_id==19)
				$charging_str="Renewal_Follow_".$charging_amt;
			else
				$charging_str="Renewal_".$charging_amt;
			$revenue=$charging_amt*$count;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOP-UP_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
} 

/////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646/////////


////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1001,1005,1003,1009,1010,1011) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		$insert_data1="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
			$activation_str1="Mode_Activation_".$mode;
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$activation_str1="Mode_TOP-UP_IVR";
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		$insert_data2="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
			$activation_str1="Mode_Activation_".$mode;
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		if($event_type=='TOPUP')
		{
			$activation_str1="Mode_TOP-UP_IVR";
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


///////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base="select count(ani),circle from docomo_radio.tbl_radio_subscription where status=11 AND plan_id != 40 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1001)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music///////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo 54646///////////////////////////////////


$get_pending_base="select count(ani),circle from hungama.tbl_jbox_subscription where status=11 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1002)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////



///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Filmi Meri Jaan//////////////////////


$getPendingBase="select count(ani),circle from docomo_starclub.tbl_jbox_subscription where status=11 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='') $fmjCircle='UND';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1005)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Miss Riya////////////////////////////////////


$getPendingBase="select count(ani),circle from docomo_manchala.tbl_riya_subscription where status=11 and plan_id!=73 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='') $fmjCircle='UND';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1009)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////


////////// Start code to insert the Pending Base date into the database Docomo MTV////////////////////////////////////////////////////////////


$getPendingBase="select count(ani),circle from docomo_hungama.tbl_mtv_subscription where status=11 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='') $fmjCircle='UND';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1003)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo MTV//////////////////////////////////////////////////////////////

////////// Start code to insert the Pending Base date into the database Docomo REDFM////////////////////////////////////////////////////////////

$getPendingBase="select count(ani),circle from docomo_redfm.tbl_jbox_subscription where status=11 and plan_id!=72 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='') $fmjCircle='UND';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1010)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo REDFM//////////////////////////////////////////////////////////


////////// Start code to insert the Pending Base date into the database Docomo GL////////////////////////////////////////////////////////////

$getPendingBase="select count(ani),circle from docomo_rasoi.tbl_rasoi_subscription where status=11 and plan_id IN (66,75,76) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='') $fmjCircle='UND';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1011)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo GL//////////////////////////////////////////////////////////

///////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base="select count(*),circle from docomo_radio.tbl_radio_subscription where status=1 AND plan_id != 40 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo 54646///////////////////////////////////////////////////

$get_active_base="select count(*),circle from docomo_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////////////////



/////////////////////////// start code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////

$getActiveBase="select count(*),circle from docomo_starclub.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='') $circlefmj='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan/////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo Miss Riya/////////////////////////////////

$get_active_base="select count(*),circle from docomo_manchala.tbl_riya_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=73 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Miss Riya////////////////////////////////////


//////////////////////////////// start code to insert the active base date into the database Docomo MTV ////////////////////////////////////////////

$getActiveBase="select count(*),circle from docomo_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='') $circlefmj='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////////////

//////////////////////////////// start code to insert the active base date into the database Docomo REDFM ////////////////////////////////////////////

$getActiveBase="select count(*),circle from docomo_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=72 group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='') $circlefmj='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo REDFM////////////////////////////////////////////

//////////////////////////////// start code to insert the active base date into the database Docomo GL ////////////////////////////////////////////

$getActiveBase="select count(*),circle from docomo_rasoi.tbl_rasoi_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id IN (66,75,76) group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='') $circlefmj='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo GL////////////////////////////////////////////


//////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id != 40 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////


////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo 54646//////////////////////


//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Filmi Meri Jaan///////////////////////////////


$get_deactivation_base="select count(*),circle from docomo_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////


//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Miss Riya////////////////////////////////////////////


$get_deactivation_base="select count(*),circle from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id!=73 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base="select count(*),circle from docomo_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo MTV////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base="select count(*),circle from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=72 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo MTV////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo GL//////////////////////

$get_deactivation_base="select count(*),circle from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (66,75,76) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo GL////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id != 40 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{	
		if($circle=='') $circle='UND';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{ 
		if($circle=='') $circle='UND';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo 54646 //////////////////////


/////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Filmi Meri Jaan  //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



//////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Miss Riya  //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id!=73 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo MTV

//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo REDFM////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=72 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo REDFM

//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo GL////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (66,75,76) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo GL

//////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('TATM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr','$call_tf[1]','0','$call_tf[2]','','1001','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('TATM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values ('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1001','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr1='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr1='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO 54646 ////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr2='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr2='N_CALLS_TF';
			
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr2','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of Tata Docomo Mtv////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr3='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr3='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr3','$call_tf[1]','0','$call_tf[2]','','1003','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1003','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the data for call_tf for the service of Tata Docomo Mtv//////////////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of Docomo Filmi Meri Jaan////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo FMJ' as service_name,date(call_date),status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr4='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr4='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr4','$call_tf[1]','0','$call_tf[2]','','1005','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo FMJ' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1005','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////////// end code to insert the data for call_tf for the service of Docomo Filmi Meri Jaan///////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO Redfm ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoREDFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1010','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoREDFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1010','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo Redfm ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO GL ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo GL ///////////////////////////////////////////////////////////////////


//////////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$callTStr1='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$callTStr1='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callTStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////



//////////////start code to insert the data for call_tf for Tata DocomO Miss Riya ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==5464669)
		{
			if($call_tf[6]==1)
				$call_tf[0]='L_CALLS_T';
			elseif($call_tf[6]!=1)
				$call_tf[0]='N_CALLS_T';
		}
		else
		{
			if($call_tf[6]==1)
				$call_tf[0]='L_CALLS_T_1';
			elseif($call_tf[6]!=1)
				$call_tf[0]='N_CALLS_T_1';
		}
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==5464669) {
			$call_tf[0]='CALLS_T';
		} else {
			$call_tf[0]='CALLS_T_1';
		}
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////


//////////////start code to insert the data for call_tf for Tata DocomoGL ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'DocomoGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{			
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo GL ///////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//start code to insert the data for mous_tf for tata Docomo Endless
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1001','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1001','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// ----------------------- end ---------------------------

//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646


//start code to insert the data for mous_tf for Tata Docomo Miss Riya
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for Tata Docomo Miss Riya

////////////////////////////////start code to insert the data for mous_tf for tata Docomo mtv////////////////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1003','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1003','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for tata Docomo mtv


//start code to insert the data for mous_tf for tata Docomo Filmi meri jaan 
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1005','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1005','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo Filmi meri jaan 


//start code to insert the data for mous_tf for tata Docomo Redfm
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoRedfm' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1010','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoRedfm' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1010','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo Redfm

//start code to insert the data for mous_tf for tata DocomoGL
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata DocomoGL


//start code to insert the data for mous_t for tata Docomo 54646
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646



//start code to insert the data for mous_t for tata Docomo Miss Riya
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==5464669) {
			if($mous_tf[7]==1) $mous_tf[0]='L_MOU_T';
			if($mous_tf[7]!=1) $mous_tf[0]='N_MOU_T';
		}elseif($mous_tf[6]==5464668) {
			if($mous_tf[7]==1) $mous_tf[0]='L_MOU_T_1';
			if($mous_tf[7]!=1) $mous_tf[0]='N_MOU_T_1';
		}
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==5464669) {
			$mous_tf[0]='MOU_T';
		} elseif($mous_tf[6]==5464668) {
			$mous_tf[0]='MOU_T_1';
		}
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646

//start code to insert the data for mous_t for tata DocomoGL
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_T';
		if($mous_tf[6]!=1) $mous_tf[0]='N_MOU_T';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{		
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata DocomoGL


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1001','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1001','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice//////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////



/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Miss Riya ///////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1009','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1009','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////

///////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocmoFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1005','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocmoFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1005','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1003','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1003','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////Docomo RedFM /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1010','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1010','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////Docomo RedFM /////////////////////////////////////////////////////////////////////


///////////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1011','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1011','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoMissRiya' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse, dnis, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[6]==5464669) {
			if($pulse_tf1[7]==1) $pulse_tf1[0]='L_PULSE_T';
			if($pulse_tf1[7]!=1) $pulse_tf1[0]='N_PULSE_T'; 
			//$pulse_tf1[0]='PULSE_T';
		} else {
			if($pulse_tf1[7]==1) $pulse_tf1[0]='L_PULSE_T_1';
			if($pulse_tf1[7]!=1) $pulse_tf1[0]='N_PULSE_T_1';
			//$pulse_tf1[0]='PULSE_T_1';
		}
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1009','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoMissRiya' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse, dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[6]==5464669) {
			$pulse_tf1[0]='PULSE_T';
		} else {
			$pulse_tf1[0]='PULSE_T_1';
		}
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1009','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata DocomoGL /////////////////////////////////////////
$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[6]==1) $pulse_tf1[0]='L_PULSE_T';
		if($pulse_tf1[6]!=1) $pulse_tf1[0]='N_PULSE_T'; 
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1011','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1011','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata DocomoGL /////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////

///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////


///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464626' and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////


///////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[5]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1003','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1003','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////// end code to insert the data for Unique Users  for Tata Docomo Mtv///////////////////////////////////////////////////////


/////////////start code to insert the data for Unique Users  for Tata Docomo Filmi Meri jaan//////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active') 
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active') 
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1005','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1005','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////// end Unique Users  for Tata Docomo Filmi Meri jaan/////////////////////////////////////////////////////////////////////////


/////////////start code to insert the data for Unique Users  for Tata Docomo Redfm//////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active') 
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active') 
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////// end Unique Users  for Tata Docomo Redfm/////////////////////////////////////////////////////////////////////////


///////////////////start code to insert the data for Unique Users_T  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' and status IN (1)) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active') 
			$uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active') 
			$uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

///////////////////////////////////////////// end Unique Users  for Tata Docomo 54646 ////////////////////////////////////////

///////////////////start code to insert the data for Unique Users_T  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'DocomoRia' as service_name,date(call_date),dnis,status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status IN (1)) group by circle,dnis)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'DocomoRia' as service_name,date(call_date),dnis,status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5]=='5464669')
		{
			if($uu_tf[6]==1) $uu_tf[0]='L_UU_T';
			if($uu_tf[6]!=1) $uu_tf[0]='N_UU_T';
			//$uu_tf[0]='UU_T';
		}
		elseif($uu_tf[5]=='5464668')
		{
			if($uu_tf[6]==1) $uu_tf[0]='L_UU_T_1';
			if($uu_tf[6]!=1) $uu_tf[0]='N_UU_T_1';
			//$uu_tf[0]='UU_T_1';
		}
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5]=='5464669') {
			$uu_tf[0]='UU_T';
		} elseif($uu_tf[5]=='5464668') {
			$uu_tf[0]='UU_T_1';
		}
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

///////////////////////////////////////////// end Unique Users  for Tata Docomo 54646 ////////////////////////////////////////


///////////////////start code to insert the data for Unique Users_T  for Tata DocomoGL //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status IN (1)) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5]==1) $uu_tf[0]='L_UU_T';
		if($uu_tf[5]!=1) $uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1011','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1011','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

///////////////////////////////////////////// end Unique Users  for Tata DocomoGL ////////////////////////////////////////


/////////////////////start code to insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end insert the data for SEC_TF  for tata Docomo Endless 


///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec), status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{		
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/////////////////////////////////// end insert the data for SEC_TF  for tata Docomo 54646 ///////////////////////////////////////////////////

////////////////////////start code to insert the data for SEC_TF  for tata Docomo Miss Riya///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/////////////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo 54646 /////////////////////////////////////////


///////////////////////start code to insert the data for SEC_TF  for tata Docomo Filmi Meri Jaan ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec), status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1005','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1005','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

////////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Filmi Meri Jaan ////////////////////////////////////////////


////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo REdfm /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1010','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1010','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
///////////////////////////////////// end insert the data for SEC_TF  for tata Docomo REdfm ///////////////////////////////////////////////


////////////////////////////////start code to insert the data for SEC_TF  for tata DocomoGL /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
///////////////////////////////////// end insert the data for SEC_TF  for tata DocomoGL ///////////////////////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_T  for tata Docomo 54646///////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for tata Docomo 54646 



///////////////////////////////////////////start code to insert the data for SEC_T  for tata Docomo 54646/////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464668','5464669') and operator ='tatm' group by circle,dnis,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==5464669) {
			if($sec_tf[7]==1) $sec_tf[0]='L_SEC_T';
			if($sec_tf[7]!=1) $sec_tf[0]='N_SEC_T'; //$sec_tf[0]='SEC_T';
		} else {
			if($sec_tf[7]==1) $sec_tf[0]='L_SEC_T_1';
			if($sec_tf[7]!=1) $sec_tf[0]='N_SEC_T_1'; //$sec_tf[0]='SEC_T_1';
		}
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464668','5464669') and operator ='tatm' group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==5464669) {
			$sec_tf[0]='SEC_T';
		} else {
			$sec_tf[0]='SEC_T_1';
		}
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end insert the data for SEC_TF  for tata Docomo 54646 


///////////////////////////////////////////start code to insert the data for SEC_T  for tata DocomoGL /////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end insert the data for SEC_TF  for tata DocomoGL 


//start code to insert the data for Activation_Follow_5 for Tata Docomo Filmi Meri jaan

//$getActiveBase="select count(ani),circle from follow_up.tbl_subscription where date(sub_date)='$view_date1' and user_bal = 5 and status = 1 and service_id = 1005";

$getActiveBase="select count(ani),circle from follow_up.tbl_subscription where date(sub_date)='$view_date1' and user_bal = 5 and service_id = 1005 and status = 1";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Follow_5' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//start code to insert the data for Activation_Follow_5 for Tata Docomo Filmi Meri jaan

//start code to insert the data for Renewal_Follow_5 for Tata Docomo Filmi Meri jaan

//$getActiveBase="select count(ani),circle from follow_up.tbl_unsubscription where date(sub_date)='$view_date1' and user_bal = 5 and status = 0 and service_id = 1005";

$getActiveBase="select count(ani),circle from follow_up.tbl_unsubscription where date(sub_date)='$view_date1' and user_bal = 5 and service_id = 1005 ";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		//$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Follow_5' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//start code to insert the data for Renewal_Follow_5 for Tata Docomo Filmi Meri jaan


//start code to insert the data for Activation_Ticket_15 for Tata Docomo Filmi Meri jaan

//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_15',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 15 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		// $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_15' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//End code to insert the data for Activation_Ticket_15 for Tata Docomo Filmi Meri jaan

//start code to insert the data for Activation_Ticket_20 for Tata Docomo Filmi Meri jaan

//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_20',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 20 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		// $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_20' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//End code to insert the data for Activation_Ticket_20 for Tata Docomo Filmi Meri jaan

//start code to insert the data for Activation_Ticket_10 for Tata Docomo Filmi Meri jaan

//$getActiveBase="select count(ani),circle,service_id,'Activation_Ticket_10',mode_of_sub from docomo_starclub.tbl_celebrity_evt_ticket where user_bal = 10 and status = 1 and service_id = 1005";

$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		// $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Activation_Ticket_10' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//End code to insert the data for Activation_Ticket_10 for Tata Docomo Filmi Meri jaan


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//start code to insert the data for RBT_*  
$rbt_tf=array();
$rbt_query="select count(*),circle,req_type from docomo_radio.tbl_crbtrng_totalreqs where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='CRBT')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
		}
		elseif($rbt_tf[2]=='RNG')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
		}


		$queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}
// end


// to inser the Migration data

$get_migrate_date="select crbt_mode,count(1),circle from docomo_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by crbt_mode,circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0)
{
	$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
	while(list($crbt_mode,$count,$circle) = mysql_fetch_array($get_query))
	{
		if($circle=='')
				$circle='NA';
		if($crbt_mode=='ACTIVATE')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='MIGRATE')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1001','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD15')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1001','NA','$count','NA','NA','NA')";
		}

		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}
echo "done";
mysql_close($dbConn);


?>
