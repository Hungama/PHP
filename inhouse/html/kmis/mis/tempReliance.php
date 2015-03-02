<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
echo $view_date1="2013-04-19";

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

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');


//start code to insert the data for RBT_*  
$rbt_tf=array();
echo $rbt_query="select count(*),circle,req_type from reliance_hungama.tbl_pausecodecrbt_reqs where DATE(date_time)='$view_date1' and req_type in('CRBT','RNG') group by circle,req_type";

$rbt_tf_result = mysql_query($rbt_query, $dbConn) or die(mysql_error());

$numRows6 = mysql_num_rows($rbt_tf_result);
if ($numRows6 > 0)
{
	while($rbt_tf = mysql_fetch_array($rbt_tf_result))
	{
		if($rbt_tf[1]=='') $rbt_tf[1]='UND';
		elseif(strtoupper($rbt_tf[1])=='HAR') $rbt_tf[1]='HAY';
		
		if(strtoupper($rbt_tf[2])=='CRBT')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RBT_*','$rbt_tf[1]','$rbt_tf[0]','0','1202','NA','NA','NA')";
		}
		elseif(strtoupper($rbt_tf[2])=='RNG')
		{
			$insert_rbt_tf_data="insert into mis_db.daily_report(report_date,type,circle,total_count,charging_rate,service_id,mous,pulse,total_sec) values('$view_date1', 'RT_*','$rbt_tf[1]','$rbt_tf[0]','0','1202','NA','NA','NA')";
		}

		echo $$insert_rbt_tf_data;
		$queryIns_rbt = mysql_query($insert_rbt_tf_data, $dbConn);
	}
}
// end


// to inser the Migration data

echo $get_migrate_date="select count(*),circle from reliance_hungama.tbl_pausecodecrbt_resp where DATE(date_time)='$view_date1' and status=1 group by circle";

$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($get_query);
if ($numRows12 > 0)
{
	$get_query = mysql_query($get_migrate_date, $dbConn) or die(mysql_error());
	while(list($crbt_mode,$count,$circle) = mysql_fetch_array($get_query))
	{
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($circle=='') $circle='NA';

		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1','RBT_EAUC','$circle','1202','NA','$count','NA','NA','NA')";		
		echo $insert_data1;
		$queryIns1 = mysql_query($insert_data1, $dbConn);
	}
}

echo "done";
mysql_close($dbConn);
?>
