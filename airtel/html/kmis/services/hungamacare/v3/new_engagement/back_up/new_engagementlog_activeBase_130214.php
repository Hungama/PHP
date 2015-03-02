<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

$serviceArray = array('1515' => 'AirtelDevo', '1513' => 'AirtelMND', '1517' => 'AirtelSE', '1502' => 'Airtel54646', 'AirtelMNDKK' => 'AirtelMNDKK', '1511' => 'AirtelGL', '1518' => 'AirtelComedy');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1515':
            $subscription_db = "airtel_devo";
            $subscription_table = "tbl_devo_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_devotional_calllog";
            $dnis_str = "dnis like '51050%'";
            break;
        case '1513':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "dnis IN ('5500196','54646196','55001961','55001962','55001963','55001964','55001965')";
            break;
        case '1517':
            $subscription_db = "airtel_SPKENG";
            $subscription_table = "tbl_spkeng_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_SPKNG_calllog";
            $dnis_str = "dnis like '571811%'";
            break;
        case '1502':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis like '54646%' and dnis not in('546461','546461000','5464612','54646169') and dnis not like '%p%'";
            break;
        case 'MNDKK':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "dnis IN ('54646196') and circle IN ('KAR')";
            break;
        case '1511':
            $subscription_db = "airtel_rasoi";
            $subscription_table = "tbl_rasoi_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_ldr_calllog";
            $dnis_str = "dnis=55001";
            break;
        case '1518':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_comedyportal_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis=5464612";
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
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now(),'" . $s_id . "','36','" . $details_0to5days[2] . "')";
            mysql_query($insert_query_0to5days, $dbConn);
        }
    }
///////////////////////////////////////////// end Code For Active Base  ////////////////////////////////////////////////////////
}
echo "Done";
?>
   
