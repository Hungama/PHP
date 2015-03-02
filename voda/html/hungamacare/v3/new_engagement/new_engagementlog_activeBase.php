<?php
include ("/var/www/html/hungamacare/2.0/incs/db.php");
$serviceArray = array('1301' => 'VodafoneMU', '1302' => 'Vodafone54646');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1301':
            $subscription_db = "vodafone_radio";
            $subscription_table = "tbl_radio_subscription";
            $dnis_str = "status in(1,7,8,6) ";
            break;
        case '1302':
            $subscription_db = "vodafone_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $dnis_str = "status =1  and dnis not like '%P%'";
            break;
         }
echo "Process Start for Active Base data===>>>";
		 
///////////////////////////////////////////// Start Code For Active Base  ///////////////////////////////////////////////////////////////////////////////////////
    $query_0to5days = "select ANI,circle,status from " . $subscription_db . "." . $subscription_table . "  nolock where ".$dnis_str . " ";
    $result_0to5days = mysql_query($query_0to5days, $dbConn) or die(mysql_error());

    $result_row_0to5days = mysql_num_rows($result_0to5days);

    if ($result_row_0to5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '36' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_0to5days = mysql_fetch_row($result_0to5days)) {
            $insert_query_0to5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now(),'" . $s_id . "','36','" . $details_0to5days[2] . "')";
            mysql_query($insert_query_0to5days, $dbConn);
        }
    }
///////////////////////////////////////////// end Code For Active Base  ////////////////////////////////////////////////////////
}
echo "Process Completed for Active Base data";
?>