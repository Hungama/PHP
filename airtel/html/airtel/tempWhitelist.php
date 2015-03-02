<?php
session_start();

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$path="/var/www/html/airtel/Air_Retail_9Aug.txt";
$insertDump= 'LOAD DATA LOCAL INFILE "'.$path.'"
INTO TABLE master_db.tbl_refer_ussdMDN
FIELDS TERMINATED BY "#"
LINES TERMINATED BY "\n"
(ANI,service_id,circle)';

/*$insertDump= 'LOAD DATA LOCAL INFILE "'.$path.'"
INTO TABLE airtel_mnd.tbl_ussdMND_whitelist
LINES TERMINATED BY "\n"
(ANI)';*/

mysql_query($insertDump,$dbConn);
echo "done";
?>
