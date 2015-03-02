<?php 

/////////////////////////////////////////////////////////// pending Base ////////////////////////////////////////////////////////////

/////////////////////// start code to insert the Pending Base date into the database airtel 54646///////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='Airtel54646' 
    and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base date into the database Airtel 54646

////////////////////// start code to insert the Pending Base date into the database airtelMPMC///////////////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelComedy' 
and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1518)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////////////////////// end code to insert the active base date into the database Airtel 54646////////////////////

///////////////////////// start code to insert the Pending Base date into the database Airtel MTV///////////////////////////////////////////

$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='MTVAirtel' 
and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////////////// end code to insert the active base date into the databases Airtel MTV/////////////////////////

/////////////////// start code to insert the Pending Base date into the database AirtelRIA///////////////////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='RIAAirtel' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////////// end code to insert the active base date into the databases AirtelRIA ////////////////////////////////////////

//////////////////////////// start code to insert the Pending Base date into the database AirtelVH1/////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='VH1Airtel' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////// end code to insert the active base date into the databases AirtelVH1 ////////////////////////////////////////////

///////////////////////// start code to insert the Pending Base date into the database AirtelGL////////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelGL' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////// end code to insert the active base date into the databases AirtelGL///////////////////////////////////////
////////////////////////// start code to insert the Pending Base date into the database AirtelEDU//////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelPD' 
    and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////// end code to insert the active base date into the databases AirtelEDU //////////////////////////////////////////////
/////////////////////////// start code to insert the Pending Base date into the database AirtelMND/////////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelMND' and status='Pending' 
and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code insert the Pending Base date into the database AirtelMND////////////////////////////////////////

///////////////////////////////////////////////////////AirtelMNDKK///////////////////////////////////////////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelMNDKK' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',15131)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////////////////// end code to insert the active base date into the databases AirtelMNDKK/////////////////////////////////////////////

///////////////////////// start code to insert the Pending Base date into the database AirtelDevo//////////////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelDevo' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1515)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////// end code to insert the active base date into the databases AirtelDevo ////////////////////////////////////////

////////////////////////////// start code to insert the Pending Base date into the database AirtelSE//////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelSE' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1517)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////// end code to insert the active base date into the databases AirtelSE////////////////////////////////////

////////////////////////////////// start code to insert the Pending Base date into the database AirtelPK//////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelPK' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1520)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////////////////// end code to insert the active base date into the databases AirtelPK//////////////////////////////

/////////////////////////// start code to insert the Pending Base date into the database AirtelEU/////////////////////////////////////////
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelEU' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1501)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
////////////////////////////////////////// end code to insert the active base date into the databases AirtelEU//////////////////////////

/////////////////////////// start code to insert the Pending Base date into the database AirtelCK/////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelRegKK' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',15222)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////////// end code to insert the active base date into the databases AirtelCK///////////////////////////////////////

//////////////////////////////////// start code to insert the Pending Base date into the database AirtelMAN/////////////////////////////////
    
$getActiveBase="select count(*),circle from mis_db.tbl_activepending_base where service='AirtelRegTN' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',15221)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////////////////// end code to insert the active base date into the databases AirtelMAN////////////////////////////////////
?>