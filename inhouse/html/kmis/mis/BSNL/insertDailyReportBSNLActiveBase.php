<?php

////////////////////////// start code to insert the Pending base data into the database for BSNL54646/////////////////////////////////////

$getActiveBaseContest="select count(*),circle from misdata.tbl_base_active nolock where service='BSNL54646' and status='Active' and 
date(date)='$view_date1' group by circle";
$activeBaseQueryContest = mysql_query($getActiveBaseContest, $LivdbConn) or die(mysql_error());
$numRowsContest = mysql_num_rows($activeBaseQueryContest);
if ($numRowsContest > 0)
{
	while(list($countContest,$circle) = mysql_fetch_array($activeBaseQueryContest))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,
                total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countContest','NA','NA','NA','NA','NA',2202)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////// end code to insert the active base data into the database for BSNL54646/////////////////////////////////////

?>
