<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
$flag=0;
// delete the prevoius record
if(isset($_REQUEST['date'])) {
	$view_date1=trim($_REQUEST['date']);
	$flag=1;
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
echo $view_date1="2013-11-26";
//$flag=1;
if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

$circle_info1=array('Delhi'=>'DEL','Gujarat'=>'GUJ','WestBengal'=>'WBL','Bihar'=>'BIH','Rajasthan'=>'RAJ','UP WEST'=>'UPW','Maharashtra'=>'MAH','Andhra Pradesh'=>'APD','UP EAST'=>'UPE','Assam'=>'ASM','Tamil Nadu'=>'TNU','Kolkata'=>'KOL','NE'=>'NES','Chennai'=>'CHN','Orissa'=>'ORI','Karnataka'=>'KAR',
'Haryana'=>'HAR','Punjab'=>'PUN','Mumbai'=>'MUM','Madhya Pradesh'=>'MPD','Jammu-Kashmir'=>'JNK',"Punjab"=>'PUB','Kerala'=>'KER','Himachal Pradesh'=>'HPD','Other'=>'UND','Haryana'=>'HAY');

//////////////////////////////// Start delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
//echo $view_date1="2012-05-01";

$deleteprevioousdata="delete from mis_db.mtsDailyReport where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////

///////////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646/////////

// remove the 1005 FMJ id from this query : show wid
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock  
        where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126) 
        and event_type in('SUB','RESUB','TOPUP','Event','EVENT') group by circle,service_id,chrg_amount,event_type,plan_id";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{  
               $flag=0;
		if($plan_id == '29' && $service_id=='1101') $flag=1; //$service_id='11012';
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			if($service_id==1106) 
                            $activation_str="Activation_Ticket_".$charging_amt;
                     $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			if($flag) {
				$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
				$queryIns = mysql_query($insert_data1, $dbConn);
			}
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			if($flag) {
				$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
				$queryIns = mysql_query($insert_data1, $dbConn);
			}
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOP-UP_".$charging_amt;
			$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			if($flag) {
				$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
				$queryIns = mysql_query($insert_data1, $dbConn);
			}
		}
		elseif(strtoupper($event_type)=='EVENT')
		{
			if($charging_amt=='02')
			$charging_amt=2;
			else if($charging_amt=='03')
			$charging_amt=3;
			else if($charging_amt=='04')
			$charging_amt=4;
			else if($charging_amt=='06')
			$charging_amt=6;
			else if($charging_amt=='08')
			$charging_amt=8;
			else if($charging_amt=='09')
			$charging_amt=9;

		
			$charging_str="Event_".$charging_amt;
			$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			if($flag) {
				$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
				$queryIns = mysql_query($insert_data1, $dbConn);
			}
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////


//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,mode,plan_id,event_type from ".$successTable." nolock  
        where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126) 
        and event_type in('SUB','Event','EVENT') group by circle,service_id,mode,plan_id,event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id,$event_type) = mysql_fetch_array($db_query))
	{
		 $flag=0;
		if($plan_id == '29' && $service_id=='1101') 
                    $flag=1; //$service_id='11012';

		if($mode == "OBD-Artist" || $mode == "push") 
                    $mode = "OBD";
		elseif($mode == "TIVR") 
                    $mode = "IVR";

		$activation_str1="Mode_Activation_".$mode;
		if($service_id==1106)
			$activation_str1="Mode_Activation_Ticket_".$mode;
                
                if(strtoupper($event_type)=='EVENT')
                            $activation_str1="Mode_Event_".$mode;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);

		if($flag) {
			$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','11012','$charging_amt','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data1, $dbConn);
		}
	}
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


/////////////////////////////////// Start the code to Renewal Record mode wise ////////////////////////////////////////////////////////

 $get_mode_renewal_query="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable." nolock  
         where DATE(response_time)='$view_date1' and service_id in(1101,1102,1125,1103,1111,1110,1116,1113,1123,1126) 
         and event_type='RESUB' group by circle,service_id,mode order by mode,plan_id";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query1))
	{
		$flag=0;
		if($plan_id == '29' && $service_id=='1101') $flag=1; // $service_id='11012';

		if($mode == "OBD-Artist" || $mode == "OBD-MS" || $mode == "push" || $mode == "push2" || $mode == "OBD-LBR" || $mode == "OBD_LBR" || $mode == "OBD_One97" || $mode == "OBD_VG" ) $mode = "OBD";
		elseif($mode == "TIVR") $mode = "IVR";

		$renewal_str="Mode_Renewal_".$mode;
		$renewal_str1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		$queryIns1 = mysql_query($renewal_str1, $dbConn);

		if($flag) {
			$renewal_str2="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','11012','$charging_amt','$count','NA','NA','NA')";
			$queryIns1 = mysql_query($renewal_str2, $dbConn);
		}
	}
}


///////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////

$flag=0;

///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid //////////////////////////////////////////////////

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock 
        where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB','RESUB','TOPUP') 
        group by circle,service_id,chrg_amount,event_type,plan_id";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($event_type=='SUB')
		{
				$activation_str="Activation_".$charging_amt;
				if($plan_id==11)
					$activation_str="Activation_Ticket_20"; //.$charging_amt;
				if($plan_id==12)
					$activation_str="Activation_Ticket_15"; //.$charging_amt;
				if($plan_id==13)
					$activation_str="Activation_Ticket_10"; //.$charging_amt;
				if($plan_id==19)
					$activation_str="Activation_Ticket_5"; //.$charging_amt;
			$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
				$activation_str="Renewal_".$charging_amt;
				if($plan_id == 11)
					$activation_str="Renewal_Ticket_20"; //.$charging_amt;
				if($plan_id == 12)
					$activation_str="Renewal_Ticket_15"; //.$charging_amt;
				if($plan_id == 13)
					$activation_str="Renewal_Ticket_10"; //.$charging_amt;
				if($plan_id == 19)
					$activation_str="Renewal_Ticket_5"; //.$charging_amt;
			$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
				$charging_str="TOP-UP_".$charging_amt;
				$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////


//////////////////////////////////Start the code to activation Record mode wise ///////////////////////////////////////////////////////////

 $get_mode_activation_query="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable." nolock  
         where DATE(response_time)='$view_date1' and service_id in(1106) and event_type in('SUB') 
         group by circle,service_id,mode,plan_id";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mode == "OBD-Artist" || $mode == "push") $mode = "OBD";
		elseif($mode == "TIVR") $mode = "IVR";

		$activation_str1="Mode_Activation_".$mode;
		if($plan_id == 11)
			$activation_str1="Mode_Activation_Ticket_20_".$mode; //.$charging_amt;
		if($plan_id == 12)
			$activation_str1="Mode_Activation_Ticket_15_".$mode; //.$charging_amt;
		if($plan_id == 13)
			$activation_str1="Mode_Activation_Ticket_10_".$mode; //.$charging_amt;
		if($plan_id == 19)
			$activation_str1="Mode_Activation_Ticket_5_".$mode; //.$charging_amt;
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


/////////////////////////////////// Start the code to Renewal Record mode wise ///////////////////////////////////////////////////////

 $get_mode_renewal_query="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable." nolock  
         where DATE(response_time)='$view_date1' and service_id in(1106) and event_type='RESUB' 
         group by circle,service_id,mode,plan_id order by mode";

$db_query1 = mysql_query($get_mode_renewal_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mode == "OBD-Artist" || $mode == "OBD-MS" || $mode == "push" || $mode == "push2" || $mode == "OBD-LBR" || $mode == "OBD_LBR" || $mode == "OBD_One97" || $mode == "OBD_VG" ) $mode = "OBD";
		elseif($mode == "TIVR") $mode = "IVR";

		$activation_str1="Mode_Renewal_".$mode;
		if($plan_id == 11)
			$activation_str1="Mode_Renewal_Ticket_20_".$mode; //.$charging_amt;
		if($plan_id == 12)
			$activation_str1="Mode_Renewal_Ticket_15_".$mode; //.$charging_amt;
		if($plan_id == 13)
			$activation_str1="Mode_Renewal_Ticket_10_".$mode; //.$charging_amt;
		if($plan_id == 19)
			$activation_str1="Mode_Renewal_Ticket_5_".$mode; //.$charging_amt;
		$renewal_str1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		$queryIns1 = mysql_query($renewal_str1, $dbConn);
	}
}


/////////////////////////////////////////////////////////////////// start code to PENDING BASE Contest ////////////////////////////////////////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSContest' 
and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "")
			$circle1="UND";
		elseif($circle1 == "HAR")
			$circle1="HAY";
		elseif($circle1 == "PUN")
			$circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1123)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}



$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSContest' 
and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "")
			$circle1="UND";
		elseif($circle1 == "HAR")
			$circle1="HAY";
		elseif($circle1 == "PUN")
			$circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1123)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}




/////////////////////////////////////////////////////////////////// END code to PENDING BASE Contest ////////////////////////////////////////////////////////////////////////////


//////////////////////////////////// end code to insert the active base date into the database Docomo MUSIC UNLIMITED////////////////////////////////



///////////////////////////////////////////////////////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSMU' and status='Pending' 
and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "")
			$circle1="UND";
		elseif($circle1 == "HAR")
			$circle1="HAY";
		elseif($circle1 == "PUN")
			$circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1101)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MUSIC UNLIMITED////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database MTS comedy///////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSComedy' and status='Pending' 
and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',11012)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////////////// end code to insert the active base date into the database MTS comedy////////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database MTS 54646 Music///////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTS54646' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1102)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database MTS MTSJokes ///////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSJokes' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
                values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1125)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database MTS Regional///////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSReg' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
                values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1126)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Regional//////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVMTS' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1103)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////


//////////////////////////////////// end code to insert the active base date into the database MTS Starclub//////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSFMJ' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1106)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////


//////////////////////////////////// end code to insert the active base date into the database MTS-devotional //////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSDevo' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1111)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database MTS-Devotional //////////////////////////////////////////


//////////////////////////////////// end code to insert the active base date into the database MTSRedFM //////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMMTS' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1110)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database MTSRedFM /////////////////////////////////////////

//////////////////////////////////// end code to insert the active base date into the database MTS Voice Alert //////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSVA' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1116)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database MTS Voice Alert /////////////////////////////////////////

//////////////////////////////////// end code to insert the active base date into the database MTSMPD //////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSMND' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1113)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database MTSMPD /////////////////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo  Music Unlimited////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSMU' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
	 $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1101)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////

////////////////////////////// start code to insert the active base date into the database MTS comedy////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSComedy' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',11012)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////// end code to insert the active base date into the database MTS comedy//////////////////////////////////////////////////////

////////////////////////////// start code to insert the active base date into the database MTS 54646//////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTS54646' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1102)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////

////////////////////////////// start code to insert the active base date into the database MTS MTSJokes //////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSJokes' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id)
                values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1125)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////

////////////////////////////// start code to insert the active base date into the database MTS Regional//////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSReg' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id)
                values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1126)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Regional/////////////////////////////////////


////////////////// start code to insert the active base date into the database MTS MTV///////////////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVMTS' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1103)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////



////////////////// start code to insert the active base date into the database Starclub///////////////////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSFMJ' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1106)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music////////////////////////////////


///////// start code to insert the active base date into the database MTSDevo///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from dm_radio.tbl_digi_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1111)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSDevo' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1111)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database MTS-Devotional ///////////////////////////////////////////////


///////// start code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from mts_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1110)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMMTS' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1110)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
////////////////////////// end code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////

///////// start code to insert the active base date into the database MTS Voice Alert ///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from mts_voicealert.tbl_voice_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1116)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSVA' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1116)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database MTS Voice Alert ///////////////////////////////////////////////

///////// start code to insert the active base date into the database MTSMPD ///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from mts_mnd.tbl_character_subscription1 where status=1 and date(sub_date)<='$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1113)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTSMND' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1113)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database MTSMPD ///////////////////////////////////////////////



//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS KIJI///////////////////

$get_deactivation_base="select count(*),circle from Mts_summer_contest.tbl_contest_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1123)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////



//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo Music Unlimited//////////////////////

$get_deactivation_base="select count(*),circle from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1101)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Comedy//////////////////////

$get_deactivation_base="select count(*),circle from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' and plan_id IN (29) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',11012)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS Comedy//////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1102)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSJokes //////////////////////

$get_deactivation_base="select count(*),circle from mts_JOKEPORTAL.tbl_jokeportal_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1125)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////


//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Regional //////////////////////

$get_deactivation_base="select count(*),circle from mts_Regional.tbl_regional_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1126)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////




//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1103)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Starclub//////////////////////

$get_deactivation_base="select count(*),circle from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1106)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database  MTS Starclub//////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS-Devotional //////////////////////

$get_deactivation_base="select count(*),circle from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1111)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional //////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSRedfm //////////////////////

$get_deactivation_base="select count(*),circle from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1110)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTSRedfm //////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Voice Alert //////////////////////

$get_deactivation_base="select count(*),circle from mts_voicealert.tbl_voice_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1116)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS Voice Alert //////////////////////

//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSMPD //////////////////////

$get_deactivation_base="select count(*),circle from mts_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1113)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTSMPD //////////////////////


///////////// start code to insert the Deactivation Base into the MIS database MTS KIJI//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from Mts_summer_contest.tbl_contest_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN Vo" ||$unsub_reason == "Insuf" || $unsub_reason=="IN Voluntary") 
			$unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") 
			$unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") 
			$unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
		values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1123)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////// end code to insert the Deactivation base into the MIS database  MTS KIJI  //////////////////////



///////////// start code to insert the Deactivation Base into the MIS database Docomo  Music UNLIMITED//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";
                elseif($unsub_reason == "155223 SMS") $unsub_reason = "SMS";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1101)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////

///////////// start code to insert the Deactivation Base into the MIS database MTS Comedy//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' and plan_id IN (29) group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',11012)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////// end code to insert the Deactivation base into the MIS database MTS Comedy //////////////////////


///////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1102)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////


///////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$chrg_amount="";
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1103)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////


///////////// start code to insert the Deactivation Base into the MIS database Starclub//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		elseif($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$chrg_amount="";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1106)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////



///////////// start code to insert the Deactivation Base into the MIS MTS-Devotional //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$chrg_amount="";
		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1111)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional  //////////////////////


///////////// start code to insert the Deactivation Base into the MIS MTSRedfm //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1110)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database MTSRedfm  //////////////////////


///////////// start code to insert the Deactivation Base into the MIS Voice Alert //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_voicealert.tbl_voice_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1116)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database MTS Voice Alert  //////////////////////

///////////// start code to insert the Deactivation Base into the MISMPD //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from mts_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN") $unsub_reason = "in";
		elseif(($serviceId!='1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason=="COMEDY_REQ") $unsub_reason = "CC";
		elseif($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS") $unsub_reason = "IVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1113)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////// end code to insert the Deactivation base into the MIS database MTSMPD  //////////////////////


////////////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1101','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status 
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,status"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5]==1) $call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1) $call_tf[0]='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1101','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

////////////////start code to insert the data for call_tf for MTS Comedy///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSComedy' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','11012','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5]==1) $call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1) $call_tf[0]='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','11012','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for MTS Comedy///////////////////////////////////////////////////////////////////

//////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%' )
 and dnis != 546461  and dnis != '5464622' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

////////////////////////////////////////////////////////// MTSJokes Call_tf ///////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSJokes' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1125','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////////// MTSJokes Call_tf ///////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////// Start code for Regional Call_t ///////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		               
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

                if($call_tf[5] == 1) $call_tf[0]='L_CALLS_T_1';
		else $call_tf[0]='N_CALLS_T_1';
                
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		               
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
 
                if($call_tf[5] == 1) $call_tf[0]='L_CALLS_T';
		else $call_tf[0]='N_CALLS_T';
		               
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////////// End code for Regional Call_t /////////////////////////////////////////////////////////////

//////////start code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////End code to insert the data for call_tf MTS Starclub ///////////////////////////////////////////////////////////////////


//////////start code to insert the data for call_tf for MTSMPD ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSMPD' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis ='54646196' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1113','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='54646196' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1113','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////End code to insert the data for call_tf MTSMPD ///////////////////////////////////////////////////////////////////


////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

////////start code to insert the data for call_tf for MTSKIJI ///////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA');";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);

	}
}
$call_tf=array();
$call_tf_query="select 'CALLS_T_1',circle, count(id),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") 
                    $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") 
                    $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end code to insert call data on interface service MTSKIJI

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_T';
		else $call_tf[0]='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of Tata Docomo Mtv////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1103','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1103','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////////// end code to insert the data for call_tf for the service of Tata Docomo Mtv//////////////////////////////////////////



////////start code to insert the data for call_t for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_T';
		else $call_tf[0]='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

////////End code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////


//////////////////////////Start code to insert the data for call_tf for the service of MTS-Devotional////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1111','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1111','NA','NA','NA');";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);

	}
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTS-Devotional //////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of MTSRedFM ////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1110','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1110','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTSRedFM //////////////////////////////////

//////////start code to insert the data for call_tf for MTSVA ///////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_OBD',circle, count(id),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'MTSVA' as service_name,date(call_date),status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($call_tf[5] == 1) $call_tf[0]='L_CALLS_TF';
		else $call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////End code to insert the data for call_tf MTSVA ///////////////////////////////////////////////////////////////////

/////////////////////////////////////start code to insert the data for mous_tf for tata Docomo Endless////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
 from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

/////////////////////////////////////start code to insert the data for mous_tf for MTS Comedy////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','11012','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','11012','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
and dnis != 546461 and dnis !='5464622' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////////////// Start MTSJokes MOU TF //////////////////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSJokes' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1125','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////////////// End MTSJokes MOU TF //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Start MTSJokes MOU TF //////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////// Start MTS Regional MOU T //////////////////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_T_1';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_T_1';

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_T';

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////////////// End Regional Jokes MOU T ////////////////////////////////////////////////////////////////

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646


////////////////////////////////////////start code to insert the data for mous_tf for MTS Starclub////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////////////////////////// end to insert the data for mous_tf for MTS Starclub////////////////////////////


////////////////////////////////////////////start code to insert the data for mous_t for tata Docomo 54646//////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}


////////////////////////////////////////////start code to insert the data for mous_t for MTSKIJI//////////////////////////////

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_1',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

// end code to insert MTS KIJI of MOU_T


$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous ,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646



////////////////////////////////////////////start code to insert the data for mous_t for MTS Starclub//////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
///////////////////////////////// end to insert the data for mous_tf for MTS Starclub/////////////////////////////


//start code to insert the data for mous_tf for tata Docomo mtv
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for tata Docomo mtv

//start code to insert the data for mous_tf for MTS-Devotional
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for MTS-Devotional

//start code to insert the data for mous_tf for MTSRedFM
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for MTSRedFM


//start code to insert the data for mous_tf for MTSVA
$mous_tf=array();
$mous_tf_query="select 'MOU_OBD',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for MTSVA


//start code to insert the data for mous_tf for MTSMPD
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1113','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		//$circle = $pulse_tf[1];
		$circle = $mous_tf[1];
		
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($mous_tf[6] == 1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6] != 1) $mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1113','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for MTSMPD


/////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////

/////////////////////////start code to insert the data for PULSE_TF for MTScomedy/////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTScomedy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','11012','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTScomedy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','11012','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for MTScomedy/////////////////////

/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'
 and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
 and dnis != 546461 and dnis !='5464622' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}



/////////////////////////////////////////////////////////// Start MTSJokes Pulse_TF ////////////////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSJokes' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1125','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////////// End MTSJokes Pulse_TF ////////////////////////////////////////////////////

/////////////////////////////////////////////////////////// Start MTS Regional Pulse_T ////////////////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_T_1';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_T_1';

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_T';


		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////////// End MTS Regional Pulse_T ////////////////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Starclub /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();

 $pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}



/////////////////////////////////////////start code to insert the data for PULSE_TF for the MTS KIJI /////////////////////////////////////////

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

// end code to insert Pulse for service MTS KIJI


$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) 
			$pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6] != 1) 
			$pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////




/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse ,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////

////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/// code end here

////////////////////End code to insert the data for PULSE_TF for the MTSRedFM /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/// code end here

////////////////////End code to insert the data for PULSE_TF for the MTSVA /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_OBD',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/// code end here

////////////////////End code to insert the data for PULSE_TF for the MTSMPD /////////////////////////////////////////
$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSMPD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1113','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();

$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($pulse_tf[6] == 1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6] != 1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1113','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/// code end here


//////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf=array();

$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1101','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1101','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////


//////////////////////start code to insert the data for Unique Users for MTSComedy//////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSComedy' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','11012','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSComedy' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','11012','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////// end Unique Users for MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
and dnis != 546461 and dnis !='5464622' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////////////////////// Start UU_TF MTSJokes //////////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSJokes' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1125','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////////////////////// End UU_TF MTSJokes //////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Start UU_TF MTS Regional //////////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date) from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Non Active' as 'user_status'
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status in(-1,11,0)
AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status IN (1))
group by circle";
$uu_tf_query .= " UNION select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Active' as 'user_status' 
 from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($uu_tf[6]=='Active') 
                    $uu_tf[0]='L_UU_T_1';
		if($uu_tf[6]=='Non Active') 
                    $uu_tf[0]='N_UU_T_1';

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date) from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Non Active' as 'user_status'
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status in(-1,11,0)
AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status IN (1))
group by circle";
$uu_tf_query .= " UNION select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Active' as 'user_status' 
 from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($uu_tf[6]=='Active') 
                    $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') 
                    $uu_tf[0]='N_UU_T';

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////////////////////// End UU_TF MTSJokes //////////////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis != '5464622' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') and dnis != 546461 and dnis !='5464622' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////

////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////

/////////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1103','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1103','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////// end code to insert the data for Unique Users  for Tata Docomo Mtv///////////////////////////////////////////////////////

/////////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1111','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1111','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////// end code to insert the data for Unique Users  for MTS-Devotional /////////////////////////////////////////////

/////////////////start code to insert the data for Unique Users  for MTSRedFM ///////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1110','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1110','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////// end code to insert the data for Unique Users for MTSRedFM /////////////////////////////////////////////

///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}



///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") 
                    $circle="UND";
		elseif($circle == "HAR")
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=3 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") 
                    $circle="UND";
		elseif($circle == "HAR")
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////////////////////////////////////////// end code to insert data for MTS KIJI///////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////// start code to insert data for MTS KIJI///////////////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' 
and chrg_rate=1 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') 
                    $uu_tf[0]='L_UU_T_1';
		if($uu_tf[6]=='Non Active') 
                    $uu_tf[0]='N_UU_T_1';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=3 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') 
                    $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') 
                    $uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////// end Unique Users  for MTS KIJI /////////////////////////////////////////////////////////////////////////




$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////


///////////////////////////start code to insert the data for Unique Users  for MTSVA //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_OBD',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////// end Unique Users for MTSVA /////////////////////////////////////////////////////////////////////////


///////////////////////////start code to insert the data for Unique Users  for MTSMPD //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1113','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		$insert_uu_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1113','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////// end Unique Users for MTSMPD /////////////////////////////////////////////////////////////////////////


//////////////////////////////start code to insert the data for SEC_TF  for MTS MU ///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
//echo "total".$numRows5;
if ($numRows5 > 0)
{

	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1101','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1101','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Endless

//////////////////////////////start code to insert the data for SEC_TF for MTSComedy ///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','11012','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','11012','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////// end insert the data for SEC_TF  for MTSComedy //////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec)
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') and dnis != 546461 and dnis !='5464622' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////////// Start MTSJokes SEC_TF //////////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSJokes' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1125','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////////// End MTSJokes SEC_TF //////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////// Start MTS Regional SEC_T //////////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T_1',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec) from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T_1',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_T_1';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_T_1';

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec) from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
                
                if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_T';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_T';

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////////// End MTS Regional SEC_T //////////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for tata Docomo 54646


///////////////////////////////////////////start code to insert the data for SEC_TF  for Mts Starcllub///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
////////////////////////////// end insert the data for SEC_TF  for MTS Starclub ////////////////////////////////////////////////////////





///////////////////////////////////////////start code to insert the data for SEC_TF  for MTS KIJI/////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T_1',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

///////////////////////////////////////////END code to insert the data for SEC_TF  for MTS KIJI/////////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_T';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for tata Docomo 54646


////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_T';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for tata Docomo 54646



///////////start code to insert the data for SEC_TF  for tata Docomo Mtv /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1103','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1103','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Mtv ////////////////////////////////////


///////////start code to insert the data for SEC_TF  for MTS-Devotional /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1111','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1111','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end insert the data for SEC_TF  for MTS-Devotional ////////////////////////////////////////

///////////start code to insert the data for SEC_TF for MTSRedFM /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1110','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1110','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSRedFM ////////////////////////////////////////


///////////start code to insert the data for SEC_TF for MTSVA /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_OBD',circle, count(msisdn),'MTSVA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSVA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSVA ////////////////////////////////////////


///////////start code to insert the data for SEC_TF for MTSMPD /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1113','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($sec_tf[6] == 1) $sec_tf[0]='L_SEC_TF';
		elseif($sec_tf[6] != 1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1113','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSMPD ////////////////////////////////////////

///////////////////////////// VoiceAlert Special Type ////////////////////////////////////////////////////////////////////
$va_logs1=array();
$va_query="select 'VA_NoAnswer',count(ani),circle from mts_voicealert.tbl_OBD_SMS_logs where date(date_time)='$view_date1' group by circle";

$va_query_result = mysql_query($va_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($va_query_result);
if ($numRows > 0)
{
	while($va_data = mysql_fetch_array($va_query_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if(!$va_data[2]) $va_data[2]='UND';
		$insert_va_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data[0]','$va_data[2]','0','$va_data[1]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_va_data, $dbConn);
	}
}

$va_logs2=array();
//$va_query1="select 'VA_Calls',count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle";
$va_query1 = "select 'VA_Calls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle";
$va_query_result1 = mysql_query($va_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($va_query_result1);
if ($numRows1 > 0)
{
	while($va_data1 = mysql_fetch_array($va_query_result1))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_va_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data1[0]','$va_data1[2]','0','$va_data1[1]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_va_data1, $dbConn);
	}
}

$va_logs3=array();
//count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle
$va_query3="select 'VA_ExpectedCalls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle
UNION
select 'VA_ExpectedCalls',count(ani),circle from mts_voicealert.tbl_OBD_SMS_logs where date(date_time)='$view_date1' group by circle";

$va_query_result3 = mysql_query($va_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($va_query_result3);
if ($numRows3 > 0)
{
	while($va_data3 = mysql_fetch_array($va_query_result3))
	{
		$circle = $va_data3[2];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_va_data3="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data3[0]','$circle','0','$va_data3[1]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_va_data3, $dbConn);
	}
}


$va_logs3=array();
$va_query3="select 'VA_ActiveBase',count(distinct ani),circle from mts_voicealert.tbl_voice_category where date(sub_date)<='$view_date1' and status=1 group by circle";

$va_query_result3 = mysql_query($va_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($va_query_result3);
if ($numRows3 > 0)
{
	while($va_data3 = mysql_fetch_array($va_query_result3))
	{
		$circle = $va_data3[2];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_va_data3="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data3[0]','$circle','0','$va_data3[1]','','1116','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_va_data3, $dbConn);
	}
}


///////////////////////////// VoiceAlert Special Type Code End here  /////////////////////////////////////////////////////

//////////////////////////////////////////////////////start code to insert the data for RBT_*  //////////////////////////////////////////////////////
$rbt_tf=array();
//$rbt_query="select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt') and crbt_mode='DOWNLOAD' group by circle,req_type";
$rbt_query="select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('crbt') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='crbt')
		{
			$circle = $rbt_tf[1];
			if($circle == "") $circle="UND";
			elseif($circle == "HAR") $circle="HAY";
			elseif($circle == "PUN") $circle="PUB";

			$insert_rbt_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$circle','$rbt_tf[0]','0','1101','NA','NA','NA')";
		}
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}

$rbt_tf=array();
$rbt_query="select count(*),circle,req_type from mts_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type='rngtone' group by circle";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='rngtone')
		{
			$circle = $rbt_tf[1];
			if($circle == "") $circle="UND";
			elseif($circle == "HAR") $circle="HAY";
			elseif($circle == "PUN") $circle="PUB";

			$insert_rbt_tf_data="insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$circle','$rbt_tf[0]','0','1101','NA','NA','NA')";
		}
        $queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}
// end


//////////////////////////////////////////////// to insert the Migration data///////////////////////////////////////////////////////////////////

$get_migrate_date="select crbt_mode,count(1),circle from mts_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and status=1 group by crbt_mode,circle";
$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0)
{
	$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
	while(list($crbt_mode,$count,$circle) = mysql_fetch_array($get_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($crbt_mode=='ACTIVATE')
		{
			$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1101','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='MIGRATE')
		{
			$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1101','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD')
		{
			$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1101','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD15')
		{
			$insert_data1="insert into mis_db.mtsDailyReport(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1101','NA','$count','NA','NA','NA')";
		}

		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}

//----------------- failure count --------------------------

$charging_fail="select count(*),circle,event_type,service_id from master_db.tbl_billing_failure where date(date_time)='$view_date1' group by circle,event_type,service_id order by service_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$service_id) = mysql_fetch_array($deactivation_base_query))
{
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";

	if($circle == "") $circle="UND";
	elseif($circle == "HAR") $circle="HAY";
	elseif($circle == "PUN") $circle="PUB";


	$insertData="insert into mis_db.mtsDailyReport(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','".$service_id."')";
	$queryIns = mysql_query($insertData, $dbConn);
}


//------------------ failure count code end here -----------


mysql_close($dbConn);

echo "done";
// end
?>
