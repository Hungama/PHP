<?php 
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");

// delete the prevoius record
$flag=0;
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
	$flag=1;
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//$flag=1;
//echo $view_date1='2013-10-12';

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
if($flag) {
	$condition = " AND type NOT IN ('Active_Base','Pending_Base') ";
} else {
	$condition = " AND 1";
}

$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in (1801,1809,1811,1810)".$condition;
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////


/////// start the code to insert the data of activation Virgin Mobile endless////////////////

///////////////////////////////////////// remove the 1801 FMJ id from this query : show wid ////////////////////////////////////////////////
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1801,1809,1810,1811) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
        while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
        {
			if($circle=='') $circle='UND';
			elseif(strtoupper($circle)=='HAR') $circle='HAY';
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
                        $charging_str="TOP-UP_".$charging_amt;
                        $insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
                }

                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

////////// End the code to insert the data of activation Virgin Mobile endless////////////////

////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1801,1809,1810,1811) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data1="";
		if($event_type=='SUB')
		{
			if(strtoupper($mode)=="155223" && $service_id!='1809' && ($service_id=='1801' || $service_id=='1805')) $mode="IVR_155223";
			elseif(strtoupper($mode)=="155223" && $service_id=='1809') $mode="155223";
			elseif(strtoupper($mode)=="IVR_52222" && $service_id=="1809") $mode="IBD";
			elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY") $mode="IVR";
			elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="TOBD" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
			elseif(strtoupper($mode)=="NETB") $mode="NET";
			elseif(strtoupper($mode)=="TPCN") $mode="PCN";
			elseif(strtoupper($mode)=="CCI" && strtoupper($mode)=="CCARE") $mode="CC";
			elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
			elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";
			
			elseif(strtoupper($mode)=="CC" && $service_id=='1801') $mode="CCI";

			$activation_str1="Mode_Activation_".strtoupper($mode);

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

////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Virgin Endless Music//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 40 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")
				$unsub_reason="IVR";
		
		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=='WAP' || strtoupper($unsub_reason)=='NET') $unsub_reason=strtoupper($unsub_reason);
		elseif(strtoupper($unsub_reason)=="CCARE" || strtoupper($unsub_reason)=="CC" || strtoupper($unsub_reason)=="CCI") $unsub_reason="CCI";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1801)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Virgin Endless Music  //////////////////////

/////////////// deactivation base of vmi MISS RIYA //////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' AND plan_id = 73 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ") $unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="155223";
		elseif(strtoupper($unsub_reason)=='WAP' || strtoupper($unsub_reason)=='NET') $unsub_reason=strtoupper($unsub_reason);
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA','1809')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////// code end here /////////////////////////////////

/////////////// deactivation base of vmiRedFM //////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id=72 group by circle, unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")
				$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA','1810')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////// code end here /////////////////////////////////


/////////////// deactivation base of vmiRedFM //////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (77,78,79) group by circle, unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")
				$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=='WAP' || strtoupper($unsub_reason)=='NET') $unsub_reason=strtoupper($unsub_reason);
		elseif(strtoupper($unsub_reason)=="CCI"  || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA','1811')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////// code end here /////////////////////////////////


///////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

/*$get_pending_base="select count(ani),circle from docomo_radio.tbl_radio_subscription where status IN (11,0,5) and date(sub_date)<= '$view_date1' AND plan_id = 40 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
        while(list($count,$circle) = mysql_fetch_array($pending_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1801)";
                $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMXvmi' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1801)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music///////////////////////////

///////////// pending base VMI MISS RIYA //////////////////////////

/*$get_pending_base="select count(ani),circle from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and date(sub_date)<= '$view_date1' AND plan_id = 73 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
        while(list($count,$circle) = mysql_fetch_array($pending_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1809)";
                $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMovmi' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1809)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
//////////// code end here /////////////////////////

///////////// pending base VMIRedFM //////////////////////////

/*$get_pending_base="select count(ani),circle from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<= '$view_date1' and plan_id=72 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
        while(list($count,$circle) = mysql_fetch_array($pending_base_query))
        {
			if($circle=='') $circle='UND';
			elseif(strtoupper($circle)=='HAR') $circle='HAY';
			$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1810)";
			$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMovmi' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1810)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
//////////// code end here /////////////////////////

///////////// pending base VMIRedFM //////////////////////////
if(!$flag) 
{ 
$get_pending_base="select count(ani),circle from docomo_rasoi.tbl_rasoi_subscription where status IN (11,0,5) and date(sub_date)<= '$view_date1' and plan_id IN (77,78,79) group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
        while(list($count,$circle) = mysql_fetch_array($pending_base_query))
        {
			if($circle=='') $circle='UND';
			elseif(strtoupper($circle)=='HAR') $circle='HAY';
			$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1811)";
			$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
        }
}
}
//////////// code end here /////////////////////////

///////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

/*$get_active_base="select count(*),circle from docomo_radio.tbl_radio_subscription where status=1 AND plan_id = 40 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($active_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1801)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMXvmi' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1801)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////

//////////////// Active Base VMI MISS RIYA /////////////////////////////

/*$get_active_base="select count(*),circle from docomo_manchala.tbl_riya_subscription where status=1 AND plan_id = 73 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($active_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1809)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMovmi' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1809)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
//////////////Code end here ////////////////////////////////////


//////////////// Active Base VMIRedFM /////////////////////////////

/*$get_active_base="select count(*),circle from docomo_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id=72 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($active_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1810)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}*/
if(!$flag) 
{ 
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMovmi' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1810)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
}
//////////////Code end here ////////////////////////////////////


//////////////// Active Base VMIGL /////////////////////////////
if(!$flag) 
{ 
$get_active_base="select count(*),circle from docomo_rasoi.tbl_rasoi_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id IN (77,78,79) group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
        while(list($count,$circle) = mysql_fetch_array($active_base_query))
        {
				if($circle=='') $circle='UND';
				elseif(strtoupper($circle)=='HAR') $circle='HAY';
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1811)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}
}
//////////////Code end here ////////////////////////////////////


////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 40 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1801)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////

/////////////////////////// Deactivation VMI MISS RIYA ////////////////////////////////

$get_deactivation_base="select count(*),circle from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' AND plan_id = 73 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1809)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////// Code End here //////////////////////////////////////////////////////////

/////////////////////////// Deactivation VMIRedFM ////////////////////////////////

$get_deactivation_base="select count(*),circle from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id=72 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1810)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////// Code End here //////////////////////////////////////////////////////////


/////////////////////////// Deactivation VMIGL ////////////////////////////////

$get_deactivation_base="select count(*),circle from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (77,78,79) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1811)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////// Code End here //////////////////////////////////////////////////////////


//////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('virm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1801','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5] == 1) $call_tf[0] = "L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0] = "N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1801','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless//////////////////////////////////////////////////////


//////////start code to insert the data for call_tf for MISS RIYA ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VmiMissRiya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in ('virm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='')
			$call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') 
			$call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1809','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////////////////////////////// End code /////////////////////////////////////////////////////////////////////////////////////////////////////




//////////start code to insert the data for call_tf for MISS RIYA ///////////////////////////////////////////////////////////////////

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'VmiMissRiya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in ('virm') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows_1 = mysql_num_rows($call_t_result);
if ($numRows_1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[1]=='')
			$call_t[1]='UND';
		elseif(strtoupper($call_t[1])=='HAR') 
			$call_t[1]='HAY';
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1809','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

//////////////////////////////////////////////// End code /////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////// start code to insert////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VmiMissRiya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') 
			$call_tf[1]='HAY';
		if($call_tf[5] == 1)
			$call_tf[0] = "L_CALLS_TF";
		elseif($call_tf[5] != 1)
			$call_tf[0] = "N_CALLS_TF";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1809','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for MISS RIYA//////////////////////////////////////////////////////



////////////////////////////////////// start code to insert////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'VmiMissRiya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='')
			$call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR')
			$call_tf[1]='HAY';

		if($call_tf[5] == 1)
			$call_tf[0] = "L_CALLS_T";
		elseif($call_tf[5] != 1) 
			$call_tf[0] = "N_CALLS_T";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1809','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for MISS RIYA//////////////////////////////////////////////////////



//////////start code to insert the data for call_tf for VMIRedFM///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VmiRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in ('virm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1810','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VmiRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5] == 1) $call_tf[0] = "L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0] = "N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1810','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for VMIRedFM//////////////////////////////////////////////////////


//////////start code to insert the data for call_tf for VMIGL///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VMIGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in ('virm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1811','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'VMIGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5] == 1) $call_tf[0] = "L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0] = "N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1811','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for VMIGL//////////////////////////////////////////////////////

//////////start code to insert the data for call_tf for VMIGL///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'VMIGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in ('virm') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1811','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'VMIGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in ('virm') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5] == 1) $call_tf[0] = "L_CALLS_T";
		elseif($call_tf[5] != 1) $call_tf[0] = "N_CALLS_T";
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1811','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for VMIGL//////////////////////////////////////////////////////


//////////////////////////start code to insert the data for mous_tf for tata Docomo Endless///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1801','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6] == 1) $mous_tf[0] = "L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0] = "N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1801','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

//////////////////////////start code to insert the data for mous_tf for MISS RIYA///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') 
			$mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') 
			$mous_tf[1]='HAY';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1809','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

//////////////////////////////////////////End code /////////////////////////////////////



//////////////////////////start code to insert the data for mous_tf for MISS RIYA///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') 
			$mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') 
			$mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1809','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

//////////////////////////////////////////End code /////////////////////////////////////



//////////////////////////start code to insert the data for live and non Live mous_tf for MISS RIYA///////////////////

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6] == 1) $mous_tf[0] = "L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0] = "N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1809','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
///////////////////////////////////// end MISS RIYA ///////////////


//////////////////////////start code to insert the data for live and non Live mous_t for MISS RIYA///////////////////

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') 
			$mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') 
			$mous_tf[1]='HAY';
		if($mous_tf[6] == 1) 
			$mous_tf[0] = "L_MOU_T";
		elseif($mous_tf[6] != 1) 
			$mous_tf[0] = "N_MOU_T";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1809','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
//////////////////////////////////////////////////////////// end MISS RIYA ///////////////////////////////////////////


//////////////////////////start code to insert the data for mous_tf for VmiRedFM///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1810','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6] == 1) $mous_tf[0] = "L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0] = "N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1810','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////// end VmiRedFM ///////////////

//////////////////////////start code to insert the data for mous_tf for VmiGL///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1811','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'VmiGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6] == 1) $mous_tf[0] = "L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0] = "N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1811','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////// end VmiGL ///////////////

//////////////////////////start code to insert the data for mous_tf for VmiGL///////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'VmiGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1811','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'VmiGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6] == 1) $mous_tf[0] = "L_MOU_T";
		elseif($mous_tf[6] != 1) $mous_tf[0] = "N_MOU_T";
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1811','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
////////////// end VmiGL ///////////////

//////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1801','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1801','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice///////////////////////////


//////////////////////////start code to insert the data for PULSE_TF for the MISS RIYA /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiMissRiya' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR')
			$pulse_tf[1]='HAY';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1809','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

//////////////////////////////////////////////////////////////////////////////End code////////////////////////////////

//////////////////////////start code to insert the data for PULSE_T for the MISS RIYA /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'VmiMissRiya' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') 
			$pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') 
			$pulse_tf[1]='HAY';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1809','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

//////////////////////////////////////////////////////////////////////////////End code////////////////////////////////

//////////////////////////start code to insert the data for PULSE_TF for the MISS RIYA /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiMissRiya' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR')
			$pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) 
			$pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) 
			$pulse_tf[0]="N_PULSE_TF";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1809','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

//////////////////////////////////// End code/////////////



//////////////////////////start code to insert the data for PULSE_T for the MISS RIYA /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'VmiMissRiya' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') 
			$pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') 
			$pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) 
			$pulse_tf[0]="L_PULSE_T";
		elseif($pulse_tf[6] != 1) 
			$pulse_tf[0]="N_PULSE_T";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1809','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

//////////////////////////////////// End code/////////////



/////////////////////////////////////////End code to insert the data for PULSE_TF for the MISS RIYA ///////////////////////////


//////////////////////////start code to insert the data for PULSE_TF for the VmiRedFM /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1810','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1810','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the VmiRedFM///////////////////////////


//////////////////////////start code to insert the data for PULSE_TF for the VmiGL /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1811','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'VmiGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1811','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the VmiGL///////////////////////////


//////////////////////////start code to insert the data for PULSE_TF for the VmiGL /////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'VmiGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1811','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'VmiGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_T";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_T";
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1811','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the VmiGL///////////////////////////


//////////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1801','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1801','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for MISS RIYA //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') 
			$uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1809','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

// End code


//////////////////////////start code to insert the data for Unique Users tollFree for MISS RIYA //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='')
			$uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') 
			$uu_tf[1]='HAY';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1809','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

// End code

//////////////////////////start code to insert the data for Unique Users tollFree for MISS RIYA //////////////////////////////////////////////


$uu_tf=array();

$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1809','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for MISS RIYA/////////////////////////////////////////////////////////////////////////


//////////////////////////start code to insert the data for Unique Users toll for MISS RIYA //////////////////////////////////////////////


$uu_tf=array();

$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') 
			$uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') 
			$uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1809','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for MISS RIYA/////////////////////////////////////////////////////////////////////////



//////////////////////////start code to insert the data for Unique Users  for MISS RIYA //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'VmiRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1810','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();

$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'VmiRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'VmiRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')	$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1810','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users for VmiRedFM/////////////////////////////////////////////////////////////////////////


//////////////////////////start code to insert the data for Unique Users  for VmiGL //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1811','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();

$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')	$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1811','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users for VmiGL /////////////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for VmiGL //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1811','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();

$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'VmiGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active')	$uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1811','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users for VmiGL /////////////////////////////////////////////////////////////////////////

/////////////////////start code to insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') $sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1801','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6] == 1) $sec_tf[0]="L_SEC_TF";
		elseif($sec_tf[6] == 1) $sec_tf[0]="N_SEC_TF";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1801','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////

/////////////////////start code to insert the data for SEC_TF  for MISS RIYA ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') $sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1809','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

// End code


/////////////////////start code to insert the data for SEC_TF  for MISS RIYA ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') 
					$sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') 
					$sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1809','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

// End code


/////////////////////start code to insert the data for SEC_T  for MISS RIYA ///////////////////////////////////////////////////


$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6] == 1) $sec_tf[0]="L_SEC_TF";
		elseif($sec_tf[6] == 1) $sec_tf[0]="N_SEC_TF";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1809','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for MISS RIYA /////////////////////////////


/////////////////////start code to insert the data for SEC_T  for MISS RIYA ///////////////////////////////////////////////////


$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'VmiMissRiya' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '5464669' or dnis like '546468') and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') 
			$sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') 
			$sec_tf[1]='HAY';
		if($sec_tf[6] == 1) 
			$sec_tf[0]="L_SEC_T";
		elseif($sec_tf[6] == 1) 
			$sec_tf[0]="N_SEC_T";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1809','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for MISS RIYA /////////////////////////////




/////////////////////start code to insert the data for SEC_TF for VmiRedFM ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') $sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1810','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis like '55935%' and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6] == 1) $sec_tf[0]="L_SEC_TF";
		elseif($sec_tf[6] == 1) $sec_tf[0]="N_SEC_TF";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1810','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF for VmiRedFM /////////////////////////////

/////////////////////start code to insert the data for SEC_TF for VmiGL ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') $sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1811','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'VmiGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6] == 1) $sec_tf[0]="L_SEC_TF";
		elseif($sec_tf[6] == 1) $sec_tf[0]="N_SEC_TF";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1811','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF for VmiGL /////////////////////////////

/////////////////////start code to insert the data for SEC_TF for VmiGL ///////////////////////////////////////////////////

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'VmiGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
				if($sec_tf[1]=='') $sec_tf[1]='UND';
				elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
                $insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1811','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'VmiGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator in('virm') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6] == 1) $sec_tf[0]="L_SEC_T";
		elseif($sec_tf[6] == 1) $sec_tf[0]="N_SEC_T";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1811','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF for VmiGL /////////////////////////////

mysql_close($dbConn);
echo "done";
?>
