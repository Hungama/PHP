<?php 
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

echo $view_date1='2012-09-06';

//Start the code to activation Record mode wise for Uninor MyRingTone

$get_mode_activation_query1="select count(msisdn),circle,service_id,chrg_amount from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') group by circle,service_id,event_type,chrg_amount order by event_type";
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

$get_mode_activation_query1="select count(msisdn),circle,service_id,mode from master_db.tbl_billing_success where DATE(response_time)='$view_date1' and service_id=1412 and event_type in('SUB','EVENT') group by circle,service_id,event_type,mode order by event_type";
$db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($db_query1);
if ($numRows > 0)
{
        $db_query1 = mysql_query($get_mode_activation_query1, $dbConn) or die(mysql_error());
        while(list($count,$circle,$service_id,$mode) = mysql_fetch_array($db_query1))
        { 
			if($circle == "") $circle="UND";
			$activation_str_m="Mode_Activation_".$mode;
			$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,service_id,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str_m','$circle','$service_id','$count','NA','NA','NA')";
			
			$queryIns = mysql_query($insert_data_m, $dbConn);
        }
}
// end the code for Uninor MyRingTone
echo "done";
?>
