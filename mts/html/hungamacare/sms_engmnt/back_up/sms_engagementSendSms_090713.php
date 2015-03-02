<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

$query = "select id,ani,message,service_id from master_db.tbl_sms_engagement_log where date(added_on)=date(now()) and status=0";
$result = mysql_query($query, $dbConn);
while ($smsRecord = mysql_fetch_row($result)) {
//    if ($smsRecord[3] == 1101)
//        echo $procedureCall = "call master_db.SENDSMS_NEW(" . $smsRecord[1] . ",'" . $smsRecord[2] . "',52222,'mtsm','NO_CALL_PROMO',5)";
//
//    if ($procedureCall) {
        $result1 = mysql_query($procedureCall);
        echo $Update = "update master_db.tbl_sms_engagement_log set status=1 where id=" . $smsRecord[0] . " and ani=" . $smsRecord[1];
        $result2 = mysql_query($Update, $dbConn);
        echo "<br>";
  //  }
}
?>
  