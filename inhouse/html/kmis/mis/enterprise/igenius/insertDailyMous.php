<?php
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'EnterpriseMaxLifeIVR' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        
		if ($circle_info[strtoupper($mous_tf[1])] == '')
		$circle= 'Other';
		else
		$circle= $circle_info[strtoupper($mous_tf[1])];
		
		$insert_mous_tf_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) 
		values('$view_date1', '$mous_tf[3]','$circle','$mous_tf[0]','$mous_tf[5]','0')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
?>