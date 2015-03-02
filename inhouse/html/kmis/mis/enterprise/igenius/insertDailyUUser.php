<?php
/////////////////////// start code to insert the data for Unique Users  for toll free for EnterpriseMaxLifeIVR ///////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'EnterpriseMaxLifeIVR' as service_name,date(call_date) from mis_db.tbl_maxlife_calllog nolock where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
	
	if ($circle_info[strtoupper($uu_tf[1])] == '')
		$circle= 'Other';
		else
		$circle= $circle_info[strtoupper($uu_tf[1])];
	

		$insert_uu_tf_data = "insert into mis_db.tbl_dailymisEnterprise(Date,Service,Circle,Type,Value,Revenue) 
		values('$view_date1', '$uu_tf[3]','$circle','$uu_tf[0]','$uu_tf[2]','0')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
?>