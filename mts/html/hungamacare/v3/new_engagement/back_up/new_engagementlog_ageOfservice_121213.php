<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

///////////////////////////////////////////// Start Code For 0-5 days  ///////////////////////////////////////////////////////////////////////////////////////
$query_0to5days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from mts_radio.tbl_radio_subscription where status in(1,11)
                   GROUP BY  ANI HAVING diff>=0 and diff<=5";
$result_0to5days = mysql_query($query_0to5days, $dbConn) or die(mysql_error());

$result_row_0to5days = mysql_num_rows($result_0to5days);

if ($result_row_0to5days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '18' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_0to5days = mysql_fetch_row($result_0to5days)) {
        $insert_query_0to5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now(),1101,'18','" . $details_0to5days[2] . "')";
        mysql_query($insert_query_0to5days, $dbConn);
    }
}
///////////////////////////////////////////// end Code For 0-5 days  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 5-10 days  ////////////////////////////////////////////////////////
$query_5to10days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from mts_radio.tbl_radio_subscription where status in(1,11)
                   GROUP BY  ANI HAVING diff>=5 and diff<=10";
$result_5to10days = mysql_query($query_5to10days, $dbConn) or die(mysql_error());

$result_row_5to10days = mysql_num_rows($result_5to10days);

if ($result_row_5to10days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '19' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_5to10days = mysql_fetch_row($result_5to10days)) {
        $insert_query_5to10days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_5to10days[0] . ",'" . $details_5to10days[1] . "',now(),1101,'19','" . $details_5to10days[2] . "')";
        mysql_query($insert_query_5to10days, $dbConn);
    }
}
///////////////////////////////////////////// End Code For 5-10 days  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 10-20 days  ////////////////////////////////////////////////////////
$query_10to20days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from mts_radio.tbl_radio_subscription where status in(1,11)
                   GROUP BY  ANI HAVING diff>=10 and diff<=20";
$result_10to20days = mysql_query($query_10to20days, $dbConn) or die(mysql_error());

$result_row_10to20days = mysql_num_rows($result_10to20days);

if ($result_row_10to20days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '20' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_10to20days = mysql_fetch_row($result_10to20days)) {
        $insert_query_10to20days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_10to20days[0] . ",'" . $details_10to20days[1] . "',now(),1101,'20','" . $details_10to20days[2] . "')";
        mysql_query($insert_query_10to20days, $dbConn);
    }
}
///////////////////////////////////////////// End Code For 10-20 days  ////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 20-30 days ////////////////////////////////////////////////
$query_20to30days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from mts_radio.tbl_radio_subscription where status in(1,11)
                   GROUP BY  ANI HAVING diff>=20 and diff<=30";
$result_20to30days = mysql_query($query_20to30days, $dbConn) or die(mysql_error());

$result_row_20to30days = mysql_num_rows($result_20to30days);

if ($result_row_20to30days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '21' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_20to30days = mysql_fetch_row($result_20to30days)) {
        $insert_query_20to30days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_20to30days[0] . ",'" . $details_20to30days[1] . "',now(),1101,'21','" . $details_20to30days[2] . "')";
        mysql_query($insert_query_20to30days, $dbConn);
    }
}
///////////////////////////////////////////// End Code For 20-30 days  /////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For More than 30 days ////////////////////////////////////////////////
$query_G30days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from mts_radio.tbl_radio_subscription where status in(1,11)
                   GROUP BY  ANI HAVING diff>=30";
$result_G30days = mysql_query($query_G30days, $dbConn) or die(mysql_error());

$result_row_G30days = mysql_num_rows($result_G30days);

if ($result_row_G30days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '22' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G30days = mysql_fetch_row($result_G30days)) {
        $insert_query_G30days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G30days[0] . ",'" . $details_G30days[1] . "',now(),1101,'22','" . $details_G30days[2] . "')";
        mysql_query($insert_query_G30days, $dbConn);
    }
}
///////////////////////////////////////////// End Code For More than 30 days  /////////////////////////////////////////////////

echo "Done";
?>
   
