<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

if(isset($_REQUEST['date'])) {
	$view_date1= trim($_REQUEST['date']);
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo $view_date1='2013-02-24';

$chrg_amount="0";

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

//----- pause code array ----------

$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

//$pauseCode = array('1'=>'Love Guru','2'=>'Music World','3'=>'Movie Junction','4'=>'Celebrity World','5'=>'Astro (JAD)');
$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');

//---------------------------------

// delete the prevoius record
$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and (type like 'Activation_%' OR type like 'Renewal_%' OR type like 'TOP-UP_%' OR type like 'Mode_Activation__%' OR type like 'Mode_Activation__%')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic

// start the code to insert the data of activation Airtel
$get_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1503,1511,1507,1514,1513,1518,1515,1517,1501,1520,1522) and event_type in('SUB','RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query1))
	{	
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		} else if($service_id == 1522) { 
			if($plan_id==63) $service_id = 15222; 
			elseif($plan_id==64) $service_id = 15221; 			
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
			$charging_str="TOP-UP_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','RESUB','TOPUP') and SC not like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query1))
	{	
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		
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

// end the code to insert the data of activation Airtel

//Start the code to activation Record mode wise 

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode,plan_id from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1503,1511,1507,1514,1513,1518,1515,1517,1501,1520,1522) and event_type in('SUB','TOPUP') and SC not like '%P%' group by circle,service_id,event_type,mode,plan_id order by event_type,plan_id"; //and plan_id!=29 

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		//if($shortCode == '5464612') $service_id='1518';
		if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
			$service_id = 1509; 
		} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
			$service_id = 1511; 
		} else if($service_id == 1522) { 
			if($plan_id==63) $service_id = 15222; 
			elseif($plan_id==64) $service_id = 15221; 			
		} 

		if($event_type == 'SUB') { 
			$activation_str1="Mode_Activation_".strtoupper($mode);
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		} else if($event_type == 'TOPUP') {
			$activation_str1="Mode_TOP-UP_IVR";
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,service_id,event_type,mode,plan_id from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','TOPUP') and SC not like '%P%' group by circle,service_id,event_type,mode,plan_id order by event_type,plan_id"; //and plan_id!=29 

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$event_type,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		if($event_type == 'SUB') { 
			$activation_str1="Mode_Activation_".strtoupper($mode);
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		} else if($event_type == 'TOPUP') {
			$activation_str1="Mode_TOP-UP_IVR";
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";	
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end the code

//---------pause code ------------------

$get_activation_query1="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,substr(SC,9,3) as p,substr(SC,14,1) as code from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB') and SC like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id,$p,$code) = mysql_fetch_array($query1))
	{	
		if($event_type=='SUB')
		{
			$pcircle = $pauseArray[$p];
			$pauseCodeVal = $pauseCode[$code];
			$activation_str="Mode_Activation_".$pauseCodeVal;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pcircle','1502P','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_activation_query1="select count(msisdn),substr(SC,9,3) as circle,chrg_amount,service_id,event_type,plan_id from ".$successTable." nolock  where DATE(response_time)='$view_date1' and service_id in(1502) and event_type in('SUB','RESUB','TOPUP') and SC like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";
$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error()); // and plan_id!=29
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0)
{
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query1))
	{	
		$pCircle = $pauseArray[$circle];
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='TOPUP')
		{
			$charging_str="TOP-UP_".$charging_amt;

			$insert_data="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1502P','$charging_amt','$count','NA','NA','NA')";
		}

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//---------pause code end here ---------

//----------------- failure count --------------------------

$charging_fail="select count(*),circle,event_type,service_id from master_db.tbl_billing_failure where date(date_time)='$view_date1' group by circle,event_type,service_id order by service_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$service_id) = mysql_fetch_array($deactivation_base_query))
{
	if($service_id == 1511 && ($plan_id==30 || $plan_id==48)) { 
		$service_id = 1509; 
	} else if($service_id == 1511 && ($plan_id==29 || $plan_id==46)) { 
		$service_id = 1511; 
	} else if($service_id == 1522) { 
		if($plan_id==64) $service_id = 15221; 
		elseif($plan_id==63) $service_id = 15222; 			
	} 
		
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";
	
	if($circle == "") $circle="UND";
	elseif($circle == "HAR") $circle="HAY";
	elseif($circle == "PUN") $circle="PUB";

	$insertData="insert into mis_db.daily_report(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle', '$count', '".$service_id."')";
	$queryIns = mysql_query($insertData, $dbConn);
}


//------------------ failure count code end here -----------


mysql_close($dbConn);
echo "done";
?>
