<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include("/var/www/html/kmis/services/hungamacare/config/live_dbConnect.php");
//$LivdbConn;

if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//echo $view_date1='2013-06-14';
/*
if($view_date1) 
{
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate)
		$successTable = "master_db.tbl_billing_success_backup";
	
	if($view_date1 < '2013-06-02') 
		$successTable = "master_db.tbl_billing_success_04_06_2013";
	else
		$successTable = "master_db.tbl_billing_success";
}
*/
//added by satay
if($view_date1) 
{
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));

	if($view_date1 < $tempDate)
	 {	
		if($view_date1 < '2013-06-02')
		{
		$successTable = "master_db.tbl_billing_success_04_06_2013";
		}
		else
		{
		$successTable = "master_db.tbl_billing_success_backup";
		}
	}
	else
	{
		$successTable = "master_db.tbl_billing_success";
	}
}
//end here
//echo $successTable;
//exit;

$circle_info1=array('Delhi'=>'DEL','Gujarat'=>'GUJ','WestBengal'=>'WBL','Bihar'=>'BIH','Rajasthan'=>'RAJ','UP WEST'=>'UPW','Maharashtra'=>'MAH','Andhra Pradesh'=>'APD','UP EAST'=>'UPE','Assam'=>'ASM','Tamil Nadu'=>'TNU','Kolkata'=>'KOL','NE'=>'NES','Chennai'=>'CHN','Orissa'=>'ORI','Karnataka'=>'KAR',
'Haryana'=>'HAR','Punjab'=>'PUN','Mumbai'=>'MUM','Madhya Pradesh'=>'MPD','Jammu-Kashmir'=>'JNK',"Punjab"=>'PUB','Kerala'=>'KER','Himachal Pradesh'=>'HPD','Other'=>'UND','Haryana'=>'HAY');

//----- pause code array ----------

$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');

//---------------------------------


$deleteprevioousdata="delete from mis_db.dailyReportUninor where date(report_date)='$view_date1'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic

$get_activation_query="select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in (1402,1403,1410,1409,1416,1408,1418) and event_type in('SUB','RESUB') and plan_id NOT IN (86,87,93,94) AND SC not like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($plan_id==95 && $service_id=='1402') $service_id='14021';
		if($circle == "") $circle="UND";
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		elseif($event_type=='RESUB')
		{
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


$get_activation_query="select count(msisdn),circle,floor(chrg_amount),service_id,event_type,plan_id from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in (1402,1403,1410,1409,1416,1408,1418) and event_type IN ('TOPUP','EVENT') and SC not like '%P%' group by circle,service_id,floor(chrg_amount),event_type,plan_id";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id) = mysql_fetch_array($query))
	{
		if($circle == "") 
                    $circle="UND";
                
		if($plan_id==95 && $service_id=='1402') 
                    $service_id='14021';
                
		if($plan_id==86 || $plan_id==87 || $plan_id==93 || $plan_id==94 || $plan_id==173)
		{
            $amt = floor($charging_amt);
			if($amt<2) 
               $charging_str="Event_1";
			else 
               $charging_str="Event_".$amt;
		}
          else 
		{
			$charging_str="TOP-UP_".$charging_amt;			
		}

		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//Start the code to activation Record mode wise for Uninor54646

$get_mode_activation_query="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1402,1410,1416,1408,1418) and event_type in('SUB') and plan_id NOT IN (86,87,93,94,95) and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type,plan_id";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query))
	{
		if($plan_id==95 && $service_id=='1402') $service_id='14021';
		if($circle == "") $circle="UND";
		if($mode == "") $mode="IVR"; 
		
		if(($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode=="CROSSRR") && $service_id=='1409') $mode="REDFMRIYA";
		elseif($mode == "CROSSENT" && $service_id!='1409') $mode="IVR";
		elseif($mode=="IVR-MPMC" || $mode == "TIVR") $mode="IVR";
		elseif(($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id!='1402') $mode="OBD";
		elseif($mode == "OBD_HUNG") $mode="OBD-HUNG";
		elseif($mode == "wap") $mode="WAP";
		elseif($mode == "pan") $mode="Others";
		elseif($mode == "OBD-9xm") $mode="9XMOBD";			
		elseif($mode == "OBD-Jokes") $mode="OBD-JOKES";

		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1402) and event_type in('SUB') and plan_id IN (95) and SC not like '%P%' group by circle,service_id,event_type,mode order by event_type,plan_id";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query))
	{		
		if($circle == "") $circle="UND";
		if($mode == "") $mode="IVR";
		
		if(($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode=="CROSSRR") && $service_id=='1409') $mode="REDFMRIYA";
		elseif($mode == "CROSSENT" && $service_id!='1409') $mode="IVR";
		elseif($mode=="IVR-MPMC" || $mode == "TIVR") $mode="IVR";
		elseif(($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id!='1402') $mode="OBD";
		elseif($mode == "OBD_HUNG") $mode="OBD-HUNG";
		elseif($mode == "wap") $mode="WAP";
		elseif($mode == "pan") $mode="Others";
		elseif($mode == "OBD-9xm") $mode="9XMOBD";
		elseif($mode == "OBD-Jokes") $mode="OBD-JOKES";

		$activation_str1="Mode_Activation_".$mode;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','14021','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// end the code for Uninor54646

// uninor Pause code 

$get_activation_query="select count(msisdn),substr(SC,9,3) as circle1,chrg_amount,service_id,event_type,plan_id,SC from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in (1402) and event_type in('SUB','RESUB') and plan_id NOT IN (86,87,93,94) AND SC like '%P%' group by circle,service_id,chrg_amount,event_type,plan_id,SC";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);

if ($numRows > 0)
{
	$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$charging_amt,$service_id,$event_type,$plan_id,$sc) = mysql_fetch_array($query))
	{
		$pCircle = $pauseArray[$circle];
		if($event_type=='SUB')
		{
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA')";
		} elseif($event_type=='RESUB') {
			$charging_str="Renewal_".$charging_amt;

			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA')";
		} elseif($event_type=='TOPUP') {
			$charging_str="TOP-UP_".$charging_amt;

			$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$charging_str','$pCircle','1402P','$charging_amt','$count','NA','NA','NA')";
		}
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


$get_mode_activation_query="select count(msisdn),substr(SC,14,1) as circle1,service_id,mode,plan_id,SC,substr(SC,14,1) as p from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1402) and event_type in('SUB') and plan_id NOT IN (86,87,93,94) and SC like '%P%' group by circle,service_id,event_type,mode order by event_type,plan_id,SC";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode,$plan_id,$sc,$p) = mysql_fetch_array($db_query))
	{
		$pMode=$pauseCode[$p];
		$pCircle = $pauseArray[$circle];
		if($mode == "") $mode="IVR";
		$activation_str1="Mode_Activation_".$pMode;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$pCircle','1402P','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}
// end


//Start the code to activation Record mode wise for Uninor54646

$get_mode_activation_query="select count(msisdn),circle,service_id,mode from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1409) and event_type in('EVENT') and plan_id IN (87) group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query))
	{
		if($circle == "")
                    $circle="UND";
		$activation_str1="Total_Success_Download";
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}


$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='UNIM' and service='1409' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str1="Total_Number_Of_Clicks";
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1409','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// end the code for Uninor54646


// Event charging Uninor RedFM

$get_mode_activation_query="select count(msisdn),circle,service_id,floor(chrg_amount) from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1410) and event_type in('EVENT') and plan_id IN (93,34,133) group by circle,service_id,event_type,floor(chrg_amount) order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$chrg_amount) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str="Event_FS_".$chrg_amount;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str','$circle','14101','$count','NA','NA','NA')";	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle,service_id,mode from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id in(1410) and event_type in('EVENT') and plan_id IN (93,34,133) group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str="Mode_FS_".$mode;
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str','$circle','14101','$count','NA','NA','NA')";	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='UNIM' and service='1410' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str1="FS_REQ";
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1410','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$get_mode_activation_query="select count(msisdn),circle from mis_db.tbl_wapRequest_data where date(datetime)='".$view_date1."' and operator='UNIM' and service='1410' and status='Success' group by circle";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		$str1="FS_SUC";
		$insert_data1="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$str1','$circle','1410','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

// End of Event charging Uninor RedFM


//Start the code to activation Record mode wise for UninorMTV

$get_mode_activation_query="select count(msisdn),circle,service_id,mode from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1403 and event_type in('SUB') and plan_id NOT IN (86,87,93,94) group by circle,service_id,event_type,mode order by event_type";
$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query);
if ($numRows > 0)
{
	$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query))
	{
		if($circle == "") $circle="UND";
		if($mode == "") $mode="IVR";
		
		if(($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode=="CROSSRR") && $service_id=='1409') $mode="REDFMRIYA";
		elseif($mode == "CROSSENT" && $service_id!='1409') $mode="IVR";
		elseif($mode=="IVR-MPMC" || $mode == "TIVR") $mode="IVR";
		elseif(($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id!='1402') $mode="OBD";
		elseif($mode == "OBD_HUNG") $mode="OBD-HUNG";
		elseif($mode == "wap") $mode="WAP";
		elseif($mode == "pan") $mode="Others";
		elseif($mode == "OBD-9xm") $mode="9XMOBD";
		elseif($mode == "OBD-Jokes") $mode="OBD-JOKES";

		$activation_str1="Mode_Activation_".$mode;
		$insert_data2="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str1','$circle','$service_id','$count','NA','NA','NA')";
	
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

// end the code for UninorMTV


//Start the code to activation Record mode wise for UninorManchala

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1409 and event_type in('SUB') and plan_id NOT IN (86,87,93,94) group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
	$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query1))
	{ 
		if($circle == "") $circle="UND";
		if($mode == "") $mode="IVR";

		if(($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode=="CROSSRR") && $service_id=='1409') $mode="REDFMRIYA";
		elseif($mode == "CROSSENT" && $service_id!='1409') $mode="IVR";
		elseif($mode=="IVR-MPMC" || $mode == "TIVR") $mode="IVR";
		elseif(($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id!='1402') $mode="OBD";
		elseif($mode == "OBD_HUNG") $mode="OBD-HUNG";
		elseif($mode == "wap") $mode="WAP";
		elseif($mode == "pan") $mode="Others";
		elseif($mode == "OBD-9xm") $mode="9XMOBD";
		elseif($mode == "OBD-Jokes") $mode="OBD-JOKES";

		$activation_str_m="Mode_Activation_".$mode;
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

// end the code for UninorManchala

//Start the code to activation Record mode wise for Uninor MyRingTone

$get_mode_activation_query1="select count(msisdn),circle,service_id,chrg_amount from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') group by circle,service_id,event_type,chrg_amount order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
	$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
	while(list($count,$circle,$service_id,$chrg_amount) = mysql_fetch_array($db_query1))
	{ 
		$amt = floor($chrg_amount);
		if($amt < 2) $amt1 = 1;
		elseif($amt <= 9 && $amt >= 2) $amt1 = $amt;
		else $amt1 = 10;

		if($circle == "") $circle="UND";
		$activation_str_m="Activation_".$amt;
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
		
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query1))
        { 
			if($circle == "") $circle="UND";
			if($mode == "") $mode="IVR";

			if(($mode == "CrossRedRiya" || $mode == "CROSSENT" || $mode=="CROSSRR") && $service_id=='1409') $mode="REDFMRIYA";
			elseif($mode == "CROSSENT" && $service_id!='1409') $mode="IVR";
			elseif($mode=="IVR-MPMC" || $mode == "TIVR") $mode="IVR";
			elseif(($mode == "OBD_HUNG" || $mode == "OBD_SW") && $service_id!='1402') $mode="OBD";
			elseif($mode == "OBD_HUNG") $mode="OBD-HUNG";
			elseif($mode == "wap") $mode="WAP";
			elseif($mode == "pan") $mode="Others";
			elseif($mode == "OBD-9xm") $mode="9XMOBD";
			elseif($mode == "OBD-Jokes") $mode="OBD-JOKES";

			$activation_str_m="Mode_Activation_".$mode;
			$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
			
			$queryIns = mysql_query($insert_data_m, $dbConn);
        }
}
// end the code for Uninor MyRingTone


// start code to insert the Pending Base data into the database for Uninor54646
/*
$get_pending_base="select count(ani),circle from uninor_hungama.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' and dnis not like '%P%' and plan_id!=95 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1402')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='Uninor54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_pending_base="select count(ani),substr(dnis,9,3) as circle1,dnis from uninor_hungama.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' and dnis like '%P%' and plan_id!=95 group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$dnis) = mysql_fetch_array($pending_base_query))
	{
		$pCircle = $pauseArray[$circle];		
		$insert_pending_base="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1402P')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

// end code to insert the active base data into the database for Uninor54646

// start code to insert the Pending Base data into the database for UninorAAV
/*
$get_pending_base="select count(ani),circle from uninor_hungama.tbl_Artist_Aloud_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' and plan_id=95 group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','14021')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='AAUninor' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',14021)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorAAV

// start code to insert the Pending Base data into the database for UninorMPMC
/*
$get_pending_base="select count(ani),circle from uninor_hungama.tbl_comedy_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1418')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorComedy' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1418)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorMPMC

// start code to insert the Pending Base data into the database for UninorMTV
/*
$get_pending_base="select count(ani),circle from uninor_hungama.tbl_mtv_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base1="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1403')";
		$queryIns_pending = mysql_query($insert_pending_base1, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVUninor' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


// end code to insert the active base data into the database for UninorMTV

// start code to insert the Pending base data into the database for UninorRedFM
/*
$get_pending_base="select count(ani),circle from uninor_redfm.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base1="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1410')";
		$queryIns_pending = mysql_query($insert_pending_base1, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMUninor' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorRedFm

// start code to insert the Pending base data into the database for UninorManchla
/*
$get_pending_base="select count(ani),circle from uninor_manchala.tbl_riya_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1409')";
		$queryIns_pending = mysql_query($insert_pending_base_m, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RIAUninor' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the active base data into the database for UninorManchala

// start code to insert the Pending base data into the database for UninorJAD
/*$get_pending_base="select count(ani),circle from uninor_jyotish.tbl_jyotish_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1416')";
		$queryIns_pending = mysql_query($insert_pending_base_m, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorAstro' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorJAD

// start code to insert the Pending base data into the database for UninorCricket
/*$get_pending_base="select count(ani),circle from uninor_cricket.tbl_cricket_subscription where status IN (11,0,5) and date(sub_date) <= '$view_date1' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_pending_base_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA','1408')";
		$queryIns_pending = mysql_query($insert_pending_base_m, $dbConn);
	}
}*/

$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorSU' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorCricket

// start code to insert the active base data into the database for Uninor54646
/*
$get_active_base="select count(*),circle from uninor_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=95 and dnis not like '%P%' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1402','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='Uninor54646' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_active_base="select count(*),substr(dnis,9,1) as circle1,dnis from uninor_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=95 and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$dnis) = mysql_fetch_array($active_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','1402P','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}
// end code to insert the active base data into the database for Uninor54646

// start code to insert the active base data into the database for UninorAAV
/*
$get_active_base="select count(*),circle from uninor_hungama.tbl_Artist_Aloud_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id=95 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','14021','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='AAUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',14021)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorAAV


// start code to insert the active base data into the database for UninorMPMC
/*
$get_active_base="select count(*),circle from uninor_hungama.tbl_comedy_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count, mode_of_sub,service_id,sub_type, mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1418','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorComedy' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1418)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorMPMC

// start code to insert the active base data into the database for UninorMTV
/*
$get_active_base="select count(*),circle from uninor_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data4="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous, pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1403','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data4, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='MTVUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorMTV


// start code to insert the active base data into the database for UninorRedFM
/*
$get_active_base_redfm="select count(*),circle from uninor_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous, pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1410','NA','NA','NA','NA')";
		$queryIns1 = mysql_query($insert_data5, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RedFMUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorREdFm


// start code to insert the active base data into the database for UninorManchala
/*
$get_active_base_redfm="select count(*),circle from uninor_manchala.tbl_riya_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous, pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1409','NA','NA','NA','NA')";
		$queryIns_m = mysql_query($insert_data_m, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='RIAUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// start code to insert the active base data into the database for UninorJAD
/*$get_active_base_redfm="select count(*),circle from uninor_jyotish.tbl_jyotish_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous, pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1416','NA','NA','NA','NA')";
		$queryIns_m = mysql_query($insert_data_m, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorAstro' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorJAD

// start code to insert the active base data into the database for UninorCricket
/*$get_active_base_redfm="select count(*),circle from uninor_cricket.tbl_cricket_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($active_base_query_redfm);
if ($numRows1 > 0)
{
	$active_base_query_redfm = mysql_query($get_active_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($active_base_query_redfm))
	{
		if($circle == "" || $circle=='0') $circle="UND";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous, pulse,total_sec) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','1408','NA','NA','NA','NA')";
		$queryIns_m = mysql_query($insert_data_m, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active where service='UninorSU' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the active base data into the database for UninorCricket

// start code to insert the Deactivation Base into the MIS database for Uninor54646

/*$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=95 and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1402')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,status,dnis from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=95 and dnis like '%P%' group by circle,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','NA','NA','NA','1402P')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646

// start code to insert the Deactivation Base into the MIS database for UninorAAV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' and plan_id=95 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','14021')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorAAV

// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data5="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1418')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMPMC

// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		$deactivation_str1="Mode_Deactivation_in";
		$insert_data6="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1403')";
		$queryIns = mysql_query($insert_data6, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV


// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows2 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		if($circle == "") $circle="UND";
		$deactivation_str2="Mode_Deactivation_in";
		$insert_data6="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str2','$circle','$count','NA','NA','NA','1410')";
		$queryIns2 = mysql_query($insert_data6, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UNINORREDFM


// start code to insert the Deactivation Base into the MIS database for UninorManchala

$get_deactivation_base_m = "select count(*),circle,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_m);
if ($numRows2 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		$deactivation_str_m="Mode_Deactivation_in";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str_m','$circle','$count','NA','NA','NA','1409')";
		$queryIns2 = mysql_query($insert_data_m, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UNINORManchala

// start code to insert the Deactivation Base into the MIS database for UninorCricket

$get_deactivation_base_m = "select count(*),circle,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_m);
if ($numRows2 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		$deactivation_str_m="Mode_Deactivation_in";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str_m','$circle','$count','NA','NA','NA','1408')";
		$queryIns2 = mysql_query($insert_data_m, $dbConn);
	}
}
*/
// end code to insert the Deactivation base into the MIS database for UninorCricket


// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub ,status,dnis from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$unsub_reason=$pauseCode[$unsub_reason];
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','$unsub_reason','NA','NA','NA','1402P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646/ Uninor Pause Code

// start code to insert the Deactivation Base into the MIS database for UninorAAV

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' and plan_id=95 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',14021)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorAAV

// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA','1418')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMPMC


// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data7="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data7, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV

// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,unsub_reason ,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows3 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_redfm="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data_redfm, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorREdfm


// start code to insert the Deactivation Base into the MIS database for UninorManchala

$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorManchala

// start code to insert the Deactivation Base into the MIS database for UninorJAD
$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database for UninorJAD

// start code to insert the Deactivation Base into the MIS database for UninorCricket
$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system" || $unsub_reason=="RECON_BLOCK")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database for UninorCricket


//start code to insert the data for call_tf for Uninor54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461','5464611') and dnis not like '%P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461','5464611') and dnis not like '%P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for Uninor54646


//start code to insert the data for call_tf for Uninor54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'UninorPause' as service_name,date(call_date),dnis from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p=$call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorPause' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$p=$call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'UninorPause' as service_name,date(call_date),dnis from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p=$call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'UninorPause' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_T";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_T";
		$p=$call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorPause


//start code to insert the data for call_tf for UninorAAV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','14021','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','14021','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorAAV

//start code to insert the data for call_tf for UninorMPMC
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMPMC' as service_name,date(call_date) from  mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1418','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMPMC' as service_name,date(call_date),status from  mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1418','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorMPMC


//start code to insert the data for call_tf for UninorMS
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorMS


//start code to insert the data for call_tf for UninorRiya
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
        $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
        while($call_tf = mysql_fetch_array($call_tf_result))
        {
                $insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
                $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
        }
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end call_tf for UninorRiya



//start code to insert the data for call_tf for UninorREdFm

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date) from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date),status from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id, mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

// end call_tf for UninorREdFm

//start code to insert the data for call_tf for UninorMTV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date) from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date),status from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
/// end call_tf for UninorMTV//////

//start code to insert the data for call_tf for UninorRT
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRT' as service_name,date(call_date) from  mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1412','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

/*$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorRT' as service_name,date(call_date),status from  mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1412','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
} */
// end call_tf for UninorRT

//start code to insert the data for call_tf for UninorJAD
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorJAD' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1416','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorJAD' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1416','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end call_tf for UninorJAD

//start code to insert the data for call_tf for UninorCricket
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorCricket' as service_name,date(call_date) from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'UninorCricket' as service_name,date(call_date),status from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_TF";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_TF";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'UninorCricket' as service_name,date(call_date) from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'UninorCricket' as service_name,date(call_date),status from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5] == 1) $call_tf[0]="L_CALLS_T";
		elseif($call_tf[5] != 1) $call_tf[0]="N_CALLS_T";
		$insert_call_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end call_tf for UninorCricket


//start code to insert the data for call_t for Uninor54646
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0]="L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0]="N_CALLS_T";
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end call_t for Uninor54646

//start code to insert the data for call_t for UninorRiya
$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0)
{
	$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0]="L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0]="N_CALLS_T";
		$insert_call_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
		$queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
	}
}

// end call_t for UninorRiya


//start code to insert the data for mous_tf for Uninor54646
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for Uninor54646

//start code to insert the data for mous_tf for UninorPause
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_T";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_T";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

// end mous_tf for UninorPause

//start code to insert the data for mous_tf for UninorAAV
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','14021','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','14021','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorAAV


//start code to insert the data for mous_tf for UninorMPMC
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1418','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1418','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorMPMC

//start code to insert the data for mous_tf for UninorMS
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorMS

//start code to insert the data for mous_tf for UninorREDFM
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorREDFM



//start code to insert the data for mous_tf for UninorMTV
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorMTV


//start code to insert the data for mous_tf for UninorRiya
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorRiya

//start code to insert the data for mous_tf for UninorRT
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRT' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1412','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

/*$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRT' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1412','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}*/
// end mous_tf for UninorRT

//start code to insert the data for mous_tf for UninorJAD
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorJAD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1416','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorJAD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1416','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorJAD

//start code to insert the data for mous_tf for UninorCricket
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_TF";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_TF";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6] == 1) $mous_tf[0]="L_MOU_T";
		elseif($mous_tf[6] != 1) $mous_tf[0]="N_MOU_T";
		$insert_mous_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end mous_tf for UninorCricket

//start code to insert the data for mous_t for Uninor54646
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0]="L_MOU_T";
		elseif($mous_t[6] == 1) $mous_t[0]="N_MOU_T";
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end mous_t for Uninor54646

//start code to insert the data for mous_t for UninorRiya
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
        $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
        while($mous_t = mysql_fetch_array($mous_t_result))
        {
                $insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
                $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
        }
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0]="L_MOU_T";
		elseif($mous_t[6] == 1) $mous_t[0]="N_MOU_T";
		$insert_mous_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end mous_t for UninorRiya


//start code to insert the data for PULSE_TF for Uninor54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for Uninor54646


//start code to insert the data for PULSE_TF for UninorPause
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";

		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_T";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_T";

		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

// end PULSE_TF for UninorPause


//start code to insert the data for PULSE_TF for UninorAAV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','14021','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','14021','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorAAV


//start code to insert the data for PULSE_TF for UninorMPMC
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1418','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1418','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorMPMC



//start code to insert the data for PULSE_TF for UninorMS
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorMS


//start code to insert the data for PULSE_TF for UninorRiya
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628','5464626') and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1409','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628','5464626') and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1409','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorRiya



//start code to insert the data for PULSE_TF for UninorREdfm
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorREdfm



//start code to insert the data for PULSE_TF for UninorMTV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorMTV

//start code to insert the data for PULSE_TF for UninorRT
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRT' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1412','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/*$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRT' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1412','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}*/
// end PULSE_TF for UninorRT

//start code to insert the data for PULSE_TF for UninorJAD
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorJAD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1416','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorJAD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1416','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorJAD

//start code to insert the data for PULSE_TF for UninorCricket
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_TF";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_TF";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6] == 1) $pulse_tf[0]="L_PULSE_T";
		elseif($pulse_tf[6] != 1) $pulse_tf[0]="N_PULSE_T";
		$insert_pulse_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end PULSE_TF for UninorCricket

//start code to insert the data for PULSE_T for Uninor54646
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] = "L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] = "N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
// end PULSE_T for Uninor54646

//start code to insert the data for PULSE_T for UninorRiya
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
        $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
        while($pulse_t = mysql_fetch_array($pulse_t_result))
        {
                $insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1409','NA','$pulse_t[5]','NA')";
                $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
        }
} 

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] = "L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] = "N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1409','NA','$pulse_t[5]','NA')";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
	}
} 
// end PULSE_T for UninorRiya

//start code to insert the data for Unique Users  for toll free for Uninor54646
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and dnis not like '%P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for Uninor54646

//start code to insert the data for Unique Users  for toll free for UninorPause
$uu_tf=array();
$uu_tf_query="select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p]; 
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p = $uu_tf[1];
		$pCircle = $pauseArray[$p]; 
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

// end toll free for UninorPause


//start code to insert the data for Unique Users  for toll free for Uninor54646
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','14021','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','14021','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorAAV

//start code to insert the data for Unique Users  for toll free for UninorMPMC
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1418','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status NOT IN (1) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		/*if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF";*/
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1418','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMPMC

//start code to insert the data for Unique Users  for toll free for UninorMS
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMS

//start code to insert the data for Unique Users  for toll free for UninorRiya
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628','5464626') and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorRiya


//start code to insert the data for Unique Users  for toll free for REDFM
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{	
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for Uninor54646



//start code to insert the data for Unique Users  for toll free for UninorMTV
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461) and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorMTV

//start code to insert the data for Unique Users  for toll free for UninorRT
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

/*$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}*/
// end toll free for UninorRT


//start code to insert the data for Unique Users  for toll free for UninorJAD
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1416','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1416','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorJAD

//start code to insert the data for Unique Users  for toll free for UninorCricket
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';

		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll free for UninorCricket

//start code to insert the data for Unique Users for toll for Uninor54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and dnis not like '%P%' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and operator in('unim') and status in(-1,11,0) and dnis not like '%P%' AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and dnis not like '%P%' and operator in('unim') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis!='5464669' and dnis not like '%P%' and operator in('unim') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_T";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_T";	
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll for Uninor54646

//start code to insert the data for Unique Users for toll for UninorRia
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_T";
		elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_T";	
		$insert_uu_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end toll for UninorRia


//start code to insert the data for SEC_TF  for Uninor54646
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for Uninor54646


//start code to insert the data for SEC_TF  for UninorPause
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('unim') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('unim') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];

		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('unim') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('unim') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle = $pauseArray[$p];

		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_T";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_T";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorPause

//start code to insert the data for SEC_TF  for UninorAAV
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorAAV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','14021','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorAAV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','14021','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorAAV

//start code to insert the data for SEC_TF  for UninorMPMC
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMPMC' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1418','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMPMC' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1418','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorMPMC


//start code to insert the data for SEC_TF  for Uninor54646
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";	
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorMS

//start code to insert the data for SEC_TF  for UninorRia
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
        $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
        while($sec_tf = mysql_fetch_array($sec_tf_result))
        {
                $insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
        }
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end SEC_TF for UninorRiya



//start code to insert the data for SEC_TF  for UninorREDFM
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

// end SEC_TF for UninorREDFM


//start code to insert the data for SEC_TF  for UninorMTV
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorMTV

//start code to insert the data for SEC_TF  for UninorRT
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRT' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1412','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/*$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorRT' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1412','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}*/
// end SEC_TF for UninorRT

//start code to insert the data for SEC_TF  for UninorJAD
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorJAD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1416','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorJAD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1416','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorJAD


//start code to insert the data for SEC_TF  for UninorCricket
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_TF";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_TF";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6] == 1) $sec_tf[0] = "L_SEC_T";
		elseif($sec_tf[6] != 1) $sec_tf[0] = "N_SEC_T";
		$insert_sec_tf_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end SEC_TF for UninorCricket

//start code to insert the data for SEC_T for Uninor54646

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1402','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end SEC_T for Uninor54646


//start code to insert the data for SEC_T for UninorRiya
$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
        $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
        while($sec_t = mysql_fetch_array($sec_t_result))
        {
                $insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1409','NA','NA','NA')";
                $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
        }
}

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1409','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end SEC_T for UninorRiya

// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,status,dnis from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','NA','NA','NA','1402P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646


// start code to insert the Deactivation Base into the MIS database for Uninor AAV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','14021')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//----------Uninor AAV

// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1418')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//----------UninorMPMC

// start code to insert the Deactivation Base into the MIS database for UninorRiya

$get_deactivation_base="select count(*),circle,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
        $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
        while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
        {
                $deactivation_str1="Deactivation_30";
                $insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1409)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

// end code to insert the Deactivation base into the MIS database for UninorRiya



// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV


// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_fm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_fm);
if ($numRows2 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		$deactivation_str1="Deactivation_10";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorRedFM

// start code to insert the Deactivation Base into the MIS database for UninorJAD

$get_deactivation_base="select count(*),circle,status from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorJAD

// start code to insert the sunsign Base into the MIS database for UninorJAD

$get_ss_base="select 'Sign_Base',count(distinct ANI) as count,circlecode from uninor_jyotish.UpdateJyotishAlarm group by circlecode";

$ss_base_query = mysql_query($get_ss_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($ss_base_query);
if ($numRows > 0)
{
	$ss_base_query_result = mysql_query($get_ss_base, $dbConn) or die(mysql_error());
	while(list($ss_base,$count,$circle) = mysql_fetch_array($ss_base_query_result))
	{	
		if(!$circle) $circle='UND';
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$ss_base','$circle','$count','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the sunsign base into the MIS database for UninorJAD

// start code to insert the Deactivation Base into the MIS database for UninorCricket

$get_deactivation_base="select count(*),circle,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorCricket

// start code to insert the Charging Failure into the MIS database for Uninor54646

$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' and service_id=1402 and SC not like '%P%' group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type) = mysql_fetch_array($deactivation_base_query))
{
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";

	$insertData="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1402')";
	$queryIns = mysql_query($insertData, $dbConn);
}

// end code to insert the Charging Failure into the MIS database for Uninor54646

// start code to insert the Charging Failure into the MIS database for UninorMTV
$charging_fail="select count(*),circle,event_type from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' and service_id=1403 group by circle,event_type";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type) = mysql_fetch_array($deactivation_base_query))
{
	if($event_type=='SUB')
		$faileStr="FAIL_ACT";
	if($event_type=='RESUB')
		$faileStr="FAIL_REN";
	if($event_type=='topup')
		$faileStr="FAIL_TOP";

	$insertData="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1403')";
	$queryIns = mysql_query($insertData, $dbConn);
}
// end code to insert the Charging Failure into the MIS database for UninorMTV

// start code to insert the Charging Failure into the MIS database for UninorMTV
$charging_fail="select count(*),circle,event_type,plan_id from master_db.tbl_billing_failure nolock where date(response_time)='$view_date1' and service_id=1412 group by circle,event_type,plan_id";
$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
while(list($count,$circle,$event_type,$plan_id) = mysql_fetch_array($deactivation_base_query))
{
	if($plan_id==69) $type='PT_REQ'; 
	elseif($plan_id==70) $type='MT_REQ';
	elseif($plan_id==71) $type='TT_REQ';	 
	
	$faileStr="RT_".$type;

	$insertData="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,service_id) values('$view_date1', '$faileStr','$circle','$count','1412')";
	$queryIns = mysql_query($insertData, $dbConn);
}

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode,plan_id from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') group by circle,service_id,event_type,mode,plan_id order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode,$plan_id) = mysql_fetch_array($db_query1))
        { 
			if($circle == "") $circle="UND";
			
			if($plan_id==69) { 
				$rtype='PT_REQ'; 
				$stype='PT_SUC'; 
			} elseif($plan_id==70) {
				$rtype='MT_REQ';
				$stype='MT_SUC';
			} elseif($plan_id==71) {
				$rtype='TT_REQ';	 
				$stype='TT_SUC';	 
			}

			$rt_req_str="RT_".$rtype;
			$insertReqData="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$rt_req_str','$circle','$service_id','$count','NA','NA','NA')";			
			$queryIns = mysql_query($insertReqData, $dbConn);

			$rtSucStr="RT_".$stype;
			$insertSucData="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$rtSucStr','$circle','$service_id','$count','NA','NA','NA')";	
			$queryIns = mysql_query($insertSucData, $dbConn);
        }
}
// end code to insert the Charging Failure into the MIS database for UninorMTV

// --------------- insert the Event Charging ------------------
$get_mode_activation_query1="select count(msisdn),circle,service_id,mode,plan_id,chrg_amount from ".$successTable."  nolock where DATE(response_time)='$view_date1' and service_id=1408 and event_type in('EVENT') group by circle,service_id,event_type,mode,plan_id,chrg_amount order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode,$plan_id,$chrg_amount) = mysql_fetch_array($db_query1))
        { 
			if($circle == "") $circle="UND";
			
			$amt = floor($chrg_amount);
			if($amt < 2) 
			$amt1 = 1;
			else 
			$amt1 = $amt;
			
			$eventStr="Event_".$amt1;
			
			$insertReqData="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec,charging_rate) values('$view_date1', '$eventStr','$circle','$service_id','$count','NA','NA','NA','$amt1')";			
			$queryIns = mysql_query($insertReqData, $dbConn);
        }
}
// end code to insert the Event Charging ------------------

echo "done";
mysql_close($dbConn);
?>
