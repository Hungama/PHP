<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");

// delete the prevoius record
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//echo $view_date1='2012-12-07';

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

//echo $view_date1='2012-07-04';
//echo $view_date1;

//----- pause code array ----------
$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');
//---------------------------------


$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in (1001,1005,1002,1003,1009,1010,1011,1000)";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////


/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

//and SC not like '%P%'
///////////////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////////
$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1001,1003,1009,1010,1011) and event_type in('SUB') and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type"; 
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			if($circle=='') $circle='UND';
			elseif(strtoupper($circle)=='HAR') $circle='HAY';
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB') and SC not like '%P%' group by circle,service_id,chrg_amount,event_type"; 
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($event_type=='SUB')
		{
			if($circle=='') $circle='UND';
			elseif(strtoupper($circle)=='HAR') $circle='HAY';
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1001,1003,1009,1010,1011) and event_type in('RESUB','TOPUP') and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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

// Riya Event Charging 

//-----------------Pause code----------------

$get_activation_query="select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,SC from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','RESUB','TOPUP') and SC like '%P%' and plan_id NOT IN (99,100,101,85) group by circle,service_id,chrg_amount,event_type,SC"; 
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$sc) = mysql_fetch_array($query))
	{
		$pCircle = $pauseArray[$circle];
		if($event_type=='SUB')
		{
			if($circle=='') $circle='UND';
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
		} elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
		} elseif($event_type=='TOPUP')
		{
			$charging_str="TOP-UP_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode,SC,substr(SC,14,1) as p from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','TOPUP') and SC like '%P%' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$sc,$p) = mysql_fetch_array($db_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_data2="";
		$pMode = $pauseCode[$p];
		if($event_type=='SUB')
		{
			$activation_str1="Mode_Activation_".$pMode;
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$pCircle','1002P','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}
//---------Pause code end here --------------

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (99,100,101) group by circle,service_id,chrg_amount";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$charging_str="Event_".$charging_amt;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and plan_id IN (85) group by circle,service_id,chrg_amount,event_type";
$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type) = mysql_fetch_array($query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($event_type == 'SUB') { 
			$charging_str="Activation_Follow_5";
		} elseif($event_type == 'RESUB') {
			$charging_str="Renewal_Follow_5";
		}
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,floor(chrg_amount) as amount from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' and status like 'success%' group by circle,chrg_amount";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$amount) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$activation_str1="EVENT_".$amount;
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('".$view_date1."', '".$activation_str1."','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' and status like 'success%' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$activation_str1="RT_FT_SUC";
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}


$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='TATM' and service='1009' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$str1="RT_FT_REQ";
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1009','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// code end here

$get_activation_query4="select count(msisdn),circle,chrg_amount,service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1005) and event_type in('SUB') group by circle,service_id,chrg_amount,plan_id";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if($numRows4 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($query4))
	{		
		//$circle_info=array();
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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

$get_activation_query3="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock WHERE DATE(response_time)='$view_date1' and service_id in(1005) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount, event_type, plan_id";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query3))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1001,1005,1003,1010,1011) and event_type in('SUB','RESUB','TOPUP') and plan_id NOT IN (85,99,100,101) and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data1="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
			
			if($mode=="155223" && ($service_id=='1001' || $service_id=='1002' || $service_id=='1010' || $service_id=='1005')) $mode=="IVR_155223";
			elseif($mode=="IVR_52222" && $service_id=="1009") $mode="IBD";
			elseif($mode=="155223" && $service_id=="1005") $mode="IVR";
			elseif($mode=="TOBD" && $service_id=="1001") $mode="OBD";
			elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY"  || strtoupper($mode)=="IVR1") $mode="IVR";
			elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
			elseif(strtoupper($mode)=="NETB") $mode="NET";
			elseif(strtoupper($mode)=="TPCN") $mode="PCN";
			elseif(strtoupper($mode)=="CCI" && $service_id != '1001') $mode="CC";
			elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
			elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";

			if(strtoupper($mode)=='CCARE' && $service_id=='1001') $mode='CCI';

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

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB','TOPUP') and plan_id NOT IN (85,99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data1="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
			
			if($mode=="155223" && ($service_id=='1001' || $service_id=='1002' || $service_id=='1010' || $service_id=='1005')) $mode=="IVR_155223";
			elseif($mode=="IVR_52222" && $service_id=="1009") $mode="IBD";
			elseif($mode=="155223" && $service_id=="1005") $mode="IVR";
			elseif($mode=="TOBD" && $service_id=="1001") $mode="OBD";
			elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY"  || strtoupper($mode)=="IVR1") $mode="IVR";
			elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
			elseif(strtoupper($mode)=="NETB") $mode="NET";
			elseif(strtoupper($mode)=="TPCN") $mode="PCN";
			elseif(strtoupper($mode)=="CCI" && $service_id != '1001') $mode="CC";
			elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
			elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";

			if(strtoupper($mode)=='CCARE' && $service_id=='1001') $mode='CCI';

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

// Event for Miss Riya
$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('SUB') and plan_id IN (99,100,101) group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data1="";

		if(is_numeric($mode)) $mode='CC';	
		if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);

		if($mode=="155223" && ($service_id=='1001' || $service_id=='1002' || $service_id=='1010' || $service_id=='1005')) $mode=="IVR_155223";
		elseif($mode=="IVR_52222" && $service_id=="1009") $mode="IBD";
		elseif($mode=="155223" && $service_id=="1005") $mode="IVR";
		elseif($mode=="TOBD" && $service_id=="1001") $mode="OBD";
		elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY"  || strtoupper($mode)=="IVR1") $mode="IVR";
		elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
		elseif(strtoupper($mode)=="NETB") $mode="NET";
		elseif(strtoupper($mode)=="TPCN") $mode="PCN";
		elseif(strtoupper($mode)=="CCI" && $service_id != '1001') $mode="CC";
		elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
		elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";

		if(strtoupper($mode)=='CCARE' && $service_id=='1001') $mode='CCI';

		
		$activation_str1="Mode_FS_".strtoupper($mode);

		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

/////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////


////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1002) and event_type in('SUB','RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data2="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			if(strcasecmp($mode, 'net') == 0) $mode = strtoupper($mode);
			
			if($mode=="155223" && ($service_id=='1001' || $service_id=='1002' || $service_id=='1010' || $service_id=='1005')) $mode=="IVR_155223";
			elseif($mode=="IVR_52222" && $service_id=="1009") $mode="IBD";
			elseif($mode=="155223" && $service_id=="1005") $mode="IVR";
			elseif($mode=="TOBD" && $service_id=="1001") $mode="OBD";
			elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY"  || strtoupper($mode)=="IVR1") $mode="IVR";
			elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
			elseif(strtoupper($mode)=="NETB") $mode="NET";
			elseif(strtoupper($mode)=="TPCN") $mode="PCN";
			elseif(strtoupper($mode)=="CCI" && $service_id != '1001') $mode="CC";
			elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
			elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";

			if(strtoupper($mode)=='CCARE' && $service_id=='1001') $mode='CCI';


			$activation_str1="Mode_Activation_".strtoupper($mode);
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


///////////////////// Add SMS Pack for DocomoEndless code ///////////////////////////////////////////////////////

$get_mode_activation_query1="select count(msisdn),circle,service_id,event_type,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(1001) and event_type in('SUB') and plan_id='92' group by circle,service_id,event_type,mode order by event_type";

$db_query = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data2="";
		if($event_type=='SUB')
		{
			if(is_numeric($mode)) $mode='CC';	
			
			if($mode=="155223" && ($service_id=='1001' || $service_id=='1002' || $service_id=='1010' || $service_id=='1005')) $mode=="IVR_155223";
			elseif($mode=="IVR_52222" && $service_id=="1009") $mode="IBD";
			elseif($mode=="155223" && $service_id=="1005") $mode="IVR";
			elseif($mode=="TOBD" && $service_id=="1001") $mode="OBD";
			elseif(strtoupper($mode)=="TIVR" || strtoupper($mode)=="IVR_52222" || strtoupper($mode)=="IVR-BOSKEY"  || strtoupper($mode)=="IVR1") $mode="IVR";
			elseif(strtoupper($mode)=="OBD-MPMC" || strtoupper($mode)=="OBD197" || strtoupper($mode)=="OBD-BOSKEY") $mode="OBD";
			elseif(strtoupper($mode)=="NETB") $mode="NET";
			elseif(strtoupper($mode)=="TPCN") $mode="PCN";
			elseif(strtoupper($mode)=="CCI" && $service_id != '1001') $mode="CC";
			elseif(strtoupper($mode)=="TUSSD") $mode="USSD";
			elseif(strtoupper($mode)=="HUNOBDBONUS") $mode="TOBD";

			if(strtoupper($mode)=='CCARE' && $service_id=='1001') $mode='CCI';


			$activation_str1="Mode_Activation_SMSPack-".strtoupper($mode);
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

$get_mode_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock WHERE DATE(response_time)='$view_date1' and service_id in(1009) and event_type in('RESUB','SUB') and plan_id='85' group by circle,service_id,chrg_amount, event_type, plan_id";

$db_query = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($db_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data2="";
		if($event_type=='SUB')
		{
			$activation_str1="Activation_Follow_1";
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$ren_str1="Renewal_Follow_1";
			$insert_data2="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$ren_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 85 group by circle,unsub_reason ";

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

		if($unsub_reason=="155223") $unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CC" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CCI";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_SMSPack-".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////////////////// Add SMS Pack for DocomoEndless code end ///////////////////////////////////////////////////////


///////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////
/*
$get_pending_base="select count(ani),circle from docomo_radio.tbl_radio_subscription where status IN (11,0,5) AND plan_id NOT IN (40,85) group by circle";
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
}*/

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMoMX' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music///////////////////////////////

///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo 54646///////////////////////////////////


/*$get_pending_base="select count(ani),circle from docomo_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis not like '%P%' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1002)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMo54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_pending_base="select count(ani),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis like '%P%' group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($pending_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1002P')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////



///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Filmi Meri Jaan//////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_starclub.tbl_jbox_subscription where status IN (11,0,5) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1005)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMoFMJ' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////


///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Miss Riya////////////////////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and plan_id!=73 and date(sub_date)<='".$view_date1."' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1009)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RIATataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////


////////// Start code to insert the Pending Base date into the database Docomo MTV////////////////////////////////////////////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1003)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVTataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo MTV//////////////////////////////////////////////////////////////

////////// Start code to insert the Pending Base date into the database Docomo REDFM////////////////////////////////////////////////////////////
/*
$getPendingBase="select count(ani),circle from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and plan_id!=72 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1010)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMTataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo REDFM//////////////////////////////////////////////////////////


////////// Start code to insert the Pending Base date into the database Docomo GL////////////////////////////////////////////////////////////

$getPendingBase="select count(ani),circle from docomo_rasoi.tbl_rasoi_subscription where status IN (11,0,5) and plan_id IN (66,75,76) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1011)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo GL//////////////////////////////////////////////////////////

///////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_radio.tbl_radio_subscription where status=1 AND plan_id != 40 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMoMX' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo 54646///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis not like '%P%' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMo54646' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_active_base="select count(*),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($active_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','NA','NA','NA','NA','1002P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////////////////



/////////////////////////// start code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_starclub.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='TataDoCoMoFMJ' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan/////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo Miss Riya/////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_manchala.tbl_riya_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=73 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		else $circle=substr($circle,0,3);
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RIATataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Miss Riya////////////////////////////////////


//////////////////////////////// start code to insert the active base date into the database Docomo MTV ////////////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVTataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////////////

//////////////////////////////// start code to insert the active base date into the database Docomo REDFM ////////////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=72 group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMTataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1010)";
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
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo GL////////////////////////////////////////////


//////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id NOT IN (40,85) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////


////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$pCircle','NA','$count','NA','NA','NA','NA','1002P')";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1005)";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1009)";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1003)";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1011)";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CC" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CCI";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

	
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{ 
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub,dnis from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$dnis) = mysql_fetch_array($deactivation_base_query))
	{ 
		$pCircle= $pauseArray[$circle];
		$mode = $pauseCode[$unsub_reason];

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$chrg_amount','$count','$unsub_reason','NA','NA','NA','1002P')";
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";


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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";


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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values ('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1001','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr1='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr1='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////

////////start code to insert the data for call_tf for Tata DocomO PauseCode ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		if($call_tf[5]==1) $callStr1='L_CALLS_TF';
		elseif($call_tf[5]!=1) $callStr1='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr1','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		if($call_tf[5]==1) $callStr1='L_CALLS_T';
		elseif($call_tf[5]!=1) $callStr1='N_CALLS_T';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr1','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo PauseCode ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO 54646 ////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr2='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr2='N_CALLS_TF';
			
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr2','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo GL ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO MS ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1000','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1000','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo MS ///////////////////////////////////////////////////////////////////


//////////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callTStr1='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$callTStr1='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$callTStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1001','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// ----------------------- end ---------------------------

//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo 54646

//start code to insert the data for mous_tf for tata Docomo PauseCode
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];

		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1) $mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];

		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1) $mous_tf[0]='N_MOU_T';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata Docomo PauseCode


//start code to insert the data for mous_tf for Tata Docomo Miss Riya
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata DocomoGL


//start code to insert the data for mous_tf for tata DocomoMS
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1000','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1000','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end to insert the data for mous_tf for tata DocomoMS


//start code to insert the data for mous_t for tata Docomo 54646
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and dnis not in('5464669','5464668') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0')
			$mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR')
			$mous_tf[1]='HAY';
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','3','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','3','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6]==5464669) {
			if($mous_tf[7]==1) $mous_tf[0]='L_MOU_T';
			if($mous_tf[7]!=1) $mous_tf[0]='N_MOU_T';
		}elseif($mous_tf[6]==5464668) {
			if($mous_tf[7]==1) $mous_tf[0]='L_MOU_T_1';
			if($mous_tf[7]!=1) $mous_tf[0]='N_MOU_T_1';
		}
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','3','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
		if($mous_tf[6]==5464669) {
			$mous_tf[0]='MOU_T';
		} elseif($mous_tf[6]==5464668) {
			$mous_tf[0]='MOU_T_1';
		}
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','3','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
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
	if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($mous_tf[1]=='' || $mous_tf[1]=='0') $mous_tf[1]='UND';
		elseif(strtoupper($mous_tf[1])=='HAR') $mous_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1001','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice//////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////

/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo PauseCode /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{

		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo PauseCode /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Miss Riya ///////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1009','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
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
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1011','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////


///////////////////////////////////////////DocomoMS /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1000','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1000','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0')
			$pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') 
			$pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) 
			$pulse_tf[0]='L_PULSE_T';
		if($pulse_tf[6]!=1) 
			$pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','3','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','3','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
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
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') 
			$pulse_tf1[1]='HAY';
		if($pulse_tf1[6]==5464669) {
			if($pulse_tf1[7]==1) 
				$pulse_tf1[0]='L_PULSE_T';
			if($pulse_tf1[7]!=1) 
				$pulse_tf1[0]='N_PULSE_T'; 
		} else {
			if($pulse_tf1[7]==1) 
				$pulse_tf1[0]='L_PULSE_T_1';
			if($pulse_tf1[7]!=1) 
				$pulse_tf1[0]='N_PULSE_T_1';
			
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
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
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
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
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
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////

///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////

///////////////////start code to insert the data for Unique Users  for Tata Docomo PauseCode //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('TATM') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('TATM') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('TATM') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('TATM') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

////////////////////////// end Unique Users  for Tata Docomo PauseCode ///////////////////////////////////////////////////////////////////


///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////// end Unique Users  for Tata Docomo Redfm/////////////////////////////////////////////////////////////////////////


/////////////start code to insert the data for Unique Users  for Tata DocomoMS//////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active') 
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active') 
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1000','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1000','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/////////////// end Unique Users  for Tata DocomoMS/////////////////////////////////////////////////////////////////////////


///////////////////start code to insert the data for Unique Users_T  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status IN (1)) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
		if($uu_tf[6]=='Non Active') 
			$uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active') 
			$uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($uu_tf[1]=='' || $uu_tf[1]=='0') $uu_tf[1]='UND';
		elseif(strtoupper($uu_tf[1])=='HAR') $uu_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end insert the data for SEC_TF  for tata Docomo Endless 


///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec), status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{		
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/////////////////////////////////// end insert the data for SEC_TF  for tata Docomo 54646 ///////////////////////////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo PauseCode///////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{		
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{		
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/////////////////////////////////// end insert the data for SEC_TF  for tata Docomo PauseCode ///////////////////////////////////////////////////

////////////////////////start code to insert the data for SEC_TF  for tata Docomo Miss Riya///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
///////////////////////////////////// end insert the data for SEC_TF  for tata DocomoGL ///////////////////////////////////////////////

////////////////////////////////start code to insert the data for SEC_TF  for tata DocomoMS /////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1000','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1000','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
///////////////////////////////////// end insert the data for SEC_TF  for tata DocomoMS ///////////////////////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_T  for tata Docomo 54646///////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0.05','$sec_tf[5]','','1002','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and dnis not like '%P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[1]=='' || $sec_tf[1]=='0') 
			$sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') 
			$sec_tf[1]='HAY';

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0.05','$sec_tf[5]','','1002','NA','NA','NA')";
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==5464669) {
			if($sec_tf[7]==1) $sec_tf[0]='L_SEC_T';
			if($sec_tf[7]!=1) $sec_tf[0]='N_SEC_T'; //$sec_tf[0]='SEC_T';
		} else {
			if($sec_tf[7]==1) $sec_tf[0]='L_SEC_T_1';
			if($sec_tf[7]!=1) $sec_tf[0]='N_SEC_T_1'; //$sec_tf[0]='SEC_T_1';
		}
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0.05','$sec_tf[5]','','1009','NA','NA','NA')";
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
		if($sec_tf[6]==5464669) {
			$sec_tf[0]='SEC_T';
		} else {
			$sec_tf[0]='SEC_T_1';
		}
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0.05','$sec_tf[5]','','1009','NA','NA','NA')";
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($sec_tf[1]=='' || $sec_tf[1]=='0') $sec_tf[1]='UND';
		elseif(strtoupper($sec_tf[1])=='HAR') $sec_tf[1]='HAY';
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
		if($circlefmj[1]=='' || $circlefmj[1]=='0') $circlefmj[1]='UND';
		elseif(strtoupper($circlefmj[1])=='HAR') $circlefmj[1]='HAY';
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


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//start code to insert the data for RBT_*  
$rbt_tf=array();
$rbt_query="select count(*),circle,req_type from docomo_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[1]=='' || $rbt_tf[1]=='0') $rbt_tf[1]='UND';
		elseif(strtoupper($rbt_tf[1])=='HAR') $rbt_tf[1]='HAY';
		if(strtoupper($rbt_tf[2])=='CRBT')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1001','NA','NA','NA')";
		}
		elseif(strtoupper($rbt_tf[2])=='RNG')
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
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
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
