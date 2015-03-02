<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

$serviceArray = array('1515' => 'Airtel - Sarnam');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1515':
            $subscription_db = "airtel_devo";
            $subscription_table = "tbl_devo_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_devotional_calllog";
            $dnis_str = "dnis like '51050%'";
            break;
    }

///////////////////////////////////////////// Start Code For Active Base  ///////////////////////////////////////////////////////////////////////////////////////
    $query_0to5days = "select ANI,circle,status from " . $subscription_db . "." . $subscription_table . "  where status =1  and " . $dnis_str . " ";
    $result_0to5days = mysql_query($query_0to5days, $dbConn) or die(mysql_error());

    $result_row_0to5days = mysql_num_rows($result_0to5days);

    if ($result_row_0to5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '36' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_0to5days = mysql_fetch_row($result_0to5days)) {
            $insert_query_0to5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now()," . $s_id . ",'36','" . $details_0to5days[2] . "')";
            mysql_query($insert_query_0to5days, $dbConn);
        }
    }
///////////////////////////////////////////// end Code For Active Base  ////////////////////////////////////////////////////////
}
echo "Done";
?>
   
