<?php

////////////////////////////////// start code to insert the Pending Base data into the database for BSNL54646///////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='BSNL54646' and status='Pending' and date(date)='$view_date1' 
group by circle";
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
		$insert_data="insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,
                total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',2202)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////// end code to insert the Pending Base data into the database for BSNL54646///////////////////////////////

?>
