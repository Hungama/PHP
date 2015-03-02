<?php
////////// start code to insert the data for SEC_TF  for EnterpriseMaxLifeIVR ///////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'EnterpriseMaxLifeIVR' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
	if ($circle_info[strtoupper($sec_tf[1])] == '')
		$circle= 'Other';
		else
		$circle= $circle_info[strtoupper($sec_tf[1])];
		
		$insert_sec_tf_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) 
		values('$view_date1', '$sec_tf[3]','$circle','$sec_tf[0]','$sec_tf[5]','0')";
		 $queryIns_pulse = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
?>