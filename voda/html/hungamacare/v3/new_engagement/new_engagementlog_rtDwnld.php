<?php
include ("/var/www/html/hungamacare/2.0/incs/db.php");
$serviceArray = array('1301' => 'VodafoneMU', '1302' => 'Vodafone54646');
foreach ($serviceArray as $s_id => $s_val) {
$isTrue=false;
    switch ($s_id) {
        case '1301':
            $subscription_db = "vodafone_radio";
            $subscription_table = "tbl_radio_subscription";
            $calllog_db = "master_db";
            $calllog_table = "tbl_voda_calllog";
            $dnis_str = "a.dnis like '546469%'";
			$statusCheck="1,7,8,6,11";			
            $rt_db = "vodafone_radio";
            $rt_table = "tbl_crbtrng_reqs_log";
            $rt_table2 = "tbl_monotone_reqs_logs";
			$isTrue=true;
            break;
    }
if($isTrue)
{
	///////////////////////// code start for Downloaded/changed 1 or more CRBT in last 1 day //////////////////////
    $query_1days = "select distinct a.ani,a.circle,b.status from " . $rt_db . "." . $rt_table . " a, " . $subscription_db . "." . $subscription_table . " b
                where  date(a.reqprocess_time) = DATE(NOW()-INTERVAL 1 DAY) and  a.responce_code='OK' and b.status in($statusCheck) and a.ani=b.ani";
    $query_1days.=" Union select distinct a.ani,a.circle,b.status from " . $rt_db . "." . $rt_table2 . " a, " . $subscription_db . "." . $subscription_table . " b
                where  date(a.date_time) = DATE(NOW()-INTERVAL 1 DAY) and b.status in($statusCheck) and a.ani=b.ani";
    
    $result_1days = mysql_query($query_1days, $dbConn) or die(mysql_error());

    $result_row_1days = mysql_num_rows($result_1days);

    if ($result_row_1days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '29' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1days = mysql_fetch_row($result_1days)) {

            $insert_query_1days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_1days[0] . ",'" . $details_1days[1] . "',now()," . $s_id . ",'29','" . $details_1days[2] . "')";
            mysql_query($insert_query_1days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded/changed 1 or more CRBT in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
    $query_5days = "select distinct a.ani,a.circle,b.status from " . $rt_db . "." . $rt_table . " a, " . $subscription_db . "." . $subscription_table . " b
        where  date(a.reqprocess_time) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.responce_code='OK' and b.status in($statusCheck) and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";
    $query_5days .= " Union select distinct a.ani,a.circle,b.status from " . $rt_db . "." . $rt_table2 . " a, " . $subscription_db . "." . $subscription_table . " b
        where  date(a.date_time) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and b.status in($statusCheck) and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";
					
	
    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '30' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {
            $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'30','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
//////////// code end for Downloaded 2 or more CRBT in last 5 day ////////////
}
else
{
echo "NOK";
}
}
echo "Done";
mysql_close($dbConn);
?>