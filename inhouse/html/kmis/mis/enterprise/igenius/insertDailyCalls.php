<?php
/////////////////// start code to insert the data for call_tf for EnterpriseMaxLifeIVR /////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'EnterpriseMaxLifeIVR' as service_name,date(call_date) 
from  mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
	if ($circle_info[strtoupper($call_tf[1])] == '')
		$circle= 'Other';
	else
		$circle= $circle_info[strtoupper($call_tf[1])];
			
        $insert_call_tf_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) 
		values('$view_date1', '$call_tf[3]','$circle','$call_tf[0]','$call_tf[2]','0')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
?>