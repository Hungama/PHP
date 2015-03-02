<?php
/////////////start code to insert the data for PULSE_TF for EnterpriseMaxLifeIVR/////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'EnterpriseMaxLifeIVR' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
	if ($circle_info[strtoupper($pulse_tf[1])] == '')
		$circle= 'Other';
		else
		$circle= $circle_info[strtoupper($pulse_tf[1])];

        $insert_pulse_tf_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) 
		values('$view_date1', '$pulse_tf[3]','$circle','$pulse_tf[0]','$pulse_tf[5]','0')";
		 $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
?>