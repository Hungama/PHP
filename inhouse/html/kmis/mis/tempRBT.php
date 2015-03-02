<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

echo $view_date1="2013-03-10";

//start code to insert the data for RBT_*  
$rbt_tf=array();
$rbt_query="select count(*),circle,req_type from indicom_radio.tbl_crbtrng_reqs_log where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[2]=='CRBT' || $rbt_tf[2]=='crbt')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1601','NA','NA','NA')";
		}
		elseif($rbt_tf[2]=='RNG' || $rbt_tf[2]=='rng')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1601','NA','NA','NA')";
		}


		$queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}
// end


// to inser the Migration data

$get_migrate_date="select crbt_mode,count(1),circle from indicom_radio.tbl_crbtrng_reqs_log where date(date_time)='$view_date1' and req_type='crbt' and (responce_code like '00%' or responce_code ='99') group by crbt_mode,circle";

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
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'RBT_ACTIVATED_1','$circle','1601','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='MIGRATE')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_MIGRATED_1','$circle','1601','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1601','NA','$count','NA','NA','NA')";
		}
		elseif($crbt_mode=='DOWNLOAD15')
		{
			$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_SELECTION_15','$circle','1601','NA','$count','NA','NA','NA')";
		}

		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_close($dbConn);
echo "done";

?>
