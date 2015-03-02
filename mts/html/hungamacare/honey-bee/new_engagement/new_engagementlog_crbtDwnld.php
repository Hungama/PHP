<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
$serviceArray = array('1101' => 'MTS - muZic Unlimited');

foreach ($serviceArray as $s_id => $s_val) {
$subscription_db='';
    switch ($s_id) {
        case '1101':
            $subscription_db = "mts_mu";
            $subscription_table = "tbl_HB_subscription";
            $crbt_db = "mts_mu";
            $crbt_table = "tbl_crbtrng_reqs_log";
            $dnis_str = "a.dnis like '52222%'";
            break;
    }
if(!empty($subscription_db))
	{	
////////////////// code start for Downloaded/changed 1 or more CRBT in last 1 day //////////////////
    $query_1days = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
                where  date(a.date_time) = DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and b.status in(1,11) and a.ani=b.ani";

    $result_1days = mysql_query($query_1days, $dbConn);

    $result_row_1days = mysql_num_rows($result_1days);

    if ($result_row_1days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '23' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1days = mysql_fetch_row($result_1days)) {

            $insert_query_1days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) values (" . $details_1days[0] . ",'" . $details_1days[1] . "',now()," . $s_id . ",'23','" . $details_1days[2] . "')";
            mysql_query($insert_query_1days, $dbConn);
        }
    }
////////////////// code end for Downloaded/changed 1 or more CRBT in last 1 day ///////////////
//////////////// code start for Downloaded 2 or more CRBT in last 5 day ////////////////
    $query_3days = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
        where  date(date_time) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and b.status in(1,11) and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";

    $result_3days = mysql_query($query_3days, $dbConn);

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '24' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'24','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////// code end for Downloaded 2 or more CRBT in last 5 day ////////////////
}//check for empty db
}
mysql_close($dbConn);
echo "Done";
?>