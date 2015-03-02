<?php
session_start();

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$path="/var/www/html/airtel/mndDump.txt";

$insertDump= 'LOAD DATA LOCAL INFILE "'.$path.'"
INTO TABLE airtel_mnd.tbl_ussdMND_whitelist
FIELDS TERMINATED BY "#"
LINES TERMINATED BY "\n"
(ANI,serviceId)';
mysql_query($insertDump,$dbConn);

echo "done";
?>
