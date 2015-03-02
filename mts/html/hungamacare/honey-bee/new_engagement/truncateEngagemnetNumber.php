<?php
//Truncate table for better performance
include ("/var/www/html/hungamacare/config/dbConnect.php");
$deleteprevioousdata = "truncate table honeybee_sms_engagement.tbl_new_engagement_number";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
////////////////////// delete back date end here/////////////////
mysql_close($dbConn);
echo "Done";
?>