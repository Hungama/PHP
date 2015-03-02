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
///////////////////////// code start for No CRBT Download in 3 days from activation ////////////////////
if($isTrue)
{
 $query_3days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table . " a where date(a.reqprocess_time) 
    between DATE(NOW()-INTERVAL 3 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani )  and b.status in($statusCheck)";
    $query_3days .=" Union select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table2 . " a where date(a.date_time) 
    between DATE(NOW()-INTERVAL 3 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani )  and b.status in($statusCheck)";
    //echo $query_3days;
    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '31' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {

            $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'31','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 3 days from activation /////////////////////////////////////
//////////////////////////////////////////////// code start for No CRBT Download in 5 days from activation /////////////////////////////////////

    $query_5days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table . " a where 
    date(a.reqprocess_time) between DATE(NOW()-INTERVAL 5 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani) and b.status in($statusCheck)";
    $query_5days .=" Union select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table2 . " a where 
    date(a.date_time) between DATE(NOW()-INTERVAL 5 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani) and b.status in($statusCheck)";
    //echo $query_5days;
    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '32' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {

            $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'32','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 5 days from activation /////////////////////////////////////
//////////////////////////////////////////////// code start for No CRBT Download in 7 days from activation /////////////////////////////////////

    $query_7days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table . " a where date(a.reqprocess_time) 
    between DATE(NOW()-INTERVAL 7 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani)  and b.status in($statusCheck)";
    $query_7days .=" Union select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table2 . " a where date(a.date_time) 
    between DATE(NOW()-INTERVAL 7 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani)  and b.status in($statusCheck)";
    //echo $query_7days;
    $result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '33' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {

            $insert_query_7days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now()," . $s_id . ",'33','" . $details_7days[2] . "')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 7 days from activation /////////////////////////////////////
//////////////////////////////////////////////// code start for No CRBT Download in 15 days from activation /////////////////////////////////////

    $query_15days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where  date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table . " a where date(a.reqprocess_time) 
    between DATE(NOW()-INTERVAL 15 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani)  and b.status in($statusCheck)";
    $query_15days .=" Union select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b
where  date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and not exists(select a.ani from " . $rt_db . "." . $rt_table2 . " a where date(a.date_time) 
    between DATE(NOW()-INTERVAL 15 DAY) 
and DATE(NOW()-INTERVAL 1 DAY) and a.ani=b.ani)  and b.status in($statusCheck)";
    //echo $query_15days;
    $result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '34' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {

            $insert_query_15days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now()," . $s_id . ",'34','" . $details_15days[2] . "')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
////////// code end for No CRBT Download in 15 days from activation ////////
}
else
{
echo "NOK";
}
}
echo "Done";
mysql_close($dbConn);
?>