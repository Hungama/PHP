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
//////// code start for No CRBT Download in 3 days from activation ///////////

if(!empty($subscription_db))
	{	
$query_3days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where not exists(select a.ani from " . $crbt_db . "." . $crbt_table . " a where date(a.date_time) between DATE(NOW()-INTERVAL 3 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani and a.status = 1 ) and date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and b.status in(1,11)";
    $result_3days = mysql_query($query_3days, $dbConn);

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '25' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {

            $insert_query_3days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'25','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////////// code end for No CRBT Download in 3 days from activation //////////////////
//////////////// code start for No CRBT Download in 5 days from activation ///////////////////

 $query_5days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where not exists(select a.ani from " . $crbt_db . "." . $crbt_table . " a where date(a.date_time) between DATE(NOW()-INTERVAL 5 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani and a.status = 1 ) and date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and b.status in(1,11)";
    $result_5days = mysql_query($query_5days, $dbConn);

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '26' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {

            $insert_query_5days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'26','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
////////////////// code end for No CRBT Download in 5 days from activation //////////////////
///////////// code start for No CRBT Download in 7 days from activation ////////////////

$query_7days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where not exists(select a.ani from " . $crbt_db . "." . $crbt_table . " a where date(a.date_time) between DATE(NOW()-INTERVAL 7 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani and a.status = 1 ) and date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and b.status in(1,11)";
    $result_7days = mysql_query($query_7days, $dbConn);

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '27' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {

            $insert_query_7days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now()," . $s_id . ",'27','" . $details_7days[2] . "')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
///////////////// code end for No CRBT Download in 7 days from activation //////////////////
//////////////// code start for No CRBT Download in 15 days from activation ///////////////

 $query_15days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where not exists(select a.ani from " . $crbt_db . "." . $crbt_table . " a where date(a.date_time) between DATE(NOW()-INTERVAL 15 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani and a.status = 1 ) and date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and b.status in(1,11)";
    $result_15days = mysql_query($query_15days, $dbConn);

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '28' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {

            $insert_query_15days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now()," . $s_id . ",'28','" . $details_15days[2] . "')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
////////////////// code end for No CRBT Download in 15 days from activation /////////////////
}//check for empty db name
}
mysql_close($dbConn);
echo "Done";
?>